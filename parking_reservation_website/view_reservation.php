<?php
// Include the database connection
include 'config.php';

// Fetch reservations from the database
$sql = "SELECT reservation_id, user_name, vehicle_type, vehicle_number, reservation_date, slot_number, hours_parked, bill_amount 
        FROM parking_reservations 
        ORDER BY reservation_id DESC";

$result = mysqli_query($conn, $sql);

// Check for query errors
if (!$result) {
    die("Error fetching reservations: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservation List - PARKER</title>
    <style>
        /* General body reset and base font */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.6;
        }

        /* Consistent Nav Styling */
        nav {
            background-color: #2c3e50;
            color: #fff;
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        nav .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 1.8rem;
            margin: 0;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
        }
        .nav-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }
        .nav-links li {
            margin-left: 25px;
        }
        .nav-links li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.95rem;
        }
        .nav-links li a:hover, .nav-links li a.active {
            color: #e67e22;
        }
        /* End Nav Styling */

        .page-container { /* Main content container */
            width: 90%;
            max-width: 1000px; /* Wider for admin content */
            margin: 30px auto;
            padding: 20px;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px; /* Reduced margin for tighter layout */
            font-size: 1.8rem; /* Slightly smaller for admin sections */
            font-weight: 600;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px; /* Rounded corners for table */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            overflow: hidden; /* Ensures border-radius clips content */
        }

        th, td {
            padding: 12px 15px; /* Adjusted padding */
            text-align: left;
            border-bottom: 1px solid #e0e0e0; /* Lighter border */
        }

        th {
            background-color: #34495e; /* Darker blue-gray for table headers */
            color: #fff;
            font-weight: 600; /* Bolder header text */
            font-size: 0.95rem;
        }

        tr:last-child td {
            border-bottom: none; /* Remove border from last row */
        }

        tr:hover {
            background-color: #f9f9f9; /* Subtle hover effect */
        }

        td {
            font-size: 0.9rem;
            color: #444;
        }

        /* Logout Button in Nav */
        #logoutBtn.nav-button { /* More specific selector if needed */
            background-color: #c0392b; /* Red for logout */
            color: #fff;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-weight: 500;
        }
        #logoutBtn.nav-button:hover {
            background-color: #a93226; /* Darker red */
            color: #fff; /* Ensure text remains white */
        }
    </style>
</head>
<body>
    <nav>
        <div class="container">
            <a href="admin.html" class="logo">PARKER - View Reservations</a>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="admin.html">Admin Dashboard</a></li>
                <li><a href="logout.php" id="logoutBtn" class="nav-button">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="page-container">
        <h2>Reservation List</h2>
        <table id="reservationTable">
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>User Email/ID</th>
                    <th>Vehicle Type</th>
                    <th>License Plate</th>
                    <th>Arrival Time</th>
                    <th>Spot</th>
                    <th>Hours</th>
                    <th>Bill ($)</th>
                </tr>
            </thead>
            <tbody>
               <?php
                // Check if any reservations were found
                if (mysqli_num_rows($result) > 0) {
                    // Loop through and display each reservation
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['reservation_id']}</td>
                                <td>{$row['user_name']}</td>
                                <td>{$row['vehicle_type']}</td>
                                <td>{$row['vehicle_number']}</td>
                                <td>{$row['reservation_date']}</td>
                                <td>{$row['slot_number']}</td>
                                <td>{$row['hours_parked']}</td>
                                <td>{$row['bill_amount']}</td>
                              </tr>";
                    }
                } else {
                    // If no reservations, display a message
                    echo "<tr><td colspan='8' style='text-align: center;'>No reservations found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // JavaScript logic can be implemented if needed for further client-side interactions.
    </script>
</body>
</html>