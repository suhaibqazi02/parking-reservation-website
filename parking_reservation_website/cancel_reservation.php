<?php

$servername = "localhost";
$username = "root";
$password = ""; // Password for MySQL server
$dbname = "parking_reservation_website";

// Create connection (using mysqli for this example)
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$licensePlate = $_POST['licence_plate_number']; // Assuming license plate number is sent in POST data

$sql = "DELETE FROM reservations WHERE licence_plate_number = '$licensePlate'";

if ($conn->query($sql) === TRUE) {
  // Redirect to index.html after successful deletion
  header('Location: index.html');
  exit(); // Exit script after sending redirect header
} else {
  echo "Error deleting reservation: " . $conn->error;
}

$conn->close();

?>
