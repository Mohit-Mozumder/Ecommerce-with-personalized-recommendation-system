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

    // Query to delete the product by ID from the database
    $sql = "DELETE FROM products WHERE id = $productId";

    if ($conn->query($sql) === TRUE) {
        // Product deleted successfully
        header("Location: manage_products.php");
        exit();
    } else {
        // Handle the case where the deletion fails
        echo "Error deleting product: " . $conn->error;
    }
} else {
    // Handle the case where the product ID is not provided
    // Redirect or display an error message
}

// Close the database connection
$conn->close();
?>
