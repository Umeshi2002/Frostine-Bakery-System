// Get the modal
var modal = document.getElementById("customerModal");

// Get the button that opens the modal
var btn = document.querySelector(".add-customer");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
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
