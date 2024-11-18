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

$sql = "SELECT MAX(employee_ID) AS max_id FROM employee_details";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$max_id = $row['max_id'];

if ($max_id) {
    $next_id = 'E' . str_pad(substr($max_id, 1) + 1, 6, '0', STR_PAD_LEFT);
} else {
    $next_id = 'E000001';
}

function validateemployeeData($userName, $firstName, $lastName, $password, $contact) {
    $errors = array();
    
    // Fix name validation to check each parameter separately
    if (!preg_match("/^[a-zA-Z\s]+$/", $firstName) || 
        !preg_match("/^[a-zA-Z\s]+$/", $lastName) ||
        !preg_match("/^[a-zA-Z0-9]+$/", $userName)) {
        $errors[] = "Invalid name format";
    }
    
    // Improve password validation
    if (strlen(trim($password)) < 4) {
        $errors[] = "Password should be at least 4 characters long";
    }
    
    // Contact validation remains the same
    if (!preg_match("/^\d{10}$/", $contact)) {
        $errors[] = "Contact number should be exactly 10 digits";
    }
    
    return $errors;
}

// Handle Add employee request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_employee'])) {
    $employee_ID = $next_id;
    $first_Name = trim($_POST["first_Name"]);
    $last_Name = trim($_POST["last_Name"]);
    $user_Name = trim($_POST["user_Name"]);
    $password = trim($_POST["employee_Password"]);
    $contact_Number = trim($_POST["contact_Number"]);

    $errors = validateemployeeData($user_Name,$first_Name,$last_Name, $password, $contact_Number);

    if (empty($errors)) {
        // Prevent SQL injection using prepared statements
        $stmt = $conn->prepare("INSERT INTO employee_details (employee_ID, first_Name, last_Name, user_Name, employee_Password,contact_Number) VALUES (?, ?, ?, ?,?,?)");
        $stmt->bind_param("ssssss", $employee_ID, $first_Name, $last_Name, $user_Name, $password, $contact_Number);
        
        if ($stmt->execute()) {
            echo "<script>alert('employee added successfully'); window.location.href='employeeManagement.php';</script>";
        } else {
            echo "<script>alert('Error adding employee: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
    }
}

// Handle Edit employee request

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_employee'])) {
    $employee_ID = trim($_POST["employee_ID"]);
    $first_Name = trim($_POST["first_Name"]);
    $last_Name = trim($_POST["last_Name"]);
    $user_Name = trim($_POST["user_Name"]);
    $password = trim($_POST["employee_Password"]);
    $contact_Number = trim($_POST["contact_Number"]);

    $errors = validateemployeeData($user_Name,$first_Name,$last_Name, $password, $contact_Number);

    if (empty($errors)) {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO employee_details (employee_ID, first_Name, last_Name, user_Name, employee_Password, contact_Number) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $employee_ID, $first_Name, $last_Name, $user_Name, $password, $contact_Number);
        
        if ($stmt->execute()) {
            echo "<script>alert('employee updated successfully'); window.location.href='employeeManagement.php';</script>";
        } else {
            echo "<script>alert('Error updating employee: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
    }
}

// Handle Delete employee request

