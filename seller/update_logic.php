<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $seller_id = $_SESSION['seller_id'];
    $product_id = intval($_POST['product_id']);
    $name = $conn->real_escape_string($_POST['product_name']);
    $price = $_POST['price'];
    $category = $conn->real_escape_string($_POST['category']);

    // 1. Check if user uploaded a NEW image
    if (!empty($_FILES['product_image']['name'])) {
        
        // --- NEW IMAGE UPLOADED ---

        // A. Fetch old image path to delete it
        $old_query = $conn->query("SELECT image FROM products WHERE id = '$product_id' AND seller_id = '$seller_id'");
        $old_row = $old_query->fetch_assoc();
        $old_image_path = "../" . $old_row['image'];
        
        // B. Delete old file
        if (file_exists($old_image_path)) {
            unlink($old_image_path);
        }

        // C. Upload new file
        $target_dir = "../assets/uploads/";
        $imageFileType = strtolower(pathinfo($_FILES["product_image"]["name"], PATHINFO_EXTENSION));
        $new_file_name = "product_" . uniqid() . "_" . time() . "." . $imageFileType;
        $target_file = $target_dir . $new_file_name;
        $db_image_path = "assets/uploads/" . $new_file_name;

        move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file);

        // D. Update SQL (Including Image)
        $sql = "UPDATE products SET name='$name', price='$price', category='$category', image='$db_image_path' 
                WHERE id='$product_id' AND seller_id='$seller_id'";

    } else {
        
        // --- NO NEW IMAGE ---
        
        // Update SQL (Keep existing image)
        $sql = "UPDATE products SET name='$name', price='$price', category='$category' 
                WHERE id='$product_id' AND seller_id='$seller_id'";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php?msg=updated");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>