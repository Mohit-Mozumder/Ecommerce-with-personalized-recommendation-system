<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoryName = $_POST['name'];

    // Insert the category into the database
    $sql = "INSERT INTO categories (name) VALUES ('$categoryName')";

    if ($conn->query($sql) === TRUE) {
        echo "Category added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

