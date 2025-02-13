<?php

namespace App\Http\Controllers;

require_once __DIR__ . '/../../../config/countrycodes.php'; // expects $countrycodes array
require 'vendor/autoload.php';

use eftec\bladeone\BladeOne;
use App\Models\User;

class HuntingtonController extends BaseController {
    private $blade;
    private $db;
    private $globalCountryCodes;

    /**
     * Inject dependencies via the constructor.
     *
     * @param \mysqli $db
     * @param array   $globalCountryCodes Global country codes array.
     */
    public function __construct($db, array $globalCountryCodes) {
        $views = __DIR__ . '/../../../views';   // Blade templates folder
        $cache = __DIR__ . '/../../../cache';     // Cache folder
        $this->blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        $this->db = $db;
        // Assign the provided global country codes to the class property.
        $this->globalCountryCodes = $globalCountryCodes;
        session_start(); // Start session for using $_SESSION
    }

    /**
     * Display available Huntington Bank products.
     */
    public function showHuntingtonbank() {
        $user = User::getAuthenticatedUser();
        if (!$user) {
            header("Location: /login");
            exit();
        }

        // Retrieve user details to display on the page.
        $username = $user->username;
        $balance  = isset($user->balance) ? $user->balance : 0;
        // Set your CSRF token here (update with your own logic if needed).
        $csrf_token = bin2hex(random_bytes(32)); // Generate a CSRF token

        // Retrieve unique countries where the product is unsold.
        $countries = [];
        $stmt = $this->db->prepare("SELECT DISTINCT `country` FROM `huntingtonbanks` WHERE sold = ? ORDER BY country ASC");
        $sold = 0;
        $stmt->bind_param('i', $sold);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $countries[] = htmlspecialchars($row['country']);
        }
        $stmt->close();

