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

// Form validation function
function validateForm(name, address, contact) {
    let isValid = true;
    let errorMessage = "";

    // Validate name (only letters and spaces)
    if (!/^[a-zA-Z\s]+$/.test(name)) {
        errorMessage += "Name should only contain letters and spaces\n";
        isValid = false;
    }

    // Validate address (not empty and minimum length)
    if (address.trim().length < 5) {
        errorMessage += "Address should be at least 5 characters long\n";
        isValid = false;
    }

    // Validate contact number (10 digits)
    if (!/^\d{10}$/.test(contact)) {
        errorMessage += "Contact number should be exactly 10 digits\n";
        isValid = false;
    }

    if (!isValid) {
        alert(errorMessage);
    }
    return isValid;
}

// Handle edit customer form submission
document.querySelector('#editCustomerModal form').onsubmit = function(e) {
    const name = document.getElementById('edit_customer_Name').value;
    const address = document.getElementById('edit_customer_Address').value;
    const contact = document.getElementById('edit_contact_Number').value;

    if (!validateForm(name, address, contact)) {
        e.preventDefault();
        return false;
    }
    return true;
};

// Handle add customer form submission
document.querySelector('#customerModal form').onsubmit = function(e) {
    const name = document.getElementById('customer_Name').value;
    const address = document.getElementById('customer_Address').value;
    const contact = document.getElementById('contact_Number').value;

    if (!validateForm(name, address, contact)) {
        e.preventDefault();
        return false;
    }
    return true;
};

// Edit button functionality
function attachEditListeners() {
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
}

// Delete button functionality
function attachDeleteListeners() {
    document.querySelectorAll('.delete-btn').forEach(function(deleteBtn) {
        deleteBtn.onclick = function() {
            var customer_ID = this.getAttribute('data-id');
            document.getElementById('confirmDelete').setAttribute('data-id', customer_ID);
            deleteModal.style.display = "block";
        }
    });
}

// Handle delete confirmation
document.getElementById('confirmDelete').onclick = function() {
    var customer_ID = this.getAttribute('data-id');
    window.location.href = 'CustomerManagement.php?delete_customer_ID=' + encodeURIComponent(customer_ID);
};

// Cancel delete
document.querySelector('#deleteCustomerModal .submit').onclick = function() {
    deleteModal.style.display = "none";
};

// Search functionality
document.querySelector('.search-btn').onclick = function(event) {
    event.preventDefault();
    var searchTerm = document.querySelector('.search-bar input').value.toLowerCase();
    var rows = document.querySelectorAll('table tbody tr');

    rows.forEach(function(row) {
        var customerName = row.cells[1].textContent.toLowerCase();
        row.style.display = customerName.includes(searchTerm) ? '' : 'none';
    });
}

// Attach event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    attachEditListeners();
    attachDeleteListeners();
});