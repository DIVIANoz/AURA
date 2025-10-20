<?php
session_start();
include '../config/dbconfig.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Handle quantity update
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

// Handle removal of single item
if (isset($_GET['remove'])) {
    $cart_id = intval($_GET['remove']);
    $conn->query("DELETE FROM cart WHERE id=$cart_id AND user_id=$user_id");
    header("Location: cart.php");
    exit;
}

// Fetch cart items
$cart_items = $conn->query("
    SELECT c.id as cart_id, p.id as product_id, p.name, p.price, p.image, c.quantity
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
<link rel="stylesheet" href="../assets/css/style.css">
<style>
.products-grid { display: flex; flex-direction: column; gap: 1rem; max-width: 800px; margin: auto; }
.cart-item { display: flex; align-items: center; gap: 1rem; border-bottom: 1px solid #ccc; padding: 10px 0; }
.cart-item img { width: 80px; height: auto; }
.cart-item div { flex: 1; }
.cart-actions { display: flex; gap: 0.5rem; }
.cart-total { text-align: right; font-weight: bold; margin-top: 1rem; }
button, input[type="number"] { padding: 5px; font-size: 0.9rem; }
</style>
</head>
<body>
<?php include 'header.php'; ?>

<main>
<h2>My Cart</h2>

<?php if ($cart_items->num_rows > 0): ?>
<form method="POST">
<div class="products-grid">
    <?php 
    $total = 0;
    while ($item = $cart_items->fetch_assoc()): 
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    ?>
    <div class="cart-item">
        <img src="../assets/Products/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
        <div>
            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
            <p>₱<?php echo number_format($item['price'], 2); ?> x 
               <input type="number" name="quantities[<?php echo $item['cart_id']; ?>]" value="<?php echo $item['quantity']; ?>" min="0" style="width:50px;">
            </p>
        </div>
        <div class="cart-actions">
            <p>Subtotal: ₱<?php echo number_format($subtotal, 2); ?></p>
            <a href="?remove=<?php echo $item['cart_id']; ?>" onclick="return confirm('Remove this item?')">Remove</a>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<div class="cart-total">
    Total: ₱<?php echo number_format($total, 2); ?>
</div>

<div style="text-align:right; margin-top:10px;">
    <button type="submit" name="update_cart">Update Cart</button>
    <a href="checkout.php" class="shop-btn">Proceed to Payment</a>
</div>
</form>

<?php else: ?>
<p>Your cart is empty.</p>
<?php endif; ?>
</main>

</body>
</html>
