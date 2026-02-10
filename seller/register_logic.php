<?php
// 1. Connect to Database
require_once '../config/db.php';

// 2. Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. Sanitize Inputs (Prevent Hacking)
    $business_name = $conn->real_escape_string($_POST['business_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    
    // Format Phone: Combine Country Code (233) with the user input
    // Note: If user enters '054...', we might want to remove the leading '0'.
    $raw_phone = $_POST['phone'];
    // Remove leading zero if present (e.g., 054 -> 54)
    if (substr($raw_phone, 0, 1) == '0') {
        $raw_phone = substr($raw_phone, 1);
    }
    $phone = "233" . $raw_phone; 

    // 4. Generate a unique Username (Slug)
    // "Kicks By Jay" -> "kicksbyjay"
    $username = strtolower(str_replace(' ', '', $business_name));
    
    // Add a random number to ensure uniqueness (e.g. kicksbyjay24)
    $username = $username . rand(10, 99); 

    // 5. Check if Email already exists
    $check_query = "SELECT id FROM sellers WHERE email = '$email'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        // Email taken, send back to register page with error
        header("Location: register.php?error=email_taken");
        exit();
    }

    // 6. Hash Password (Security)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 7. Insert into Database
    $sql = "INSERT INTO sellers (business_name, username, phone_number, email, password) 
            VALUES ('$business_name', '$username', '$phone', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        // Success! 
        
        // 8. Start Session (Log them in automatically)
        session_start();
        $_SESSION['seller_id'] = $conn->insert_id; // Get the ID of the new user
        $_SESSION['business_name'] = $business_name;
        
        // 9. Redirect to Dashboard
        header("Location: dashboard.php");
        exit();
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>