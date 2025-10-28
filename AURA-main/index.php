<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Let Your Scent Tell the Story</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/header-footer.css">
    <link rel="stylesheet" href="assets/css/indexxstyle.css">
</head>

<body>
    <!-- ===== HEADER ===== -->
    <header class="site-header">
        <div class="site-header-content">
            <div class="site-logo-container">
                <img src="assets/img/Logo-W.png" alt="AURA Logo" class="site-logo-img" id="siteLogo">
            </div>

            <nav class="site-nav">
                <ul class="site-center-nav">
                    <li><a href="Page/cart.php">CART</a></li>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="Page/aboutus.php">ABOUT US</a></li>
                </ul>

                <ul class="site-right-actions">
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="site-welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
                        <li><a href="Page/logout.php" class="site-logout-btn">LOG OUT</a></li>
                    <?php else: ?>
                        <li><a href="Page/login.php" class="site-login-link">LOG IN</a></li>
                        <li><a href="Page/signup.php" class="site-signup-btn">SIGN UP</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="site-container">
        <main>
            <section class="hero">
                <div class="hero-content">
                    <h1>Let Your Scent Tell the Story</h1>
                    <p>We create perfumes that linger like a memory — soft, personal, and timeless. Each scent is
                        designed to become part of your story, adding beauty to the everyday without ever overwhelming
                        it. Made for those who find meaning in the quiet details.</p>
                    <a href="Page/shop.php" class="shop-btn">SHOP</a>
                </div>
            </section>
        </main>
    </div>

    <!-- ===== FOOTER ===== -->
    <footer class="site-footer">
        <div class="site-footer-content">
            <div class="site-social-links">
                <a href="#" class="site-social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="site-social-icon"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="site-copyright">
                © <?php echo date('Y'); ?> AURA. All rights reserved.
            </div>
            <div style="width: 100px;"></div>
        </div>
    </footer>
</body>

</html>
