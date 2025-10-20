<?php
session_start();
include '../config/dbconfig.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);

    // Fetch product info
    $result = $conn->query("SELECT * FROM products WHERE id = $product_id");
    if ($result && $result->num_rows === 1) {
        $product = $result->fetch_assoc();

        // Check if product already in cart
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] === $product_id) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }

        // Add new product to cart
        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1
            ];
        }
    }
    header("Location: cart.php");
    exit;
}

// Remove item
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] === $remove_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index
    header("Location: cart.php");
    exit;
}

// Clear cart
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | AURA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    <h2>Your Shopping Cart</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <p>Your cart is empty.</p>
        <a href="shop.php">Continue Shopping</a>
    <?php else: ?>
        <form method="POST" action="checkout.php">
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>Product</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                <?php
                $grand_total = 0;
                foreach ($_SESSION['cart'] as $item):
                    $total = $item['price'] * $item['quantity'];
                    $grand_total += $total;
                ?>
                <tr>
                    <td><img src="../assets/img/Products/<?php echo $item['image']; ?>" width="60"></td>
                    <td><?php echo $item['name']; ?></td>
                    <td>₱<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₱<?php echo number_format($total, 2); ?></td>
                    <td><a href="cart.php?remove=<?php echo $item['id']; ?>">Remove</a></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" align="right"><strong>Grand Total:</strong></td>
                    <td colspan="2"><strong>₱<?php echo number_format($grand_total, 2); ?></strong></td>
                </tr>
            </table>

            <br>
            <a href="cart.php?clear">Clear Cart</a> |
            <a href="shop.php">Continue Shopping</a> |
            <button type="submit" name="checkout">Proceed to Checkout</button>
        </form>
    <?php endif; ?>
</main>

</body>
</html>
