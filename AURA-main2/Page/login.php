<?php
session_start();
include '../config/dbconfig.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Store important session data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: add_product.php");
            } else {
                header("Location: ../index.php");
            }
            exit;
        } else {
            $message = "<p class='login-error'>Invalid email or password</p>";
        }
    } else {
        $message = "<p class='login-error'>Invalid email or password</p>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | AURA</title>

    <link rel="stylesheet" href="../assets/css/header-footer.css">
    <link rel="stylesheet" href="../assets/css/loginstyle.css">
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
                    <?php if (!isset($_SESSION['email'])): ?>
                        <li><a href="../Page/login.php">LOG IN</a></li>
                        <li><a href="../Page/signup.php" class="site-signup-btn">SIGN UP</a></li>
                    <?php else: ?>
                        <li class="site-welcome-text">Welcome, <?= htmlspecialchars($_SESSION['first_name']); ?></li>
                        <li><a href="../Page/logout.php" class="site-signup-btn">LOG OUT</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ===== MAIN LOGIN CONTENT ===== -->
    <main>
        <div class="login-wrapper">
            <div class="login-box">
                <h2>LogIn</h2>

                <?= $message ?>

                <form method="POST">
                    <div class="input-group">
                        <label>Email</label>
                        <input type="text" name="email" required>
                    </div>

                    <div class="input-group">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>

                    <button type="submit">Log In</button>
                </form>

                <p class="signup-link">Don’t have an account? <a href="signup.php">Sign up here</a></p>
            </div>
        </div>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="site-footer">
        <div class="site-footer-content">
            <div class="site-social-links">
                <a href="#" class="site-social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="site-social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="site-social-icon"><i class="fab fa-twitter"></i></a>
            </div>
            <div class="site-copyright">
                © <?= date('Y'); ?> AURA. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
