<?php
session_start();
include '../config/dbconfig.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $email      = trim($_POST['email']);
    $password   = trim($_POST['password']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "Email already exists!";
    } else {
        $stmt2 = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, 'user')");
        $stmt2->bind_param("ssss", $first_name, $last_name, $email, $password);
        if ($stmt2->execute()) {
            header("Location: login.php?signup=success");
            exit;
        } else {
            $message = "Error: " . $conn->error;
        }
        $stmt2->close();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | AURA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/img/Logo-S.png">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <section class="signup-section">
            <h2>Sign Up</h2>
            <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>

            <form method="POST">
                <label>First Name:</label><br>
                <input type="text" name="first_name" required><br><br>

                <label>Last Name:</label><br>
                <input type="text" name="last_name" required><br><br>

                <label>Email:</label><br>
                <input type="email" name="email" required><br><br>

                <label>Password:</label><br>
                <input type="password" name="password" required><br><br>

                <button type="submit">Create Account</button>
            </form>
        </section>
    </main>
</body>
</html>
