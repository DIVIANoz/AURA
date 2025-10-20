<?php
session_start();
include '../config/dbconfig.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | AURA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/img/Logo-S.png">
</head>
<body>

<header>
    <div class="header-content">
        <div class="logo-container">
            <img src="../assets/img/Logo-W.png" alt="AURA Logo" class="logo-img" id="siteLogo">
        </div>
        <nav>
            <ul class="center-nav">
                <li><a href="cart.php">CART</a></li>
                <li><a href="../index.php">HOME</a></li>
                <li><a href="about.php">ABOUT US</a></li>
            </ul>
            <ul class="right-actions">
                <?php if (!isset($_SESSION['username'])): ?>
                    <li><a href="login.php">LOG IN</a></li>
                    <li><a href="signup.php" class="signup-btn">SIGN UP</a></li>
                <?php else: ?>
                    <li><span>Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></span></li>
                    <li><a href="../logout.php">LOG OUT</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main>
    <h2>Our Collection</h2>

    <div class="product-grid">
        <?php
        $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="product-card">
                    <a href="product.php?id=<?php echo $row['id']; ?>">
                        <img src="../assets/img/Products/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    </a>
                    <h3><?php echo $row['name']; ?></h3>
                    <p>₱<?php echo number_format($row['price'], 2); ?></p>
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                </div>
                <?php
            }
        } else {
            echo "<p>No products available.</p>";
        }
        ?>
    </div>
</main>

<footer>
    <div class="footer-content">
        <div class="social-links">
            <a href="#">Facebook</a> |
            <a href="#">Instagram</a>
        </div>
        <p>© <?php echo date('Y'); ?> AURA. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
