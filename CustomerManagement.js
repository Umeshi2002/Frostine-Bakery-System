// Get the modal elements
var addModal = document.getElementById("customerModal");
var editModal = document.getElementById("editCustomerModal");
var deleteModal = document.getElementById("deleteCustomerModal");

// Get the button that opens the modal
var addBtn = document.querySelector(".add-customer");

// Get the <span> element that closes the modal
var closeBtns = document.querySelectorAll(".close");

// When the user clicks the button, open the add customer modal
addBtn.onclick = function() {
    addModal.style.display = "block";
}

// When the user clicks on close, close the modals
closeBtns.forEach(function(btn) {
    btn.onclick = function() {
        addModal.style.display = "none";
        editModal.style.display = "none";
        deleteModal.style.display = "none";
    }
});

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == addModal || event.target == editModal || event.target == deleteModal) {
        addModal.style.display = "none";
        editModal.style.display = "none";
        deleteModal.style.display = "none";
    }
}

// Open edit modal when clicking on edit button
document.querySelectorAll('.edit-btn').forEach(function(editBtn) {
    editBtn.onclick = function() {
        // Get customer data
        var customerID = this.getAttribute('data-id');
        var customerName = this.getAttribute('data-name');
        var customerAddress = this.getAttribute('data-address');
        var contactNumber = this.getAttribute('data-contact');

        // Set data to the form
        document.getElementById('edit_customer_ID').value = customer_ID;
        document.getElementById('edit_customer_Name').value = customer_Name;
        document.getElementById('edit_customer_Address').value = customer_Address;
        document.getElementById('edit_contact_No').value = contact_No;

        // Open edit modal
        editModal.style.display = "block";
    }
});

// Open delete confirmation modal when clicking on delete button
document.querySelectorAll('.delete-btn').forEach(function(deleteBtn) {
    deleteBtn.onclick = function() {
        var customerID = this.getAttribute('data-id');
        document.getElementById('confirmDelete').setAttribute('data-id', customerID);
        deleteModal.style.display = "block";
    }
});

// Handle delete confirmation
document.getElementById('confirmDelete').onclick = function() {
    var customerID = this.getAttribute('data-id');
    // Redirect to delete_customer.php with the customer ID
    window.location.href = "delete_customer.php?customer_ID=" + customerID;
}

// Search functionality
document.querySelector('.search-btn').onclick = function () {
    // Get the search term
    var searchTerm = document.querySelector('.search-bar input').value.toLowerCase();

    // Get all table rows
    var rows = document.querySelectorAll('table tbody tr');

    // Loop through the rows
    rows.forEach(function (row) {
        // Get the customer name from the second column (index 1)
        var customerName = row.cells[1].textContent.toLowerCase();

        // Check if the search term is in the customer name
        if (customerName.includes(searchTerm)) {
            // Highlight the row if the customer name contains the search term
            row.style.backgroundColor = 'yellow';
        } else {
            // Remove highlight if the name does not match
            row.style.backgroundColor = '';
        }
    });
}


