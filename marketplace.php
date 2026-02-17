<?php
// FIX 1: Start the session so login checks work
session_start();
require_once 'config/db.php';
require_once 'includes/base_url.php';
$category_filter = isset($_GET['category']) ? $_GET['category'] : 'All';
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// 1. Initialize Base Query
$sql = "SELECT products.*, sellers.business_name, sellers.username, sellers.phone_number 
        FROM products 
        JOIN sellers ON products.seller_id = sellers.id 
        WHERE 1=1"; 

// 2. Check for Category Filter
if ($category_filter != 'All') {
    $cat = $conn->real_escape_string($category_filter);
    $sql .= " AND category = '$cat'";
}

// 3. Check for Search Keyword
if (!empty($search_query)) {
    $search = $conn->real_escape_string($search_query);
    $sql .= " AND (products.name LIKE '%$search%' OR products.description LIKE '%$search%')";
}

// 4. Finish the Query
$sql .= " ORDER BY products.id DESC";

$result = $conn->query($sql);
$page_title = "Marketplace - StatusShelf";
?>
<?php include 'includes/header.php'; ?>
<body class="bg-gray-100 pb-20">

    <header class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="index.php" class="flex items-center gap-2 text-green-600 font-bold text-lg">
                <i class="fa-solid fa-layer-group"></i> StatusShelf
            </a>
            <a href="seller/login.php" class="text-sm font-medium bg-gray-100 px-3 py-1 rounded-full text-gray-700">Sell Item</a>
        </div>
        
        <div class="px-4 pb-3 max-w-xl mx-auto">
            <form action="marketplace.php" method="GET" class="relative">
                <i class="fa-solid fa-search absolute left-3 top-3 text-gray-400"></i>
                <input type="text" name="search" id="search-input"
                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                       placeholder="Search products..." 
                       class="w-full bg-gray-100 rounded-lg py-2 pl-10 pr-4 text-sm focus:outline-none focus:bg-white transition">
            </form>
        </div>
    </header>

    <main class="max-w-xl mx-auto px-4 py-4">
        
        <div class="flex gap-2 overflow-x-auto pb-4 mb-2 no-scrollbar">
            <?php 
                $cats = ['All', 'Fashion', 'Electronics', 'Beauty', 'Food', 'Home'];
                foreach($cats as $c): 
                    $activeClass = ($category_filter == $c) ? 'bg-black text-white' : 'bg-white border border-gray-200 text-gray-600';
            ?>
                <a href="marketplace.php?category=<?php echo $c; ?>" class="<?php echo $activeClass; ?> px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap transition">
                    <?php echo $c; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="grid grid-cols-2 gap-4" id="product-grid">
            
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden flex flex-col hover:shadow-md transition">
                        <div class="h-40 bg-gray-200 relative">
                            <img src="<?php echo $row['image']; ?>" class="w-full h-full object-cover">
                        </div>
                        
                        <div class="p-3 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-sm text-gray-700 font-medium truncate"><?php echo htmlspecialchars($row['name']); ?></h3>
                                <p class="text-lg font-bold text-gray-900">₵ <?php echo number_format($row['price'], 2); ?></p>
                            </div>

                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <a href="shop.php?u=<?php echo $row['username']; ?>" class="flex items-center gap-2 mb-2 hover:bg-gray-50 p-1 rounded transition">
                                    <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center text-xs text-blue-600 font-bold">
                                        <?php echo strtoupper(substr($row['business_name'], 0, 1)); ?>
                                    </div>
                                    <span class="text-xs text-gray-500 truncate">Sold by <strong><?php echo htmlspecialchars($row['business_name']); ?></strong></span>
                                </a>

                                <?php
                                    $msg = "Hi! I want to buy " . $row['name'] . " (₵" . $row['price'] . ")";
                                    $wa_link = "https://wa.me/" . $row['phone_number'] . "?text=" . urlencode($msg);
                                ?>
                                
                                <a href="<?php echo $wa_link; ?>" onclick="trackClick(<?php echo $row['id']; ?>)" target="_blank" class="w-full bg-green-50 text-green-700 border border-green-200 py-1.5 rounded-lg text-xs font-bold flex items-center justify-center gap-1 hover:bg-green-100 transition">
                                    <i class="fa-brands fa-whatsapp"></i> Buy Now
                                </a>

                                <div class="mt-2 flex justify-end">
                                    <button onclick="toggleSave(this, <?php echo $row['id']; ?>)" class="w-8 h-8 rounded-full border border-gray-200 text-gray-400 flex items-center justify-center hover:text-red-500 hover:bg-red-50 transition">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-2 text-center py-10 text-gray-400">
                    <p>No products found in this category.</p>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <nav class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around py-3 pb-safe z-50">
        <a href="marketplace.php" class="text-green-600 flex flex-col items-center gap-1">
            <i class="fa-solid fa-home"></i>
            <span class="text-[10px] font-medium">Home</span>
        </a>

        <a href="explore.php" class="text-gray-400 flex flex-col items-center gap-1 hover:text-gray-600">
            <i class="fa-solid fa-compass"></i>
            <span class="text-[10px] font-medium">Explore</span>
        </a>

        <?php if (isset($_SESSION['customer_id'])): ?>
            <a href="customer/profile.php" class="text-gray-400 flex flex-col items-center gap-1 hover:text-gray-600">
                <i class="fa-solid fa-user"></i>
                <span class="text-[10px] font-medium">Profile</span>
            </a>
        <?php else: ?>
            <a href="customer/login.php" class="text-gray-400 flex flex-col items-center gap-1 hover:text-green-600">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span class="text-[10px] font-medium">Login</span>
            </a>
        <?php endif; ?>
    </nav>

<script>
    // Search Logic
    document.getElementById('search-input').addEventListener('keyup', function() {
        let query = this.value;
        let formData = new FormData();
        formData.append('query', query);

        fetch('includes/search_logic.php', { method: 'POST', body: formData })
        .then(response => response.text())
        .then(data => { document.getElementById('product-grid').innerHTML = data; });
    });

    // Save/Heart Logic
    function toggleSave(btn, productId) {
        let icon = btn.querySelector('i');
        let formData = new FormData();
        formData.append('product_id', productId);

        fetch('includes/ajax_save.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "saved") {
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid', 'text-red-500');
                btn.classList.add('bg-red-50', 'border-red-200');
            } else if (data.trim() === "removed") {
                icon.classList.remove('fa-solid', 'text-red-500');
                icon.classList.add('fa-regular');
                btn.classList.remove('bg-red-50', 'border-red-200');
            } else if (data.trim() === "login_required") {
                alert("Please login to save items!");
                window.location.href = "customer/login.php";
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Track Clicks Logic (Added this so it doesn't crash if missing)
    function trackClick(productId) {
        if(typeof navigator.sendBeacon === "function") {
            let formData = new FormData();
            formData.append('product_id', productId);
            navigator.sendBeacon('seller/includes/track_click.php', formData);
        }
    }
</script>

</body>
</html>