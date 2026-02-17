<?php
session_start();
require_once '../config/db.php';
require_once '../includes/base_url.php';



// 1. Security Check: Kick them out if not logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];
$customer_name = $_SESSION['customer_name']; // Got this from login_logic.php


// Fetch fresh user data (to get the image)
$user_query = $conn->query("SELECT * FROM customers WHERE id = '$customer_id'");
$user_data = $user_query->fetch_assoc();


// 2. Fetch Saved Items (Future Proofing)
// We join the 'saved_items' table with 'products' to get the details
$sql = "SELECT products.*, sellers.business_name, sellers.username 
        FROM saved_items 
        JOIN products ON saved_items.product_id = products.id 
        JOIN sellers ON products.seller_id = sellers.id 
        WHERE saved_items.customer_id = '$customer_id'";

$saved_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - StatusShelf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/images/favicon.png">
</head>
<body class="bg-gray-50 pb-20">

    <header class="bg-white shadow-sm px-4 py-4  flex justify-between items-center sticky top-0 z-10">
        <h1 class="font-bold text-lg text-gray-800">My Account</h1>
        <div>
        <a href="settings.php" class="text-gray-400 hover:text-gray-600 mr-4"><i class="fa-solid fa-gear"></i></a>
        <a href="../logout.php" class="text-red-500 text-sm font-medium hover:text-red-700"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
        </div>
    </header>

    <div class="bg-white p-6 m-4 rounded-xl shadow-sm flex items-center gap-4 border border-gray-100">
       <div class="w-14 h-14 rounded-full flex items-center justify-center overflow-hidden border-2 border-green-50 bg-green-100 text-green-600 text-xl font-bold">
    <?php if (!empty($user_data['profile_image'])): ?>
        <img src="../<?php echo $user_data['profile_image']; ?>" class="w-full h-full object-cover">
    <?php else: ?>
        <?php echo strtoupper(substr($customer_name, 0, 2)); ?>
    <?php endif; ?>
</div>
        <div>
            <h2 class="font-bold text-lg text-gray-900"><?php echo htmlspecialchars($customer_name); ?></h2>
            <p class="text-gray-500 text-sm">Member since 2026</p>
        </div>
    </div>

    <div class="px-4">
        <h3 class="font-bold text-gray-800 mb-4 text-lg">Saved Items <span class="text-gray-400 text-sm font-normal">(<?php echo $saved_result->num_rows; ?>)</span></h3>
        
        <div class="space-y-3">
            
            <?php if ($saved_result->num_rows > 0): ?>
                <?php while($item = $saved_result->fetch_assoc()): ?>
                    
                    <div class="bg-white p-3 rounded-xl shadow-sm flex gap-3 items-center border border-gray-100">
                        <img src="../<?php echo $item['image']; ?>" class="w-16 h-16 object-cover rounded-lg bg-gray-100">
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 text-sm"><?php echo htmlspecialchars($item['name']); ?></h4>
                            <p class="text-gray-500 text-xs mb-1">Sold by <?php echo htmlspecialchars($item['business_name']); ?></p>
                            <p class="font-bold text-green-600">₵ <?php echo number_format($item['price'], 2); ?></p>
                        </div>
                        <a href="../shop.php?u=<?php echo $item['username']; ?>" class="w-8 h-8 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center hover:bg-green-50 hover:text-green-600 transition">
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                
                <div class="text-center py-8 bg-white rounded-xl border border-dashed border-gray-300">
                    <div class="text-gray-300 text-3xl mb-2"><i class="fa-regular fa-heart"></i></div>
                    <p class="text-gray-500 text-sm">No saved items yet.</p>
                    <a href="../marketplace.php" class="text-green-600 text-sm font-bold mt-2 inline-block">Go Shopping</a>
                </div>

            <?php endif; ?>

        </div>
    </div>

    <nav class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around py-3 pb-safe z-50">
        <a href="../marketplace.php" class="text-gray-400 flex flex-col items-center gap-1 hover:text-gray-600">
            <i class="fa-solid fa-home"></i>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        <a href="../marketplace.php?category=all" class="text-gray-400 flex flex-col items-center gap-1 hover:text-gray-600">
            <i class="fa-solid fa-compass"></i>
            <span class="text-[10px] font-medium">Explore</span>
        </a>
        <a href="#" class="text-green-600 flex flex-col items-center gap-1">
            <i class="fa-solid fa-user"></i>
            <span class="text-[10px] font-medium">Profile</span>
        </a>
    </nav>

</body>
</html>