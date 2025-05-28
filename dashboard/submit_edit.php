<?php
session_start();

// Only allow admin to submit edit requests
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  http_response_code(403);
  echo "Unauthorized";
  exit;
}

// Validate POST data
$required = ['customer_id', 'name', 'division', 'gender', 'age', 'marital_status', 'income'];
foreach ($required as $field) {
  if (empty($_POST[$field]) && $_POST[$field] !== '0') { // allow 0 as valid
    http_response_code(400);
    echo "Missing required field: $field";
    exit;
  }
}

$customerId = $_POST['customer_id'];
$name = $_POST['name'];
$division = $_POST['division'];
$gender = $_POST['gender'];
$age = (int) $_POST['age'];
$maritalStatus = $_POST['marital_status'];
$income = (int) $_POST['income'];
$submittedBy = $_SESSION['user']['username'] ?? 'unknown';

// Connect to MySQL
$mysqli = new mysqli("localhost", "root", "1234", "reneta_users");
if ($mysqli->connect_error) {
  http_response_code(500);
  echo "Database connection failed.";
  exit;
}

// Insert into customer_edits table
$stmt = $mysqli->prepare("
  INSERT INTO customer_edits 
  (customer_id, name, division, gender, age, marital_status, income, submitted_by, status) 
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
");

if (!$stmt) {
  http_response_code(500);
  echo "Prepare failed: " . $mysqli->error;
  exit;
}

$stmt->bind_param("isssssis", 
  $customerId, $name, $division, $gender, $age, $maritalStatus, $income, $submittedBy
);

if ($stmt->execute()) {
  // ✅ Insert notification for managers
  $notifStmt = $mysqli->prepare("INSERT INTO notifications (type, message, link) VALUES (?, ?, ?)");
  $type = 'edit_request';
  $message = "Edit request submitted for customer: $name";
  $link = 'pending-edits.php';
  $notifStmt->bind_param("sss", $type, $message, $link);
  $notifStmt->execute();
  $notifStmt->close();

  echo "success";
} else {
  http_response_code(500);
  echo "Error saving edit request.";
}

$stmt->close();
$mysqli->close();
?>
