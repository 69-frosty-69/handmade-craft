<?php
// Save this as tools/insert_users.php and run once in browser
require_once "../config/db.php";

$admin_pass = password_hash("admin123", PASSWORD_DEFAULT);
$user_pass = password_hash("user123", PASSWORD_DEFAULT);

$pdo->exec("INSERT INTO users (username, password, is_admin) VALUES 
    ('admin', '$admin_pass', 1),
    ('john', '$user_pass', 0)
");

echo "Sample users inserted!";
?>
