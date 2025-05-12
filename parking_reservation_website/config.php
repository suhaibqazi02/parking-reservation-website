<?php
// Database connection settings
$servername = "localhost";  // Hostname or IP address of the database server
$username = "root";         // Your database username (change if necessary)
$password = "";             // Your database password (change if necessary)
$dbname = "parking_system"; // Name of your database (change if necessary)

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to UTF-8
$conn->set_charset("utf8");

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
