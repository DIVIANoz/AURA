<?php
session_start();
include '../config/dbconfig.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);

    $checkEmail = $conn->prepare("SELECT id FROM accounts WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        $message = "<p class='form-error'>Email already registered!</p>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO accounts (username, email, password, address, phone, role) VALUES (?, ?, ?, ?, ?, 'user')");
        $stmt->bind_param("sssss", $username, $email, $hashed_password, $address, $phone);

        if ($stmt->execute()) {
            $message = "<p class='form-success'>Signup successful! You can now <a href='login.php'>login</a>.</p>";
        } else {
            $message = "<p class='form-error'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }

    $checkEmail->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up | AURA</title>

    <!-- Universal header-footer CSS -->
    <link rel="stylesheet" href="../assets/css/header-footer.css">

    <!-- Page-specific CSS -->
    <link rel="stylesheet" href="../assets/css/signupstyle.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- ===== HEADER ===== -->
    <header class="site-header">
        <div class="site-header-content">
            <div class="site-logo-container">
                <img src="../assets/img/Logo-W.png" alt="AURA Logo" class="site-logo-img" id="siteLogo">
            </div>

            <nav class="site-nav">
                <ul class="site-center-nav">
                    <li><a href="../Page/cart.php">CART</a></li>
                    <li><a href="../index.php">HOME</a></li>
                    <li><a href="../Page/aboutus.php">ABOUT US</a></li>
                </ul>

                <ul class="site-right-actions">
                    <?php if (!isset($_SESSION['username'])): ?>
                        <li><a href="../Page/login.php">LOG IN</a></li>
                        <li><a href="../Page/signup.php" class="site-signup-btn">SIGN UP</a></li>
                    <?php else: ?>
                        <li class="site-welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                        <li><a href="../Page/logout.php" class="site-signup-btn">LOG OUT</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ===== MAIN SIGNUP CONTENT ===== -->
    <main>
        <div class="signup-wrapper">
            <div class="signup-box">
                <h2>Create Account</h2>

                <?php if ($message) echo $message; ?>

                <form method="POST">
                    <div class="input-group">
                        <label>Username</label>
                        <input type="text" name="username" required>
                    </div>

                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="email" required>
                    </div>

                    <div class="input-group">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>

                    <div class="input-group">
                        <label>Address</label>
                        <input type="text" name="address">
                    </div>

                    <div class="input-group">
                        <label>Phone</label>
                        <input type="text" name="phone">
                    </div>

                    <button type="submit">Sign Up</button>
                </form>

                <p class="signup-link">Already have an account? <a href="login.php">Log in here</a></p>
            </div>
        </div>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="site-footer">
        <div class="site-footer-content">
            <div class="site-social-links">
                <a href="#" class="site-social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="site-social-icon"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="site-copyright">
                © <?php echo date('Y'); ?> AURA. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
