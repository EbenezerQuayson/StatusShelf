<?php
// 1. Connect to Database (Go up one level to find config)
require_once '../config/db.php';

// 2. Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. Sanitize Inputs
    $full_name = $conn->real_escape_string($_POST['fullname']); // Matches name="fullname" in HTML
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // 4. Check if Email already exists
    $check_query = "SELECT id FROM customers WHERE email = '$email'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        // Email taken
        header("Location: register.php?error=email_taken");
        exit();
    }

    // 5. Hash Password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 6. Insert into Database
    $sql = "INSERT INTO customers (full_name, email, password) 
            VALUES ('$full_name', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        
        // 7. Auto-Login the user
        session_start();
        $_SESSION['customer_id'] = $conn->insert_id;
        $_SESSION['customer_name'] = $full_name;
        
        // 8. Redirect to Profile (or Marketplace)
        header("Location: profile.php");
        exit();
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>