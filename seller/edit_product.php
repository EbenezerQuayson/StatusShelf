<?php
session_start();
require_once '../config/db.php';

// 1. Security Check
if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}

// 2. Fetch the Product Data
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $seller_id = $_SESSION['seller_id'];

    $sql = "SELECT * FROM products WHERE id = '$product_id' AND seller_id = '$seller_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        die("Product not found or access denied.");
    }

    $product = $result->fetch_assoc();
} else {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - StatusShelf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg overflow-hidden">
        
        <div class="bg-blue-600 p-4 text-white flex justify-between items-center">
            <h2 class="font-bold text-lg"><i class="fa-solid fa-pen"></i> Edit Product</h2>
            <a href="dashboard.php" class="text-sm opacity-80 hover:opacity-100">Cancel</a>
        </div>

        <form action="update_logic.php" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            
            <div class="flex justify-center mb-4">
                <img src="../<?php echo $product['image']; ?>" class="h-24 w-24 object-cover rounded-lg border border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>" class="w-full border-gray-300 rounded-lg p-2 border" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" class="w-full border-gray-300 rounded-lg p-2 border bg-white">
                    <?php 
                        $cats = ['Fashion', 'Electronics', 'Beauty', 'Home', 'Food', 'Services', 'Other'];
                        foreach($cats as $c) {
                            $selected = ($product['category'] == $c) ? 'selected' : '';
                            echo "<option value='$c' $selected>$c</option>";
                        }
                    ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price (GHS)</label>
                <input type="number" name="price" value="<?php echo $product['price']; ?>" class="w-full border-gray-300 rounded-lg p-2 border" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Change Image (Optional)</label>
                <input type="file" name="product_image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-1">Leave blank to keep current image.</p>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition">
                Save Changes
            </button>

        </form>
    </div>

</body>
</html>