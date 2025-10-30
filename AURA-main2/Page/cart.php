<?php
session_start();
include '../config/dbconfig.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Fetch cart items
$cart_items = $conn->query("
    SELECT c.id AS cart_id, p.id AS product_id, p.name, p.price, p.image, c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id=$user_id
");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Cart | AURA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/header-footer.css">
    <link rel="stylesheet" href="../assets/css/cartstyle.css">
</head>

<body>

    <!-- HEADER -->
    <header class="site-header">
        <div class="site-header-content">
            <div class="site-logo-container">
                <a href="../index.php"><img src="../assets/img/Logo-W.png" alt="AURA" class="site-logo-img"></a>
            </div>
            <nav class="site-center-nav site-nav">
                <ul>
                    <li><a href="cart.php" class="active">CART</a></li>
                    <li><a href="shop.php">SHOP</a></li>
                    <li><a href="aboutus.php">ABOUT US</a></li>
                </ul>
            </nav>
            <div class="site-right-actions site-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="site-welcome-text">Welcome, <?= htmlspecialchars($_SESSION['first_name']); ?>!</span>
                    <form action="logout.php" method="POST" style="display:inline;">
                        <button type="submit" class="site-signup-btn">Logout</button>
                    </form>
                <?php else: ?>
                    <a href="login.php"><button class="site-signup-btn">Login</button></a>
                    <a href="signup.php"><button class="site-signup-btn">Sign Up</button></a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- CART -->
    <main class="cart-container">
        <h2 class="cart-title">My Cart</h2>

        <?php if ($cart_items->num_rows > 0): ?>
            <div id="cart-container">
                <?php while ($item = $cart_items->fetch_assoc()): ?>
                    <div class="cart-item" data-price="<?= $item['price']; ?>">
                        <div class="item-left">
                            <input type="checkbox" class="item-check" checked>
                            <img src="../assets/img/Products/<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>" class="product-img">
                            <div class="item-details">
                                <div class="item-name"><?= htmlspecialchars($item['name']); ?></div>
                                <div class="price">₱ <?= number_format($item['price'],2); ?></div>
                            </div>
                        </div>
                        <div class="item-right">
                            <div class="quantity-controls">
                                <button class="minus">-</button>
                                <input type="number" class="qty-input" value="<?= $item['quantity']; ?>" min="1">
                                <button class="plus">+</button>
                                <button class="remove-btn" data-cartid="<?= $item['cart_id']; ?>"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="cart-total-section">
                <p>Total: <span id="totalPrice">0</span></p>
                <button id="checkoutBtn" class="primary-btn">Check Out (0)</button>
            </div>

        <?php else: ?>
            <p class="empty-cart">Your cart is empty.</p>
        <?php endif; ?>
    </main>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="site-footer-content">
            <div class="site-social-links">
                <a href="#" class="site-social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="site-social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="site-social-icon"><i class="fab fa-twitter"></i></a>
            </div>
            <div class="site-copyright">
                © <?= date('Y') ?> AURA — All rights reserved
            </div>
        </div>
    </footer>

    <script src="../assets/js/cart.js"></script>
</body>
</html>
