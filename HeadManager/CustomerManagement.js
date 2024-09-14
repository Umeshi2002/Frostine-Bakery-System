document.addEventListener('DOMContentLoaded', function() {
    const addCustomerBtn = document.querySelector('.add-customer');
    const searchBtn = document.querySelector('.search-btn');
    const editBtns = document.querySelectorAll('.edit-btn');
    const deleteBtns = document.querySelectorAll('.delete-btn');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    addCustomerBtn.addEventListener('click', function() {
        alert('Add new customer functionality to be implemented');
    });

    searchBtn.addEventListener('click', function() {
        const searchTerm = document.querySelector('.search-bar input').value;
        alert(`Searching for: ${searchTerm}`);
    });

    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const customerId = row.querySelector('td:first-child').textContent;
            alert(`Edit customer ${customerId}`);
        });
    });

    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const customerId = row.querySelector('td:first-child').textContent;
            if (confirm(`Are you sure you want to delete customer ${customerId}?`)) {
                alert(`Customer ${customerId} deleted`);
            }
        });
    });

    prevBtn.addEventListener('click', function() {
        alert('Previous page');
    });

    nextBtn.addEventListener('click', function() {
        alert('Next page');
    });
});