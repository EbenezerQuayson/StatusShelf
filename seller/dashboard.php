<?php
session_start();
require_once '../config/db.php';

// 1. Security Check: If not logged in, go to login page
if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];

// 2. Get User Details (we need the username for the link)
$sql = "SELECT * FROM sellers WHERE id = '$seller_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// 3. Get User's Products
$product_sql = "SELECT * FROM products WHERE seller_id = '$seller_id' ORDER BY id DESC";
$products_result = $conn->query($product_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - StatusShelf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-white shadow-sm border-b border-gray-200 px-4 py-3 flex justify-between items-center sticky top-0 z-10">
        <div class="font-bold text-lg text-gray-800">
            My Dashboard
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-500 hidden md:inline">
                Logged in as <strong class="text-gray-800"><?php echo htmlspecialchars($user['business_name']); ?></strong>
            </span>
            <a href="../logout.php" class="text-red-500 text-sm font-medium hover:text-red-700">Logout</a>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto p-4 space-y-6">

        <div class="bg-indigo-600 rounded-xl p-6 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-2xl font-bold mb-2">Your store is live! 🚀</h2>
                <p class="text-indigo-100 mb-4 text-sm">Share this link on your WhatsApp Status.</p>
                
                <div class="flex bg-indigo-800 rounded-lg p-1.5 items-center">
                    <input type="text" value="http://localhost/statusshelf/shop.php?u=<?php echo $user['username']; ?>" 
                           readonly class="bg-transparent text-sm text-indigo-200 w-full px-2 focus:outline-none select-all">
                    
                    <button onclick="navigator.clipboard.writeText(this.previousElementSibling.value); alert('Copied!');" 
                            class="bg-white text-indigo-700 px-4 py-2 rounded-md font-bold text-sm hover:bg-gray-100 transition">
                        Copy
                    </button>
                </div>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500 rounded-full opacity-50 blur-2xl"></div>
        </div>

        <div class="flex justify-between items-end">
            <h3 class="text-xl font-bold text-gray-800">Your Products (<?php echo $products_result->num_rows; ?>)</h3>
            <a href="add_product.php" class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Add New
            </a>
        </div>

        <div class="space-y-4">
            
            <?php if ($products_result->num_rows > 0): ?>
                <?php while($product = $products_result->fetch_assoc()): ?>
                    
                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex gap-4 items-center">
                        <img src="../<?php echo $product['image']; ?>" class="w-20 h-20 object-cover rounded-lg bg-gray-100" alt="Product">
                        
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900"><?php echo htmlspecialchars($product['name']); ?></h4>
                            <p class="text-gray-500 text-sm">₵ <?php echo number_format($product['price'], 2); ?></p>
                        </div>
                        
                        <div class="flex gap-2">
    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="p-2 text-gray-400 hover:text-blue-500 transition" title="Edit">
        <i class="fa-solid fa-pen"></i>
    </a>
    
    <a href="delete_product.php?id=<?php echo $product['id']; ?>" 
       onclick="return confirm('Are you sure you want to delete this product?');"
       class="p-2 text-gray-400 hover:text-red-500 transition" title="Delete">
        <i class="fa-solid fa-trash"></i>
    </a>
</div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                
                <div class="text-center py-10 bg-white rounded-xl border border-dashed border-gray-300">
                    <div class="text-gray-300 text-4xl mb-3"><i class="fa-solid fa-box-open"></i></div>
                    <p class="text-gray-500">You haven't added any products yet.</p>
                </div>

            <?php endif; ?>

        </div>
        
    </div>

</body>
</html>