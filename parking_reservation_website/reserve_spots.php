<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reserve Parking Spots</title>
  <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Modern font stack */
        background-color: #f8f9fa; /* Lighter grey background */
        margin: 0;
        padding: 0; /* Container will handle main content padding */
        color: #212529; /* Darker text color for better contrast */
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
        padding-top: 20px; /* Spacing at the top of the page */
        padding-bottom: 20px; /* Spacing at the bottom of the page */
    }
    .container {
        width: 80%;
        max-width: 1000px; /* Max width for larger screens */
        background-color: #ffffff; /* White background for content */
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Softer shadow */
    }
    h2 {
        color: #007bff; /* A modern blue */
        text-align: center;
        margin-bottom: 25px;
        font-size: 2em; /* Larger heading */
    }
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
        border: 1px solid #dee2e6; /* Light border for the table */
    }
    th, td {
        padding: 12px 15px; /* Increased padding */
        text-align: left;
        border-bottom: 1px solid #dee2e6; /* Lighter border for rows */
    }
    th {
        background-color: #007bff;
        color: white;
        font-weight: 600; /* Slightly bolder */
        text-transform: uppercase; /* Uppercase headers */
        letter-spacing: 0.5px;
    }
    tr:nth-child(even) {
        background-color: #f8f9fa; /* Subtle zebra striping */
    }
    tr:hover {
        background-color: #e9ecef; /* Hover effect for rows */
    }
    .message { /* Generic message class for info/errors */
        text-align: center;
        font-size: 1.1em; 
        color: #6c757d; /* Default message color */
        margin-top: 30px;
        padding: 20px;
        background-color: #f8f9fa; /* Light background for message box */
        border-radius: 5px;
        border: 1px solid #dee2e6; /* Light border for message box */
    }
    .error-message { /* Specific styling for error messages */
        color: #dc3545; /* Bootstrap danger color for text */
        background-color: #f8d7da; /* Light red background for error box */
        border-color: #f5c6cb; /* Reddish border for error box */
    }
  </style>
</head>
<body>

<div class="container"> <?php // Opening container div ?>

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
  // Display styled error message within the container
  echo "<div class='message error-message'>Connection failed: " . htmlspecialchars($conn->connect_error) . "</div>";
} else { // Only proceed if connection is successful

    // SQL query to fetch all reserve parking spots
    $sql = "SELECT * FROM reservations";
    $result = $conn->query($sql);

    echo "<h2>Reserve Parking Spots</h2>"; // Moved h2 inside container and after connection check

    if ($result && $result->num_rows > 0) { // Added check for $result itself
      echo "<table>";
        echo "<tr>";
          echo "<th>Spot ID</th>";
          echo "<th>License Plate Number</th>";
          echo "<th>Spot Number</th>"; 
          echo "<th>Hours</th>"; 
        echo "</tr>";

        // Loop through results and display each spot
        while($row = $result->fetch_assoc()) {
          echo "<tr>";
            // Added htmlspecialchars for security when outputting data
            echo "<td>" . htmlspecialchars($row["reservation_id"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["licence_plate_number"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["spot"]) . "</td>"; 
            echo "<td>" . htmlspecialchars($row["parking_hours"]) . "</td>";
          echo "</tr>";
        }
      echo "</table>";
    } else if ($result) { // if $result is true but num_rows is 0
      echo "<div class='message'>No reserve parking spots found.</div>"; // Use styled message
    } else { // if $result is false (query error)
      echo "<div class='message error-message'>Error fetching parking spots: " . htmlspecialchars($conn->error) . "</div>"; // Use styled error message
    }

    $conn->close();
} // End of else for successful connection
?>

</div> <?php // Closing container div ?>

</body>
</html>
