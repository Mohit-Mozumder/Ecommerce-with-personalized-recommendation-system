<?php
// Include your database connection code here
$servername = "localhost"; // Change to your server name
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "ecommerce"; // Change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve products from the database
$sql = "SELECT p.id, p.name AS product_name, p.description, p.price, c.name AS category_name, p.image_url
        FROM products AS p
        JOIN categories AS c ON p.category_id = c.id";

$result = $conn->query($sql);

// Initialize an empty array to store products
$products = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
</head>
<body>
    <h2>Manage Products</h2>
    <a href="add_product.php">Add New Product</a>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th> 
            <th>Category</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php
        // Loop through products and display them in rows
        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>" . $product['id'] . "</td>";
            echo "<td>" . $product['product_name'] . "</td>";
            echo "<td>" . $product['description'] . "</td>";
            echo "<td>" . $product['price'] . "</td>";
            echo "<td><img src='" . $product['image_url'] . "' alt='Product Image' style='max-width: 100px; max-height: 100px;'></td>";
            echo "<td>" . $product['category_name'] . "</td>";
            echo "<td><a href='edit_product.php?id=" . $product['id'] . "'>Edit</a></td>";
            echo "<td><a href='delete_product.php?id=" . $product['id'] . "'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <br>
    <a href="admin_panel.php">Admin panel</a><br>
</body>
</html>
