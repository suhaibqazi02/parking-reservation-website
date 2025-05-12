<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1); // Good for dev, consider changing for production

require_once 'db_connect.php'; // Use the centralized database connection

// Function to sanitize and validate input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data); // Useful if magic_quotes_gpc is on (though deprecated)
    $data = htmlspecialchars($data); // Primarily for XSS prevention on output, but can be used cautiously on input
    return $data;
}

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form inputs
    $vehicleType = clean_input($_POST["vehicle_type"]);
    $licensePlateNumber = clean_input($_POST["licence_plate_number"]);
    $arrivalTime = $_POST["arrival_time"]; // Dates/times need careful handling, ensure format is correct for DB
    $spot = clean_input($_POST["spot"]);
    $parkingHours = filter_var(clean_input($_POST["parking_hours"]), FILTER_VALIDATE_INT);

    if ($parkingHours === false) {
        echo '<div class="error-message" id="error-message">
                <h2>Error: Invalid parking hours provided.</h2>
                <p>It looks like the parking hours you entered are not valid. Please check and try again.</p>
              </div>';
        echo '<script>
                setTimeout(function() {
                    document.getElementById("error-message").style.display = "none";
                    window.location.href = "reservation.html";
                }, 3000);
              </script>';
        exit;
    }

    // Define a time window for detecting overlapping reservations (e.g., 15 minutes)
    try {
        $arrivalDateTime = new DateTime($arrivalTime);
        $startTimeWindow = clone $arrivalDateTime;
        $startTimeWindow->modify('-15 minutes'); // Subtract 15 minutes
        $endTimeWindow = clone $arrivalDateTime;
        $endTimeWindow->modify('+15 minutes'); // Add 15 minutes

        $startTimeWindowStr = $startTimeWindow->format('Y-m-d H:i:s');
        $endTimeWindowStr = $endTimeWindow->format('Y-m-d H:i:s');
    } catch (Exception $e) {
        echo '<div class="error-message" id="error-message">
                <h2>Error: Invalid arrival time format.</h2>
                <p>Please ensure your arrival time follows the correct format: YYYY-MM-DD HH:MM:SS.</p>
              </div>';
        echo '<script>
                setTimeout(function() {
                    document.getElementById("error-message").style.display = "none";
                    window.location.href = "reservation.html";
                }, 3000);
              </script>';
        exit;
    }

    // Check if the license plate number already exists in the database
    $sql_check_license_plate = "SELECT * FROM reservations WHERE licence_plate_number = ?";
    $stmt_check_license_plate = mysqli_prepare($conn, $sql_check_license_plate);
    if ($stmt_check_license_plate) {
        mysqli_stmt_bind_param($stmt_check_license_plate, "s", $licensePlateNumber);
        mysqli_stmt_execute($stmt_check_license_plate);
        $result_license_check = mysqli_stmt_get_result($stmt_check_license_plate);

        if ($result_license_check && mysqli_num_rows($result_license_check) > 0) {
            echo '<div class="error-message" id="error-message">
                    <div class="error-content">
                        <h2>Error: License Plate Number already reserved.</h2>
                        <p>The license plate number "' . htmlspecialchars($licensePlateNumber) . '" is already associated with an existing reservation. Please use a different plate number.</p>
                    </div>
                  </div>';
            echo '<script>
                    setTimeout(function() {
                        document.getElementById("error-message").style.display = "none";
                        window.location.href = "reservation.html";
                    }, 3000);
                  </script>';
            exit;
        }
    }

    // Check for overlapping reservations within a time window of 15 minutes for the selected spot
    $sql_check_reservation = "SELECT * FROM reservations WHERE spot = ? AND arrival_time BETWEEN ? AND ?";
    $stmt_check_reservation = mysqli_prepare($conn, $sql_check_reservation);
    if ($stmt_check_reservation) {
        mysqli_stmt_bind_param($stmt_check_reservation, "sss", $spot, $startTimeWindowStr, $endTimeWindowStr);
        mysqli_stmt_execute($stmt_check_reservation);
        $result_check = mysqli_stmt_get_result($stmt_check_reservation);

        if ($result_check && mysqli_num_rows($result_check) > 0) {
            echo '<div class="error-message" id="error-message">
                    <div class="error-content">
                        <h2>Error: Spot already reserved.</h2>
                        <p>Spot #' . htmlspecialchars($spot) . ' is already reserved for the selected time window. Please choose a different spot or time.</p>
                    </div>
                  </div>';
            echo '<script>
                    setTimeout(function() {
                        document.getElementById("error-message").style.display = "none";
                        window.location.href = "reservation.html";
                    }, 3000);
                  </script>';
            exit;
        }
    }

    // If everything is okay, insert the reservation into the database
    $sql_insert = "INSERT INTO reservations (vehicle_type, licence_plate_number, arrival_time, spot, parking_hours) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    if ($stmt_insert) {
        mysqli_stmt_bind_param($stmt_insert, "ssssi", $vehicleType, $licensePlateNumber, $arrivalTime, $spot, $parkingHours);

        if (mysqli_stmt_execute($stmt_insert)) {
            // Calculate bill amount
            $billAmount = $parkingHours * 50; // Rate: 50 rupees per hour

            // Store reservation and bill details in session
            $_SESSION['reservation'] = [
                'vehicle_type' => $vehicleType,
                'licence_plate_number' => $licensePlateNumber,
                'arrival_time' => $arrivalTime,
                'spot' => $spot,
                'parking_hours' => $parkingHours,
                'bill_amount' => $billAmount,
                'reservation_id' => mysqli_insert_id($conn) // Store the new reservation ID
            ];

            header('Location: receipt.php');
            exit();
        } else {
            echo '<div class="error-message" id="error-message">
                    <div class="error-content">
                        <h2>Error: Reservation failed.</h2>
                        <p>Something went wrong while processing your reservation. Please try again later.</p>
                    </div>
                  </div>';
            echo '<script>
                    setTimeout(function() {
                        document.getElementById("error-message").style.display = "none";
                        window.location.href = "reservation.html";
                    }, 3000);
                  </script>';
        }
    }
}
?>

<!-- HTML for the Reservation Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Reservation</title>
    <style>
        /* Error message styling */
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            font-family: Arial, sans-serif;
            font-size: 18px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            text-align: center;
            width: 60%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: block;
        }

        .error-message h2 {
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .error-message p {
            font-size: 18px;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        /* Cool heading styling */
        h1 {
            font-family: 'Arial', sans-serif;
            font-size: 40px;
            text-align: center;
            color: #4CAF50;
            margin-top: 100px;
            text-shadow: 2px 2px 8px #f1f1f1;
        }

        .reservation-form {
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>Parking Reservation</h1>

    <!-- Reservation Form -->
    <form class="reservation-form" action="" method="post">
        <label for="vehicle_type">Vehicle Type: </label>
        <input type="text" name="vehicle_type" id="vehicle_type" required><br><br>
        
        <label for="licence_plate_number">License Plate Number: </label>
        <input type="text" name="licence_plate_number" id="licence_plate_number" required><br><br>
        
        <label for="arrival_time">Arrival Time: </label>
        <input type="datetime-local" name="arrival_time" id="arrival_time" required><br><br>
        
        <label for="spot">Spot Number: </label>
        <input type="number" name="spot" id="spot" min="1" max="20" required><br><br>
        
        <label for="parking_hours">Parking Hours: </label>
        <input type="number" name="parking_hours" id="parking_hours" required><br><br>

        <input type="submit" value="Reserve Spot">
    </form>

</body>
</html>
