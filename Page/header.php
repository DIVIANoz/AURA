<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div class="header-content">
        <div class="logo-container">
            <a href="../index.php">
                <a href="../index.php"><img src="../assets/img/Logo-W.png" alt="AURA Logo" class="logo-img" id="siteLogo"></a>
            </a>
        </div>
        <nav>
            <ul class="center-nav">
                <li><a href="cart.php">CART</a></li>
                <li><a href="shop.php">SHOP</a></li>
                <li><a href="about.php">ABOUT US</a></li>
            </ul>

            <ul class="right-actions">
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li><a href="login.php" class="login-btn">Sign In</a></li>
                <?php else: ?>
                    <li><a href="logout.php" class="logout-btn">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
