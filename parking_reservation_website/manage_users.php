<?php
session_start();

// Only allow admin access
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html");
    exit();
}

// Database config
$host = "localhost";
$dbname = "user_data";  // Ensure this matches your actual database name
$db_user = "root"; // Your MySQL username (default is root)
$db_pass = "";     // Your MySQL password (empty by default on XAMPP)

// Connect to MySQL
$conn = new mysqli($host, $db_user, $db_pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle user deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_users.php");
    exit();
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $id = intval($_POST['user_id']);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssi", $first_name, $last_name, $email, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_users.php");
    exit();
}

// Fetch all users
$result = $conn->query("SELECT id, first_name, last_name, email FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f7f7f7;
        }
        h1 {
            color: #333;
            text-align: center;  /* Centers the heading */
            font-size: 36px;     /* Increases the size of the heading */
            font-family: 'Arial', sans-serif; /* Changes the font */
            margin-bottom: 40px; /* Adds space below the heading */
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background-color: white;
        }
        th, td {
            border: 1px solid #bbb;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #ff6600;
            color: white;
        }
        .btn {
            padding: 6px 12px;
            color: white;
            background-color: #007bff;  /* Change the background color */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;  /* Remove underline */
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn:hover {
            background-color: #0056b3;  /* Change the hover background color */
        }
        form {
            margin: 0;
        }
    </style>
</head>
<body>

<h1>Manage Users</h1>
<a href="admin.html" class="btn">Back to Dashboard</a>

<table>
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <form method="POST">
            <td><?= $row['id'] ?></td>
            <td><input type="text" name="first_name" value="<?= htmlspecialchars($row['first_name']) ?>"></td>
            <td><input type="text" name="last_name" value="<?= htmlspecialchars($row['last_name']) ?>"></td>
            <td><input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>"></td>
            <td>
                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                <button type="submit" name="update_user" class="btn">Update</button>
                <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </form>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

<?php $conn->close(); ?>
