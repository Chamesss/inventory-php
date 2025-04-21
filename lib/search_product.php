<?php
require(__DIR__ . '/../config/database.php');

header('Content-Type: application/json');

$response = ['products' => [], 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'] ?? '';

    $keyword = isset($_POST['search-input']) ? $_POST['search-input'] : '';

    if (empty($keyword)) {
        $response['message'] = 'Keyword is empty.';
    } else {
        $conn = getConnection();
        $search = "%$keyword%"; // Add wildcards for LIKE query

        // Use ? placeholders for MySQLi prepared statements
        $sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $search, $search); // Bind the same parameter twice as strings
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $response['products'][] = $row;
        }

        $stmt->close();
        $conn->close();

        if (empty($response['products'])) {
            $response['message'] = 'No products found.';
        }
    }
} else {
    $response['message'] = 'Invalid request.';
}

echo json_encode($response);
?>