<?php
include '../config/dbconfig.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        $message = "Email already exists!";
    } else {
        $sql = "INSERT INTO users (username, email, password, role)
                VALUES ('$username', '$email', '$password', 'user')";
        if ($conn->query($sql)) {
            $message = "Account created! <a href='login.php'>Login here</a>";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | AURA</title>
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
  <h2>Sign Up</h2>
  <?php if ($message) echo "<p>$message</p>"; ?>

  <form method="POST">
      <label>Username:</label><br>
      <input type="text" name="username" required><br><br>

      <label>Email:</label><br>
      <input type="email" name="email" required><br><br>

      <label>Password:</label><br>
      <input type="password" name="password" required><br><br>

      <button type="submit">Create Account</button>
  </form>
</body>
</html>
