<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CustomerDetails";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Customer_ID,customer_name,customer_address FROM customer_details";
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
                <img src="FrostineLogo.png" alt="Frostine Logo">
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
                <div class="customer-list">
                    <div class="search-bar">
                        <input type="text" placeholder="Customer Details">
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
                                        <td><?php echo htmlspecialchars($customer['Customer_ID']); ?></td>
                                        <td><?php echo htmlspecialchars($customer['customer_name']); ?></td>
                                        <td><?php echo htmlspecialchars($customer['customer_address']); ?></td>
                                        <td><?php echo htmlspecialchars($customer['Contact_Number']); ?></td>
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