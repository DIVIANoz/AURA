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
        $message = "Email already registered!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO accounts (username, email, password, address, phone, role) VALUES (?, ?, ?, ?, ?, 'user')");
        $stmt->bind_param("sssss", $username, $email, $hashed_password, $address, $phone);

        if ($stmt->execute()) {
            $message = "Signup successful! You can now <a href='login.php'>login</a>.";
        } else {
            $message = "Error: " . $stmt->error;
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
</head>
<body>
  <h2>Create Account</h2>
  <?php if ($message) echo "<p>$message</p>"; ?>

  <form method="POST">
      <label>Username:</label><br>
      <input type="text" name="username" required><br><br>

      <label>Email:</label><br>
      <input type="email" name="email" required><br><br>

      <label>Password:</label><br>
      <input type="password" name="password" required><br><br>

      <label>Address:</label><br>
      <input type="text" name="address"><br><br>

      <label>Phone:</label><br>
      <input type="text" name="phone"><br><br>

      <button type="submit">Sign Up</button>
  </form>

  <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
