<?php
session_start();
require '../login/config.php'; // Make sure this file defines $conn properly

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize user input
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // ✅ Validation checks
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: register.php?error=Please fill in all fields");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: register.php?error=Invalid email format");
        exit;
    }

    if ($password !== $confirm_password) {
        header("Location: register.php?error=Passwords do not match");
        exit;
    }

    // ✅ Check if email is already registered
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if (!$stmt) {
        header("Location: register.php?error=Server error. Please try again.");
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        header("Location: register.php?error=Email already registered");
        exit;
    }
    $stmt->close();

    // ✅ Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ✅ Insert the new user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
    if (!$stmt) {
        header("Location: register.php?error=Server error while preparing statement.");
        exit;
    }

    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        // ✅ Auto-login after registration
        $_SESSION['user'] = [
            'id' => $stmt->insert_id,
            'name' => $name,
            'role' => 'user'
        ];
        $stmt->close();
        header("Location: register-success.html");
        exit;
    } else {
        $stmt->close();
        header("Location: register.php?error=Something went wrong. Try again.");
        exit;
    }
} else {
    header("Location: register.php");
    exit;
}
