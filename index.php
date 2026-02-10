<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StatusShelf - Turn WhatsApp into a Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white text-gray-800">

    <nav class="flex justify-between items-center p-6 max-w-6xl mx-auto">
        <div class="text-2xl font-bold text-green-600 tracking-tighter">
            <i class="fa-solid fa-layer-group"></i> StatusShelf
        </div>
        <div>
            <a href="seller/login.php" class="text-gray-600 font-medium hover:text-green-600 mr-4">Log In</a>
            <a href="seller/register.php" class="bg-green-600 text-white px-5 py-2 rounded-full font-bold hover:bg-green-700 transition">Get Started</a>
        </div>
    </nav>

    <header class="text-center py-20 px-4">
        <h1 class="text-5xl md:text-6xl font-extrabold mb-6 tracking-tight">
            Stop spamming your <br>
            <span class="text-green-600">WhatsApp Status.</span>
        </h1>
        <p class="text-xl text-gray-500 mb-8 max-w-2xl mx-auto">
            Create a beautiful, searchable product catalog in seconds. Send your customers <strong>one link</strong> instead of 50 photos.
        </p>
        <div class="flex flex-col md:flex-row justify-center gap-4">
            <a href="seller/register.php" class="bg-black text-white px-8 py-4 rounded-lg font-bold text-lg hover:scale-105 transition transform">
                Create My Store Free
            </a>
            <a href="marketplace.php" class="bg-gray-100 text-gray-800 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-200 transition">
                View Demo Store
            </a>
        </div>
    </header>

    <section class="bg-gray-50 py-20 px-4">
        <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 mb-4 text-xl">
                    <i class="fa-solid fa-link"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">One Magic Link</h3>
                <p class="text-gray-500">Put one link in your bio. Customers see everything you have for sale, neatly organized.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mb-4 text-xl">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Direct WhatsApp Orders</h3>
                <p class="text-gray-500">No complex carts. Customers click "Buy" and it opens a pre-filled WhatsApp chat with you.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 mb-4 text-xl">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Instant Updates</h3>
                <p class="text-gray-500">Sold out? Delete it in one click. No more explaining "sorry, that's gone" to 20 people.</p>
            </div>
        </div>
    </section>

    <footer class="bg-white text-center py-8 text-gray-400 text-sm">
        &copy; 2026 StatusShelf. Built for hustlers.
    </footer>

</body>
</html>