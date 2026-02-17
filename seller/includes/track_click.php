<?php
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $id = intval($_POST['product_id']);
    
    // Increment the click count for this product
    $conn->query("UPDATE products SET clicks = clicks + 1 WHERE id = '$id'");
    
    echo "success";
}
?>