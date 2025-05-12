<?php
session_start();
require_once 'db_connect.php'; // Central DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]); // Sanitize input
    $password = $_POST["password"]; // Password should be hashed in a real-world scenario

    // Query to select only the necessary fields (email and password)
    $sql = "SELECT id, password FROM user WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // For now, without password hashing, we just compare directly
            if ($password == $user['password']) {
                $_SESSION["email"] = $email;
                $_SESSION["user_id"] = $user['id'];
                header("Location: reservation.html");
                exit();
            } else {
                $_SESSION["login_error"] = "Invalid email or password"; // Set session error message
                header("Location: login.html");
                exit();
            }
        } else {
            $_SESSION["login_error"] = "Invalid email or password"; // Set session error message
            header("Location: login.html");
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION["login_error"] = "Database error"; // Set session error message
        header("Location: login.html");
        exit();
    }
}
?>
