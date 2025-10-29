<?php
session_start();
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
$is_logged_in = isset($_SESSION['user_name']);

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
    
?>
<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AURA Fragrances</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Universal CSS -->
    <link rel="stylesheet" href="../assets/css/header-footer.css">
    <!-- Shop-specific CSS -->
    <link rel="stylesheet" href="../assets/css/shopstyle.css">
</head>

<body>
    <div class="shop-page">

        <!-- ===== HEADER ===== -->
        <header class="site-header">
            <div class="site-header-content">

                <!-- Logo -->
                <div class="site-logo-container">
                    <img src="../assets/img/Logo-W.png" alt="AURA" class="site-logo-img">
                </div>

                <!-- Center Navigation -->
                <nav class="site-nav">
                    <ul class="site-center-nav">
                        <li><a href="cart.php">CART</a></li>
                        <li><a href="../index.php">HOME</a></li>
                        <li><a href="aboutus.php">ABOUT US</a></li>
                    </ul>

                    <ul class="site-right-actions">
                        <?php if (isset($_SESSION['username'])): ?>
                            <li class="site-welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                            </li>
                            <li><a href="logout.php" class="site-signup-btn">LOG OUT</a></li>
                        <?php else: ?>
                            <li><a href="login.php" class="site-nav-link">LOG IN</a></li>
                            <li><a href="signup.php" class="site-signup-btn">SIGN UP</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- ===== PRODUCTS GRID ===== -->
        <main class="products-container">
            <!-- Product 1 -->
            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="AURA Classic">
                </div>
                <div class="price">₱ 4,200</div>
                <div class="button-group">
                    <button class="buy-btn">BUY</button>
                    <button class="cart-btn">ADD TO CART</button>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="product-card">
                <p class="product-name">Celestial Oud</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Celestial-Oud.png" alt="AURA Ville">
                </div>
                <div class="price">₱ 8,700</div>
                <div class="button-group">
                    <button class="buy-btn">BUY</button>
                    <button class="cart-btn">ADD TO CART</button>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="product-card">
                <p class="product-name">Apex</p>
                <div class="product-image">
                    <a href="apex.php"><img src="../assets/img/Products/Apex.png" alt="AURA Apex"></a>
                </div>
                <div class="price">₱ 6,000</div>
                <div class="button-group">
                    <button class="buy-btn">BUY</button>
                    <button class="cart-btn">ADD TO CART</button>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="product-card">
                <p class="product-name">Midnight Recerie</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Midight-recerie.png" alt="AURA Blue">
                </div>
                <div class="price">₱ 6,000</div>
                <div class="button-group">
                    <button class="buy-btn">BUY</button>
                    <button class="cart-btn">ADD TO CART</button>
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
                    © <?php echo date('Y'); ?> AURA. All rights reserved.
                </div>
            </div>
        </footer>

    </div>
</body>

</html>