<?php
header('Content-Type: application/json');
require_once '../config/database.php';

$conn = getConnection();
$sql = "SELECT COUNT(*) as count FROM products";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

echo json_encode([
    'count' => $data['count'],
    'timestamp' => date('Y-m-d H:i:s')
]);

$conn->close();
?>