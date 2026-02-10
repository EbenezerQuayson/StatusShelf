<?php
session_start();
require_once '../config/db.php';

// 1. Check if User is Logged In
if (!isset($_SESSION['customer_id'])) {
    echo "login_required";
    exit();
}

$customer_id = $_SESSION['customer_id'];
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

if ($product_id > 0) {
    
    // 2. Check if already saved
    $check = $conn->query("SELECT id FROM saved_items WHERE customer_id = '$customer_id' AND product_id = '$product_id'");

    if ($check->num_rows > 0) {
        // ALREADY SAVED -> DELETE IT (Unlike)
        $conn->query("DELETE FROM saved_items WHERE customer_id = '$customer_id' AND product_id = '$product_id'");
        echo "removed";
    } else {
        // NOT SAVED -> INSERT IT (Like)
        $conn->query("INSERT INTO saved_items (customer_id, product_id) VALUES ('$customer_id', '$product_id')");
        echo "saved";
    }
}
?>