<?php
session_start();
include '../config/dbconfig.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Only admins allowed here
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' AND role='admin'";
    $result = $conn->query($query);

    if ($result && $result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['username'];
        $_SESSION['role'] = 'admin';

        header("Location: admin_page.php");
        exit;
    } else {
        $message = "Invalid admin credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | AURA</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="admin-login-container">
        <h2>Admin Login</h2>
        <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>

        <form method="POST">
            <label>Email:</label><br>
            <input type="email" name="email" required><br><br>

            <label>Password:</label><br>
            <input type="password" name="password" required><br><br>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
