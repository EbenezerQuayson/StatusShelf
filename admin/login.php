<?php
session_start();
require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM admins WHERE username = '$username'");

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            header("Location: dashboard.php");
            exit();
        }
    }
    $error = "Invalid credentials";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-xl w-96">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Admin Access</h2>
        <?php if (isset($error)) echo "<p class='text-red-500 text-sm mb-4'>$error</p>"; ?>
        <form method="POST" class="space-y-4">
            <input type="text" name="username" placeholder="Username" class="w-full border p-2 rounded" required>
            <input type="password" name="password" placeholder="Password" class="w-full border p-2 rounded" required>
            <button class="w-full bg-gray-800 text-white py-2 rounded hover:bg-black">Enter</button>
        </form>
    </div>
</body>
</html>