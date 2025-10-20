<?php
include '../config/dbconfig.php';

if (!isset($_GET['id'])) {
    die("Product not found.");
}

$id = intval($_GET['id']);
$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();

if (!$product) {
    die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?> | AURA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/img/Logo-S.png">
</head>
<body>
<?php include 'header.php'; ?>
    <a href="shop.php">← Back to Shop</a>
    <h1><?= htmlspecialchars($product['name']) ?></h1>
    <img src="../assets/img/Products/<?= htmlspecialchars($product['image']) ?>" width="300">
    <p><strong>Price:</strong> ₱<?= number_format($product['price'], 2) ?></p>
    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($product['description'])) ?></p>

    <form method="POST" action="cart.php">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <button type="submit">Add to Cart</button>
    </form>
</body>
</html>
