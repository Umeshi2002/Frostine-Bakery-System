<?php
$servername = "localhost";  // Change if hosted elsewhere
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password
$dbname = "frostine"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
