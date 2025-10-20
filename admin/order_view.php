<?php
session_start();
include '../config/dbconfig.php';

// Admin only
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: admin_orders.php");
    exit;
}

$order_id = intval($_GET['id']);

// Fetch order info
$order = $conn->query("SELECT o.*, u.first_name, u.last_name, u.email
                       FROM orders o
                       JOIN users u ON o.user_id = u.id
                       WHERE o.id=$order_id")->fetch_assoc();

// Fetch order items
$items = $conn->query("SELECT p.name, p.price, oi.quantity
                       FROM order_items oi
                       JOIN products p ON oi.product_id = p.id
                       WHERE oi.order_id=$order_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order #<?php echo $order_id; ?> | AURA</title>
<link rel="stylesheet" href="admin_style.css">
<style>
table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
th, td { padding: 0.5rem; border: 1px solid #ccc; text-align: left; }
</style>
</head>
<body>
<div class="admin-container">
    <header class="admin-header">
        <h1>Order #<?php echo $order_id; ?></h1>
        <a href="admin_orders.php">Back to Orders</a>
    </header>

    <section class="order-details">
        <p><strong>User:</strong> <?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
        <p><strong>Total:</strong> ₱<?php echo number_format($order['total'], 2); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
        <p><strong>Date:</strong> <?php echo $order['created_at']; ?></p>

        <h2>Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $total = 0;
            while($item = $items->fetch_assoc()):
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>₱<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₱<?php echo number_format($subtotal, 2); ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <p><strong>Calculated Total:</strong> ₱<?php echo number_format($total, 2); ?></p>
    </section>
</div>
</body>
</html>
