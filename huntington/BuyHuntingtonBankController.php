<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use eftec\bladeone\BladeOne;
use mysqli;

class HuntingtonController
{
    protected $dbcon;
    protected $blade;
    protected $countrycodes;

    public function __construct($dbcon)
    {
        $this->dbcon = $dbcon;
        $this->countrycodes = include __DIR__ . '/../../../config/countrycodes.php';

        $views = __DIR__ . '/../../../views';
        $cache = __DIR__ . '/../../../storage/cache';
        $this->blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
    }

    /**
     * Show Huntington bank listings (with caching)
     */
    public function showHuntingtonbank()
    {
        ob_start();
        session_start();
        date_default_timezone_set('UTC');

        // Ensure user is logged in
        if (!isset($_SESSION['user']) && !isset($_SESSION['pass'])) {
            header("Location: /login");
            exit();
        }

        $uid = is_array($_SESSION['user']) ? $_SESSION['user']['username'] : $_SESSION['user'];
        $uid = mysqli_real_escape_string($this->dbcon, $uid);

        // Cache user data for performance
        $cacheFile = __DIR__ . "/../../../storage/cache/user_{$uid}.json";
        if (file_exists($cacheFile) && time() - filemtime($cacheFile) < 300) { // Cache for 5 minutes
            $userData = json_decode(file_get_contents($cacheFile), true);
        } else {
            $query = mysqli_query($this->dbcon, "SELECT username, balance FROM users WHERE username='$uid'");
            $userData = mysqli_fetch_assoc($query);
            file_put_contents($cacheFile, json_encode($userData));
        }

        if (!$userData) {
            header("Location: /logout");
            exit();
        }

        $username = $userData['username'];
        $balance = $userData['balance'];

        // Generate CSRF Token
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        // Fetch Huntington bank data (cached)
        $cacheFile = __DIR__ . "/../../../storage/cache/huntington_data.json";
        if (file_exists($cacheFile) && time() - filemtime($cacheFile) < 300) { // Cache for 5 minutes
            $data = json_decode(file_get_contents($cacheFile), true);
        } else {
            $data = [
                "countries" => $this->dbcon->query("SELECT DISTINCT(country) FROM huntingtonbanks WHERE sold = '0' ORDER BY country ASC")->fetch_all(MYSQLI_ASSOC),
                "sellers" => $this->dbcon->query("SELECT DISTINCT(resseller) FROM huntingtonbanks WHERE sold = '0' ORDER BY resseller ASC")->fetch_all(MYSQLI_ASSOC),
                "huntingtonbanks" => $this->dbcon->query("SELECT * FROM huntingtonbanks WHERE sold='0' ORDER BY RAND()")->fetch_all(MYSQLI_ASSOC)
            ];
            file_put_contents($cacheFile, json_encode($data));
        }

        echo $this->blade->run("huntington", [
            "username" => $username,
            "balance" => $balance,
            "countries" => $data['countries'],
            "sellers" => $data['sellers'],
            "huntingtonbanks" => $data['huntingtonbanks'],
            "csrf_token" => $_SESSION['csrf_token'],
            "countrycodes" => $this->countrycodes
        ]);
    }

    /**
     * Handle purchase request (JSON API)
     */
    public function buyHuntington()
    {
        ob_start();
        session_start();
        $dbcon = $this->dbcon;
        $date = date("Y-m-d H:i:s");

        // Ensure the request is JSON
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);

        if (!$input || !isset($input['id'], $input['_token'])) {
            return $this->jsonResponse(["success" => false, "message" => "Invalid JSON request."], 400);
        }

        // Validate CSRF token
        if ($input['_token'] !== $_SESSION['csrf_token']) {
            return $this->jsonResponse(["success" => false, "message" => "Invalid CSRF token."], 403);
        }

        if (!isset($_SESSION['user'])) {
            return $this->jsonResponse(["success" => false, "message" => "User not logged in."], 401);
        }

        $username = $_SESSION['user'];
        $uid = intval($input['id']);

        // Fetch the item
        $stmt = $dbcon->prepare("SELECT * FROM huntingtonbanks WHERE id=? AND sold=0");
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        $bank = $result->fetch_assoc();
        $stmt->close();

        if (!$bank) {
            return $this->jsonResponse(["success" => false, "message" => "Item already sold or does not exist."], 404);
        }

