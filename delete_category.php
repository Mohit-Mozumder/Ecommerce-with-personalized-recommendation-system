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
    $categoryId = $_GET['id'];

    // Query to delete the category by ID from the database
    $sql = "DELETE FROM categories WHERE id = $categoryId";

    if ($conn->query($sql) === TRUE) {
        // Category deleted successfully
        header("Location: manage_categories.php");
        exit();
    } else {
        // Handle the case where the deletion fails
        echo "Error deleting category: " . $conn->error;
    }
} else {
    // Handle the case where the category ID is not provided
    // Redirect or display an error message
}

// Close the database connection
$conn->close();
?>
