<?php
include '../config/dbconfig.php';

if (!isset($_GET['id'])) {
    die("Order ID not provided.");
}

$order_id = intval($_GET['id']);
$order_query = mysqli_query($conn, "SELECT * FROM orders WHERE id = $order_id");

if (!$order_query || mysqli_num_rows($order_query) == 0) {
    die("Order not found.");
}

$order = mysqli_fetch_assoc($order_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Receipt | AURA Admin</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="receipt-container">
    <div class="receipt-header">
        <h2>🧾 AURA Order Receipt</h2>
        <p>Order ID: <strong>#<?php echo $order['id']; ?></strong></p>
    </div>

    <div class="receipt-details">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
        <p><strong>City:</strong> <?php echo htmlspecialchars($order['city']); ?></p>
        <p><strong>Postal Code:</strong> <?php echo htmlspecialchars($order['postal_code']); ?></p>
        <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
        <p><strong>Order Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>
        <hr>
        <p><strong>Total Amount:</strong> ₱<?php echo number_format($order['total_price'], 2); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
    </div>

    <div class="receipt-footer">
        <p>Thank you for ordering from <strong>AURA</strong>!</p>
        <a href="admin_orders.php" class="back-btn">← Back to Orders</a>
    </div>
</div>

</body>
</html>
