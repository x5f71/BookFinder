<?php
session_start();
include "../config/db.php";

header("Content-Type: application/json");

// read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// validate input
if (!$data || !isset($data["email"], $data["password"], $data["captcha"])) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields"
    ]);
    exit;
}

$email = trim($data["email"]);
$password = $data["password"];
$captcha = $data["captcha"];

// check CAPTCHA
if (!isset($_SESSION["captcha"]) || strtolower($captcha) !== strtolower($_SESSION["captcha"])) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid CAPTCHA"
    ]);
    exit;
}

// prevent CAPTCHA reuse
unset($_SESSION["captcha"]);

// get user 
$stmt = $conn->prepare("
    SELECT id, email, name, phone, password 
    FROM users 
    WHERE email = ?
");

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid email or password"
    ]);
    exit;
}

$user = $result->fetch_assoc();

// verify password
if (!password_verify($password, $user["password"])) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid email or password"
    ]);
    exit;
}

// set session
$_SESSION["user"] = [
    "id" => (int) $user["id"],
    "email" => $user["email"],
    "name" => $user["name"],
    "phone" => $user["phone"]
];

// regenerate session ID for security
session_regenerate_id(true);

// success response
echo json_encode([
    "status" => "success",
    "message" => "Login successful",
    "user" => [
        "id" => $user["id"],
        "email" => $user["email"],
        "name" => $user["name"],
        "phone" => $user["phone"]
    ]
]);