<?php
$host = "localhost";
$username = "root";
$password = "1234";  // ✅ Fixed
$database = "reneta_users";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
