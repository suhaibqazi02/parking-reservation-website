<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_signup.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PARKER - Admin Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.6;
        }
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
            font-weight: 600;
            color: #fff;
            text-decoration: none;
        }
        .nav-links {
            list-style: none;
            display: flex;
            gap: 15px;
        }
        .nav-links a {
            background-color: #c0392b;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            transition: background-color 0.3s ease;
            font-weight: 500;
        }
        .nav-links a:hover {
            background-color: #a93226;
        }

        .page-container {
            width: 90%;
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
        }
        .content {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 2rem;
            font-weight: 600;
        }
        .content p {
            color: #555;
            margin-bottom: 25px;
            font-size: 1rem;
        }
        .admin-actions {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        .admin-actions li {
            flex: 1 1 200px; /* Grow, shrink, base width */
            max-width: 220px;
        }
        .btn {
            display: block;
            width: 100%;
            background-color: #e67e22;
            color: #fff;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-weight: 500;
            text-align: center;
            font-size: 0.95rem;
            box-sizing: border-box;
        }
        .btn:hover {
            background-color: #d35400;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<nav>
    <div class="container">
        <a href="admin.php" class="logo">PARKER - Admin Dashboard</a>
        <ul class="nav-links">
            <li><a href="logout.php" class="nav-button">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="page-container">
    <div class="content">
        <h2>Welcome to the Admin Dashboard</h2>
        <p>Hi Admin, what would you like to do today?</p>
        <ul class="admin-actions">
            <li><a href="view_reservations.php" class="btn">View Reservation List</a></li>
            <li><a href="cancel_reservation." class="btn">Cancel Reservation</a></li>
            <li><a href="generate_report.php" class="btn">Generate Report</a></li>
            <li><a href="manage_users.php" class="btn">Manage Users</a></li>
        </ul>
    </div>
</div>

<script>
    document.querySelector('.nav-button')?.addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm("Are you sure you want to logout?")) {
            window.location.href = this.href;
        }
    });
</script>

</body>
</html>
