<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AURA - Cart</title>
<link rel="stylesheet" href="../assets/css/cartstyle.css">
</head>
<body>

<!-- Navbar -->
<nav>
    <div class="logo">
        <img src="../assets/img/Logo-W.png" alt="AURA Logo" class="logo-img">
    </div>
    <div class="nav-links">
        <a href="cart.php">CART</a>
        <a href="../index.php">HOME</a>
        <a href="aboutus.php">ABOUT US</a>
    </div>
    <div class="search-bar">
        <input type="text" placeholder="Search">
        <span>×</span>
    </div>
</nav>

<!-- Cart Section -->
<div class="cart-container" id="cart-container"></div>

<!-- Bottom Section -->
<div class="bottom">
    <div class="bottom-left">
        <input type="checkbox" id="selectAll">
        <label for="selectAll">All</label>
    </div>
    <div class="bottom-right">
        <div class="total" id="totalPrice">₱ 0</div>
        <button class="checkout-btn" id="checkoutBtn">Check Out (0)</button>
    </div>
</div>

<!-- Footer -->
<footer>
    all rights reserved
</footer>

<script src="../assets/js/cartjs.js"></script>
</body>
</html>