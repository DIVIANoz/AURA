<?php
session_start();
include '../config/dbconfig.php';

// Checks if Amin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

// Update order status
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();
    $stmt->close();
}

// Gets all orders and user data
$orders = $conn->query("
    SELECT 
        o.*, 
        u.first_name, 
        u.last_name, 
        u.address, 
        u.phone
    FROM orders o 
    LEFT JOIN users u ON o.user_id = u.id 
    ORDER BY o.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders | AURA Admin</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Customer Orders</h1>
            <nav>
                <a href="admin_page.php">Products</a> |
                <a href="admin_orders.php" class="active">Orders</a> |
                <a href="../logout.php">Logout</a>
            </nav>
        </header>

        <section class="orders-section">
            <?php if ($orders && $orders->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Total (₱)</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($order = $orders->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td>
                                <?php 
                                $fullname = trim(($order['first_name'] ?? '') . ' ' . ($order['last_name'] ?? ''));
                                echo htmlspecialchars($fullname ?: 'Guest');
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($order['address'] ?? '—'); ?></td>
                            <td><?php echo htmlspecialchars($order['phone'] ?? '—'); ?></td>
                            <td><?php echo number_format($order['total'], 2); ?></td>

                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="pending" <?php if ($order['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                        <option value="shipped" <?php if ($order['status'] == 'shipped') echo 'selected'; ?>>Shipped</option>
                                        <option value="completed" <?php if ($order['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                                        <option value="cancelled" <?php if ($order['status'] == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>

                            <td><?php echo $order['created_at']; ?></td>
                            <td><a href="order_view.php?id=<?php echo $order['id']; ?>">View</a></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No orders found.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
