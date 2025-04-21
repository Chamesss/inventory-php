document.addEventListener('DOMContentLoaded', function() {
    // Set up delete buttons if they exist
    const deleteButtons = document.querySelectorAll('.btn-delete');
    if (deleteButtons) {
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this product?')) {
                    deleteProduct(productId);
                }
            });
        });
    }
    
    // Set up form validation if form exists
    const productForm = document.getElementById('add-product-form');
    if (productForm) {
        productForm.addEventListener('submit', function(e) {
            const nameField = document.getElementById('name');
            const priceField = document.getElementById('price');
            
            if (nameField.value.trim() === '') {
                e.preventDefault();
                alert('Product name is required!');
                return false;
            }
            
            if (parseFloat(priceField.value) < 0) {
                e.preventDefault();
                alert('Price cannot be negative!');
                return false;
            }
        });
    }


    const searchForm = document.getElementById('search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const nameField = document.getElementById('search-input');
            if (!nameField) {
                console.error('Search field not found');
                return;
            }
            if (parseFloat(nameField.value.length) === 0) {
                e.preventDefault();
                return false;
            }
            searchProduct(nameField.value);
        });
    }

    function searchProduct(keyword) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/lib/search_product.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
                if (this.status === 200) {
                    try {
                        const response = JSON.parse(this.responseText);
                        const tbody = document.getElementById('product-table-body');
                        tbody.innerHTML = '';

                        if (response.products.length > 0) {
                            response.products.forEach(product => {
                                tbody.innerHTML += `
                                    <tr>
                                        <td>${product.id}</td>
                                        <td>${product.name}</td>
                                        <td>${product.price}</td>
                                        <td><button class="btn-delete" data-id="${product.id}">Delete</button></td>
                                    </tr>
                                `;
                            });
                        } else {
                            tbody.innerHTML = `<tr><td colspan="4">${response.message}</td></tr>`;
                        }
                    } catch (err) {
                        console.error('Invalid JSON:', err);
                    }
                }
            };
        xhr.send(`search-input=${keyword}`);
        xhr.onerror = function(e) {
            console.error('Request failed:', e);
        };
    }

});



function deleteProduct(id) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_product.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status === 200) {
            const response = JSON.parse(this.responseText);
            if (response.success) {
                // Remove product from DOM
                const row = document.querySelector(`button[data-id="${id}"]`).closest('tr');
                row.parentNode.removeChild(row);
            } else {
                alert('Error deleting product: ' + response.message);
            }
        }
    };
    xhr.send(`id=${id}`);
}

// function searchProducts() {
//     const searchKey = document.getElementById('search-key').value;
//     const xhr = new XMLHttpRequest();
//     xhr.open('GET', `search_products.php?key=${encodeURIComponent(searchKey)}`, true);
//     xhr.onload = function() {
//         if (this.status === 200) {
//             const response = JSON.parse(this.responseText);
//             const productTableBody = document.getElementById('product-table-body');
//             productTableBody.innerHTML = '';
//             response.products.forEach(product => {
//                 productTableBody.innerHTML += `
//                     <tr>
//                         <td>${product.id}</td>
//                         <td>${product.name}</td>
//                         <td>${product.price}</td>
//                         <td><button class="btn-delete" data-id="${product.id}">Delete</button></td>
//                     </tr>
//                 `;
//             });
//         }
//     };
//     xhr.send();
// }

// Function to fetch product count for homepage widget
function fetchProductCount() {
    const countContainer = document.getElementById('product-count-container');
    if (!countContainer) return;
    
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'api/get_product_count.php', true);
    xhr.onload = function() {
        if (this.status === 200) {
            const response = JSON.parse(this.responseText);
            countContainer.innerHTML = `
                <div class="dashboard-widget">
                    <h3>Inventory Status</h3>
                    <p>Total Products: <strong>${response.count}</strong></p>
                    <p>Last Updated: <strong>${response.timestamp}</strong></p>
                </div>
            `;
        }
    };
    xhr.onerror = function() {
        console.error('Request failed');
    };
    xhr.send();
}
