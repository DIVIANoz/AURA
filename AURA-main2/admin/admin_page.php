<?php
session_start();
include '../config/dbconfig.php';

// Restrict access to logged-in admin only
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Handle product delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: admin_page.php");
    exit;
}

// Handle add product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);

    // Image upload
    $target_dir = "../assets/Products/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO products (name, description, price, image)
                VALUES ('$name', '$description', '$price', '$image_name')";
        if ($conn->query($sql)) {
            // Redirect to avoid duplicate insert on refresh
            header("Location: admin_page.php?success=1");
            exit;
        } else {
            $error_message = "SQL Error: " . $conn->error;
        }
    } else {
        $error_message = "Image upload failed — check folder path or permissions.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | AURA</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h1>
            <div class="admin-actions">
                <a href="admin_orders.php" class="orders-btn">View Orders</a>
                <a href="logout.php" class="logout">
                    <img src="../assets/img/Signout.png" alt="Logout">
                </a>
            </div>
        </header>

        <?php if (isset($_GET['success'])): ?>
            <p style="color:green;">Product added successfully!</p>
        <?php endif; ?>

        <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>

        <section class="add-product">
            <h2>Add Product</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Product Name" required>
                <textarea name="description" placeholder="Description" rows="3"></textarea>
                <input type="number" name="price" placeholder="Price (₱)" step="0.01" required>
                <input type="file" name="image" accept="image/*" required>
                <button type="submit">Add Product</button>
            </form>
        </section>

        <section class="product-list">
            <h2>Product List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th><th>Name</th><th>Price</th><th>Image</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>₱" . number_format($row['price'], 2) . "</td>
                            <td><img src='../assets/Products/{$row['image']}' width='60'></td>
                            <td><a class='delete' href='admin_page.php?delete={$row['id']}'
                                   onclick='return confirm(\"Delete this product?\")'>Delete</a></td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No products found.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
