<?php
session_start();
include '../config/dbconfig.php';

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Handle checkout form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $email = $_SESSION['email'];
    $total = 0;

    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Insert into orders table
    $conn->query("INSERT INTO orders (fullname, phone, address, email, total_amount, order_date)
                  VALUES ('$fullname', '$phone', '$address', '$email', '$total', NOW())");

    $order_id = $conn->insert_id;

    // Insert each product in order_items
    foreach ($_SESSION['cart'] as $item) {
        $pid = $item['id'];
        $qty = $item['quantity'];
        $price = $item['price'];
        $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price)
                      VALUES ($order_id, $pid, $qty, $price)");
    }

    // Clear cart
    $_SESSION['cart'] = [];

    header("Location: order_success.php?order_id=$order_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | AURA</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/Logo-S.png">
</head>
<body>
<header>
    <div class="header-content">
        <div class="logo-container">
            <img src="../assets/img/Logo-W.png" alt="AURA Logo" class="logo-img">
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
    <h2>Checkout</h2>

    <form method="POST">
        <label>Full Name:</label><br>
        <input type="text" name="fullname" required><br><br>

        <label>Phone Number:</label><br>
        <input type="text" name="phone" required><br><br>

        <label>Address:</label><br>
        <textarea name="address" rows="3" required></textarea><br><br>

        <h3>Order Summary:</h3>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th></tr>
            <?php
            $grand_total = 0;
            foreach ($_SESSION['cart'] as $item):
                $total = $item['price'] * $item['quantity'];
                $grand_total += $total;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>₱<?php echo number_format($item['price'], 2); ?></td>
                <td>₱<?php echo number_format($total, 2); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" align="right"><strong>Grand Total:</strong></td>
                <td><strong>₱<?php echo number_format($grand_total, 2); ?></strong></td>
            </tr>
        </table>

        <br>
        <button type="submit">Place Order</button>
    </form>
</main>

</body>
</html>
