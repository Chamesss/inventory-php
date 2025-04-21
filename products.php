<?php
$pageTitle = 'Products - Inventory Management';
include 'includes/header.php';
require_once 'config/database.php';

// Get connection
$conn = getConnection();

// Prepare and execute query
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<?php
include 'ui/forms/search.php';
?>

<h2>Product Inventory</h2>

<?php if ($result->num_rows > 0): ?>
    <table class="product-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>$<?php echo number_format($row['price'], 2); ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>
                        <button class="btn-delete" data-id="<?php echo $row['id']; ?>">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No products found in the inventory.</p>
<?php endif; ?>

<?php
// Close connection
$conn->close();
include 'includes/footer.php';
?>