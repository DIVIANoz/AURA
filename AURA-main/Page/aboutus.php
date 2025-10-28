<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AURA - About Us</title>

    <!-- Universal header-footer CSS -->
    <link rel="stylesheet" href="../assets/css/header-footer.css">

    <!-- Page-specific CSS -->
    <link rel="stylesheet" href="../assets/css/aboutsstyle.css">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- ===== HEADER ===== -->
    <header class="site-header">
        <div class="site-header-content">
            <div class="site-logo-container">
                <img src="../assets/img/Logo-W.png" alt="AURA Logo" class="site-logo-img" id="siteLogo">
            </div>

            <nav class="site-nav">
                <ul class="site-center-nav">
                    <li><a href="cart.php">CART</a></li>
                    <li><a href="../index.php">HOME</a></li>
                    <li><a href="aboutus.php" class="active">ABOUT US</a></li>
                </ul>

                <ul class="site-right-actions">
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="site-welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
                        <li><a href="logout.php" class="site-signup-btn">LOG OUT</a></li>
                    <?php else: ?>
                        <li><a href="login.php" class="site-nav-link">LOG IN</a></li>
                        <li><a href="signup.php" class="site-signup-btn">SIGN UP</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="about-page">
        <div class="main-flex">
            <div class="left-block">
                <section class="about-section">
                    <h1>About AURA</h1>
                    <p>Welcome to AURA, where we believe that every scent tells a unique story. Our passion for <br>
                    perfumery combines artisanal craftsmanship with modern sophistication to create fragrances<br>
                    that capture moments, memories, and emotions.</p>

                    <div class="about-content">
                        <h2>Our Story</h2>
                        <p>Founded with a vision to create personal and timeless fragrances, AURA has been dedicated<br>
                        to the art of perfumery. We carefully select the finest ingredients and combine them to
                        create<br> scents that resonate with individuality and elegance.</p>

                        <h2>Our Philosophy</h2>
                        <p>At AURA, we believe that perfume is more than just a fragrance – it's a form of self-expression.<br>
                        Each of our creations is designed to enhance your personal story, adding subtle sophistication<br> to
                        your everyday moments.</p>
                    </div>
                    <br>

                    <div class="social-links-row">
                        <div class="social-item facebook">
                            <img src="../assets/img/facebook.jpg" alt="Facebook">
                            <a href="#" target="_blank" style="color:inherit;text-decoration:none;">AURA_scent</a>
                        </div>
                        <div class="social-item instagram">
                            <img src="../assets/img/insta.jpg" alt="Instagram">
                            <a href="#" target="_blank" style="color:inherit;text-decoration:none;">AURA_scent</a>
                        </div>
                        <div class="social-item twitter">
                            <img src="../assets/img/twitter.jpg" alt="Twitter">
                            <a href="#" target="_blank" style="color:inherit;text-decoration:none;">AURA_scent</a>
                        </div>
                    </div>
                </section>
            </div>

            <div class="right-block">
                <h1 class="aura-title">AURA</h1>
            </div>
        </div>
    </main>

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
        </div>
    </footer>
</body>
</html>
