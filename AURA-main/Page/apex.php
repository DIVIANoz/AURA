<?php
session_start();
$user_name = $_SESSION['user_name'] ?? 'Guest';
$is_logged_in = isset($_SESSION['user_name']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AURA - Apex</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Universal Header/Footer CSS -->
    <link rel="stylesheet" href="../assets/css/header-footer.css">

    <!-- Page-specific Apex CSS -->
    <link rel="stylesheet" href="../assets/css/apexstyle.css">
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
                    <li><a href="cart.php">CART</a></li>
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

    <!-- ===== PRODUCT DETAILS ===== -->
    <main class="product-detail-2row-container">
        <div class="product-detail-2row-top">
            <div class="product-detail-left">
                <div class="product-card large">
                    <div class="product-image transparent">
                        <img src="../assets/img/Products/Apex.png" alt="Apex">
                    </div>
                </div>
            </div>

            <div class="product-detail-right">
                <h1 class="product-title-main">APEX</h1>
                <h2 class="product-title-sub">Eau de Parfum</h2>
                <div class="price">₱ 6,000</div>
                <div class="button-group">
                    <button class="buy-btn">BUY</button>
                    <button class="cart-btn">ADD TO CART</button>
                </div>
            </div>
        </div>

        <div class="product-detail-2row-bottom">
            <section>
                <h3 class="about-title">About Product</h3>
                <p class="product-description">
                    AURA APEX, a Bold Aromatic Woody fragrance designed for the leader and the visionary, embodies the
                    pinnacle of strength and sophistication. It opens with an exhilarating burst of freshness, where the
                    crisp zest of Calabrian bergamot and the electrifying coolness of Sichuan pepper are met by the
                    clean, sharp aroma of juniper berries. This commanding introduction then ascends into a powerful
                    heart, where the smoky, leathery depths of birch tar and the rich earthiness of vetiver are
                    beautifully balanced by the herbaceous refinement of lavender. Finally, the ascent concludes on an
                    enduring, magnificent base, where the creamy warmth of sandalwood, the resonant power of ambroxan,
                    and the grounding masculinity of patchouli merge, creating an undeniably confident and exquisitely
                    long-lasting trail that leaves a profound mark.
                </p>
            </section>

            <section class="product-ingredients-2col">
                <div>Alcohol Denat. (Carrier) 75.0%</div>
                <div>Santalum Album Oil (Sandalwood) 5.0%</div>
                <div>Aqua Oil (Water) 5.0%</div>
                <div>Pogostemon Cablin Leaf Oil (Patchouli) 2.0%</div>
                <div>Vetiveria Zizanoides Root Oil (Vetiver) 4.0%</div>
                <div>Citrus Aurantium Bergamia Peel Oil (Calabrian Bergamot) 2.0%</div>
                <div>Ambroxan (Synthetic Ambergris) 2.5%</div>
                <div>Betula Alba Oil (Birch Tar) 5.0%</div>
                <div>Lavandula Angustifolia Oil (Lavender) 5.0%</div>
                <div>Zanthoxylum Piperitum Fruit Extract (Sichuan Pepper) 4.0%</div>
            </section>
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
        </div>
        <div class="site-copyright">
            © <?= date('Y'); ?> AURA. All rights reserved.
        </div>
        </div>
    </footer>

</body>

</html>