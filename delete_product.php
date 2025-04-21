<?php
header('Content-Type: application/json');
require_once 'config/database.php';

// Check if ID was provided
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'No product ID provided']);
    exit;
}

$id = intval($_POST['id']);
$conn = getConnection();

// Prepare statement for security
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);

// Execute and respond
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$stmt->close();
$conn->close();
?>