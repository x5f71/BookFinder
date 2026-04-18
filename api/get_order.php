<?php
/*
 * RESTful API Endpoint: get_order.php
 * Method:  GET
 * Params:  order_id (integer, primary key of the orders table)
 * Returns: JSON object containing the full order details.
 *
 * Designed for use by a manager or external system to look up individual
 * orders by ID without requiring a browser session.
 *
 * HTTP status codes:
 *   200 - Order found and returned successfully
 *   400 - Missing or invalid order_id parameter
 *   404 - No order found with the given ID
 *   405 - Request method was not GET
 */

include "../config/db.php";

header("Content-Type: application/json");

// Only GET requests are accepted
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode([
        "status"  => "error",
        "message" => "Method not allowed"
    ]);
    exit;
}

// Cast to int to ensure a valid numeric ID was provided
$orderId = isset($_GET["order_id"]) ? (int)$_GET["order_id"] : 0;

if ($orderId <= 0) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Invalid order ID"
    ]);
    exit;
}

// Prepared statement prevents SQL injection
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode([
        "status"  => "error",
        "message" => "Order not found"
    ]);
    exit;
}

$order = $result->fetch_assoc();

// Sanitise all string fields before returning them in the response
$order["name"]       = htmlspecialchars($order["name"]);
$order["email"]      = htmlspecialchars($order["email"]);
$order["phone"]      = htmlspecialchars($order["phone"]);
$order["book_title"] = htmlspecialchars($order["book_title"]);
$order["book_id"]    = (int)$order["book_id"];
$order["price"]      = (float)$order["price"];

echo json_encode([
    "status" => "success",
    "order"  => $order
]);
