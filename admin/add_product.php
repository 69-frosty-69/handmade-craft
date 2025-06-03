<?php
require_once "../config/db.php";  // Connect to the database

// Define variables and initialize with empty values
$name = $price = $description = "";
$success = $error = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $name = trim($_POST["name"]);
    $price = trim($_POST["price"]);
    $description = trim($_POST["description"]);

    if (empty($name) || empty($price) || empty($description)) {
        $error = "All fields are required.";
    } elseif (!is_numeric($price)) {
        $error = "Price must be a number.";
    } else {
        // Insert into database
        $sql = "INSERT INTO products (name, price, description) VALUES (:name, :price, :description)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":description", $description);

        if ($stmt->execute()) {
            $success = "Product added successfully.";
            // Clear form
            $name = $price = $description = "";
        } else {
            $error = "Failed to add product.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Product</h2>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form action="" method="post" class="mt-4">
        <div class="mb-3">
            <label for="name" class="form-label">Product Name:</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price (INR):</label>
            <input type="text" name="price" class="form-control" value="<?= htmlspecialchars($price) ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($description) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Add Product</button>
        <a href="../public/index.php" class="btn btn-secondary">Back to Home</a>
    </form>
</div>
</body>
</html>
