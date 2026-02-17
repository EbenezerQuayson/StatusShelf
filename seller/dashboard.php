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

// 2. Fetch Data
$seller = $conn->query("SELECT * FROM sellers WHERE id = '$seller_id'")->fetch_assoc();
$products_result = $conn->query("SELECT * FROM products WHERE seller_id = '$seller_id' ORDER BY id DESC");
$total_products = $products_result->num_rows;
$clicks_query = $conn->query("SELECT SUM(clicks) as total_clicks FROM products WHERE seller_id = '$seller_id'");
$total_clicks = $clicks_query->fetch_assoc()['total_clicks'] ?? 0;

$total_views = $seller['store_views'];

// Construct Store Link
$base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'], 2);
$store_link = $base_url . "/shop.php?u=" . $seller['username'];
$short_link = str_replace(["http://", "https://"], "", $store_link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo htmlspecialchars($seller['business_name']); ?></title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/images/favicon.png">
        

    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        
        /* Custom "Aurora" Brand Color */
        .bg-aurora-green { background-color: #1a5d47; }
        .text-aurora-green { color: #1a5d47; }
        
        /* Active Nav State */
        .active-nav { background-color: #e6f0ed; color: #1a5d47; }
        
        /* Card Hover Effect */
        .hover-shadow:hover { transform: translateY(-2px); transition: all 0.2s; box-shadow: 0 .5rem 1rem rgba(0,0,0,.05)!important; }
        
        /* Mobile Link Text Truncate */
        .link-text { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    </style>
</head>
<body>

    <div class="d-flex">
        
        <?php include 'includes/sidebar.php'; ?>

        <div class="flex-grow-1" style="min-width: 0;">
            
            <?php include 'includes/header.php'; ?>

            <div class="container-fluid p-4">
                
                <div class="card bg-aurora-green text-white border-0 shadow-sm mb-4 overflow-hidden rounded-4">
                    <div class="card-body p-4 position-relative">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.1; background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                        
                        <div class="row align-items-center position-relative z-1 g-3">
                            <div class="col-md-8">
                                <span class="badge bg-white bg-opacity-25 text-white mb-2">STATUSSHELF BUSINESS</span>
                                <h2 class="fw-bold mb-1"><?php echo htmlspecialchars($seller['business_name']); ?></h2>
                                
                                <div class="d-inline-flex align-items-center bg-black bg-opacity-25 rounded px-3 py-1 mt-2">
                                    <a href="<?php echo $store_link; ?>" target="_blank" class="text-white text-decoration-none small link-text" style="max-width: 250px;">
                                        <?php echo $short_link; ?> <i class="fa-solid fa-arrow-up-right-from-square ms-1 small"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-md-4 text-md-end">
                                <div class="d-flex flex-column gap-2 align-items-md-end">
                                    <span class="badge bg-success bg-opacity-75 rounded-pill px-3 py-2">
                                        <i class="fa-solid fa-circle text-light me-1 small"></i> Store Live
                                    </span>
                                    <button onclick="navigator.clipboard.writeText('<?php echo $store_link; ?>'); alert('Copied!');" class="btn btn-light text-aurora-green fw-bold btn-sm shadow-sm  w-md-auto">
                                        <i class="fa-regular fa-copy me-1"></i> Copy Link
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100 rounded-4 hover-shadow">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.25rem;">
                                        <i class="fa-solid fa-tags"></i>
                                    </div>
                                </div>
                                <p class="text-muted small fw-bold mb-0">ACTIVE PRODUCTS</p>
                                <h3 class="fw-bold text-dark mb-0"><?php echo $total_products; ?></h3>
                            </div>
                        </div>
                    </div>

                <div class="col-12 col-sm-6 col-lg-4">
    <div class="card border-0 shadow-sm h-100 rounded-4 hover-shadow">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.25rem;">
                    <i class="fa-solid fa-eye"></i>
                </div>
            </div>
            <p class="text-muted small fw-bold mb-0">TOTAL VIEWS</p>
            <h3 class="fw-bold text-dark mb-0"><?php echo number_format($total_views); ?></h3>
        </div>
    </div>
</div>

<div class="col-12 col-lg-4">
    <div class="card border-0 shadow-sm h-100 rounded-4 hover-shadow">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.25rem;">
                    <i class="fa-solid fa-arrow-pointer"></i>
                </div>
            </div>
            <p class="text-muted small fw-bold mb-0">INTERESTED BUYERS</p>
            <h3 class="fw-bold text-dark mb-0"><?php echo number_format($total_clicks); ?></h3>
        </div>
    </div>
</div>

                <div class="card border-0 shadow-sm rounded-4" id="products">
                    <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Your Products</h5>
                        <a href="add_product.php" class="btn btn-sm text-white fw-bold d-flex align-items-center gap-2 px-3 rounded-3" style="background-color: #1a5d47;">
                            <i class="fa-solid fa-plus"></i> <span class="d-none d-sm-inline">Add Product</span>
                        </a>
                    </div>
                    
                    <div class="card-body p-0">
                        <?php if ($products_result->num_rows > 0): ?>
                            <div class="list-group list-group-flush">
                                <?php while($row = $products_result->fetch_assoc()): ?>
                                    <div class="list-group-item p-3 border-bottom-0 border-top">
                                        <div class="row align-items-center g-3">
                                            
                                            <div class="col-12 col-md-6 d-flex align-items-center gap-3">
                                                <img src="../<?php echo $row['image']; ?>" class="rounded-3 border object-fit-cover bg-light" style="width: 60px; height: 60px;">
                                                <div class="min-width-0">
                                                    <h6 class="fw-bold mb-1 text-truncate text-dark"><?php echo htmlspecialchars($row['name']); ?></h6>
                                                    <span class="badge bg-light text-secondary border fw-normal"><?php echo $row['category']; ?></span>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="d-flex justify-content-between justify-content-md-end align-items-center gap-4">
                                                    <span class="fw-bold text-dark">GHS <?php echo number_format($row['price'], 2); ?></span>
                                                    
                                                    <div class="d-flex gap-2">
                                                        <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-light btn-sm border text-secondary hover-primary">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                        <a href="delete_product.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete?');" class="btn btn-light btn-sm border text-secondary hover-danger">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5 text-muted">
                                <i class="fa-solid fa-box-open fs-1 mb-3 opacity-25"></i>
                                <p>No products yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>