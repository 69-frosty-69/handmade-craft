<?php
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../public/login.php");
    exit;
}
?>
<?php

require_once "../config/db.php";

$name = $price = $description = "";
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $price = trim($_POST["price"]);
    $description = trim($_POST["description"]);

    if (empty($name) || empty($price) || empty($description)) {
        $error = "All fields are required.";
    } else {
        // Handle image upload
        $imagePath = null;
        if (!empty($_FILES["image"]["name"])) {
            $targetDir = "../uploads/";
            $fileName = basename($_FILES["image"]["name"]);
            $targetFile = $targetDir . time() . "_" . $fileName;

            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedTypes = ["jpg", "jpeg", "png", "gif"];

            if (!in_array($imageFileType, $allowedTypes)) {
                $error = "Only JPG, JPEG, PNG, GIF files are allowed.";
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    $imagePath = basename($targetFile); // just the filename for DB
                } else {
                    $error = "Failed to upload image.";
                }
            }
        }

        if (empty($error)) {
            $stmt = $pdo->prepare("INSERT INTO products (name, price, description, image) VALUES (:name, :price, :description, :image)");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":image", $imagePath);

            if ($stmt->execute()) {
                $success = "Product added successfully!";
                $name = $price = $description = "";
            } else {
                $error = "Something went wrong.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<ul class="navbar-nav ms-auto">
    <?php if (isset($_SESSION['user_id'])): ?>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
        </li>
    <?php endif; ?>
</ul>
</nav>

<div class="container mt-5" style="max-width: 600px;">
    <h2>Add New Product</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div class="mb-3">
            <label>Price:</label>
            <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($price) ?>" required>
        </div>
        <div class="mb-3">
            <label>Description:</label>
            <textarea name="description" class="form-control" required><?= htmlspecialchars($description) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Product Image (optional):</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button class="btn btn-primary" type="submit">Add Product</button>
    </form>
</div>
</body>
</html>
