<?php
// Database Configuration
$host = "localhost";
$user = "root";       
$pass = "";           
$dbname = "statusshelf_db";

// Create Connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Start Session (Required for login to work on every page)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>