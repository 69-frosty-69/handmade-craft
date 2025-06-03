<?php
$host = "localhost";       // XAMPP default
$dbname = "handmade_crafts";
$username = "root";        // Default for XAMPP
$password = "";            // Default (no password)

try {
    // PDO = PHP Data Object, safer for DB access
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set error mode to exception for easy debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optional success message
    // echo "Database connection successful!";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
