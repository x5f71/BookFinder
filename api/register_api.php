<?php
include "../config/db.php";

header("Content-Type: application/json");
header("X-Content-Type-Options: nosniff");

// validate input
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data["name"], $data["phone"], $data["email"], $data["password"])) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields"
    ]);
    exit;
}

// sanitise input
$name = trim($data["name"]);
$phone = trim($data["phone"]);
$email = trim($data["email"]);
$password = $data["password"];

// email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid email format"
    ]);
    exit;
}

// phone validation
if (!preg_match("/^[0-9]{10}$/", $phone)) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid phone number"
    ]);
    exit;
}

// check duplicate email
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        "status" => "error",
        "error_type" => "email_exists",
        "message" => "Email already exists"
    ]);
    exit;
}

// hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// insert user
$stmt = $conn->prepare("INSERT INTO users (name, phone, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $phone, $email, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Registered successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Registration failed"
    ]);
}