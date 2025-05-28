<?php
session_start();
if ($_SESSION['user']['role'] !== 'manager') {
    http_response_code(403);
    echo 'Forbidden';
    exit;
}

//  Database connection
$conn = new mysqli("localhost", "root", "1234", "reneta_users");
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

$edit_id = $_POST['edit_id'];
$action = $_POST['action'];

$stmt = $conn->prepare("SELECT * FROM customer_edits WHERE id = ?");
$stmt->bind_param("i", $edit_id);
$stmt->execute();
$result = $stmt->get_result();
$edit = $result->fetch_assoc();

if (!$edit) {
    echo "Edit not found.";
    exit;
}

if ($action === 'reject') {
    $update = $conn->prepare("UPDATE customer_edits SET status='rejected' WHERE id = ?");
    $update->bind_param("i", $edit_id);
    $update->execute();
    echo "❌ Rejected.";
    exit;
}

if ($action === 'approve') {
    $json_path = __DIR__ . '/assets/data/data.json';
    $data = json_decode(file_get_contents($json_path), true);
    $found = false;

    foreach ($data as &$entry) {
        if ($entry['ID'] === $edit['customer_id']) {
            $entry['Customer Name'] = $edit['name'];
            $entry['Division'] = $edit['division'];
            $entry['Gender'] = $edit['gender'] === 'Male' ? 'M' : ($edit['gender'] === 'Female' ? 'F' : 'O');
            $entry['Age'] = (int)$edit['age'];
            $entry['MaritalStatus'] = $edit['marital_status'];
            $entry['Income'] = (int)$edit['income'];
            $found = true;
            break;
        }
    }

    if ($found) {
        file_put_contents($json_path, json_encode($data, JSON_PRETTY_PRINT));
        $update = $conn->prepare("UPDATE customer_edits SET status='approved' WHERE id = ?");
        $update->bind_param("i", $edit_id);
        $update->execute();
        echo "✅ Approved and applied to JSON.";
    } else {
        echo "⚠️ Customer ID not found in JSON.";
    }
}
