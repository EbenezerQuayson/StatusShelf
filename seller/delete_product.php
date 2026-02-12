<?php
session_start();
require_once '../config/db.php';

// 1. Security: Must be logged in
if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $seller_id = $_SESSION['seller_id'];

    // 2. Security: Ensure the product actually belongs to THIS seller
    // (Prevents sellers from deleting each other's items by changing the URL ID)
    $check = $conn->query("SELECT image FROM products WHERE id = '$product_id' AND seller_id = '$seller_id'");

    if ($check->num_rows > 0) {
        $row = $check->fetch_assoc();
        
        // 3. Optional: Delete the image file from the folder to save space
        // Note: You need to go up one level from 'seller/' to reach 'assets/'
        $image_path = "../" . $row['image']; 
        if (file_exists($image_path)) {
            unlink($image_path); //This commands deletes the file from the server. Be very careful with this! Always check the path first to avoid deleting important files.
        }

        // 4. Delete from Database
        $sql = "DELETE FROM products WHERE id = '$product_id' AND seller_id = '$seller_id'";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: dashboard.php?msg=deleted");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        // Product doesn't exist or doesn't belong to you
        header("Location: dashboard.php?error=unauthorized");
        exit();
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>