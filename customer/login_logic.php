<?php
require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Look for the customer
    $sql = "SELECT * FROM customers WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify Password
        if (password_verify($password, $user['password'])) {
            
            // Login Success
            session_start();
            $_SESSION['customer_id'] = $user['id'];
            $_SESSION['customer_name'] = $user['full_name'];

            // Redirect to Profile
            header("Location: profile.php");
            exit();

        } else {
            header("Location: login.php?error=invalid_password");
            exit();
        }

    } else {
        header("Location: login.php?error=no_user");
        exit();
    }
}
?>