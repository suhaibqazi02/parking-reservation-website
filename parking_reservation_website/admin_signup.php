<?php
session_start();

// Database config
$host = "localhost";
$dbname = "user_data"; // Change if your DB name is different
$db_user = "root";     
$db_pass = "";         

// Connect to MySQL
$conn = new mysqli($host, $db_user, $db_pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// On form submit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input_user = $_POST["admin_username"] ?? '';
    $input_pass = $_POST["admin_password"] ?? '';

    // Prepare statement
    $stmt = $conn->prepare("SELECT password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $input_user);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($stored_pass);
        $stmt->fetch();

        // Verify the hashed password
        if (password_verify($input_pass, $stored_pass)) {
            $_SESSION["admin_logged_in"] = true;
            $_SESSION["admin_username"] = $input_user;
            header("Location: admin.html");  // Redirect to admin dashboard
            exit();
        }
    }

    echo "<script>
        alert('Invalid username or password.');
        window.location.href = 'admin_signup.html'; // fallback redirect
    </script>";
    $stmt->close();
}

$conn->close();
?>
