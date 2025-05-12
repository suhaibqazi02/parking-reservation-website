<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to logout confirmation page
header("Location: admin_signup.html");
exit();
?>
