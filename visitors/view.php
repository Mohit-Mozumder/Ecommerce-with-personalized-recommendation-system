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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Display</title>
    <style>
        /* Reset default browser styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Create a container for the product grid */
        .product-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Responsive grid */
            gap: 20px;
            padding: 20px;
        }

        /* Style each product card */
        .product-card {
            border: 1px solid #e0e0e0;
            padding: 20px;
            text-align: center;
        }

        /* Style the product image */
        .product-image img {
            max-width: 100%;
            height: auto;
        }

        /* Style the product title */
        .product-title {
            font-size: 1.2rem;
            margin: 10px 0;
        }

        /* Style the product price */
        .product-price {
            font-weight: bold;
            color: #e47911; /* Amazon's price color */
        }

        /* Add some basic hover effect */
        .product-card:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="product-container">
        <?php
        // Loop through products and display them in cards
        foreach ($products as $product) {
            echo "<div class='product-card'>";
            echo "<div class='product-image'>";
            echo "<img src='" . $product['image_url'] . "' alt='" . $product['product_name'] . "'>";
            echo "</div>";
            echo "<div class='product-title'>" . $product['product_name'] . "</div>";
            echo "<div class='product-price'>$" . $product['price'] . "</div>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
