<?php
session_start();

// Include your database connection code here (same as in your existing files)
$servername = "localhost"; // Change to your server name
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "ecommerce"; // Change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for form data and error messages
$email = $password = "";
$emailErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
    }

    // If both inputs are valid, perform login
    if (empty($emailErr) && empty($passwordErr)) {
        $sql = "SELECT id, password FROM customer WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($customer_id, $hashed_password);

        if ($stmt->fetch() && password_verify($password, $hashed_password)) {
            $_SESSION["customer_id"] = $customer_id;
            header("Location: view.php"); // Redirect to the customer dashboard
            exit();
        } else {
            $passwordErr = "Login failed. Please check your email and password.";
        }

        $stmt->close();
    }
}

// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
</head>
<body>
    <h2>Customer Login</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <span class="error"><?php echo $emailErr; ?></span><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <span class="error"><?php echo $passwordErr; ?></span><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
