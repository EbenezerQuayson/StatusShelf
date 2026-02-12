<?php
session_start();
require_once '../config/db.php';

// 1. Security: Admin Only
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// 2. Fetch Stats
$total_sellers = $conn->query("SELECT COUNT(*) as count FROM sellers")->fetch_assoc()['count'];
$total_products = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$total_customers = $conn->query("SELECT COUNT(*) as count FROM customers")->fetch_assoc()['count'];

// 3. Fetch Recent Sellers
$sellers = $conn->query("SELECT * FROM sellers ORDER BY id DESC LIMIT 5");

// 4. Fetch Recent Products
$products = $conn->query("SELECT products.*, sellers.business_name FROM products JOIN sellers ON products.seller_id = sellers.id ORDER BY products.id DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="bg-gray-900 text-white p-4 flex justify-between items-center shadow-md">
        <h1 class="font-bold text-xl"><i class="fa-solid fa-shield-halved mr-2"></i> StatusShelf Admin</h1>
        <a href="../logout.php" class="text-sm bg-red-600 px-3 py-1 rounded hover:bg-red-700">Logout</a>
    </div>

    <div class="p-6 max-w-6xl mx-auto space-y-6">

        <div class="grid grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                <p class="text-gray-500 text-sm">Total Sellers</p>
                <h3 class="text-3xl font-bold"><?php echo $total_sellers; ?></h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                <p class="text-gray-500 text-sm">Active Products</p>
                <h3 class="text-3xl font-bold"><?php echo $total_products; ?></h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-purple-500">
                <p class="text-gray-500 text-sm">Customers</p>
                <h3 class="text-3xl font-bold"><?php echo $total_customers; ?></h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <div class="bg-white rounded-xl shadow-sm p-4">
                <h3 class="font-bold text-gray-800 mb-4">Newest Sellers</h3>
                <table class="w-full text-sm text-left">
                    <thead class="text-gray-500 border-b">
                        <tr>
                            <th class="pb-2">Business</th>
                            <th class="pb-2">Phone</th>
                            <th class="pb-2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <?php while($s = $sellers->fetch_assoc()): ?>
                        <tr>
                            <td class="py-3 font-medium"><?php echo htmlspecialchars($s['business_name']); ?></td>
                            <td class="py-3 text-gray-500"><?php echo htmlspecialchars($s['phone_number']); ?></td>
                            <td class="py-3">
                                <a href="../shop.php?u=<?php echo $s['username']; ?>" target="_blank" class="text-blue-600 hover:underline">View</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4">
                <h3 class="font-bold text-gray-800 mb-4">Latest Products</h3>
                <div class="space-y-3">
                    <?php while($p = $products->fetch_assoc()): ?>
                    <div class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition group">
                        <img src="../<?php echo $p['image']; ?>" class="w-10 h-10 rounded object-cover bg-gray-200">
                        <div class="flex-1">
                            <p class="font-medium text-gray-800 truncate"><?php echo htmlspecialchars($p['name']); ?></p>
                            <p class="text-xs text-gray-500">by <?php echo htmlspecialchars($p['business_name']); ?></p>
                        </div>
                        
                        <a href="delete_item.php?id=<?php echo $p['id']; ?>" 
                           onclick="return confirm('ADMIN: Delete this item?')"
                           class="text-gray-300 hover:text-red-600 group-hover:block hidden">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>

        </div>
    </div>
</body>
</html>