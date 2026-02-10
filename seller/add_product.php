<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product - StatusShelf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg overflow-hidden">
        
        <div class="bg-blue-600 p-4 text-white flex justify-between items-center">
            <h2 class="font-bold text-lg"><i class="fa-solid fa-plus-circle"></i> Add New Product</h2>
            <a href="dashboard.php" class="text-sm opacity-80 hover:opacity-100">Cancel</a>
        </div>

        <form action="upload_logic.php" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" name="product_name" placeholder="e.g. Vintage Denim Jacket" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" required>
            </div>

            <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
    <div class="relative">
        <select name="category" required class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md border appearance-none bg-white">
            <option value="Fashion">Fashion & Clothing</option>
            <option value="Electronics">Electronics & Gadgets</option>
            <option value="Beauty">Beauty & Personal Care</option>
            <option value="Home">Home & Living</option>
            <option value="Food">Food & Groceries</option>
            <option value="Services">Services</option>
            <option value="Other">Other</option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <i class="fa-solid fa-chevron-down text-xs"></i>
        </div>
    </div>
</div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price (GHS)</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">₵</span>
                    </div>
                    <input type="number" name="price" placeholder="0.00" class="w-full pl-7 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
                
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition cursor-pointer relative overflow-hidden" id="drop-zone">
                    
                    <div class="space-y-1 text-center" id="upload-prompt">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400"></i>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                <span>Click to Upload</span>
                                <input id="file-upload" name="product_image" type="file" class="sr-only" accept="image/*" required onchange="previewImage(event)">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG up to 5MB</p>
                    </div>

                    <div id="preview-container" class="hidden absolute inset-0 w-full h-full bg-white flex items-center justify-center">
                        <img id="preview-image" src="#" alt="Preview" class="max-h-full max-w-full object-contain">
                        <button type="button" onclick="resetUpload()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 shadow-sm" title="Remove Image">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>

                </div>
            </div>

            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                Post to Store
            </button>

        </form>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('preview-image');
                output.src = reader.result;
                
                // Hide the prompt, Show the preview
                document.getElementById('upload-prompt').classList.add('hidden');
                document.getElementById('preview-container').classList.remove('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function resetUpload() {
            // Clear the input
            document.getElementById('file-upload').value = "";
            
            // Show the prompt, Hide the preview
            document.getElementById('upload-prompt').classList.remove('hidden');
            document.getElementById('preview-container').classList.add('hidden');
        }
    </script>

</body>
</html>