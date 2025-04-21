<h2>Search Product</h2>
<form class="search-form" id="search-form">
    <label for="search-input">Enter Product ID:</label>
    <div class="search-container">
        <input class="search-input" id="search-input" name="search-input" placeholder="Search..." required />
        <button class="search-submit-button" type="submit">Search</button>
    </div>
</form>

<!-- Table to show search results -->
<table class="product-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="product-table-body">
        <!-- Filled dynamically -->
    </tbody>
</table>