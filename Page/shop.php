<?php
session_start();
include '../config/dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $product_id = intval($_POST['product_id']);
    $user_id = intval($_SESSION['user_id']);

    // Check if product already in cart
    $check = $conn->query("SELECT * FROM cart WHERE user_id=$user_id AND product_id=$product_id");

    if ($check->num_rows > 0) {
        // Update quantity
        $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id=$user_id AND product_id=$product_id");
    } else {
        // Insert new item
        $conn->query("INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)");
    }

    // Redirect to cart page after adding
    header("Location: cart.php");

    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop | AURA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<main>
    <h2>Shop</h2>
    <div class="products-grid">
        <?php
        $products = $conn->query("SELECT * FROM products");
        if ($products->num_rows > 0):
            while ($product = $products->fetch_assoc()):
        ?>
        <div class="product-card">
            <a href="product.php?id=<?php echo $product['id']; ?>">
                <img src="../assets/Products/<?php echo htmlspecialchars($product['image']); ?>" 
                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                     class="product-img">
            </a>
            <h3>
                <a href="product.php?id=<?php echo $product['id']; ?>">
                    <?php echo htmlspecialchars($product['name']); ?>
                </a>
            </h3>
            <p>₱<?php echo number_format($product['price'], 2); ?></p>
            
            <?php if (isset($_SESSION['user_id'])): ?>
            <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <button type="submit">Add to Cart</button>
            </form>
            <?php else: ?>
            <a href="login.php" class="shop-btn">Sign in to Add</a>
            <?php endif; ?>
        </div>
        <?php
            endwhile;
        else:
            echo "<p>No products available.</p>";
        endif;
        ?>
    </div>
</main>

</body>
</html>
