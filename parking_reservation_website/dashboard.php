<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; }
        a { display: block; margin: 10px 0; text-decoration: none; color: blue; }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>!</h1>
    <p>This is your dashboard.</p>

    <a href="reservation.html">Make a Reservation</a>
    <a href="cancel_reservation.html">Cancel Reservation</a>
    <a href="check_reservation.html">Check Reservation</a>
    <a href="profile.php">View Profile</a>
    <a href="logout.php">Logout</a>
</body>
</html>
