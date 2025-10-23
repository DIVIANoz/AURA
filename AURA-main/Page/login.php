<?php
session_start();
include '../config/dbconfig.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Use prepared statements for security
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // ✅ Verify password (matches password_hash from signup)
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: add_product.php");
            } else {
                header("Location: ../index.php");
            }
            exit;
        } else {
            $message = "<p style='color:red;'>Invalid username or password</p>";
        }
    } else {
        $message = "<p style='color:red;'>Invalid username or password</p>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | AURA</title>
</head>
<body>
  <h2>Login</h2>
  <?php if ($message) echo $message; ?>

  <form method="POST">
      <label>Username:</label><br>
      <input type="text" name="username" required><br><br>

      <label>Password:</label><br>
      <input type="password" name="password" required><br><br>

      <button type="submit">Login</button>
  </form>

  <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
</body>
</html>
