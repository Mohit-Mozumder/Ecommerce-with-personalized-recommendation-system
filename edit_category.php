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

    // Query to fetch the category details by ID
    $sql = "SELECT id, name FROM categories WHERE id = $categoryId";
    $result = $conn->query($sql);

    // Initialize an empty array to store the category
    $category = array();

    if ($result->num_rows == 1) {
        $category = $result->fetch_assoc();
    } else {
        // Handle the case where the category does not exist
        // Redirect or display an error message
    }
} else {
    // Handle the case where the category ID is not provided
    // Redirect or display an error message
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoryId = $_POST['id'];
    $newCategoryName = $_POST['name'];

    // Query to update the category name in the database
    $sql = "UPDATE categories SET name = '$newCategoryName' WHERE id = $categoryId";

    if ($conn->query($sql) === TRUE) {
        // Category updated successfully
        header("Location: manage_categories.php");
        exit();
    } else {
        // Handle the case where the update fails
        echo "Error updating category: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
</head>
<body>
    <h2>Edit Category</h2>
    <form action="edit_category.php" method="post">
        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
        <label for="name">Category Name:</label>
        <input type="text" name="name" value="<?php echo $category['name']; ?>" required><br><br>
        <input type="submit" value="Update Category">
    </form>
    <br>
    <a href="admin_panel.php">Admin panel</a><br>
</body>
</html>
