<?php
session_start();

// Only admins can insert notifications
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  http_response_code(403);
  echo "Unauthorized";
  exit;
}

// Connect to your database
$conn = new mysqli("localhost", "root", "1234", "reneta_users");
if ($conn->connect_error) {
  http_response_code(500);
  echo "Database connection failed";
  exit;
}

// Gather inputs
$type = 'edit_request';
$message = $_POST['message'] ?? 'A new customer edit request was submitted.';
$link = 'pending-edits.php';

// Insert into notifications table
$stmt = $conn->prepare("INSERT INTO notifications (type, message, link) VALUES (?, ?, ?)");
if (!$stmt) {
  http_response_code(500);
  echo "Prepare failed: " . $conn->error;
  exit;
}

$stmt->bind_param("sss", $type, $message, $link);

if ($stmt->execute()) {
  echo "success";
} else {
  http_response_code(500);
  echo "Failed to insert notification";
}

$stmt->close();
$conn->close();
?>
