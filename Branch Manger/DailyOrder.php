<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Requirement</title>
    <link rel="stylesheet" href="DailyOrder.css">
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
            <h1>Daily Requirement</h1>
            <div class="form-container">
                <form action="DailyOrder.php" method="POST">
                    <label for="branch-id">Branch ID:</label>
                    <input type="text" id="branch-id" name="branch-id">

                    <label for="branch-name">Branch Name:</label>
                    <input type="text" id="branch-name" name="branch-name">

                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date">

                    <label for="order-description">Order Description:</label>
                    <textarea id="order-description" name="order-description"></textarea>

                    <button type="submit" class="submit-btn">Submit</button>
                </form>
            </div>
        </div>

        <!-- Profile Picture -->
        <div class="profile-section">
            <img src="Bimg/profile.jpeg" alt="Profile" class="profile-pic">
        </div>
    </div>
    <?php
// Include your database connection
include '../Cashier/config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $branchID = $_POST['branch-id'];
    $branchName = $_POST['branch-name'];
    $date = $_POST['date'];
    $description = $_POST['order-description'];

    // SQL query to insert data into the dailybranchorder table
    $sql = "INSERT INTO dailybranchorder (BranchID,BranchName,Date,Description) VALUES (?, ?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $branchID, $branchName, $date, $description);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('New daily order added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
