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

$sql = "SELECT MAX(customer_ID) AS max_id FROM customer_details";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$max_id = $row['max_id'];

if ($max_id) {
    $next_id = 'C' . str_pad(substr($max_id, 1) + 1, 6, '0', STR_PAD_LEFT);
} else {
    $next_id = 'C000001';
}

function validateCustomerData($name, $address, $contact) {
    $errors = array();
    
    // Validate name
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $errors[] = "Name should only contain letters and spaces";
    }
    
    // Validate address
    if (strlen(trim($address)) < 5) {
        $errors[] = "Address should be at least 5 characters long";
    }
    
    // Validate contact number
    if (!preg_match("/^\d{10}$/", $contact)) {
        $errors[] = "Contact number should be exactly 10 digits";
    }
    
    return $errors;
}

// Handle Add Customer request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_customer'])) {
    $customer_ID = $next_id;
    $customer_Name = trim($_POST["customer_Name"]);
    $customer_Address = trim($_POST["customer_Address"]);
    $contact_Number = trim($_POST["contact_Number"]);

    $errors = validateCustomerData($customer_Name, $customer_Address, $contact_Number);

    if (empty($errors)) {
        // Prevent SQL injection using prepared statements
        $stmt = $conn->prepare("INSERT INTO customer_details (customer_ID, customer_Name, customer_Address, contact_Number) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $customer_ID, $customer_Name, $customer_Address, $contact_Number);
        
        if ($stmt->execute()) {
            echo "<script>alert('Customer added successfully'); window.location.href='CustomerManagement.php';</script>";
        } else {
            echo "<script>alert('Error adding customer: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
    }
}

// Handle Edit Customer request

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_customer'])) {
    $customer_ID = trim($_POST["customer_ID"]);
    $customer_Name = trim($_POST["customer_Name"]);
    $customer_Address = trim($_POST["customer_Address"]);
    $contact_Number = trim($_POST["contact_Number"]);

    $errors = validateCustomerData($customer_Name, $customer_Address, $contact_Number);

    if (empty($errors)) {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("UPDATE customer_details SET customer_Name=?, customer_Address=?, contact_Number=? WHERE customer_ID=?");
        $stmt->bind_param("ssss", $customer_Name, $customer_Address, $contact_Number, $customer_ID);
        
        if ($stmt->execute()) {
            echo "<script>alert('Customer updated successfully'); window.location.href='CustomerManagement.php';</script>";
        } else {
            echo "<script>alert('Error updating customer: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
    }
}

// Handle Delete Customer request

if (isset($_GET["delete_customer_ID"])) {
    $customer_ID = trim($_GET["delete_customer_ID"]);
    
    // Use prepared statement for delete
    $stmt = $conn->prepare("DELETE FROM customer_details WHERE customer_ID=?");
    $stmt->bind_param("s", $customer_ID);
    
    if ($stmt->execute()) {
        echo "<script>alert('Customer deleted successfully'); window.location.href='CustomerManagement.php';</script>";
    } else {
        echo "<script>alert('Error deleting customer: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Fetch all customers
$stmt = $conn->prepare("SELECT customer_ID, customer_Name, customer_Address, contact_Number FROM customer_details");
$stmt->execute();
$result = $stmt->get_result();


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <nav>
                <ul>
                    <b>
                    <li><a href="#"><i class="fas fa-tachometer-alt"></i>&nbsp;Dashboard</a></li>
                    <li><a href="../Employee Management/EmployeeManagement.php"><i class="fas fa-users"></i>&nbsp;Employees</a></li>
                    <li><a href="#"><i class="fas fa-truck"></i>&nbsp;Suppliers</a></li>
                    <li><a href="../Product Management/ProductManagement.php"><i class="fas fa-box"></i>&nbsp;Inventory</a></li>
                    <li><a href="../Customer Management/CustomerManagement.php"><i class="fas fa-user"></i>&nbsp;Customers</a></li>
                    <li><a href="#"><i class="fas fa-shopping-cart"></i>&nbsp;Orders</a></li>
                    </b>
                </ul>
            </nav>
            <div class="logo">
                <img src="FrostineLogo.png" alt="Frostine Logo">
            </div>
        </aside>
        <main>
            <header>
                <h1><i class="fas fa-user"></i>&nbsp&nbsp;Customers</h1>
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
                            <input type="text" id="customer_Name" name="customer_Name" required pattern="[a-zA-Z\s]+" title="Please enter a valid name (letters only)">

                            <label for="customer_Address">Address:</label>
                            <input type="text" id="customer_Address" name="customer_Address" required>

                            <label for="contact_Number">Contact No:</label>
                            <input type="text" id="contact_Number" name="contact_Number" required pattern="[0-9]{10}" title="Please enter a 10-digit contact number">

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
                            <button type="submit" id="confirmDelete" class="btn reset">Yes</button>
                            <button type="reset" class="btn submit">No</button>
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
                                    <th>Update/Delete</th>
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
                                        <!--button class="edit-btn" data-id="<?php echo $customer['customer_ID']; ?>" data-name="<?php echo htmlspecialchars($customer['customer_Name']); ?>" data-address="<?php echo htmlspecialchars($customer['customer_Address']); ?>" data-contact="<?php echo htmlspecialchars($customer['contact_Number']); ?>">✏️</button-->
                                        <!--button class="delete-btn" data-id="<?php echo $customer['customer_ID']; ?>">🗑️</button-->
                                        <button class="edit-btn" data-id="<?php echo $customer['customer_ID']; ?>" data-name="<?php echo htmlspecialchars($customer['customer_Name']); ?>" data-address="<?php echo htmlspecialchars($customer['customer_Address']); ?>" data-contact="<?php echo htmlspecialchars($customer['contact_Number']); ?>"><i class="fas fa-edit icon"></i></button>
                                        <button class="delete-btn" data-id="<?php echo $customer['customer_ID']; ?>"><i class="fas fa-trash icon"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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