if (isset($_GET["delete_employee_ID"])) {
    $employee_ID = trim($_GET["delete_employee_ID"]);
    
    // Use prepared statement for delete
    $stmt = $conn->prepare("DELETE FROM employee_details WHERE employee_ID=?");
    $stmt->bind_param("s", $employee_ID);
    
    if ($stmt->execute()) {
        echo "<script>alert('employee deleted successfully'); window.location.href='employeeManagement.php';</script>";
    } else {
        echo "<script>alert('Error deleting employee: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Fetch all employees
$stmt = $conn->prepare("SELECT employee_ID,first_Name, last_Name, user_Name, employee_Password, contact_Number FROM employee_details");
$stmt->execute();
$result = $stmt->get_result();


$employees = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine employee Management</title>
    <link rel="stylesheet" href="EmployeeManagement.css">
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
                    <li><a href="../Customer Management/customerManagement.php"><i class="fas fa-user"></i>&nbsp;Customers</a></li>
                    <li><a href="#"><i class="fas fa-shopping-cart"></i>&nbsp;Orders</a></li>
                    </b>
                </ul>
            </nav>
            <div class="logo">
                <img src="../Images/FrostineLogo.png" alt="Frostine Logo">
            </div>
        </aside>
        <main>
            <header>
                <h1><i class="fas fa-user"></i>&nbsp&nbsp;Employees</h1>
                <div class="user-info">
                    <span>Dasun Pathirana</span>
                    <span>(Head Manager)</span>
                </div>
            </header>
            <div class="content">
                <button class="add-employee">+ Add New employee</button>
                <!-- Add employee Modal -->
                <div id="employeeModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Add New employee</h2>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <label for="first_Name">First Name:</label>
                            <input type="text" id="first_Name" name="first_Name" required pattern="[A-Za-z]{1,}" title="Please enter a valid first name(letters only)">

                            <label for="last_Name">Last Name:</label>
                            <input type="text" id="last_Name" name="last_Name" required pattern="[A-Za-z]{1,}" title="Please enter a valid last name(letters only)">

                            <label for="user_Name">User Name:</label>
                            <input type="text" id="user_Name" name="user_Name" required pattern="[A-Za-z0-9]{1,}" title="Please enter a valid user name(letters and numbers only)">

                            <label for="employee_Password">Password:</label>
                            <input type="password" id="employee_Password" name="employee_Password" required pattern="[A-Za-z0-9]{1,}" title="Please enter a valid password(letters and numbers only)">

                            <label for="contact_Number">Contact No:</label>
                            <input type="text" id="contact_Number" name="contact_Number" required pattern="[0-9]{10}" title="Please enter a 10-digit contact number">

                            <div class="buttons">
                                <button type="reset" class="btn reset">Reset</button>
                                <button type="submit" name="add_employee" class="btn submit">Register</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit employee Modal -->
                <div id="editemployeeModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Edit employee</h2>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input type="hidden" id="edit_employee_ID" name="employee_ID">
                            <label for="edit_first_Name">First Name:</label>
                            <input type="text" id="edit_first_Name" name="first_Name" required>

                            <label for="edit_last_Name">Last Name:</label>
                            <input type="text" id="edit_last_Name" name="last_Name" required>

                            <label for="edit_user_Name">User Name:</label>
                            <input type="text" id="edit_user_Name" name="user_Name" required>

                            <label for="edit_employee_Password">Password:</label>  
                            <input type="password" id="edit_employee_Password" name="employee_Password" required>

                            <label for="edit_contact_Number">Contact No:</label>
                            <input type="text" id="edit_contact_Number" name="contact_Number" required>

                            <div class="buttons">
                                <button type="submit" name="edit_employee" class="btn submit">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div id="deleteemployeeModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Delete employee</h2>
                        <p>Are you sure you want to delete this employee?</p>
                        <div class="buttons">
                            <button type="submit" id="confirmDelete" class="btn reset">Yes</button>
                            <button type="reset" class="btn submit">No</button>
                        </div>
                    </div>
                </div>

                <div class="employee-list">
                    <div class="search-bar">
                        <form method="GET" action="">
                            <input type="text" placeholder="Search by User Name">
                            <button class="search-btn">🔍</button>
                        </form>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Employee Id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>User Name</th>
                                    <th>Password</th>       
                                    <th>Contact No</th>
                                    <th>Update/Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($employees as $employee): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($employee['employee_ID']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['first_Name']); ?></td> 
                                    <td><?php echo htmlspecialchars($employee['last_Name']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['user_Name']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['employee_Password']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['contact_Number']); ?></td>
                                    <td>
                                        <button class="edit-btn" data-id="<?php echo $employee['employee_ID']; ?>" data-firstName="<?php echo $employee['first_Name']; ?>" data-lastName="<?php echo $employee['last_Name']; ?>" data-userName="<?php echo $employee['user_Name']; ?>" data-password="<?php echo $employee['employee_Password']; ?>" data-contactNumber="<?php echo $employee['contact_Number']; ?>"><i class="fas fa-edit icon"></i></button>
                                        <button class="delete-btn" data-id="<?php echo $employee['employee_ID']; ?>"><i class="fas fa-trash icon"></i></button>
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
    <script src="EmployeeManagement.js"></script>
</body>
</html>
<?php
$conn->close();
?>