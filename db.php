<?php
// Database connection details
$host = "localhost";  // Database host
$user = "root";       // Database username (default for XAMPP)
$password = "";       // Database password (default is empty for XAMPP)
$dbname = "gate_pass_system";  // The name of your database

// Create a connection to the MySQL database using mysqli
$conn = new mysqli("localhost", "root", "", "gate_pass_system" ); // Replace 3307 with your custom port

// Check if the connection was successful
if ($conn->connect_error) {
    // If there is a connection error, display an error message and stop execution
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection successful!";
}
?>
