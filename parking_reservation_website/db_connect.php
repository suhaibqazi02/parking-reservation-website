<?php
// Database configuration
$host = "localhost"; // Database server (use "localhost" for local development)
$dbname = "parking_reservation_website"; // Update this to match your actual database name
$db_user = "root"; // MySQL username (default is "root" for XAMPP)
$db_pass = ""; // MySQL password (empty by default for XAMPP)

// Create a new MySQLi connection
$conn = new mysqli($host, $db_user, $db_pass, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set the character set to UTF-8 for proper encoding
$conn->set_charset("utf8");
?>