document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-product');
    const productModal = document.getElementById('productModal');
    const productForm = document.getElementById('productForm');
    const modalTitle = document.getElementById('productModalLabel');
    const addUrl = document.getElementById('addUrl').value;
    const updateUrl = document.getElementById('updateUrl').value;
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const price = this.getAttribute('data-price');
            const stock = this.getAttribute('data-stock');
            const status = this.getAttribute('data-status');
			
			productForm.action = updateUrl + id;
            
            document.getElementById('product_id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('price').value = price;
            document.getElementById('stock').value = stock;
            document.getElementById('status').value = status;
            
            modalTitle.textContent = 'Edit Product';

            const bsModal = new bootstrap.Modal(productModal);
            bsModal.show();
        });
    });
    
    productModal.addEventListener('hidden.bs.modal', function() {
        productForm.reset();
        productForm.action = addUrl;
        modalTitle.textContent = 'Add New Product';
        document.getElementById('product_id').value = '';
    });
    
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#productsTable tbody tr:not(#empty-row)');
        
        tableRows.forEach(row => {
            const productName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if (productName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    const table = document.getElementById('productsTable');
    const headers = table.querySelectorAll('th[data-sort]');
    let currentSort = null;
    
    headers.forEach(header => {
        header.addEventListener('click', function() {
            const sortBy = this.getAttribute('data-sort');
            const sortDirection = currentSort && currentSort.column === sortBy && currentSort.direction === 'asc' ? 'desc' : 'asc';
            
            document.querySelectorAll('.sort-icon').forEach(icon => {
                icon.className = 'sort-icon';
            });
            
            this.querySelector('.sort-icon').classList.add(`sort-${sortDirection}`);
            
            currentSort = { column: sortBy, direction: sortDirection };
            
            const rows = Array.from(table.querySelectorAll('tbody tr:not(#empty-row)'));
            
            rows.sort((a, b) => {
                let valueA = a.getAttribute(`data-${sortBy}`);
                let valueB = b.getAttribute(`data-${sortBy}`);
                
                if (sortBy === 'price' || sortBy === 'stock' || sortBy === 'index') {
                    valueA = parseFloat(valueA);
                    valueB = parseFloat(valueB);
                }
                
                if (valueA < valueB) {
                    return sortDirection === 'asc' ? -1 : 1;
                }
                if (valueA > valueB) {
                    return sortDirection === 'asc' ? 1 : -1;
                }
                return 0;
            });
            
            const tbody = table.querySelector('tbody');
            rows.forEach(row => {
                tbody.appendChild(row);
            });
        });
    });
});
