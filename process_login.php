<?php
// Include your database connection code here

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create a database connection
    $servername = "localhost"; // Change to your server name
    $db_username = "root"; // Change to your MySQL username
    $db_password = ""; // Change to your MySQL password
    $dbname = "ecommerce"; // Change to your database name

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the provided username and password match a user record
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User authentication successful
        // Start a session and store user information
        session_start();
        $_SESSION['username'] = $username;

        // Redirect to the user panel or a user dashboard page
        header("Location: admin_panel.php");
        exit();
    } else {
        // Invalid credentials
        echo "Invalid username or password.";
    }

    // Close the database connection
    $conn->close();
}
?>
