<?php
session_start();
include '../config/dbconfig.php';

// Check if order_id is provided
if (!isset($_GET['order_id'])) {
    header("Location: ../index.php");
    exit;
}

$order_id = intval($_GET['order_id']);

// Fetch order details
$order = $conn->query("SELECT * FROM orders WHERE id = $order_id")->fetch_assoc();
if (!$order) {
    echo "Order not found.";
    exit;
}

// Fetch ordered items
$items = $conn->query("
    SELECT oi.*, p.name, p.image
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = $order_id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success | AURA</title>
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
                <li><a href="../index.php">HOME</a></li>
                <li><a href="shop.php">SHOP</a></li>
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
    <h2>Thank You for Your Order!</h2>
    <p>Your order has been placed successfully. Below are your order details:</p>

    <h3>Order Information</h3>
    <p><strong>Order ID:</strong> <?php echo $order['id']; ?></p>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($order['fullname']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
    <p><strong>Date:</strong> <?php echo $order['order_date']; ?></p>
    <p><strong>Total Amount:</strong> ₱<?php echo number_format($order['total_amount'], 2); ?></p>

    <h3>Ordered Items</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
        <?php while ($item = $items->fetch_assoc()): ?>
            <tr>
                <td><img src="../assets/img/Products/<?php echo $item['image']; ?>" width="60"></td>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>₱<?php echo number_format($item['price'], 2); ?></td>
                <td>₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="../index.php">← Back to Home</a>
</main>

</body>
</html>
