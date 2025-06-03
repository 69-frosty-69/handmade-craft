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
    <div class="container">
        <a class="navbar-brand" href="#">Handmade Crafts</a>
        <a class="btn btn-light" href="../admin/add_product.php">+ Add Product</a>
    </div>
</nav>

<!--  Main Container -->
<div class="container mt-5">
    <h1 class="mb-4">Our Handmade Products</h1>

    <div class="row">
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="Craft Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text"><strong>₹<?= $product['price'] ?></strong></p>
                            <p class="card-text"><?= substr(htmlspecialchars($product['description']), 0, 80) ?>...</p>
                            <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
