<?php
// 1. Connect to Database
require_once '../config/db.php';

// 2. Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // 3. Look for the user in the database
    $sql = "SELECT * FROM sellers WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, now fetch the data
        $user = $result->fetch_assoc();

        // 4. Verify Password (The crucial security step)
        // password_verify(plain_text, hashed_code_from_db)
        if (password_verify($password, $user['password'])) {
            
            // Password is correct! Start the session.
            session_start();
            $_SESSION['seller_id'] = $user['id'];
            $_SESSION['business_name'] = $user['business_name'];
            $_SESSION['username'] = $user['username'];

            // Redirect to Dashboard
            header("Location: dashboard.php");
            exit();

        } else {
            // Wrong Password
            header("Location: login.php?error=invalid_password");
            exit();
        }

    } else {
        // No user found with that email
        header("Location: login.php?error=no_user");
        exit();
    }
}
?>