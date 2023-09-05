<?php
// Start a session and include your database connection code here
include("db.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle product and category management here
// Add, edit, and delete categories and products
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 24px;
        }

        .admin-panel {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .admin-menu {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .admin-button {
            display: block;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: center;
        }

        .admin-button:hover {
            background-color: #555;
        }

        .logout {
            color: #f00;
            text-decoration: none;
            float: right;
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
      Welcome, <?php echo $_SESSION['username']; ?>
        <a class="logout" href="logout.php">Logout</a>
    </div>

    <div class="admin-panel">
        <div class="admin-menu">
            <a href="add_category.php" class="admin-button">Add Category</a>
            <a href="manage_categories.php" class="admin-button">View Categories</a>
            <a href="add_product.php" class="admin-button">Add Product</a>
            <a href="manage_products.php" class="admin-button">View Products</a>
        </div>
    </div>
</body>
</html>
