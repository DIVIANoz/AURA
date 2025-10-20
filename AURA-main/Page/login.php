<?php
session_start();
include '../config/dbconfig.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Only allow normal users
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' AND role='user'";
    $result = $conn->query($query);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['email'] = $user['email'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: ../index.php");
        exit;
    } else {
        $message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | AURA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/img/Logo-S.png">
</head>
<body>
<header>
    <div class="header-content">
        <div class="logo-container">
            <img src="../assets/img/Logo-W.png" alt="AURA Logo" class="logo-img" id="siteLogo">
        </div>
        <nav>
            <ul class="center-nav">
                <li><a href="cart.php">CART</a></li>
                <li><a href="../index.php">HOME</a></li>
                <li><a href="about.php">ABOUT US</a></li>
            </ul>
            <ul class="right-actions">
                <?php if (!isset($_SESSION['username'])): ?>
                    <li><a href="login.php">LOG IN</a></li>
                    <li><a href="signup.php" class="signup-btn">SIGN UP</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main>
    <section class="login-section">
        <h2>Login</h2>
        <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>

        <form method="POST">
            <label>Email:</label><br>
            <input type="email" name="email" required><br><br>

            <label>Password:</label><br>
            <input type="password" name="password" required><br><br>

            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </section>
</main>
</body>
</html>
