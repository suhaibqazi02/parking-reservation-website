<?php
$db_hostname = 'localhost';
$db_username = 'root';
$db_password = ''; 
$db_database = 'parking_reservation_website';

$report_type = $_POST['reportType'];
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: "  . $conn->connect_error);
}

// Function to execute a query and return the results
function getReportData($sql) {
  global $conn; // Access the global connection variable
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }
    return $data;
  } else {
    return false;
  }
}

// Build the query based on the report type
$sql = "";
switch ($report_type) {
  case 'daily':
    $today = date('Y-m-d');
    $sql = "SELECT * FROM reserve_parking_spots WHERE reservation_date = '$today'";
    break;
  case 'weekly':
    $start_date = date('Y-m-d', strtotime('sunday this week'));
    $end_date = date('Y-m-d', strtotime('saturday this week'));
    $sql = "SELECT * FROM reserve_parking_spots WHERE reservation_date BETWEEN '$start_date' AND '$end_date'";
    break;
  case 'monthly':
    $month = date('m');
    $year = date('Y');
    $sql = "SELECT * FROM reserve_parking_spots WHERE MONTH(reservation_date) = $month AND YEAR(reservation_date) = $year";
    break;
  default:
    // Handle invalid report type
    echo "Invalid report type";
    exit();
}

// Get report data
$report_data = getReportData($sql);

if ($report_data) {
  echo json_encode($report_data);
} else {
  echo "No data found for this report.";
}

$conn->close();

?>
