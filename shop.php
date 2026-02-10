<?php
require_once 'config/db.php';

// 1. Get the username from the URL (e.g., shop.php?u=kicksbyjay)
if (!isset($_GET['u'])) {
    // If no user specified, go to the main marketplace
    header("Location: marketplace.php");
    exit();
}

$username = $conn->real_escape_string($_GET['u']);

// 2. Fetch Seller Details
$sql = "SELECT * FROM sellers WHERE username = '$username'";
$seller_result = $conn->query($sql);

if ($seller_result->num_rows == 0) {
    die("Store not found!");
}

$seller = $seller_result->fetch_assoc();
$seller_id = $seller['id'];

// 3. Fetch Seller's Products
$product_sql = "SELECT * FROM products WHERE seller_id = '$seller_id' ORDER BY id DESC";
$products = $conn->query($product_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($seller['business_name']); ?> | StatusShelf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen pb-10">
    <input type="hidden" id="current-seller-id" value="<?php echo $seller['id']; ?>">

    <div class="bg-gray-900 text-white pt-8 pb-16 px-4 relative">
        <div class="max-w-xl mx-auto text-center">
            
            <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 border-4 border-white overflow-hidden shadow-lg flex items-center justify-center text-gray-800 text-3xl">
                <i class="fa-solid fa-store"></i>
            </div>
            
            <h1 class="text-2xl font-bold mb-1"><?php echo htmlspecialchars($seller['business_name']); ?></h1>
            <p class="text-gray-400 text-sm mb-4">Welcome to my online store.</p>
            
            <a href="https://wa.me/<?php echo $seller['phone_number']; ?>" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-full text-sm font-bold transition shadow-lg shadow-green-900/20">
                <i class="fa-brands fa-whatsapp"></i> Chat with Seller
            </a>
        </div>
    </div>

    <main class="max-w-xl mx-auto px-4 -mt-8 relative z-10">
                
        
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex justify-around text-center border border-gray-100">
            <div>
                <span class="block font-bold text-xl text-gray-800"><?php echo $products->num_rows; ?></span>
                <span class="text-xs text-gray-500 uppercase tracking-wide">Products</span>
            </div>
            <div class="w-px bg-gray-200"></div>
            <div>
                <span class="block font-bold text-xl text-green-600">Online</span>
                <span class="text-xs text-gray-500 uppercase tracking-wide">Status</span>
            </div>
        </div>



        <h3 class="font-bold text-gray-800 mb-4 text-lg">Latest Arrivals</h3>
        <div class="mb-6 relative">
    <i class="fa-solid fa-search absolute left-3 top-3.5 text-gray-400"></i>
    <input type="text" id="store-search" placeholder="Search in <?php echo htmlspecialchars($seller['business_name']); ?>..." 
           class="w-full bg-white border border-gray-200 rounded-lg py-3 pl-10 pr-4 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 shadow-sm transition">
    
    <input type="hidden" id="current-seller-id" value="<?php echo $seller['id']; ?>">
</div>
        
        <?php if ($products->num_rows > 0): ?>
            <div class="grid grid-cols-2 gap-4" id="store-grid">
                
                <?php while($item = $products->fetch_assoc()): ?>
                    <?php
                        // --- THE WHATSAPP LOGIC ---
                        // We construct the message here using PHP
                        $msg = "Hello! I saw your " . $item['name'] . " for " . $item['price'] . " on StatusShelf. Is it still available?";
                        $encoded_msg = urlencode($msg);
                        $wa_link = "https://wa.me/" . $seller['phone_number'] . "?text=" . $encoded_msg;
                    ?>

                    <div class="bg-white rounded-xl shadow-sm overflow-hidden group hover:shadow-md transition">
                        <div class="h-40 bg-gray-200 relative overflow-hidden">
                            <img src="<?php echo $item['image']; ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        
                        <div class="p-3">
                            <h3 class="text-sm font-medium text-gray-900 truncate"><?php echo htmlspecialchars($item['name']); ?></h3>
                            
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-bold text-gray-900">₵ <?php echo number_format($item['price'], 2); ?></span>
                                
                                <a href="<?php echo $wa_link; ?>" target="_blank" class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-500 hover:text-white transition shadow-sm">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>

            </div>
        <?php else: ?>
            
            <div class="text-center py-10">
                <div class="text-gray-300 text-5xl mb-3"><i class="fa-solid fa-ghost"></i></div>
                <p class="text-gray-500">This seller hasn't posted any products yet.</p>
            </div>

        <?php endif; ?>

    </main>

    <div class="text-center py-8 opacity-50 text-xs">
        <a href="index.php" class="hover:underline">Powered by <strong>StatusShelf</strong></a>
    </div>

</body>
<script>
    document.getElementById('store-search').addEventListener('keyup', function() {
        let query = this.value;
        let sellerId = document.getElementById('current-seller-id').value; // Get this specific seller's ID

        let formData = new FormData();
        formData.append('query', query);
        formData.append('seller_id', sellerId); // Send it to the backend

        // Note: We are looking into the 'includes' folder now
        fetch('includes/search_logic.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // We need to target the grid. 
            // Make sure your product grid container has this ID: <div class="grid..." id="store-grid">
            let grid = document.getElementById('store-grid');
            if(grid) {
                grid.innerHTML = data;
            } else {
                console.error("Error: Could not find element with id 'store-grid'");
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
</html>