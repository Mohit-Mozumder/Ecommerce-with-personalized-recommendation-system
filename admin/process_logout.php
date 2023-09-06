<?php
session_start();

// Destroy the session
session_destroy();

// Redirect the user to the login page or any other desired page
header("Location: admin_login.php");
exit();
?>