        // Retrieve seller usernames and convert them into standardized seller IDs.
        $sellers = [];
        $stmt = $this->db->prepare("SELECT DISTINCT `resseller` FROM `huntingtonbanks` WHERE sold = ? ORDER BY resseller ASC");
        $stmt->bind_param('i', $sold);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            // For each seller, get the seller's id from the resseller table.
            $stmt2 = $this->db->prepare("SELECT `id` FROM resseller WHERE username = ? ORDER BY id ASC LIMIT 1");
            $stmt2->bind_param('s', $row['resseller']);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            if ($sellerRow = $result2->fetch_assoc()) {
                $sellers[] = "seller" . htmlspecialchars($sellerRow['id']);
            }
            $stmt2->close();
        }
        $stmt->close();

        // Retrieve all unsold Huntington Bank products.
        $banks = [];
        $stmt = $this->db->prepare("SELECT * FROM huntingtonbanks WHERE sold = ? ORDER BY RAND()");
        $stmt->bind_param('i', $sold);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $banks[] = $row;
        }
        $stmt->close();

        // Pass variables to the view.
        echo $this->blade->run("huntington", [
            "countries"       => $countries,
            "sellers"         => $sellers,
            "huntingtonbanks" => $banks,  // Renamed key to match the view's expected variable.
            "countrycodes"    => $this->globalCountryCodes,
            "username"        => $username,
            "balance"         => $balance,
            "csrf_token"      => $csrf_token
        ]);
    }

    public function getHuntingtonData()
    {
        // Get request parameters
        $country = isset($_GET['country']) ? $_GET['country'] : '';
        $seller = isset($_GET['seller']) ? $_GET['seller'] : '';
        $start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
        $length = isset($_GET['length']) ? (int)$_GET['length'] : 10;
        $searchValue = isset($_GET['search']['value']) ? trim($_GET['search']['value']) : '';
        $orderColumnIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
        $orderDir = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : 'asc';

        // Map DataTables column index to actual database columns
        $columns = ['acctype', 'country', 'resseller', 'price'];
        $orderBy = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'acctype';

        // Base SQL query
        $sql = "SELECT * FROM huntingtonbanks WHERE sold = 0";

        // Apply filters
        if (!empty($country)) {
            $sql .= " AND country = '" . $this->db->real_escape_string($country) . "'";
        }
        if (!empty($seller)) {
            $sql .= " AND resseller = '" . $this->db->real_escape_string($seller) . "'";
        }
        if (!empty($searchValue)) {
            $sql .= " AND (acctype LIKE '%" . $this->db->real_escape_string($searchValue) . "%' 
                           OR country LIKE '%" . $this->db->real_escape_string($searchValue) . "%'
                           OR resseller LIKE '%" . $this->db->real_escape_string($searchValue) . "%')";
        }

        // Get total records before pagination
        $totalRecords = $this->db->query("SELECT COUNT(*) as count FROM huntingtonbanks WHERE sold = 0")->fetch_assoc()['count'];

        // Apply ordering and pagination
        $sql .= " ORDER BY $orderBy $orderDir LIMIT $start, $length";

        // Fetch data
        $results = $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);

        // Prepare response for DataTables
        $data = [];
        foreach ($results as $bank) {
            $data[] = [
                'acctype' => $bank['acctype'],
                'country' => $bank['country'],
                'resseller' => $bank['resseller'],
                'price' => number_format($bank['price'], 2),
                'action' => '<button class="btn btn-buy" onclick="confirmPurchase('.$bank['id'].', '.$bank['price'].')">Buy Now</button>'
            ];
        }

        // Return JSON response
        echo json_encode([
            'draw' => isset($_GET['draw']) ? (int)$_GET['draw'] : 1,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => count($data),
            'data' => $data
        ]);
        exit;
    }

    /**
     * Process the purchase of a Huntington Bank product.
     */
    public function buyHuntingtonbank() {
        $user = User::getAuthenticatedUser();
        if (!$user) {
            header("Location: /login");
            exit();
        }

        // Validate required input.
        if (!isset($_SESSION['user_id'], $_POST['id'])) {
            echo json_encode(["status" => "error", "message" => "Invalid request"]);
            exit();
        }

        $user = $_SESSION['user_id'];
        $uid   = (int)$_POST['id'];
        $date  = date("Y-m-d H:i:s");

        // Fetch user details.
        $stmt = $this->db->prepare("SELECT balance, ipurchassed FROM users WHERE username = ?");
        $stmt->bind_param('s', $user);
        $stmt->execute();
        $userResult = $stmt->get_result();
        $userData = $userResult->fetch_assoc();
        $stmt->close();

        if (!$userData) {
            echo json_encode(["status" => "error", "message" => "User not found"]);
            exit();
        }
        $balance = $userData['balance'];

        // Fetch Huntington Bank product details.
        $stmt = $this->db->prepare("SELECT * FROM huntingtonbanks WHERE id = ? AND sold = ? LIMIT 1");
        $sold = 0;
        $stmt->bind_param('ii', $uid, $sold);
        $stmt->execute();
        $bankResult = $stmt->get_result();
        $bank = $bankResult->fetch_assoc();
        $stmt->close();

        if (!$bank) {
            echo json_encode(["status" => "error", "message" => "Item not found or already sold"]);
            exit();
        }

        // Verify that the user has sufficient funds.
        if ($balance < $bank['price']) {
            echo json_encode(["status" => "error", "message" => "Not enough balance"]);
            exit();
        }
        $newBalance = $balance - $bank['price'];

        // Begin transaction.
        $this->db->begin_transaction();
        $transactionSuccess = true;

        // 1. Mark the bank product as sold.
        $stmt = $this->db->prepare("UPDATE huntingtonbanks SET sold = 1, sto = ?, dateofsold = ? WHERE id = ?");
        $stmt->bind_param('ssi', $user, $date, $uid);
        if (!$stmt->execute()) {
            $transactionSuccess = false;
        }
        $stmt->close();

        // 2. Deduct the purchase price from the user's balance and increment purchase count.
        if ($transactionSuccess) {
            $stmt = $this->db->prepare("UPDATE users SET balance = ?, ipurchassed = ipurchassed + 1 WHERE username = ?");
            $stmt->bind_param('is', $newBalance, $user);
            if (!$stmt->execute()) {
                $transactionSuccess = false;
            }
            $stmt->close();
        }

        // 3. Insert a new order record.
        if ($transactionSuccess) {
            $stmt = $this->db->prepare("INSERT INTO orders (s_id, buyer, type, date, country, infos, url, login, pass, price, resseller)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $type = $bank['acctype'];
            $stmt->bind_param(
                'issssssssds',
                $uid,
                $user,
                $type,
                $date,
                $bank['country'],
                $bank['infos'],
                $bank['url'],
                $bank['login'],
                $bank['pass'],
                $bank['price'],
                $bank['resseller']
            );
            if (!$stmt->execute()) {
                $transactionSuccess = false;
            }
            $stmt->close();
        }

        // 4. Update the reseller's sales statistics.
        if ($transactionSuccess) {
            $stmt = $this->db->prepare("UPDATE resseller SET allsales = allsales + ?, soldb = soldb + ? WHERE username = ?");
            $price = $bank['price'];
            $stmt->bind_param('dds', $price, $price, $bank['resseller']);
            if (!$stmt->execute()) {
                $transactionSuccess = false;
            }
            $stmt->close();
        }

        // Finalize transaction.
        if ($transactionSuccess) {
            $this->db->commit();
            echo json_encode(["status" => "success", "message" => "Purchase successful"]);
        } else {
            $this->db->rollback();
            echo json_encode(["status" => "error", "message" => "Transaction failed"]);
        }
    }
}