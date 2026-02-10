<?php
session_start();
require_once '../config/db.php';

// 1. Security Check
if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $seller_id = $_SESSION['seller_id'];
    $name = $conn->real_escape_string($_POST['product_name']);
    $price = $_POST['price']; // Decimal type in DB handles formatting
    $category = $conn->real_escape_string($_POST['category']);
    
    // 2. Image Handling Logic
    $target_dir = "../assets/uploads/";
    
    // Get file extension (e.g. .jpg)
    $imageFileType = strtolower(pathinfo($_FILES["product_image"]["name"], PATHINFO_EXTENSION));
    
    // Generate unique name (e.g. product_65a4b3_170899.jpg)
    $new_file_name = "product_" . uniqid() . "_" . time() . "." . $imageFileType;
    $target_file = $target_dir . $new_file_name;
    
    // Database path (what we store in SQL) - removes the "../"
    $db_image_path = "assets/uploads/" . $new_file_name;

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["product_image"]["tmp_name"]);
    if($check === false) {
        die("File is not an image.");
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // 3. Move the file & Save to DB
    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        
$sql = "INSERT INTO products (seller_id, name, price, category, image) 
        VALUES ('$seller_id', '$name', '$price', '$category', '$db_image_path')";
        if ($conn->query($sql) === TRUE) {
            header("Location: dashboard.php?success=product_added");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>