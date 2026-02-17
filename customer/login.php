<?php 
require_once '../includes/base_url.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/images/favicon.png">
    <title>Login - StatusShelf</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen px-4">

    <div class="w-full max-w-sm bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Welcome Back</h1>
        </div>

        <form action="login_logic.php" method="POST" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 border focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 border focus:ring-green-500 focus:border-green-500">
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 transition">
                Log In
            </button>
        </form>

        <div class="mt-6 text-center text-sm">
            <a href="register.php" class="text-green-600 hover:underline">Create an account</a>
        </div>

    </div>

</body>
</html>