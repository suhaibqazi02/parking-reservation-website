<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.html");
    exit();
}

// Example user info from session
$username = $_SESSION['username'] ?? 'Guest';
$email = $_SESSION['email'] ?? 'Not available';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Profile</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; }
        .info { margin: 10px 0; }
    </style>
</head>
<body>
    <h2>User Profile</h2>
    <div class="info">Username: <?php echo htmlspecialchars($username); ?></div>
    <div class="info">Email: <?php echo htmlspecialchars($email); ?></div>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
