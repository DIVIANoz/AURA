<?php
session_start();
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
$is_logged_in = isset($_SESSION['user_name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AURA - Cart</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Universal Header/Footer CSS -->
    <link rel="stylesheet" href="../assets/css/header-footer.css">

    <!-- Page-specific Cart CSS -->
    <link rel="stylesheet" href="../assets/css/cartstyle.css">
</head>
<body>

    <!-- ===== HEADER ===== -->
    <header class="site-header">
        <div class="site-header-content">
            <div class="site-logo-container">
                <img src="../assets/img/Logo-W.png" alt="AURA Logo" class="site-logo-img">
            </div>

            <nav class="site-nav">
                <ul class="site-center-nav">
                    <li><a href="cart.php" class="active">CART</a></li>
                    <li><a href="../index.php">HOME</a></li>
                    <li><a href="aboutus.php">ABOUT US</a></li>
                </ul>

                <ul class="site-right-actions">
                    <?php if ($is_logged_in): ?>
                        <li class="site-welcome-text">Welcome, <?= htmlspecialchars($user_name); ?>!</li>
                        <li><a href="logout.php" class="site-signup-btn">LOG OUT</a></li>
                    <?php else: ?>
                        <li><a href="login.php" class="site-nav-link">LOG IN</a></li>
                        <li><a href="signup.php" class="site-signup-btn">SIGN UP</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ===== CART CONTENT ===== -->
    <main class="cart-page">
        <div class="cart-container" id="cart-container">
            <!-- JS will dynamically add cart items here -->
        </div>

        <div class="bottom">
            <div class="bottom-left">
                <input type="checkbox" id="selectAll">
                <label for="selectAll">All</label>
            </div>
            <div class="bottom-right">
                <div class="total" id="totalPrice">₱ 0</div>
                <button class="checkout-btn" id="checkoutBtn">Check Out (0)</button>
            </div>
        </div>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="site-footer">
        <div class="site-footer-content">
            <div class="site-social-links">
                <a href="#" class="site-social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="site-social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="site-social-icon"><i class="fab fa-twitter"></i></a>
            </div>
            <div class="site-copyright">
                © <?= date('Y'); ?> AURA. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="../assets/js/cartjs.js"></script>
</body>
</html>
