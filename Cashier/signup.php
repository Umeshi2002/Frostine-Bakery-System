<?php
include 'config.php';  // Include the database configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password != $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

   // Hash the password for security
   $hashed_password = password_hash($password, PASSWORD_DEFAULT);

   // Check if the email already exists in the 'login' table
   $stmt = $conn->prepare("SELECT id FROM login WHERE email = ?");
   $stmt->bind_param("s", $email);
   $stmt->execute();
   $stmt->store_result();

   if ($stmt->num_rows > 0) {
       echo "Email already exists!";
       $stmt->close();
       exit;
   }

   // Insert the new user into the 'login' table with the column 'username'
   $stmt = $conn->prepare("INSERT INTO login (username, email,password) VALUES (?, ?, ?)");
   $stmt->bind_param("sss", $username, $email, $hashed_password);

   // Execute the query and check if the user is successfully added
   if ($stmt->execute()) {
       echo "Signup successful! You can now login.";
   } else {
       echo "Error: " . $stmt->error;
   }

   $stmt->close();
   $conn->close();
}
?>

