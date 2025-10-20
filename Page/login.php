<?php
session_start();
include '../config/dbconfig.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Only normal users
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND password=? AND role='user'");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['role']       = $user['role'];

        header("Location: ../index.php");
        exit;
    } else {
        $message = "Invalid email or password.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | AURA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/img/Logo-S.png">
</head>
<body>
    <?php include 'header.php'; ?>

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
