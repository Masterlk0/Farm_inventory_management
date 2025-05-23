<?php
// Database configuration
$host = 'localhost';         // Usually localhost
$dbname = 'farm_inventory';  // Your database name
$username = 'root';          // Your MySQL username
$password = '';              // Your MySQL password ("" if none for local)

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set character set
$conn->set_charset("utf8");
?>
