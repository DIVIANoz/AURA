<?php
session_start();
include '../config/dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);

    // Check if product exists first
    $check_product = $conn->prepare("SELECT id FROM products WHERE id = ?");
    $check_product->bind_param("i", $product_id);
    $check_product->execute();
    $result = $check_product->get_result();
    if ($result->num_rows === 0) {
        die("Product does not exist.");
    }

    // Check if product already in cart
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

    header("Location: cart.php");
    exit;
}

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

                <!-- Navigation -->
                <nav class="site-nav">
                    <ul class="site-center-nav">
                        <li><a href="cart.php">CART</a></li>
                        <li><a href="../index.php">HOME</a></li>
                        <li><a href="aboutus.php">ABOUT US</a></li>
                    </ul>

                    <ul class="site-right-actions">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="site-welcome-text">
                                Welcome, <?= htmlspecialchars($_SESSION['first_name']); ?>!
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

            <!-- Example Product Card -->
            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="6">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Celestial Oud</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Celestial-Oud.png" alt="Celestial Oud">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="4">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Midnight Recerie</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Midight-Recerie.png" alt="Midnight Recerie">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="25">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Apex</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Apex.png" alt="Apex">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="7">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Velle</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Velle.png" alt="Velle">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="8">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="9">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="10">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="11">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="12">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="14">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="15">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="16">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="17">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="18">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="19">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="20">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="21">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="22">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="23">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="24">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <div class="product-card">
                <p class="product-name">Rose Alchemy</p>
                <div class="product-image">
                    <img src="../assets/img/Products/Rose-Alchemy.png" alt="Rose Alchemy">
                </div>
                <div class="price">₱ 4,200</div>
                <form method="POST">
                    <input type="hidden" name="product_id" value="25">
                    <div class="button-group">
                        <button type="button" class="buy-btn">BUY</button>
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>

            <!-- Repeat product cards for other items (with unique product_id) -->

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
    </div>
</body>

</html>