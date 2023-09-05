<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <h2>Add Product</h2>
    <form action="process_product.php" method="post">
        <label for="name">Product Name:</label>
        <input type="text" name="name" required><br><br>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea><br><br>
        <label for="price">Price:</label>
        <input type="text" name="price" required><br><br>
        <label for="category">Category:</label>
        <select name="category" required>
            <?php
            // Include your database connection code here

            include("db.php");

            // Query to fetch categories from the database
            $categoryQuery = "SELECT id, name FROM categories";
            $result = $conn->query($categoryQuery);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
            }

            // Close the database connection
            $conn->close();
            ?>
        </select><br><br>
        <input type="submit" value="Add Product">
    </form>
    <br>
    <a href="admin_panel.php">Admin panel</a><br>
</body>
</html>
