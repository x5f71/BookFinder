<?php
$host = "localhost";
$user = "x5f71";
$password = "x5f71x5f71";
$database = "x5f71";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>