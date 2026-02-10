<?php
session_start();
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Categories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 pb-20">

    <header class="bg-white shadow-sm px-4 py-4 sticky top-0 z-10">
        <h1 class="font-bold text-xl text-gray-800">Explore</h1>
        <p class="text-sm text-gray-500">Find exactly what you need.</p>
    </header>

    <div class="p-4 grid grid-cols-2 gap-4">
        
        <a href="marketplace.php?category=Fashion" class="bg-pink-100 p-6 rounded-2xl flex flex-col items-center justify-center gap-2 hover:scale-105 transition">
            <i class="fa-solid fa-shirt text-3xl text-pink-500"></i>
            <span class="font-bold text-gray-700">Fashion</span>
        </a>

        <a href="marketplace.php?category=Electronics" class="bg-blue-100 p-6 rounded-2xl flex flex-col items-center justify-center gap-2 hover:scale-105 transition">
            <i class="fa-solid fa-mobile-screen text-3xl text-blue-500"></i>
            <span class="font-bold text-gray-700">Gadgets</span>
        </a>

        <a href="marketplace.php?category=Beauty" class="bg-purple-100 p-6 rounded-2xl flex flex-col items-center justify-center gap-2 hover:scale-105 transition">
            <i class="fa-solid fa-spray-can-sparkles text-3xl text-purple-500"></i>
            <span class="font-bold text-gray-700">Beauty</span>
        </a>

        <a href="marketplace.php?category=Food" class="bg-orange-100 p-6 rounded-2xl flex flex-col items-center justify-center gap-2 hover:scale-105 transition">
            <i class="fa-solid fa-burger text-3xl text-orange-500"></i>
            <span class="font-bold text-gray-700">Food</span>
        </a>

        <a href="marketplace.php?category=Home" class="bg-green-100 p-6 rounded-2xl flex flex-col items-center justify-center gap-2 hover:scale-105 transition">
            <i class="fa-solid fa-couch text-3xl text-green-500"></i>
            <span class="font-bold text-gray-700">Home</span>
        </a>

        <a href="marketplace.php?category=Services" class="bg-gray-200 p-6 rounded-2xl flex flex-col items-center justify-center gap-2 hover:scale-105 transition">
            <i class="fa-solid fa-briefcase text-3xl text-gray-500"></i>
            <span class="font-bold text-gray-700">Services</span>
        </a>

    </div>

    <nav class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around py-3 pb-safe z-50">
        <a href="marketplace.php" class="text-gray-400 flex flex-col items-center gap-1 hover:text-gray-600">
            <i class="fa-solid fa-home"></i>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        
        <a href="#" class="text-green-600 flex flex-col items-center gap-1">
            <i class="fa-solid fa-compass"></i>
            <span class="text-[10px] font-medium">Explore</span>
        </a>

        <?php if (isset($_SESSION['customer_id'])): ?>
            <a href="customer/profile.php" class="text-gray-400 flex flex-col items-center gap-1 hover:text-gray-600">
                <i class="fa-solid fa-user"></i>
                <span class="text-[10px] font-medium">Profile</span>
            </a>
        <?php else: ?>
            <a href="customer/login.php" class="text-gray-400 flex flex-col items-center gap-1 hover:text-gray-600">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span class="text-[10px] font-medium">Login</span>
            </a>
        <?php endif; ?>
    </nav>

</body>
</html>