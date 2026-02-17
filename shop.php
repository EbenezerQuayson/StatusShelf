<?php
session_start();
require_once 'config/db.php';
require_once 'includes/base_url.php';

// 1. Get the username from the URL
if (!isset($_GET['u'])) {
    header("Location: marketplace.php");
    exit();
}

$username = $conn->real_escape_string($_GET['u']);

// 2. Fetch Seller Details
$sql = "SELECT * FROM sellers WHERE username = '$username'";
$seller_result = $conn->query($sql);




if ($seller_result->num_rows == 0) {
    die("Store not found! <a href='index.php'>Go Home</a>");
}

$seller = $seller_result->fetch_assoc();
if (!isset($_SESSION['seller_id']) || $_SESSION['seller_id'] != $seller['id']) {
    $conn->query("UPDATE sellers SET store_views = store_views + 1 WHERE id = '" . $seller['id'] . "'");
}
$seller_id = $seller['id'];
$product_sql = "SELECT * FROM products WHERE seller_id = '$seller_id' ORDER BY id DESC";
$products = $conn->query($product_sql);
$has_custom_shop = !empty($seller['shop_banner']); 
$theme_color = $has_custom_shop && !empty($seller['theme_color']) ? $seller['theme_color'] : '#2563eb';

$page_title = htmlspecialchars($seller['business_name']) . " | StatusShelf";
?>

<?php include 'includes/header.php'; ?>

<body class="bg-gray-50 min-h-screen pb-10">
    <input type="hidden" id="current-seller-id" value="<?php echo $seller['id']; ?>">

    <?php if ($has_custom_shop): ?>

    <div class="relative pt-12 pb-24 px-4 text-white text-center bg-gray-900 bg-no-repeat bg-cover bg-center"
         style="background-image: url('<?php echo $seller['shop_banner']; ?>');">
        
        <div class="absolute inset-0 bg-black/60 z-0"></div>

        <div class="relative z-10 max-w-xl mx-auto">
            <a href="marketplace.php" class="absolute top-4 left-4 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-full text-sm hover:bg-white/40 transition">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            
         <div class="w-24 h-24 bg-white rounded-full mx-auto mb-4 border-4 border-white overflow-hidden shadow-xl flex items-center justify-center text-3xl">
    <?php if (!empty($seller['shop_logo'])): ?>
        <img src="<?php echo $seller['shop_logo']; ?>" class="w-full h-full object-cover">
    <?php else: ?>
        <i class="fa-solid fa-store text-brand"></i>
    <?php endif; ?>
