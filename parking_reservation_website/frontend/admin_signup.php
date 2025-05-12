<?php
session_start();

// Admin credentials
$adminUsername = "suhaib qazi";
$adminPassword = "1234";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["admin_username"];
    $password = $_POST["admin_password"];

    // Check if credentials match
    if ($username === $adminUsername && $password === $adminPassword) {
        // Admin login successful, redirect to admin.html
        header("Location: admin.html");
        exit();
    } else {
        // Incorrect credentials, display error message
        echo "<script>alert('Invalid username or password.');</script>";
    }
}
?>
