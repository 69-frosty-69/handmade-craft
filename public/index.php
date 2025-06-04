<?php
session_start();

?>

<?php
require_once "../config/db.php";

// Fetch all products from database
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Handmade Crafts</title>
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
        <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
        </li>
    <?php endif; ?>
</ul>
</nav>

<!--  Main Container -->

<div class="container mt-5">
    <h1>Handmade Craft Products</h1>
    <div class="row mt-4">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if ($product["image"]): ?>
                        <img src="../uploads/<?= htmlspecialchars($product["image"]) ?>" class="card-img-top" alt="Product Image">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/400x300?text=No+Image" class="card-img-top" alt="No image">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product["name"]) ?></h5>
                        <p class="card-text">Price: ₹<?= htmlspecialchars($product["price"]) ?></p>
                        <p class="card-text"><?= nl2br(htmlspecialchars(substr($product["description"], 0, 100))) ?>...</p>
                        <a href="product.php?id=<?= $product["id"] ?>" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
