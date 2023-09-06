<?php
// Include your database connection code here
include("db.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve product details from the form
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category_id = $_POST["category"];

    // Process the image upload
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Directory where you want to store uploaded images
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // Image upload was successful
            $image_url = $uploadFile;
        } else {
            // Image upload failed
            // Handle the error
            echo "Image upload failed.";
            exit;
        }
    } else {
        // No image was uploaded or an error occurred
        // Handle accordingly
        echo "No image uploaded or an error occurred.";
        exit;
    }

    // Insert the product into the database
    $insertQuery = "INSERT INTO products (name, description, price, category_id, image_url)
                    VALUES ('$name', '$description', '$price', '$category_id', '$image_url')";

    if ($conn->query($insertQuery) === TRUE) {
        // Product insertion successful
        echo "Product added successfully.";
    } else {
        // Product insertion failed
        echo "Error adding product: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
