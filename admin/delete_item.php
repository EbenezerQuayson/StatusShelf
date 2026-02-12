<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Admin doesn't need to check "seller_id" - they have absolute power
    $conn->query("DELETE FROM products WHERE id = '$id'");
    
    // Optional: Also unlink the image file (same code as before)
    $check = $conn->query("SELECT image FROM products WHERE id = '$id'");
    if ($check->num_rows > 0) {
        $row = $check->fetch_assoc();
        $image_path = "../" . $row['image']; 
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    header("Location: dashboard.php?msg=deleted");
}
?>