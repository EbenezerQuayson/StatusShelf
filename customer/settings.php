<?php
session_start();
require_once '../config/db.php';
require_once '../includes/base_url.php';

// 1. Security Check
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];
$message = "";

// 2. Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $full_name = $conn->real_escape_string($_POST['full_name']);
    
    // A. Handle Image Upload
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "../assets/uploads/";
        $file_name = "user_" . $customer_id . "_" . time() . ".jpg"; // Unique name
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            // Update DB with new image path
            $db_path = "assets/uploads/" . $file_name;
            $conn->query("UPDATE customers SET profile_image = '$db_path' WHERE id = '$customer_id'");
        }
    }

    // B. Handle Password Change (Only if typed)
    if (!empty($_POST['password'])) {
        $new_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $conn->query("UPDATE customers SET password = '$new_pass' WHERE id = '$customer_id'");
    }

    // C. Update Name
    $conn->query("UPDATE customers SET full_name = '$full_name' WHERE id = '$customer_id'");
    
    // Update Session Name immediately
    $_SESSION['customer_name'] = $full_name;
    $message = "Profile updated successfully!";
}

// 3. Fetch Current Data
$user = $conn->query("SELECT * FROM customers WHERE id = '$customer_id'")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings - StatusShelf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/images/favicon.png">
</head>
<body class="bg-gray-50 pb-20">

    <div class="bg-white p-4 shadow-sm flex items-center gap-3">
        <a href="profile.php" class="text-gray-500 hover:text-gray-800"><i class="fa-solid fa-arrow-left"></i></a>
        <h1 class="font-bold text-lg">Edit Profile</h1>
    </div>

    <div class="p-6 max-w-md mx-auto">
        
        <?php if ($message): ?>
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm text-center"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            
            <div class="flex flex-col items-center gap-3">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 border-4 border-white shadow-md relative group">
                    <?php if ($user['profile_image']): ?>
                        <img src="../<?php echo $user['profile_image']; ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-3xl font-bold bg-gray-100">
                            <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                        <i class="fa-solid fa-camera text-white"></i>
                    </div>
                </div>
                <input type="file" name="profile_image" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password <span class="text-gray-400 font-normal">(Optional)</span></label>
                <input type="password" name="password" placeholder="••••••••" class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-green-500 focus:border-green-500">
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition shadow-lg shadow-green-200">
                Save Changes
            </button>

        </form>
    </div>

</body>
</html>