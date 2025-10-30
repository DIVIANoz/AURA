<?php
session_start();
include '../config/dbconfig.php';

if (!isset($_SESSION['user_id'])) {
    echo "not_logged_in";
    exit;
}

$user_id = intval($_SESSION['user_id']);
$product_id = intval($_POST['product_id']);

// Check if product already in cart
$check = $conn->query("SELECT * FROM cart WHERE user_id=$user_id AND product_id=$product_id");
if ($check->num_rows > 0) {
    // Increment quantity
    $row = $check->fetch_assoc();
    $newQty = $row['quantity'] + 1;
    $conn->query("UPDATE cart SET quantity=$newQty WHERE id=".$row['id']);
} else {
    // Add new product
    $conn->query("INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)");
}

echo "success";
