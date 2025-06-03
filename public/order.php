<?php
require_once "../config/db.php";

// Initialize
$name = $address = "";
$success = $error = "";
$product_id = isset($_GET['product_id']) ? (int) $_GET['product_id'] : 0;

// Fetch product name for display
$product = null;
if ($product_id > 0) {
    $stmt = $pdo->prepare("SELECT name FROM products WHERE id = :id");
    $stmt->bindParam(":id", $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$product) {
    die("Invalid product.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $address = trim($_POST["address"]);

    if (empty($name) || empty($address)) {
        $error = "Please fill in all fields.";
    } else {
        $sql = "INSERT INTO orders (product_id, name, address) VALUES (:product_id, :name, :address)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":address", $address);

        if ($stmt->execute()) {
            $success = "Order placed successfully!";
            $name = $address = "";
        } else {
            $error = "Failed to place order.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!--  Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Handmade Crafts</a>
    </div>
</nav>

<!--  Order Form -->
<div class="container mt-5">
    <h2>Order: <?= htmlspecialchars($product['name']) ?></h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" class="mt-4">
        <div class="mb-3">
            <label class="form-label">Product:</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Your Name:</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Delivery Address:</label>
            <textarea name="address" class="form-control" rows="4"><?= htmlspecialchars($address) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Place Ord
