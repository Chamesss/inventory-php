<?php
$pageTitle = 'Home - Inventory Management';
include 'includes/header.php';
?>

<h2>Welcome to Inventory Management System</h2>
<p>This is a simple PHP application that demonstrates:
<ul>
    <li>PHP file structure and organization</li>
    <li>MySQL database connections</li>
    <li>JavaScript integration</li>
    <li>Basic CRUD operations</li>
</ul>
</p>
<div id="product-count-container">
    Loading product count...
</div>

<script>
    // Inline JavaScript to fetch product count immediately on the home page
    document.addEventListener('DOMContentLoaded', function () {
        fetchProductCount();
    });

</script>

<?php
include 'includes/footer.php';
?>