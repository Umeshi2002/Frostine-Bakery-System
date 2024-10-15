<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cashier</title>
    <link rel="stylesheet" href="addcashier.css">
</head>
<body>
    <div class="container">
        <!-- Navigation Sidebar -->
        <div class="sidebar">
            <img src="Bimg\frostineLogo.png" alt="Logo" class="logo"><br><br>
            <nav>
                <ul>
                    <li><a href="#"><img src="Bimg\home.png" alt="Home"></a></li><br><br><br>
                    <li><a href="#"><img src="Bimg\choice.png" alt="Inventory"></a></li><br><br><br>
                    <li><a href="#"><img src="Bimg\clipboard.png" alt="Edit"></a></li><br><br><br>
                    <li><a href="#"><img src="Bimg\report.png" alt="Reports"></a></li><br><br><br>
                    <li><a href="#"><img src="Bimg\log-out.png" alt="logout"></a></li><br><br><br>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h1>ADD CASHIER</h1>
            <div class="form-container">
                <form action="addcashier.php" method="POST">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name">

                    <label for="cashier-id">Cashier ID:</label>
                    <input type="int" id="cashier_id" name="cashier_id">

                    <label for="contact">Contact:</label>
                    <input type="text" id="contact" name="contact">

                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address">

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">

                    <label for="join-date">Join Date:</label>
                    <input type="date" id="join_date" name="join_date">

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">

                    <div class="buttons">
                        <button type="submit" class="add-btn">ADD</button>
                        <button type="button" class="cancel-btn">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Profile Picture -->
        <div class="profile-section">
            <img src="D:\IS\2 nd year\1 st semester\group\figma\images (2).jpeg" alt="Profile" class="profile-pic">
        </div>
    </div>
    <?php
include '../Cashier/config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Capture form data
  $name = $_POST['name'];
  $cashier_id = $_POST['cashier_id'];
  $contact = $_POST['contact'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $join_date = $_POST['join_date'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

  // Prepare and execute the SQL query
  $stmt = $conn->prepare("INSERT INTO cashiers (`name`,cashier_id,`contact`,`address`,`email`,`join_date`,`password`) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sisssss", $name, $cashier_id, $contact, $address, $email, $join_date, $password);

  if ($stmt->execute()) {
    echo "<script>showSuccessMessage('New cashier added successfully!');</script>";
} else {
    echo "Error: " . $stmt->error;
}

  $stmt->close();
  $conn->close();
}
?>
</body>
</html>
