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

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Query your database to retrieve the product details based on the 'id'
    $sql = "SELECT p.id, p.name AS product_name, p.description, p.price, c.name AS category_name, p.image_url
            FROM products AS p
            JOIN categories AS c ON p.category_id = c.id
            WHERE p.id = $product_id";

    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <!-- Add your CSS styles here if needed -->
</head>
<body>
    <!-- Add a logout button at the top -->
    <?php include('nav.html'); ?>

    <h1><?php echo $product['product_name']; ?></h1>
    <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['product_name']; ?>" width="300">
    <p><?php echo $product['description']; ?></p>
    <p>Price: $<?php echo $product['price']; ?></p>
    <p>Category: <?php echo $product['category_name']; ?></p>
    <!-- Add other product details as needed -->

    <!-- Add a link to go back to the product list page -->
    <a href="view.php">Back to Product List</a>
</body>
</html>

<?php
    } else {
        // Handle the case where no product is found with the given ID
        echo "Product not found or database error.";
    }
} else {
    // Handle the case where 'id' parameter is not set
    echo "Product ID is missing.";
}

// Close the database connection
$conn->close();
?>
