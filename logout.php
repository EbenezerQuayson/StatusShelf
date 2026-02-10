<?php
session_start();

// 1. Determine who is logging out BEFORE we destroy the session
$redirect_url = "index.php"; // Default fallback (Home)

if (isset($_SESSION['seller_id'])) {
    // If it was a Seller, send them back to Seller Login
    $redirect_url = "seller/login.php";
} elseif (isset($_SESSION['customer_id'])) {
    // If it was a Customer, send them back to Marketplace or Customer Login
    $redirect_url = "customer/login.php"; 
}

// 2. Destroy the session (The actual logout)
session_unset();
session_destroy();

// 3. Redirect to the correct page
header("Location: " . $redirect_url);
exit();
?>