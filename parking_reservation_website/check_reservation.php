<?php
include 'db_connect.php'; // Ensure this file contains the correct DB connection details

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservation_id = $_POST['reservation_id'] ?? '';

    if (empty($reservation_id)) {
        echo "Please enter a reservation ID.";
        exit();
    }

    // Validate that reservation_id is numeric
    if (!is_numeric($reservation_id)) {
        echo "Invalid reservation ID.";
        exit();
    }

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM   reservations WHERE reservation_id = ?"; // Updated table and column name
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Failed to prepare the statement: " . $conn->error;
        exit();
    }

    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if reservation was found
    if ($row = $result->fetch_assoc()) {
        echo "<h2>Reservation Details:</h2>";
        echo "Name: " . htmlspecialchars($row['user_name']) . "<br>"; // Updated column name
        echo "Spot Number: " . htmlspecialchars($row['slot_number']) . "<br>"; // Updated column name
        echo "Date: " . htmlspecialchars($row['reservation_date']) . "<br>";
        echo "Time: " . htmlspecialchars($row['reservation_time']) . "<br>";
    } else {
        echo "No reservation found with ID " . htmlspecialchars($reservation_id);
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>