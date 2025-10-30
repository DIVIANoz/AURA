<?php
session_start();
include '../config/dbconfig.php';
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
            <div class="site-logo-container">
                <a href="../index.php"><img src="../assets/img/Logo-W.png" alt="AURA" class="site-logo-img"></a>
            </div>

            <nav class="site-nav">
                <ul class="site-center-nav">
                    <li><a href="cart.php">CART</a></li>
                    <li><a href="shop.php" class="active">SHOP</a></li>
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
        <?php
        $products = $conn->query("SELECT * FROM products ORDER BY id DESC");
        if ($products && $products->num_rows > 0) {
            while ($product = $products->fetch_assoc()):
        ?>
            <div class="product-card">
                <p class="product-name"><?= htmlspecialchars($product['name']); ?></p>
                <div class="product-image">
                    <img src="../assets/img/Products/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                </div>
                <div class="price">₱ <?= number_format($product['price'], 2); ?></div>
                <form method="POST" action="cart_add.php">
                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                    <div class="button-group">
                        <button type="submit" class="cart-btn">ADD TO CART</button>
                    </div>
                </form>
            </div>
        <?php
            endwhile;
        } else {
            echo '<p style="grid-column: 1 / -1; text-align:center;">No products available.</p>';
        }
        ?>
    </main>

    <!-- ===== TOAST NOTIFICATION ===== -->
    <div id="toast"></div>

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

<script>
// ===== TOAST NOTIFICATION =====
function showToast(message) {
    const toast = document.getElementById("toast");
    toast.textContent = message;
    toast.classList.add("show");
    setTimeout(() => toast.classList.remove("show"), 2000);
}

// ===== ADD TO CART AJAX =====
document.querySelectorAll(".cart-btn").forEach(button => {
    button.addEventListener("click", (e) => {
        e.preventDefault(); // Prevent default form submission
        const form = e.target.closest("form");
        const formData = new FormData(form);

        fetch(form.action, {
            method: form.method,
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            showToast("Added to cart!");
        })
        .catch(err => {
            showToast("Error adding to cart");
            console.error(err);
        });
    });
});
</script>
</body>
</html>
