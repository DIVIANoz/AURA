<?php
session_start();
include '../config/dbconfig.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AURA Payment</title>
  <link rel="stylesheet" href="../assets/css/paystyle.css">
</head>
<body>
  <!-- HEADER -->
  <header>
    <a href="../index.php">HOME</a>
    <h1>AURA</h1>
    <div></div>
  </header>

  <!-- MAIN PAYMENT SECTION -->
  <main class="checkout">
    <div class="menu-container">
      <button class="menu-btn"><a href="shop.php">MENU</a></button>
    </div>

    <?php if ($cart_items->num_rows > 0): ?>
        <?php 
        $total = 0;
        while($item = $cart_items->fetch_assoc()):
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
        ?>
            <div class="product">
              <img src="../assets/img/Products/<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>">
              <div class="product-info">
                <h2><?= htmlspecialchars($item['name']); ?></h2>
                <p>₱<?= number_format($item['price'], 2); ?> &nbsp;&nbsp;&nbsp; x<?= $item['quantity']; ?></p>
              </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center; font-weight:bold;">Your cart is empty.</p>
    <?php endif; ?>

    <div class="payment-section">
      <h3>Select Payment Method</h3>
      <div class="payment-options">
        <img src="../assets/img/transac/maya.jpg" alt="Maya">
        <img src="../assets/img/transac/visa.jpg" alt="Visa">
        <img src="../assets/img/transac/bpi.jpg" alt="BPI">
        <img src="../assets/img/transac/mastercard.jpg" alt="Mastercard">
      </div>
    </div>
  </main>

  <!-- ORDER SUMMARY -->
  <?php if ($cart_items->num_rows > 0): ?>
    <div class="order-summary">
      <p>₱<?= number_format($total,2); ?></p>
      <form action="place_order.php" method="POST">
        <button type="submit">Place Order</button>
      </form>
    </div>
  <?php endif; ?>

  <!-- FOOTER -->
  <footer></footer>

  <script src="script.js"></script>
</body>
</html>
