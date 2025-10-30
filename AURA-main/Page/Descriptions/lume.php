<?php
session_start();
include '../../config/dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);

    $check_product = $conn->prepare("SELECT id FROM products WHERE id = ?");
    $check_product->bind_param("i", $product_id);
    $check_product->execute();
    $result = $check_product->get_result();
    if ($result->num_rows === 0)
        die("Product does not exist.");

    $check = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $check->bind_param("ii", $user_id, $product_id);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $update = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
        $update->bind_param("ii", $user_id, $product_id);
        $update->execute();
    } else {
        $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
        $insert->bind_param("ii", $user_id, $product_id);
        $insert->execute();
    }

    header("Location: ../cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AURA - Lume</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/header-footer.css">
    <link rel="stylesheet" href="../../assets/css/Descriptionstyle.css">
</head>

<body>
    <header class="site-header">
        <div class="site-header-content">
            <div class="site-logo-container">
                <img src="../../assets/img/Logo-W.png" alt="AURA Logo" class="site-logo-img">
            </div>
            <nav class="site-nav">
                <ul class="site-center-nav">
                    <li><a href="../cart.php">CART</a></li>
                    <li><a href="../../index.php">HOME</a></li>
                    <li><a href="../aboutus.php">ABOUT US</a></li>
                </ul>
                <ul class="site-right-actions">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="site-welcome-text">
                            Welcome, <?= htmlspecialchars($_SESSION['first_name']); ?>!
                        </li>
                        <li><a href="../logout.php" class="site-signup-btn">LOG OUT</a></li>
                    <?php else: ?>
                        <li><a href="../login.php" class="site-nav-link">LOG IN</a></li>
                        <li><a href="../signup.php" class="site-signup-btn">SIGN UP</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="product-detail-2row-container">
        <div class="product-detail-2row-top">
            <div class="product-detail-left">
                <div class="product-card large">
                    <div class="product-image transparent">
                        <img src="../../assets/img/Products/LUME.png" alt="Lume">
                    </div>
                </div>
            </div>
            <div class="product-detail-right">
                <h1 class="product-title-main">LUME</h1>
                <h2 class="product-title-sub">Eau de Parfum</h2>
                <div class="price">₱ 5,620</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="16">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="product-detail-2row-bottom">
            <section>
                <h3 class="about-title">About Product</h3>
                <p class="product-description">
                    LUME is a luminous fragrance inspired by the glow of morning light. It opens with sparkling notes of
                    bergamot, pear, and a hint of green apple, delivering a fresh and invigorating introduction. The heart
                    blends delicate freesia, peony, and a subtle touch of lily, creating a soft, floral bouquet that
                    evokes gentle elegance. The base unfolds with creamy sandalwood, white musk, and soft amber,
                    leaving a warm, lingering trail that radiates sophistication and comfort. LUME is perfect for daywear
                    or evening occasions, embodying serenity and radiant charm.
                </p>
            </section>

            <section class="product-ingredients-2col">
                <div>Alcohol Denat. (Carrier) 75.0%</div>
                <div>Citrus Aurantium Bergamia Peel Oil (Bergamot) 3.0%</div>
                <div>Pyrus Communis Extract (Pear) 2.5%</div>
                <div>Malus Domestica Extract (Green Apple) 2.0%</div>
                <div>Freesia Refracta Extract (Freesia) 3.0%</div>
                <div>Paeonia Lactiflora Extract (Peony) 2.5%</div>
                <div>Lilium Candidum Extract (Lily) 2.0%</div>
                <div>Santalum Album Oil (Sandalwood) 3.0%</div>
                <div>White Musk 2.5%</div>
            </section>
        </div>
    </main>

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
    </footer>
</body>

</html>
