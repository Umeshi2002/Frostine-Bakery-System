// Get the modal elements
var addModal = document.getElementById("employeeModal");
var editModal = document.getElementById("editemployeeModal");
var deleteModal = document.getElementById("deleteemployeeModal");

// Get the button that opens the modal
var addBtn = document.querySelector(".add-employee");

// Get the <span> element that closes the modal
var closeBtns = document.querySelectorAll(".close");

// When the user clicks the button, open the add employee modal
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
function validateForm(firstName, lastName, userName, password, contact) {
    let isValid = true;
    let errorMessage = "";

    // Name validation
    if (!/^[a-zA-Z\s]+$/.test(firstName) || !/^[a-zA-Z\s]+$/.test(lastName)) {
        errorMessage += "Names should only contain letters and spaces\n";
        isValid = false;
    }

    // Username validation
    if (!/^[a-zA-Z0-9]+$/.test(userName)) {
        errorMessage += "Username should only contain letters and numbers\n";
        isValid = false;
    }

    // Password validation
    if (password.length < 4) {
        errorMessage += "Password should be at least 4 characters long\n";
        isValid = false;
    }

    // Contact validation
    if (!/^\d{10}$/.test(contact)) {
        errorMessage += "Contact number should be exactly 10 digits\n";
        isValid = false;
    }

    if (!isValid) {
        alert(errorMessage);
    }
    return isValid;
}

// Handle edit employee form submission
document.querySelector('#editemployeeModal form').onsubmit = function(e) {
    const firstName = document.getElementById('edit_first_Name').value;
    const lastName = document.getElementById('edit_last_Name').value;
    const userName = document.getElementById('edit_user_Name').value;
    const password = document.getElementById('edit_password').value;
    const contact = document.getElementById('edit_contact_Number').value;

    if (!validateForm(firstName, lastName, userName, password, contact)) {
        e.preventDefault();
        return false;
    }
};

// Handle add employee form submission
document.querySelector('#employeeModal form').onsubmit = function(e) {
    const firstName = document.getElementById('first_Name').value;
    const lastName = document.getElementById('last_Name').value;
    const userName = document.getElementById('user_Name').value;
    const password = document.getElementById('password').value;
    const contact = document.getElementById('contact_Number').value;

    if (!validateForm(firstName, lastName, userName, password, contact)) {
        e.preventDefault();
        return false;
    }
};

// Edit button functionality
function attachEditListeners() {
    document.querySelectorAll('.edit-btn').forEach(function(editBtn) {
        editBtn.onclick = function() {
            var employee_ID = this.getAttribute('data-id');
            var first_Name = this.getAttribute('data-firstName');
            var last_Name = this.getAttribute('data-lastName');
            var user_Name = this.getAttribute('data-userName');
            var password = this.getAttribute('data-password');
            var contact_Number = this.getAttribute('data-contactNumber');

            document.getElementById('edit_employee_ID').value = employee_ID;
            document.getElementById('edit_first_Name').value = first_Name;
            document.getElementById('edit_last_Name').value = last_Name;
            document.getElementById('edit_user_Name').value = user_Name;
            document.getElementById('edit_employee_Password').value = password;
            document.getElementById('edit_contact_Number').value = contact_Number;

            editModal.style.display = "block";
        }
    });
}

// Delete button functionality
function attachDeleteListeners() {
    document.querySelectorAll('.delete-btn').forEach(function(deleteBtn) {
        deleteBtn.onclick = function() {
            var employee_ID = this.getAttribute('data-id');
            document.getElementById('confirmDelete').setAttribute('data-id', employee_ID);
            deleteModal.style.display = "block";
        }
    });
}

// Handle delete confirmation
document.getElementById('confirmDelete').onclick = function() {
    var employee_ID = this.getAttribute('data-id');
    window.location.href = 'employeeManagement.php?delete_employee_ID=' + encodeURIComponent(employee_ID);
};

// Cancel delete
document.querySelector('#deleteemployeeModal .submit').onclick = function() {
    deleteModal.style.display = "none";
};

// Search functionality
document.querySelector('.search-btn').onclick = function(event) {
    event.preventDefault();
    var searchTerm = document.querySelector('.search-bar input').value.toLowerCase();
    var rows = document.querySelectorAll('table tbody tr');

    rows.forEach(function(row) {
        var employeeName = row.cells[1].textContent.toLowerCase();
        row.style.display = employeeName.includes(searchTerm) ? '' : 'none';
    });
}

// Attach event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    attachEditListeners();
    attachDeleteListeners();
});