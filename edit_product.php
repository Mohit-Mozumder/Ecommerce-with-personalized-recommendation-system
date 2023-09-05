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

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Query to fetch the product details by ID
    $sql = "SELECT p.id, p.name AS product_name, p.description, p.price, p.category_id, c.name AS category_name
            FROM products AS p
            JOIN categories AS c ON p.category_id = c.id
            WHERE p.id = $productId";

    $result = $conn->query($sql);

    // Initialize an empty array to store the product
    $product = array();

    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
    } else {
        // Handle the case where the product does not exist
        // Redirect or display an error message
    }
} else {
    // Handle the case where the product ID is not provided
    // Redirect or display an error message
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['id'];
    $newProductName = $_POST['name'];
    $newProductDescription = $_POST['description'];
    $newProductPrice = $_POST['price'];
    $newProductCategoryId = $_POST['category_id'];

    // Query to update the product details in the database
    $sql = "UPDATE products
            SET name = '$newProductName', description = '$newProductDescription', price = $newProductPrice, category_id = $newProductCategoryId
            WHERE id = $productId";

    if ($conn->query($sql) === TRUE) {
        // Product updated successfully
        header("Location: manage_products.php");
        exit();
    } else {
        // Handle the case where the update fails
        echo "Error updating product: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form action="edit_product.php" method="post">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <label for="name">Product Name:</label>
        <input type="text" name="name" value="<?php echo $product['product_name']; ?>" required><br><br>
        <label for="description">Description:</label>
        <textarea name="description" required><?php echo $product['description']; ?></textarea><br><br>
        <label for="price">Price:</label>
        <input type="number" name="price" value="<?php echo $product['price']; ?>" step="0.01" required><br><br>
        <label for="category_id">Category:</label>
        <!-- Replace with a dropdown list of categories, fetching categories from your database -->
        <select name="category_id" required>
        <option value="<?php echo $product['category_id']; ?>"><?php echo $product['category_name']; ?></option>
        <!-- Add options for other categories fetched from your database -->
     </select><br><br>

        <input type="submit" value="Update Product">
    </form>
    <br>
    <a href="admin_panel.php">Admin panel</a><br>
</body>
</html>
