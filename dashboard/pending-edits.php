<?php
session_start();
if ($_SESSION['user']['role'] !== 'manager') {
  header("Location: ../login/login.html");
  exit;
}

//Update this with your real DB creds
$conn = new mysqli("localhost", "root", "1234", "reneta_users");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM customer_edits WHERE status = ?");
$status = 'pending';
$stmt->bind_param("s", $status);
$stmt->execute();
$pendingEdits = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Pending Edits</title>
  <style>
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #2a3558; color: #fff; }
    td button { margin: 0 2px; }
  </style>
</head>
<body>
<h2>Pending Customer Edits</h2>
<table>
  <tr>
    <th>Customer ID</th><th>Name</th><th>Division</th><th>Gender</th>
    <th>Age</th><th>Income</th><th>Marital Status</th><th>Submitted By</th><th>Actions</th>
  </tr>
  <?php while ($row = $pendingEdits->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['customer_id']) ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['division']) ?></td>
      <td><?= htmlspecialchars($row['gender']) ?></td>
      <td><?= htmlspecialchars($row['age']) ?></td>
      <td><?= htmlspecialchars($row['income']) ?></td>
      <td><?= htmlspecialchars($row['marital_status']) ?></td>
      <td><?= htmlspecialchars($row['submitted_by']) ?></td>
      <td>
        <form action="apply_edit.php" method="POST" style="display:inline;">
          <input type="hidden" name="edit_id" value="<?= $row['id'] ?>">
          <button name="action" value="approve">Approve</button>
          <button name="action" value="reject">Reject</button>
        </form>
      </td>
    </tr>
  <?php endwhile; ?>
</table>
</body>
</html>
