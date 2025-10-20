<?php
session_start();
include '../config/dbconfig.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Here we could insert into orders table
$total = 0;
$cart_items = $conn->query("
    SELECT c.id as cart_id, p.id as product_id, p.price, c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id=$user_id
");

while ($item = $cart_items->fetch_assoc()) {
    $total += $item['price'] * $item['quantity'];
}

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

// Redirect to thank you page
header("Location: thank_you.php?order_id=$order_id");
exit;
?>
