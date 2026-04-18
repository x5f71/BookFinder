<?php
session_start();

header("Content-Type: application/json");

$captchas = [
    "image1.jpg" => "Aeik2",
    "image2.jpg" => "ecb4f",
    "image3.jpg" => "7PlBJ7",
    "image4.jpg" => "24quz",
];

$keys = array_keys($captchas);
$randomKey = $keys[array_rand($keys)];

$_SESSION["captcha"] = $captchas[$randomKey];

echo json_encode([
    "image" => "assets/images/captcha/" . $randomKey
]);