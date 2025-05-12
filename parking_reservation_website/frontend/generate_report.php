<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; // No password for localhost
$dbname = "parking_reservation_website"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve report type from form data
  $reportType = $_POST["reportType"];

  // Placeholder for actual report generation logic
  $reportData = generateReport($conn, $reportType);
  var_dump($reportData); // Debugging statement
  // Return report data as JSON response
  header('Content-Type: application/json');
  echo json_encode($reportData);
}


// Function to generate report based on report type
function generateReport($conn, $reportType) {
    // Placeholder for actual report generation logic
    switch ($reportType) {
        case 'daily':
            // Generate daily report
            $sql = "SELECT * FROM reservations WHERE DATE(arrival_time) = CURDATE()";
            break;
        case 'weekly':
            // Generate weekly report
            $sql = "SELECT * FROM reservations WHERE YEARWEEK(arrival_time) = YEARWEEK(CURDATE())";
            break;
        case 'monthly':
            // Generate monthly report
            $sql = "SELECT * FROM reservations WHERE MONTH(arrival_time) = MONTH(CURDATE())";
            break;
        default:
            // Invalid report type
            return "Invalid report type.";
    }

    // Execute SQL query
    $result = $conn->query($sql);

    // Check if query was successful
    if ($result) {
        $reportData = array();

        // Fetch data from the result set
        while ($row = $result->fetch_assoc()) {
            $reportData[] = $row;
        }

        // Debug: Inspect the content of $reportData
  var_dump($reportData);

        // Free result set
        $result->free();
    } else {
        $reportData = "Error executing SQL query: " . $conn->error;
    }

    return $reportData;
}

// Close database connection
$conn->close();
?>