        // Get user balance
        $stmt = $dbcon->prepare("SELECT balance, ipurchassed FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$user || $user['balance'] < $bank['price']) {
            return $this->jsonResponse(["success" => false, "message" => "Insufficient balance. Please add funds."], 400);
        }

        // Deduct balance and mark item as sold
        $newBalance = $user['balance'] - $bank['price'];
        $npur = $user['ipurchassed'] + 1;

        $dbcon->begin_transaction();
        try {
            // Update user's balance
            $stmt = $dbcon->prepare("UPDATE users SET balance=?, ipurchassed=? WHERE username=?");
            $stmt->bind_param("dis", $newBalance, $npur, $username);
            $stmt->execute();
            $stmt->close();

            // Mark bank as sold
            $stmt = $dbcon->prepare("UPDATE huntingtonbanks SET sold='1', sto=?, dateofsold=?, resseller=? WHERE id=?");
            $stmt->bind_param("sssi", $username, $date, $bank['resseller'], $uid);
            $stmt->execute();
            $stmt->close();

            $dbcon->commit();

            return $this->jsonResponse(["success" => true, "orderId" => $uid]);
        } catch (Exception $e) {
            $dbcon->rollback();
            return $this->jsonResponse(["success" => false, "message" => "Transaction failed."], 500);
        }
    }

    /**
     * Helper function to send JSON response
     */
    private function jsonResponse($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit();
    }

    /**
     * Open Huntington Bank order details
     */
    public function OpenHuntingtonbankorder()
    {
        function srl($item)
        {
            $item0 = $item;
            $item1 = rtrim($item0);
            $item2 = ltrim($item1);
            return $item2;
        }

        $username = mysqli_real_escape_string($this->dbcon, $_SESSION['user']);
        $orderid = mysqli_real_escape_string($this->dbcon, $_GET['id']);
        $query = mysqli_query($this->dbcon, "SELECT * FROM purchases WHERE buyer='$username' and id='$orderid'") or die(mysqli_error($this->dbcon));

        while ($row = mysqli_fetch_assoc($query)) {
            // Huntington Bank
            if ($row['type'] == "huntingtonbank") {
                $itemid = $row['s_id'];
                $question = mysqli_query($this->dbcon, "SELECT * FROM huntingtonbanks WHERE id='$itemid'") or die(mysqli_error($this->dbcon));
                while ($row_country = mysqli_fetch_assoc($question)) {
                    $country = $row_country['country'];
                    $infos = $row_country['infos'];
                    $url = $row_country['url'];
                    $row_url = explode("|", $url);
                    $url = srl($row_url[0]);
                    $login = srl($row_url[1]);
                    $balance = srl($row_url[2]);
                    $maindom = parse_url($url, PHP_URL_HOST);
                    $domain = $row_country['domain'];
                    $code = array_search("$country", $this->countrycodes);
                    $countrycode = strtolower($code);
?>

<h4>Huntington Bank</h4>
<table class="table">
<tr>
  <td>Country</td>
  <td><b><span class="flag-icon flag-icon-<?php echo htmlspecialchars($countrycode); ?>"></span> <?php echo htmlspecialchars($country); ?></b></td>
</tr>

<tr>
  <td>Bank Name</td>
  <td><b><?php echo htmlspecialchars($domain); ?></b></td>
</tr>

<tr>
  <td>Available Information</td>
  <td><b><?php echo htmlspecialchars($infos); ?></b></td>
</tr>

<tr>
  <td>Balance</td>
  <td><b><a><?php echo htmlspecialchars($balance); ?></a></b></td>
</tr>

<tr>
  <td>Account Info</td>
  <td><b><textarea rows='10' cols='30'><?php echo htmlspecialchars($login); ?></textarea></b></td>
</tr>
</table>
<?php
                }
            }
        }
    }
}
?>update my huntingtonbank with my provided column --

  `id` int(11) NOT NULL,
  `acctype` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `infos` text NOT NULL,
  `price` int(11) NOT NULL,
  `url` text NOT NULL,
  `sold` int(11) NOT NULL,
  `sto` varchar(255) NOT NULL,
  `dateofsold` text NOT NULL DEFAULT current_timestamp(),
  `date` text NOT NULL,
  `resseller` varchar(255) NOT NULL,
  `reported` varchar(255) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--