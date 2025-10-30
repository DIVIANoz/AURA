<?php
session_start();
include '../config/dbconfig.php';

// Access control
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// ADD PRODUCT
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);

    // Image upload
    $target_dir = "../assets/img/Products/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO products (name, description, price, image)
                    VALUES ('$name', '$description', '$price', '$image_name')";
            if (mysqli_query($conn, $sql)) {
                $message = "<p style='color:green;'>✅ Product added successfully!</p>";
            } else {
                $message = "<p style='color:red;'>❌ Database error: " . mysqli_error($conn) . "</p>";
            }
        } else {
            $message = "<p style='color:red;'>❌ Failed to upload image.</p>";
        }
    } else {
        $message = "<p style='color:red;'>❌ File is not an image.</p>";
    }
}

// DELETE PRODUCT
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Get image name before deleting
    $result = mysqli_query($conn, "SELECT image FROM products WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
    $image_path = "../assets/img/Products/" . $row['image'];

    // Delete from database
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");

    // Delete image file
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    $message = "<p style='color:orange;'>🗑️ Product deleted successfully!</p>";
}

// Fetch all products
$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Products</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        h2 { color: #333; }
        form { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #ccc; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; background: white; }
        table th, table td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        table th { background: #f1f1f1; }
        button, input[type=submit] { padding: 8px 12px; cursor: pointer; }
        .delete-btn { color: white; background: #dc3545; border: none; border-radius: 5px; }
        .logout-btn { float: right; background: #555; color: white; padding: 6px 12px; text-decoration: none; border-radius: 5px; }
        img { width: 80px; height: auto; border-radius: 6px; }
    </style>
</head>
<body>
    <a href="../index.php" class="logout-btn">🏠 Go to Site</a>
    <h2>Admin - Manage Products</h2>

    <?php if (isset($message)) echo $message; ?>

    <!-- ADD PRODUCT FORM -->
    <form method="POST" enctype="multipart/form-data">
        <h3>Add New Product</h3>
        <label>Product Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" rows="3"></textarea><br><br>

        <label>Price (₱):</label><br>
        <input type="number" name="price" step="0.01" required><br><br>

        <label>Image:</label><br>
        <input type="file" name="image" accept="image/*" required><br><br>

        <input type="submit" name="add_product" value="Add Product">
    </form>

    <!-- PRODUCT LIST -->
    <h3>Current Products</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Preview</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price (₱)</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($products)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><img src="../assets/img/Products/<?php echo $row['image']; ?>" alt=""></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td><?php echo number_format($row['price'], 2); ?></td>
            <td>
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this product?');">
                    <button class="delete-btn">Delete</button>
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
