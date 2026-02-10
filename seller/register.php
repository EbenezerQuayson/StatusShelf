<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Store - StatusShelf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen px-4 py-8">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Start Selling</h2>
            <p class="text-sm text-gray-500 mt-1">Get your free product link in seconds.</p>
        </div>

        <form action="register_logic.php" method="POST" class="space-y-4">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Business Name</label>
                <input type="text" name="business_name" required placeholder="e.g. Kicks By Jay" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2.5 border">
                <p class="text-xs text-gray-400 mt-1">This will be your store title.</p>
            </div>
            

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500 font-bold border-r pr-2 mr-2">
                        +233
                    </div>
                    <input type="tel" name="phone" required placeholder="XXXXXXX" class="pl-16 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2.5 border">
                </div>
                <p class="text-xs text-green-600 mt-1"><i class="fa-brands fa-whatsapp"></i> Customers will message this number.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" required placeholder="you@example.com" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2.5 border">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Create Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2.5 border">
            </div>

            <button type="submit" class="w-full bg-black text-white font-bold py-3 px-4 rounded-lg hover:bg-gray-800 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black mt-2">
                Create My Account
            </button>

        </form>

        <div class="mt-6 text-center text-sm">
            <span class="text-gray-500">Already have an account?</span>
            <a href="login.php" class="font-medium text-green-600 hover:text-green-500 ml-1">Login here</a>
        </div>

    </div>

</body>
</html>