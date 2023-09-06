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

// Query to retrieve categories from the database
$sql = "SELECT id, name FROM categories";
$result = $conn->query($sql);

// Initialize an empty array to store categories
$categories = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Categories</title>
</head>
<body>
    <h2>Manage Categories</h2>
    <a href="add_category.php">Add New Category</a>
    <table>
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php
        // Loop through categories and display them in rows
        foreach ($categories as $category) {
            echo "<tr>";
            echo "<td>" . $category['id'] . "</td>";
            echo "<td>" . $category['name'] . "</td>";
            echo "<td><a href='edit_category.php?id=" . $category['id'] . "'>Edit</a></td>";
            echo "<td><a href='delete_category.php?id=" . $category['id'] . "'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <br>
    <a href="admin_panel.php">Admin panel</a><br>
</body>
</html>
