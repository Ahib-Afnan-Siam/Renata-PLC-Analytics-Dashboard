<?php
session_start();
require 'config.php'; // Includes DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute SQL query
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $row['password'])) {
            // ✅ Store user in session
            $_SESSION['user'] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'role' => $row['role']
            ];

            // ✅ Redirect to dashboard
            header("Location: ../dashboard/index.php");
            exit;
        } else {
            // Wrong password
            header("Location: login.html?error=Incorrect password");
            exit;
        }
    } else {
        // User not found
        header("Location: login.html?error=User not found");
        exit;
    }
} else {
    header("Location: login.html?error=Invalid request");
    exit;
}
?>
