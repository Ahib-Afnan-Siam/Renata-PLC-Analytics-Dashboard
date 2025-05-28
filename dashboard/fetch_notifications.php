<?php
session_start();

// ✅ Only allow access to manager
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
  http_response_code(403);
  echo json_encode(["error" => "Unauthorized"]);
  exit;
}

// ✅ Connect to the database
$conn = new mysqli("localhost", "root", "1234", "reneta_users");
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Database connection failed"]);
  exit;
}

// ✅ Fetch unseen notifications
$result = $conn->query("SELECT id, message, link FROM notifications WHERE seen = 0 ORDER BY created_at DESC");

$notifications = [];
$idsToMarkSeen = [];

while ($row = $result->fetch_assoc()) {
  $notifications[] = $row;
  $idsToMarkSeen[] = $row['id'];
}

// ✅ Mark fetched notifications as seen
if (!empty($idsToMarkSeen)) {
  $idList = implode(',', array_map('intval', $idsToMarkSeen));
  $conn->query("UPDATE notifications SET seen = 1 WHERE id IN ($idList)");
}

// ✅ Return JSON response
header('Content-Type: application/json');
echo json_encode($notifications);

$conn->close();
?>
