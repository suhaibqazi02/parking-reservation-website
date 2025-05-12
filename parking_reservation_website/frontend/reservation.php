<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details (replace with your actual details)
$servername = "localhost";
$username = "root";
$password = ""; // Password for MySQL server
$dbname = "parking_reservation_website"; // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize and validate input
function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // Sanitize and validate form inputs
  $vehicleType = clean_input($_POST["vehicle_type"]);
  $licensePlateNumber = clean_input($_POST["licence_plate_number"]);
  $arrivalTime = clean_input($_POST["arrival_time"]);
  $spot = clean_input($_POST["spot"]);
  $parkingHours = clean_input($_POST["parking_hours"]);

  // Define a time window for detecting overlapping reservations (e.g., 15 minutes)
  $bufferTime = 15 * 60; // 15 minutes in seconds

  // Check for existing reservation for the chosen spot and time window
  $sql = "SELECT * FROM reservations 
          WHERE spot = '$spot' 
            AND (arrival_time BETWEEN DATE_SUB('$arrivalTime', INTERVAL $bufferTime SECOND) 
                 AND DATE_ADD('$arrivalTime', INTERVAL $bufferTime SECOND))";

  $result = mysqli_query($conn, $sql); // Execute the query

  if (mysqli_num_rows($result) > 0) {
    // Reservation already exists within the time window, inform user
    echo "Error: Spot #$spot is already reserved for this arrival time or a close time window. Please choose another spot or time.";
  } else {
    // Spot is available, proceed with reservation processing (insertion)
    $stmt = $conn->prepare("INSERT INTO reservations (vehicle_type, licence_plate_number, arrival_time, spot, parking_hours) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $vehicleType, $licensePlateNumber, $arrivalTime, $spot, $parkingHours);
  
    if ($stmt->execute()) {
      // Registration successful

      // Calculate bill amount
      $billAmount = $parkingHours * 50; // Rate: 50 rupees per hour

      // Store reservation and bill details in session
      $_SESSION['reservation'] = [
        'vehicle_type' => $vehicleType,
        'licence_plate_number' => $licensePlateNumber,
        'arrival_time' => $arrivalTime,
        'spot' => $spot,
        'parking_hours' => $parkingHours,
        'bill_amount' => $billAmount
      ];

      // Redirect to the receipt page
      header('Location: receipt.php');
      exit();
    } else {
      // Insertion failed, handle error (optional)
      echo "Error: An error occurred while processing your reservation. Please try again.";
    }

    // Close the prepared statement
    $stmt->close();
  }
}

$conn->close();
?>
