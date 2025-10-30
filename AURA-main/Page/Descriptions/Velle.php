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
    <title>AURA - Velle</title>
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
                        <img src="../../assets/img/Products/Velle.png" alt="Velle">
                    </div>
                </div>
            </div>
            <div class="product-detail-right">
                <h1 class="product-title-main">VELLE</h1>
                <h2 class="product-title-sub">Eau de Parfum</h2>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="4">
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
                    VELLE is a soft floral fragrance that captures the essence of springtime sophistication. It
                    opens with a
                    sparkling bouquet of orange blossom, peony, and a hint of zesty bergamot, creating a fresh and
                    uplifting
                    introduction. At the heart, lush Damask rose and delicate jasmine petals intertwine with subtle
                    notes of
                    lily of the valley, evoking elegance and grace. As the fragrance settles, creamy vanilla and
                    white musk
                    form a warm, comforting base, enhanced by soft hints of cedar and sandalwood, leaving an aura of
                    refined
                    sophistication that lingers gracefully. Ideal for both day and evening wear, VELLE embodies
                    timeless
                    femininity and understated charm.
                </p>
            </section>

            <section class="product-ingredients-2col">
                <div>Alcohol Denat. (Carrier) 75.0%</div>
                <div>Citrus Aurantium Dulcis Peel Oil (Orange Blossom) 3.0%</div>
                <div>Paeonia Lactiflora Extract (Peony) 2.5%</div>
                <div>Rosa Damascena Flower Oil (Damask Rose) 4.0%</div>
                <div>Jasminum Officinale Extract (Jasmine) 3.5%</div>
                <div>Convallaria Majalis Extract (Lily of the Valley) 2.0%</div>
                <div>Vanilla Planifolia Extract (Vanilla) 3.0%</div>
                <div>White Musk 2.5%</div>
                <div>Cedrus Atlantica Bark Oil (Cedarwood) 2.0%</div>
                <div>Santalum Album Oil (Sandalwood) 2.5%</div>
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