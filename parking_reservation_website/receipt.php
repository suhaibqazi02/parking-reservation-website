<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if reservation details are available in the session
if (!isset($_SESSION['reservation'])) {
    echo "No reservation details found.";
    exit();
}

$reservation = $_SESSION['reservation'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Receipt</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; /* Reset margin */
            padding: 0; /* Reset padding */
            background-color: #f4f7f6;
            color: #333;
        }
        /* Consistent Nav Styling from index.html */
        nav {
            background-color: #2c3e50;
            color: #fff;
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav .container { /* Ensure nav container also uses this */
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
            display: flex; /* For aligning logo and links */
            justify-content: space-between; /* Pushes logo and links apart */
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
            display: inline-block;
            margin-left: 25px;
        }

        .nav-links li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.95rem;
        }

        .nav-links li a:hover,
        .nav-links li a.active {
            color: #e67e22;
        }
        /* End Nav Styling */

        .receipt-container { /* Specific container for the receipt */
            max-width: 600px;
            margin: 30px auto; /* Margin from nav and centered */
            padding: 30px;
            background-color: #fff;
            border: 1px solid #e0e0e0; /* Softer border */
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        .receipt-container h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 1.8rem;
            font-weight: 600;
        }
        .receipt-container p {
            font-size: 1rem; /* Slightly larger paragraph text */
            line-height: 1.7;
            color: #444; /* Darker gray for text */
            margin-bottom: 12px; /* Spacing between details */
        }
        .receipt-container p span {
            font-weight: 600; /* Bolder labels */
            color: #333;
            margin-right: 8px;
        }
    </style>
</head>
<body>

<nav>
    <div class="container">
        <a href="index.html" class="logo">PARKER</a>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="contact.html">Contact Us</a></li>
        </ul>
    </div>
</nav>
    
<div class="receipt-container"> <!-- Changed class name -->
    <h2>Reservation Receipt</h2>
    <p><span>Vehicle Type:</span> <?php echo htmlspecialchars($reservation['vehicle_type']); ?></p>
    <p><span>License Plate Number:</span> <?php echo htmlspecialchars($reservation['licence_plate_number']); ?></p>
    <p><span>Arrival Time:</span> <?php echo htmlspecialchars($reservation['arrival_time']); ?></p>
    <p><span>Parking Spot:</span> <?php echo htmlspecialchars($reservation['spot']); ?></p>
    <p><span>Parking Hours:</span> <?php echo htmlspecialchars($reservation['parking_hours']); ?></p>
    <p><span>Bill Amount:</span> <?php echo htmlspecialchars($reservation['bill_amount']); ?> Dollars</p>
</div>
</body>
</html>

<?php
// Clear the reservation details from the session
unset($_SESSION['reservation']);
?>
