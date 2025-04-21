<?php
$pageTitle = 'Add Product - Inventory Management';
include 'includes/header.php';
require_once 'config/database.php';

$message = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $quantity = $_POST['quantity'] ?? 0;
    
    // Validate inputs
    if (empty($name)) {
        $message = 'Product name is required';
    } else {
        // Get connection
        $conn = getConnection();
        
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, quantity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $name, $description, $price, $quantity);
        
        // Execute and check
        if ($stmt->execute()) {
            $message = 'Product added successfully!';
        } else {
            $message = 'Error: ' . $conn->error;
        }
        
        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<h2>Add New Product</h2>

<?php if ($message): ?>
    <div class="message"><?php echo $message; ?></div>
<?php endif; ?>

<form id="add-product-form" method="POST" action="">
    <div class="form-group">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
    </div>
    
    <div class="form-group">
        <label for="price">Price ($):</label>
        <input type="number" id="price" name="price" step="0.01" min="0" required>
    </div>
    
    <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="0" required>
    </div>
    
    <button type="submit">Add Product</button>
</form>

<?php include 'includes/footer.php'; ?>