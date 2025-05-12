<?php
require_once 'db_connect.php';

if ($conn) {
    echo "✅ Connection to MySQL successful!";
} else {
    echo "❌ Connection failed: " . mysqli_connect_error();
}
?>
