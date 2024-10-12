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
        // Get customer data from data attributes
        var customer_ID = this.getAttribute('data-id');
        var customer_Name = this.getAttribute('data-name');
        var customer_Address = this.getAttribute('data-address');
        var contact_Number = this.getAttribute('data-contact');

        // Set data to the form
        document.getElementById('edit_customer_ID').value = customer_ID;
        // $('#edit_customer_ID').val(customer_ID);
        document.getElementById('edit_customer_Name').value = customer_Name;
        document.getElementById('edit_customer_Address').value = customer_Address;
        document.getElementById('edit_contact_Number').value = contact_Number;

        // Open edit modal
        editModal.style.display = "block";
    }
});

// Open delete confirmation modal when clicking on delete button
document.querySelectorAll('.delete-btn').forEach(function(deleteBtn) {
    deleteBtn.onclick = function() {
        var customer_ID = this.getAttribute('data-id');
        document.getElementById('confirmDelete').setAttribute('data-id', customer_ID);
        deleteModal.style.display = "block";
    }
});

// Handle delete confirmation
document.getElementById('confirmDelete').onclick = function() {
    var customer_ID = this.getAttribute('data-id');
    // Redirect to delete customer with the customer ID
    window.location.href = window.location.href + "?delete_customer_ID=" + customer_ID;
}

// Search functionality
document.querySelector('.search-btn').onclick = function (event) {
    event.preventDefault(); // Prevent form submission
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
            // Show the row if the customer name contains the search term
            row.style.display = '';
        } else {
            // Hide the row if the name does not match
            row.style.display = 'none';
        }
    });
}

// Add event listeners after DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Re-attach event listeners to dynamically added elements
    function reattachListeners() {
        // Edit buttons
        document.querySelectorAll('.edit-btn').forEach(function(editBtn) {
            editBtn.onclick = function() {
                var customer_ID = this.getAttribute('data-id');
                var customer_Name = this.getAttribute('data-name');
                var customer_Address = this.getAttribute('data-address');
                var contact_Number = this.getAttribute('data-contact');

                document.getElementById('edit_customer_ID').value = customer_ID;
                document.getElementById('edit_customer_Name').value = customer_Name;
                document.getElementById('edit_customer_Address').value = customer_Address;
                document.getElementById('edit_contact_Number').value = contact_Number;

                editModal.style.display = "block";
            }
        });

        // Delete buttons
        document.querySelectorAll('.delete-btn').forEach(function(deleteBtn) {
            deleteBtn.onclick = function() {
                var customer_ID = this.getAttribute('data-id');
                document.getElementById('confirmDelete').setAttribute('data-id', customer_ID);
                deleteModal.style.display = "block";
            }
        });
    }

    // Call reattachListeners initially
    reattachListeners();

    // You might want to call reattachListeners() after any AJAX operations 
    // that update the table content
});