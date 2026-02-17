<?php
session_start();
require_once '../config/db.php';
require_once '../includes/base_url.php';

// 1. Security Check
if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];
$seller_name = $_SESSION['username'];
$seller = $conn->query("SELECT * FROM sellers WHERE id = '$seller_id'")->fetch_assoc();

// 2. Fetch Products (With optional Search)
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sql = "SELECT * FROM products WHERE seller_id = '$seller_id'";

if ($search) {
    $sql .= " AND (name LIKE '%$search%' OR category LIKE '%$search%')";
}

$sql .= " ORDER BY id DESC";
$products_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - <?php echo htmlspecialchars($seller['business_name']); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/images/favicon.png">

    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .bg-aurora-green { background-color: #1a5d47; }
        .active-nav { background-color: #e6f0ed; color: #1a5d47; }
        .table-hover tbody tr:hover { background-color: #f8f9fa; }
    </style>
</head>
<body>

    <div class="d-flex">
        
        <?php include 'includes/sidebar.php'; ?>

        <div class="flex-grow-1" style="min-width: 0;">
            
            <?php include 'includes/header.php'; ?>

            <div class="container-fluid p-4">
                
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">Inventory</h4>
                        <p class="text-muted small mb-0">Manage your store's catalog</p>
                    </div>
                    <a href="add_product.php" class="btn text-white fw-bold d-flex align-items-center gap-2" style="background-color: #1a5d47;">
                        <i class="fa-solid fa-plus"></i> Add New Item
                    </a>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-2">
                        <form action="" method="GET" class="d-flex gap-2">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0 ps-3"><i class="fa-solid fa-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-0 shadow-none" placeholder="Search products by name or category..." value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                            <?php if($search): ?>
                                <a href="products.php" class="btn btn-light text-muted">Clear</a>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-light fw-bold text-dark px-4">Search</button>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-secondary small fw-bold text-uppercase">Product</th>
                                    <th class="py-3 text-secondary small fw-bold text-uppercase">Price</th>
                                    <th class="py-3 text-secondary small fw-bold text-uppercase">Category</th>
                                    <th class="py-3 text-secondary small fw-bold text-uppercase text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($products_result->num_rows > 0): ?>
                                    <?php while($row = $products_result->fetch_assoc()): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="../<?php echo $row['image']; ?>" class="rounded-3 border object-fit-cover bg-light" style="width: 48px; height: 48px;">
                                                    <div>
                                                        <h6 class="fw-bold mb-0 text-dark"><?php echo htmlspecialchars($row['name']); ?></h6>
                                                        <small class="text-success d-flex align-items-center gap-1">
                                                            <i class="fa-solid fa-circle" style="font-size: 6px;"></i> Active
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-dark">GHS <?php echo number_format($row['price'], 2); ?></td>
                                            <td><span class="badge bg-light text-secondary border fw-normal"><?php echo $row['category']; ?></span></td>
                                            <td class="text-end pe-4">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-light btn-sm border text-secondary" title="Edit">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    <a href="delete_product.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this product?');" class="btn btn-light btn-sm border text-secondary hover-danger" title="Delete">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-box-open fs-1 mb-3 opacity-25"></i>
                                            <p class="mb-0">No products found.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>