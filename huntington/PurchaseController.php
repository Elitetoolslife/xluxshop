<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use eftec\bladeone\BladeOne;
use mysqli;

class PurchaseController
{
    protected $db;
    protected $blade;

    public function __construct($db)
    {
        $this->db = $db;

        $views = __DIR__ . '/../../../views';
        $cache = __DIR__ . '/../../../storage/cache';
        $this->blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
    }

    private function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function showPurchases()
    {
        $this->startSession();

        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $user = trim($_SESSION['user']);
        $uid = mysqli_real_escape_string($this->db, $user);

        $stmt = $this->db->prepare("SELECT * FROM purchases WHERE buyer = ? ORDER BY id DESC");
        $stmt->bind_param("s", $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        $purchases = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        echo $this->blade->run("purchased", ["purchases" => $purchases]);
    }

    public function reportOrder(Request $request)
    {
        $this->startSession();

        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            return new Response(json_encode(["message" => "Unauthorized"]), Response::HTTP_UNAUTHORIZED, ['Content-Type' => 'application/json']);
        }

        $user = trim($_SESSION['user']);
        $userId = mysqli_real_escape_string($this->db, $user);
        $orderId = trim($request->get("order_id"));
        $message = trim($request->get("message"));

        if (empty($orderId) || empty($message)) {
            return new Response(json_encode(["message" => "Order ID and message are required."]), Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
        }

        // Validate if the order belongs to the user
        $stmt = $this->db->prepare("SELECT * FROM purchases WHERE id = ? AND buyer = ?");
        $stmt->bind_param("is", $orderId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return new Response(json_encode(["message" => "Invalid Order ID or unauthorized access."]), Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
        }
        $stmt->close();

        // Check if order is already reported
        $stmt = $this->db->prepare("SELECT * FROM reports WHERE s_id = ? AND uid = ?");
        $stmt->bind_param("is", $orderId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return new Response(json_encode(["message" => "Order already reported."]), Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
        }
        $stmt->close();

        // Insert report
        $stmt = $this->db->prepare("INSERT INTO reports (s_id, uid, message, status) VALUES (?, ?, ?, 'pending')");
        $stmt->bind_param("iss", $orderId, $userId, $message);

        if ($stmt->execute()) {
            return new Response(json_encode(["message" => "Order reported successfully."]), Response::HTTP_OK, ['Content-Type' => 'application/json']);
        } else {
            return new Response(json_encode(["message" => "Database error, please try again."]), Response::HTTP_INTERNAL_SERVER_ERROR, ['Content-Type' => 'application/json']);
        }
        $stmt->close();
    }
}