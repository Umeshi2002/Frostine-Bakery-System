<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bakery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Add Customer request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_customer'])) {
    $customer_Name = $_POST["customer_Name"];
    $customer_Address = $_POST["customer_Address"];
    $contact_Number = $_POST["contact_Number"];

    $sql = "INSERT INTO customer_details (customer_Name, customer_Address, contact_Number)
            VALUES ('$customer_Name', '$customer_Address', '$contact_Number')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Customer added successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Edit Customer request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_customer'])) {
    $customer_ID = $_POST["customer_ID"];
    $customer_Name = $_POST["customer_Name"];
    $customer_Address = $_POST["customer_Address"];
    $contact_Number = $_POST["contact_Number"];

    $sql = "UPDATE customer_details SET customer_Name='$customer_Name', customer_Address='$customer_Address', contact_Number='$contact_Number' WHERE customer_ID=$customer_ID";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Customer updated successfully');</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Handle Delete Customer request
if (isset($_GET["delete_customer_ID"])) {
    $customer_ID = $_GET["delete_customer_ID"];

    $sql = "DELETE FROM customer_details WHERE customer_ID=$customer_ID";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Customer deleted successfully');</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch all customers
$sql = "SELECT customer_ID, customer_Name, customer_Address, contact_Number FROM customer_details";
$result = $conn->query($sql);

$customers = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Customer Management</title>
    <link rel="stylesheet" href="CustomerManagement.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="#"><i class="icon-dashboard"></i>Dashboard</a></li>
                    <li><a href="#"><i class="icon-user"></i>User Management</a></li>
                    <li><a href="#"><i class="icon-supplier"></i>Supplier Management</a></li>
                    <li><a href="#"><i class="icon-product"></i>Product Management</a></li>
                    <li><a href="#"><i class="icon-customer"></i>Customer Management</a></li>
                    <li><a href="#"><i class="icon-orders"></i>View Orders</a></li>
                </ul>
            </nav>
            <div class="logo">
                <img src="images/FrostineLogo.png" alt="Frostine Logo">
            </div>
        </aside>
        <main>
            <header>
                <h1>Customer Management</h1>
                <div class="user-info">
                    <span>Dasun Pathirana</span>
                    <span>(Head Manager)</span>
                </div>
            </header>
            <div class="content">
                <button class="add-customer">+ Add New Customer</button>
                <!-- Add Customer Modal -->
                <div id="customerModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Add New Customer</h2>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <label for="customer_Name">Customer Name:</label>
                            <input type="text" id="customer_Name" name="customer_Name" required>

                            <label for="customer_Address">Address:</label>
                            <input type="text" id="customer_Address" name="customer_Address" required>

                            <label for="contact_Number">Contact No:</label>
                            <input type="text" id="contact_Number" name="contact_Number" required>

                            <div class="buttons">
                                <button type="reset" class="btn reset">Reset</button>
                                <button type="submit" name="add_customer" class="btn submit">Register</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Customer Modal -->
                <div id="editCustomerModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Edit Customer</h2>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input type="hidden" id="edit_customer_ID" name="customer_ID">
                            <label for="edit_customer_Name">Customer Name:</label>
                            <input type="text" id="edit_customer_Name" name="customer_Name" required>

                            <label for="edit_customer_Address">Address:</label>
                            <input type="text" id="edit_customer_Address" name="customer_Address" required>

                            <label for="edit_contact_Number">Contact No:</label>
                            <input type="text" id="edit_contact_Number" name="contact_Number" required>

                            <div class="buttons">
                                <button type="submit" name="edit_customer" class="btn submit">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div id="deleteCustomerModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Delete Customer</h2>
                        <p>Are you sure you want to delete this customer?</p>
                        <div class="buttons">
                            <button id="confirmDelete" class="btn delete">Yes</button>
                            <button class="btn cancel">No</button>
                        </div>
                    </div>
                </div>

                <div class="customer-list">
                    <div class="search-bar">
                        <form method="GET" action="">
                            <input type="text" placeholder="Search by Customer Name">
                            <button class="search-btn">🔍</button>
                        </form>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Customer Id</th>
                                    <th>Full Name</th>
                                    <th>Address</th>
                                    <th>Contact No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($customer['customer_ID']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['customer_Name']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['customer_Address']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['contact_Number']); ?></td>
                                    <td>
                                        <button class="edit-btn" data-id="<?php echo $customer['customer_ID']; ?>" data-name="<?php echo htmlspecialchars($customer['customer_Name']); ?>" data-address="<?php echo htmlspecialchars($customer['customer_Address']); ?>" data-contact="<?php echo htmlspecialchars($customer['contact_Number']); ?>">✏️</button>
                                        <button class="delete-btn" data-id="<?php echo $customer['customer_ID']; ?>">🗑️</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination">
                        <button class="prev-btn">❮</button>
                        <span class="page-number">1</span>
                        <span class="page-number">2</span>
                        <button class="next-btn">❯</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="CustomerManagement.js"></script>
</body>
</html>
<?php
$conn->close();
?>