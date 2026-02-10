<?php
require_once '../config/db.php';

// 1. Get the Search Term
$query = isset($_POST['query']) ? $conn->real_escape_string($_POST['query']) : '';

// 2. Get the Seller ID (Optional)
// If this is set, we restrict the search to just this person.
$seller_id = isset($_POST['seller_id']) ? intval($_POST['seller_id']) : 0;

// 3. Build the SQL Query
$sql = "SELECT products.*, sellers.business_name, sellers.username, sellers.phone_number 
        FROM products 
        JOIN sellers ON products.seller_id = sellers.id 
        WHERE (products.name LIKE '%$query%' OR products.description LIKE '%$query%')";

// --- THE SMART PART ---
if ($seller_id > 0) {
    // If we are in a specific shop, ONLY show that shop's items
    $sql .= " AND products.seller_id = '$seller_id'";
}

$sql .= " ORDER BY products.id DESC LIMIT 10";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // ... (Output HTML Card - Same as before) ...
        echo '
        <div class="bg-white rounded-xl shadow-sm overflow-hidden flex flex-col hover:shadow-md transition">
            <div class="h-40 bg-gray-200 relative">
                <img src="'.$row['image'].'" class="w-full h-full object-cover">
            </div>
            <div class="p-3 flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="text-sm text-gray-700 font-medium truncate">'.htmlspecialchars($row['name']).'</h3>
                    <p class="text-lg font-bold text-gray-900">₵ '.number_format($row['price'], 2).'</p>
                </div>
                '. ($seller_id == 0 ? '<div class="text-xs text-gray-400 mt-1">Sold by '.htmlspecialchars($row['business_name']).'</div>' : '') .'
                
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <a href="https://wa.me/'.$row['phone_number'].'?text=Hi" target="_blank" class="w-full bg-green-50 text-green-700 border border-green-200 py-1.5 rounded-lg text-xs font-bold flex items-center justify-center gap-1 hover:bg-green-100 transition">
                        <i class="fa-brands fa-whatsapp"></i> Buy Now
                    </a>
                </div>
            </div>
        </div>';
    }
} else {
    echo '<div class="col-span-2 text-center text-gray-400 py-10">No products found.</div>';
}
?>