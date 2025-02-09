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
     * Helper function to get cached data or fetch it from the database.
     */
    private function getCachedData($cacheFile, $query)
    {
        if (file_exists($cacheFile) && time() - filemtime($cacheFile) < 300) { // Cache for 5 minutes
            return json_decode(file_get_contents($cacheFile), true);
        }

        $data = $this->dbcon->query($query)->fetch_all(MYSQLI_ASSOC);
        file_put_contents($cacheFile, json_encode($data));

        return $data;
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
        $userData = file_exists($cacheFile) && time() - filemtime($cacheFile) < 300
            ? json_decode(file_get_contents($cacheFile), true)
            : $this->fetchUserData($uid);

        if (!$userData) {
            header("Location: /logout");
            exit();
        }

        // Generate CSRF Token
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        // Fetch Huntington bank data (cached)
        $data = [
            "countries" => $this->getCachedData(__DIR__ . "/../../../storage/cache/countries.json", "SELECT DISTINCT(country) FROM huntingtonbanks WHERE sold = '0' ORDER BY country ASC"),
            "sellers" => $this->getCachedData(__DIR__ . "/../../../storage/cache/sellers.json", "SELECT DISTINCT(resseller) FROM huntingtonbanks WHERE sold = '0' ORDER BY resseller ASC"),
            "huntingtonbanks" => $this->getCachedData(__DIR__ . "/../../../storage/cache/huntington_data.json", "SELECT * FROM huntingtonbanks WHERE sold='0' ORDER BY RAND()")
        ];

        echo $this->blade->run("huntington", [
            "username" => $userData['username'],
            "balance" => $userData['balance'],
            "countries" => $data['countries'],
            "sellers" => $data['sellers'],
            "huntingtonbanks" => $data['huntingtonbanks'],
            "csrf_token" => $_SESSION['csrf_token'],
            "countrycodes" => $this->countrycodes
        ]);
    }

    /**
     * Fetch user data from database and cache it.
     */
    private function fetchUserData($uid)
    {
        $query = mysqli_query($this->dbcon, "SELECT username, balance FROM users WHERE username='$uid'");
        $userData = mysqli_fetch_assoc($query);
        file_put_contents(__DIR__ . "/../../../storage/cache/user_{$uid}.json", json_encode($userData));

        return $userData;
    }

    /**
     * Handle purchase request (JSON API)
     */
    public function buyHuntington()
    {
        ob_start();
        session_start();
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
        $stmt = $this->dbcon->prepare("SELECT * FROM huntingtonbanks WHERE id=? AND sold=0");
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        $bank = $result->fetch_assoc();
        $stmt->close();

        if (!$bank) {
            return $this->jsonResponse(["success" => false, "message" => "Item already sold or does not exist."], 404);
        }

        // Get user balance
        $stmt = $this->dbcon->prepare("SELECT balance, ipurchassed FROM users WHERE username=?");
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
     * Show user's purchases
     */
    public function showPurchases()
    {
        ob_start();
        session_start();
        date_default_timezone_set('UTC');

        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $uid = mysqli_real_escape_string($this->dbcon, $_SESSION['user']);
        $query = mysqli_query($this->dbcon, "SELECT * FROM purchases WHERE buyer='$uid' ORDER BY id DESC");
        $purchases = mysqli_fetch_all($query, MYSQLI_ASSOC);

        echo $this->blade->run("purchased", [
            "purchases" => $purchases
        ]);
    }

    /**
     * Handle report request
     */
    public function reportPurchase($id, $message)
    {
        session_start();
        $username = mysqli_real_escape_string($this->dbcon, $_SESSION['user']);
        $id = intval($id);
        $message = mysqli_real_escape_string($this->dbcon, $message);

        // Fetch the purchase
        $stmt = $this->dbcon->prepare("SELECT * FROM purchases WHERE id=? AND buyer=?");
        $stmt->bind_param("is", $id, $username);
        $stmt->execute();
        $purchase = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$purchase) {
            echo "Invalid Purchase";
            exit();
        }

        // Update the purchase to mark as reported
        $stmt = $this->dbcon->prepare("UPDATE purchases SET reported=1, report_message=? WHERE id=?");
        $stmt->bind_param("si", $message, $id);
        $stmt->execute();
        $stmt->close();

        echo "Report submitted successfully";
    }
}