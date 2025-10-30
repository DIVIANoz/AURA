<?php
session_start();
include '../config/dbconfig.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Update quantities
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $cart_id => $qty) {
        $qty = intval($qty);
        if ($qty > 0) {
            $conn->query("UPDATE cart SET quantity=$qty WHERE id=$cart_id AND user_id=$user_id");
        } else {
            $conn->query("DELETE FROM cart WHERE id=$cart_id AND user_id=$user_id");
        }
    }
    header("Location: cart.php");
    exit;
}

// Remove item
if (isset($_GET['remove'])) {
    $cart_id = intval($_GET['remove']);
    $conn->query("DELETE FROM cart WHERE id=$cart_id AND user_id=$user_id");
    header("Location: cart.php");
    exit;
}

// Fetch cart items
$cart_items = $conn->query("
    SELECT c.id AS cart_id, p.id AS product_id, p.name, p.price, p.image, c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id=$user_id
");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Cart | AURA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/header-footer.css">
    <link rel="stylesheet" href="../assets/css/cartstyle.css">
</head>

<body>

    <!-- HEADER -->
    <header class="site-header">
        <div class="site-header-content">
            <div class="site-logo-container">
                <img src="../assets/img/Logo-W.png" alt="AURA" class="site-logo-img">
            </div>

            <!-- Center Navigation -->
            <nav class="site-center-nav site-nav">
                <ul>
                    <li><a href="cart.php" class="active">CART</a></li>
                    <li><a href="../index.php">HOME</a></li>
                    <li><a href="aboutus.php">ABOUT US</a></li>
                </ul>
            </nav>

            <!-- Right Actions -->
            <div class="site-right-actions site-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="site-welcome-text">
                        Welcome, <?= htmlspecialchars($_SESSION['first_name']); ?>!
                    </span>
                    <form action="logout.php" method="POST" style="display:inline;">
                        <button type="submit" class="site-signup-btn">Logout</button>
                    </form>
                <?php else: ?>
                    <a href="login.php"><button class="site-signup-btn">Login</button></a>
                    <a href="signup.php"><button class="site-signup-btn">Sign Up</button></a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- MAIN CART SECTION -->
    <main class="cart-container">
        <h2 class="cart-title">My Cart</h2>

        <?php if ($cart_items->num_rows > 0): ?>
            <form method="POST" class="cart-form">
                <div class="cart-list">
                    <?php
                    $total = 0;
                    while ($item = $cart_items->fetch_assoc()):
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                        ?>
                        <div class="cart-item">
                            <div class="cart-image">
                                <img src="../assets/img/Products/<?php echo htmlspecialchars($item['image']); ?>"
                                    alt="<?php echo htmlspecialchars($item['name']); ?>">
                            </div>

                            <div class="cart-details">
                                <h3 class="cart-name"><?php echo htmlspecialchars($item['name']); ?></h3>
                                <p class="cart-price">₱<?php echo number_format($item['price'], 2); ?></p>
                                <div class="quantity-control">
                                    <label>Qty:</label>
                                    <input type="number" name="quantities[<?php echo $item['cart_id']; ?>]"
                                        value="<?php echo $item['quantity']; ?>" min="0">
                                </div>
                            </div>

                            <div class="cart-summary">
                                <p class="cart-subtotal">
                                    Subtotal: ₱<?php echo number_format($subtotal, 2); ?>
                                </p>
                                <a href="?remove=<?php echo $item['cart_id']; ?>" class="remove-btn"
                                    onclick="return confirm('Remove this item?')">
                                    Remove
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="cart-total-section">
                    <p class="cart-total">Total: ₱<?php echo number_format($total, 2); ?></p>
                    <div class="cart-buttons">
                        <button type="submit" name="update_cart" class="primary-btn">Update Cart</button>
                        <a href="checkout.php" class="secondary-btn">Proceed to Payment</a>
                    </div>
                </div>
            </form>

        <?php else: ?>
            <p class="empty-cart">Your cart is empty.</p>
        <?php endif; ?>
    </main>

    <!-- FOOTER (Universal) -->
    <footer class="site-footer">
        <div class="site-footer-content">
            <div class="site-social-links">
                <a href="#" class="site-social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="site-social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="site-social-icon"><i class="fab fa-twitter"></i></a>
            </div>
            <div class="site-copyright">
                © <?= date('Y') ?> AURA — All rights reserved
            </div>
        </div>
    </footer>

</body>

</html>