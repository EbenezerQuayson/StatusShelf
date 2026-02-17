<?php
require_once '../includes/base_url.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join StatusShelf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/images/favicon.png">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen px-4">

    <div class="w-full max-w-sm bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Create Account</h2>
            <p class="text-sm text-gray-500 mt-1">Save your favorite items and shop faster.</p>
        </div>

        <form action="register_logic.php" method="POST" class="space-y-4">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" name="fullname" required placeholder="John Doe" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2.5 border">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" required placeholder="john@example.com" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2.5 border">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2.5 border">
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 transition mt-2">
                Sign Up
            </button>

        </form>

        <div class="mt-6 text-center text-sm">
            <span class="text-gray-500">Already have an account?</span>
            <a href="login.php" class="font-medium text-green-600 hover:underline ml-1">Log in</a>
        </div>
        
        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400">Want to sell instead?</p>
            <a href="../seller/register.php" class="text-xs font-bold text-gray-800 hover:underline">Create a Store</a>
        </div>

    </div>

</body>
</html>