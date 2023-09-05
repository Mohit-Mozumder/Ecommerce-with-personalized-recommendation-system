<?php
// Include your database connection code here

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['name'];
    $productDescription = $_POST['description'];
    $productPrice = $_POST['price'];
    $categoryId = $_POST['category'];

    // Validate input data (you can add more validation)
    if (empty($productName) || empty($productDescription) || empty($productPrice) || empty($categoryId)) {
        echo "All fields are required.";
    } else {
        // Create a database connection
        include("db.php");

        // Escape user inputs to prevent SQL injection
        $productName = mysqli_real_escape_string($conn, $productName);
        $productDescription = mysqli_real_escape_string($conn, $productDescription);
        $productPrice = mysqli_real_escape_string($conn, $productPrice);
        $categoryId = mysqli_real_escape_string($conn, $categoryId);

        // Insert the product into the database
        $sql = "INSERT INTO products (name, description, price, category_id) VALUES ('$productName', '$productDescription', '$productPrice', '$categoryId')";

        if ($conn->query($sql) === TRUE) {
            echo "Product added successfully!";
        } else {
            echo "Error adding product: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    }
}
?>
