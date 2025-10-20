<?php
session_start();
include '../config/dbconfig.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);
$message = '';
$order_placed = false;

// Fetch cart items
$cart_items = $conn->query("
    SELECT c.id as cart_id, p.id as product_id, p.name, p.price, c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id=$user_id
");

$total = 0;
while ($item = $cart_items->fetch_assoc()) {
    $total += $item['price'] * $item['quantity'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name  = $conn->real_escape_string($_POST['last_name']);
    $phone      = $conn->real_escape_string($_POST['phone']);
    $address    = $conn->real_escape_string($_POST['address']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);

    if ($total <= 0) {
        $message = "Your cart is empty. Add items before checkout.";
    } else {
        // Insert order
        $conn->query("INSERT INTO orders (user_id, total) VALUES ($user_id, $total)");
        $order_id = $conn->insert_id;

        // Insert order items
        $cart_items = $conn->query("
            SELECT c.id as cart_id, p.id as product_id, p.price, c.quantity
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id=$user_id
        ");
        while ($item = $cart_items->fetch_assoc()) {
            $conn->query("INSERT INTO order_items (order_id, product_id, quantity) 
                          VALUES ($order_id, {$item['product_id']}, {$item['quantity']})");
        }

        // Clear cart
        $conn->query("DELETE FROM cart WHERE user_id=$user_id");
        $order_placed = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout | AURA</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
.checkout-form { max-width: 500px; margin: auto; display: flex; flex-direction: column; gap: 1rem; }
.checkout-form input, .checkout-form select, .checkout-form button { padding: 10px; font-size: 1rem; width: 100%; }
.checkout-form h2 { text-align: center; }
.payment-methods { display: flex; flex-direction: column; gap: 0.5rem; }
.total-display { font-weight: bold; text-align: right; margin-bottom: 1rem; }
.message { color: red; text-align: center; margin-bottom: 1rem; }
.thank-you { text-align:center; padding:2rem; }
</style>
</head>
<body>
<?php include 'header.php'; ?>

<main>
<?php if ($order_placed): ?>
    <div class="thank-you">
        <h2>Thank You for Your Purchase!</h2>
        <p>Your order has been successfully placed.</p>
        <a href="shop.php" class="shop-btn">Continue Shopping</a>
    </div>
<?php else: ?>
    <h2 style="text-align:center;">Checkout</h2>
    <?php if ($message) echo "<div class='message'>{$message}</div>"; ?>

    <form class="checkout-form" method="POST">
        <div class="total-display">Total Amount: ₱<?php echo number_format($total, 2); ?></div>

        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="text" name="address" placeholder="Address" required>

        <div class="payment-methods">
            <label>Choose Payment Method:</label>
            <select name="payment_method" required>
                <option value="Gcash">Gcash</option>
                <option value="Maya">Maya</option>
                <option value="BDO">BDO</option>
                <option value="BPI">BPI</option>
            </select>
        </div>

        <button type="submit">Confirm Payment</button>
    </form>
<?php endif; ?>
</main>

</body>
</html>
