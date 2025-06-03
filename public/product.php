<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
require_once "../config/db.php";



// Check if ID is set in URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

// Sanitize ID
$id = (int) $_GET['id'];

// Fetch product by ID
$sql = "SELECT * FROM products WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?> - Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!--  Navbar -->
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

<!--  Product Details -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <?php if ($product["image"]): ?>
                        <img src="../uploads/<?= htmlspecialchars($product["image"]) ?>" class="card-img-top" alt="Product Image">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/400x300?text=No+Image" class="card-img-top" alt="No image">
                    <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <h4 class="text-success">₹<?= $product['price'] ?></h4>
            <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

            <a href="order.php?product_id=<?= $product['id'] ?>" class="btn btn-primary mt-3">Order Now</a>
            <a href="index.php" class="btn btn-secondary mt-3">Back to Products</a>
        </div>
    </div>
</div>

</body>
</html>
