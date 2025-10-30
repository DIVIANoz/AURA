<?php
include '../config/dbconfig.php';

$newPassword = '123456789';
$hashed = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password=? WHERE email='Auraadmin@gmail.com'");
$stmt->bind_param("s", $hashed);
$stmt->execute();

echo "Admin password reset to: $newPassword";
?>
