<?php
require_once '../includes/base_url.php';

$page_title = "Login - StatusShelf";

include '../includes/header.php';
?>
<body class="bg-gray-50 flex items-center justify-center min-h-screen px-4">

    <div class="w-full max-w-sm bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 text-green-600 mb-4 text-xl">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Welcome back</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your store and products.</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm text-center" role="alert">
                <?php 
                    if ($_GET['error'] == "invalid_password") echo "Incorrect password.";
                    elseif ($_GET['error'] == "no_user") echo "No account found with that email.";
                ?>
            </div>
        <?php endif; ?>

        <form action="login_logic.php" method="POST" class="space-y-5">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <input type="email" name="email" required class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2.5 border placeholder-gray-400">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <input type="password" name="password" required class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2.5 border placeholder-gray-400">
                </div>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-md shadow-green-200">
                Sign In
            </button>

        </form>

        <div class="mt-6 text-center text-sm">
            <span class="text-gray-500">Don't have a store yet?</span>
            <a href="register.php" class="font-medium text-green-600 hover:text-green-500 ml-1">Create one</a>
        </div>

    </div>

</body>
</html>