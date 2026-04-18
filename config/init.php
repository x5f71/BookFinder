<?php
session_start();

include __DIR__ . "/db.php";


function isLoggedIn() {
    return isset($_SESSION["user"]);
}

$loggedIn = isLoggedIn();

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}