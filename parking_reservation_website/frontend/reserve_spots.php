<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reserve Parking Spots</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
  </style>
</head>
<body>

<?php

// Database connection details (**Security Risk: Credentials exposed in HTML**)
$db_hostname = 'localhost';
$db_username = 'root';
$db_password = ''; // No password (not recommended for production)
$db_database = 'parking_reservation_website';

// Create connection
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch all reserve parking spots
$sql = "SELECT * FROM reservations";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<h2>Reserve Parking Spots</h2>";
  echo "<table>";
    echo "<tr>";
      echo "<th>Spot ID</th>";
      echo "<th>License Plate Number</th>";
      echo "<th>Spot Number</th>"; // Update based on your table structure
      echo "<th>Hours</th>"; // Optional: Update button
    echo "</tr>";

    // Loop through results and display each spot
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
        echo "<td>" . $row["reservation_id"] . "</td>";
        echo "<td>" . $row["licence_plate_number"] . "</td>";
        echo "<td>" . $row["spot"] . "</td>"; // Update based on your table structure
        echo "<td>" . $row["parking_hours"] . "</td>";  // Optional: Update button
          // Add an update button if needed (replace with your logic)
          // echo "<button>Update</button>";
        echo "</td>";
      echo "</tr>";
    }
  echo "</table>";
} else {
  echo "No reserve parking spots found.";
}

$conn->close();

?>

</body>
</html>