</div>
            
            <h1 class="text-3xl font-bold mb-2 shadow-sm"><?php echo htmlspecialchars($seller['business_name']); ?></h1>
            
            <?php if (!empty($seller['bio'])): ?>
                <p class="text-gray-200 text-sm mb-4 max-w-sm mx-auto line-clamp-2"><?php echo htmlspecialchars($seller['bio']); ?></p>
            <?php else: ?>
                <p class="text-gray-300 text-sm mb-4">Welcome to my official store.</p>
            <?php endif; ?>
            
            <a href="https://wa.me/<?php echo $seller['phone_number']; ?>" class="inline-flex items-center gap-2 bg-brand text-white px-6 py-2.5 rounded-full text-sm font-bold transition shadow-lg hover:opacity-90">
                <i class="fa-brands fa-whatsapp text-lg"></i> Chat with Seller
            </a>

            <div class="mt-4 flex justify-center gap-4">
                <?php if(!empty($seller['instagram'])): ?>
                    <a href="https://instagram.com/<?php echo $seller['instagram']; ?>" class="text-white/80 hover:text-white hover:scale-110 transition"><i class="fa-brands fa-instagram text-xl"></i></a>
                <?php endif; ?>
                <?php if(!empty($seller['tiktok'])): ?>
                    <a href="https://tiktok.com/@<?php echo $seller['tiktok']; ?>" class="text-white/80 hover:text-white hover:scale-110 transition"><i class="fa-brands fa-tiktok text-xl"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <main class="max-w-xl mx-auto px-4 -mt-10 relative z-10">
                
        <div class="bg-white rounded-xl shadow-lg p-4 mb-6 flex justify-around text-center border border-gray-100">
            <div>
                <span class="block font-bold text-xl text-gray-800"><?php echo $products->num_rows; ?></span>
                <span class="text-xs text-gray-500 uppercase tracking-wide">Products</span>
            </div>
            <div class="w-px bg-gray-200"></div>
            <div>
                <span class="block font-bold text-xl text-brand">Online</span>
                <span class="text-xs text-gray-500 uppercase tracking-wide">Status</span>
            </div>
        </div>

        <h3 class="font-bold text-gray-800 mb-4 text-lg">Latest Arrivals</h3>
        
        <div class="mb-6 relative">
            <i class="fa-solid fa-search absolute left-3 top-3.5 text-gray-400"></i>
            <input type="text" id="store-search" placeholder="Search in <?php echo htmlspecialchars($seller['business_name']); ?>..." 
                   class="w-full bg-white border border-gray-200 rounded-lg py-3 pl-10 pr-4 focus:outline-none focus:border-brand focus:ring-1 ring-brand shadow-sm transition">
        </div>
        
        <?php if ($products->num_rows > 0): ?>
            <div class="grid grid-cols-2 gap-4" id="store-grid">
                <?php while($item = $products->fetch_assoc()): ?>
                    <?php
                        $msg = "Hello! I saw your " . $item['name'] . " for " . $item['price'] . " on StatusShelf. Is it still available?";
                        $wa_link = "https://wa.me/" . $seller['phone_number'] . "?text=" . urlencode($msg);
                    ?>
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden group hover:shadow-md transition border border-gray-100">
                        <div class="h-40 bg-gray-200 relative overflow-hidden">
                            <img src="<?php echo $item['image']; ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="p-3">
                            <h3 class="text-sm font-medium text-gray-900 truncate"><?php echo htmlspecialchars($item['name']); ?></h3>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-bold text-gray-900">₵ <?php echo number_format($item['price'], 2); ?></span>
                                <a href="<?php echo $wa_link; ?>" target="_blank"  class="w-8 h-8 rounded-full bg-gray-50 text-brand border border-gray-100 flex items-center justify-center hover:bg-brand hover:text-white transition shadow-sm">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-10 text-gray-400">
                <i class="fa-solid fa-box-open text-4xl mb-3 text-gray-300"></i>
                <p>No products yet.</p>
            </div>
        <?php endif; ?>

    </main>

    <?php else: ?>

    <div class="bg-gray-900 text-white pt-8 pb-16 px-4 relative">
        <div class="max-w-xl mx-auto text-center">
             <a href="marketplace.php" class="absolute top-4 left-4 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-full text-sm hover:bg-white/40 transition">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            
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
        </div>

        <?php if ($products->num_rows > 0): ?>
            <div class="grid grid-cols-2 gap-4" id="store-grid">
                <?php while($item = $products->fetch_assoc()): ?>
                    <?php
                        $msg = "Hello! I saw your " . $item['name'] . " for " . $item['price'] . " on StatusShelf. Is it still available?";
                        $wa_link = "https://wa.me/" . $seller['phone_number'] . "?text=" . urlencode($msg);
                    ?>
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden group hover:shadow-md transition">
                        <div class="h-40 bg-gray-200 relative overflow-hidden">
                            <img src="<?php echo $item['image']; ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="p-3">
                            <h3 class="text-sm font-medium text-gray-900 truncate"><?php echo htmlspecialchars($item['name']); ?></h3>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-bold text-gray-900">₵ <?php echo number_format($item['price'], 2); ?></span>
                                <a href="<?php echo $wa_link; ?>" target="_blank" onclick="trackClick(<?php echo $item['id']; ?>)" class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-500 hover:text-white transition shadow-sm">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-10">
                <i class="fa-solid fa-ghost text-4xl mb-3 text-gray-300"></i>
                <p class="text-gray-500">No products yet.</p>
            </div>
        <?php endif; ?>

    </main>

    <?php endif; ?>

    <div class="text-center py-8 opacity-50 text-xs">
        <a href="index.php" class="hover:underline">Powered by <strong>StatusShelf</strong></a>
    </div>

    <script>
        document.getElementById('store-search').addEventListener('keyup', function() {
            let query = this.value;
            let sellerId = document.getElementById('current-seller-id').value;

            let formData = new FormData();
            formData.append('query', query);
            formData.append('seller_id', sellerId);

            fetch('includes/search_logic.php', { method: 'POST', body: formData })
            .then(response => response.text())
            .then(data => {
                let grid = document.getElementById('store-grid');
                if(grid) grid.innerHTML = data;
            });
        });

        function trackClick(productId) {
        let formData = new FormData();
        formData.append('product_id', productId);
        
        let url = 'seller/includes/track_click.php';

        if (navigator.sendBeacon) {
            navigator.sendBeacon(url, formData);
        } else {
            fetch(url, { method: 'POST', body: formData });
        }
    }
    </script>
</body>
</html>