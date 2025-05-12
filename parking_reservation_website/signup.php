<?php
// Include the MySQL database connection file
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"]; // Store plain password directly

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
        exit();
    }

    // Check if the email already exists
    $query_check = "SELECT * FROM user WHERE email = ?";
    $stmt_check = mysqli_prepare($conn, $query_check);
    mysqli_stmt_bind_param($stmt_check, "s", $email);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if ($result_check && mysqli_num_rows($result_check) > 0) {
        echo "<script>alert('Email already exists!');</script>";
    } else {
        // Insert user data into the user table
        $query_insert = "INSERT INTO user (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $query_insert);
        mysqli_stmt_bind_param($stmt_insert, "ssss", $firstName, $lastName, $email, $password);
        $result_insert = mysqli_stmt_execute($stmt_insert);

        if ($result_insert) {
            session_start();
            $_SESSION['email'] = $email;
            header("Location: reservation.html");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Close the prepared statements
    mysqli_stmt_close($stmt_check);
    mysqli_stmt_close($stmt_insert);
}
?>
