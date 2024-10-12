<?php
include 'config.php';  // Include the database configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];  // Use email as the username for login
    $password = $_POST['password'];

    // Prepare a statement to fetch the user from the database
    $stmt = $conn->prepare("SELECT id, password FROM login WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Bind the results
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['user_id'] = $id;
            echo "Login successful! Welcome to Frostine.";
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found with that email.";
    }

    $stmt->close();
    $conn->close();
}
?>
