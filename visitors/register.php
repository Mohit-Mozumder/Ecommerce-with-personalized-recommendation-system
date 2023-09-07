<?php
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
$username = $email = $address = $password = "";
$usernameErr = $emailErr = $addressErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate username
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = test_input($_POST["username"]);
        // Check if username only contains letters and numbers
        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $usernameErr = "Only letters and numbers allowed";
        }
    }

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

    // Validate address
    if (empty($_POST["address"])) {
        $addressErr = "Address is required";
    } else {
        $address = test_input($_POST["address"]);
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
        // Password length validation (adjust as needed)
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters";
        }
    }

    // If all inputs are valid, perform registration
    if (empty($usernameErr) && empty($emailErr) && empty($addressErr) && empty($passwordErr)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        // Perform registration by inserting data into the customer table
        $sql = "INSERT INTO customer (username, email, address, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $email, $address, $hashedPassword);

        if ($stmt->execute()) {
            // Registration successful, redirect to login page
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
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
    <title>Customer Registration</title>
</head>
<body>
    <h2>Customer Registration</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <span class="error"><?php echo $usernameErr; ?></span><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <span class="error"><?php echo $emailErr; ?></span><br>

        <label for="address">Address:</label>
        <input type="text" name="address" required>
        <span class="error"><?php echo $addressErr; ?></span><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <span class="error"><?php echo $passwordErr; ?></span><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
