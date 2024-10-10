<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Bakery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT customer_ID,customer_Name,customer_Address,contact_Number FROM customer_Details";
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
                <!-- Modal -->
                <div id="customerModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Add New Customer</h2>
                        <form action="/submit-customer-details" method="post">
                            <label for="customer_Name">Customer Name:</label>
                            <input type="text" id="customer_Name" name="customer_Name" required>

                            <label for="address">Address:</label>
                            <input type="text" id="customer_Address" name="customer_Address" required>

                            <label for="contact_No">Contact No:</label>
                            <input type="text" id="contact_No" name="contact_No" required>

                            <div class="buttons">
                                <button type="reset" class="btn reset">Reset</button>
                                <button type="submit" class="btn submit">Register</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="customer-list">
                    <div class="search-bar">
                        <input type="text" placeholder="Search by Customer Name">
                        <button class="search-btn">🔍</button>
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
                                            <button class="edit-btn">✏️</button>
                                            <button class="delete-btn">🗑️</button>
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