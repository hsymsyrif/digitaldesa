<?php
$host = 'localhost';
$db   = 'user_management';
$user = 'root';  // Ganti dengan user MySQL Anda
$pass = '';      // Ganti dengan password MySQL Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

