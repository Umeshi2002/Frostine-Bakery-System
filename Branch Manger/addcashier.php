<?php
include 'Cashier/config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Capture form data
  $name = $_POST['name'];
  $cashier_id = $_POST['cashier-id'];
  $contact = $_POST['contact'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $join_date = $_POST['join-date'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

  // Prepare and execute the SQL query
  $stmt = $conn->prepare("INSERT INTO cashiers (name, cashier_id, contact, address, email, join_date, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssssss", $name, $cashier_id, $contact, $address, $email, $join_date, $password);

  if ($stmt->execute()) {
      echo "New cashier added successfully!";
  } else {
      echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}
?>