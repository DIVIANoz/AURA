<?php
session_start();
include '../config/dbconfig.php';

// Restrict to admin only
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Handle order deletion
if (isset($_GET['delete'])) {
    $order_id = intval($_GET['delete']);
    $conn->query("DELETE FROM orders WHERE id=$order_id");
    header("Location: admin_orders.php");
    exit;
}

// Handle status update
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();
    header("Location: admin_orders.php");
    exit;
}

// Fetch all orders
$orders = $conn->query("SELECT o.id, o.user_id, o.total, o.status, o.created_at, u.first_name, u.last_name
                        FROM orders o
                        JOIN users u ON o.user_id = u.id
                        ORDER BY o.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Orders | AURA</title>
<link rel="stylesheet" href="admin_style.css">
<style>
table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
th, td { padding: 0.5rem; border: 1px solid #ccc; text-align: left; }
.actions { display: flex; gap: 0.5rem; }
.actions form { display: inline; margin: 0; }
</style>
</head>
<body>
<div class="admin-container">
    <header class="admin-header">
        <h1>Orders</h1>
        <div class="admin-actions">
            <a href="admin_page.php" class="orders-btn">Back to Dashboard</a>
        </div>
    </header>

    <section class="order-list">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($orders->num_rows > 0): ?>
                <?php while($order = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                    <td>₱<?php echo number_format($order['total'], 2); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <select name="status">
                                <option value="pending" <?php if($order['status']=='pending') echo 'selected'; ?>>Pending</option>
                                <option value="shipped" <?php if($order['status']=='shipped') echo 'selected'; ?>>Shipped</option>
                                <option value="completed" <?php if($order['status']=='completed') echo 'selected'; ?>>Completed</option>
                                <option value="cancelled" <?php if($order['status']=='cancelled') echo 'selected'; ?>>Cancelled</option>
                            </select>
                            <button type="submit" name="update_status">Update</button>
                        </form>
                    </td>
                    <td><?php echo $order['created_at']; ?></td>
                    <td class="actions">
                        <a href="admin_orders.php?delete=<?php echo $order['id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                        <a href="order_view.php?id=<?php echo $order['id']; ?>">View</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">No orders found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </section>
</div>
</body>
</html>
