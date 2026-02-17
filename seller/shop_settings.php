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
$msg = "";
$msg_type = "";

// 2. Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $color = $conn->real_escape_string($_POST['theme_color']);
    $bio = $conn->real_escape_string($_POST['bio']);
    $insta = $conn->real_escape_string($_POST['instagram']);
    $tiktok = $conn->real_escape_string($_POST['tiktok']);
    $loc = $conn->real_escape_string($_POST['location']);

    // Handle Banner Upload
    if (!empty($_FILES['shop_banner']['name'])) {
        $target_dir = "../assets/uploads/";
        $file_name = "banner_" . $seller_id . "_" . time() . ".jpg";
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($_FILES["shop_banner"]["tmp_name"], $target_file)) {
            $db_banner = "assets/uploads/" . $file_name;
            $conn->query("UPDATE sellers SET shop_banner = '$db_banner' WHERE id = '$seller_id'");
        }
    }

    if (!empty($_FILES['shop_logo']['name'])) {
        $target_dir = "../assets/uploads/";
        $file_name = "logo_" . $seller_id . "_" . time() . ".jpg";
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["shop_logo"]["tmp_name"], $target_file)) {
            $db_logo = "assets/uploads/" . $file_name;
            $conn->query("UPDATE sellers SET shop_logo = '$db_logo' WHERE id = '$seller_id'");
        }
    }

    $sql = "UPDATE sellers SET theme_color='$color', bio='$bio', instagram='$insta', tiktok='$tiktok', location='$loc' WHERE id='$seller_id'";
    
    if ($conn->query($sql) === TRUE) {
        $msg = "Store appearance updated successfully!";
        $msg_type = "success";
    } else {
        $msg = "Error updating store: " . $conn->error;
        $msg_type = "danger";
    }
}

// 3. Fetch Data
$seller = $conn->query("SELECT * FROM sellers WHERE id = '$seller_id'")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Appearance - <?php echo htmlspecialchars($seller['business_name']); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/images/favicon.png">

    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .bg-aurora-green { background-color: #1a5d47; }
        .active-nav { background-color: #e6f0ed; color: #1a5d47; }
        .form-control:focus { border-color: #1a5d47; box-shadow: 0 0 0 0.25rem rgba(26, 93, 71, 0.25); }
    </style>
</head>
<body>

    <div class="d-flex">
        
        <?php include 'includes/sidebar.php'; ?>

        <div class="flex-grow-1" style="min-width: 0;">
            
            <?php include 'includes/header.php'; ?>

            <div class="container-fluid p-4">
                
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        
                        <div class="mb-4">
                            <h4 class="fw-bold text-dark mb-1">Store Appearance</h4>
                            <p class="text-muted small">Customize how your shop looks to customers.</p>
                        </div>

                        <?php if ($msg): ?>
                            <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show shadow-sm border-0" role="alert">
                                <?php echo $msg; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4">
                                <form method="POST" enctype="multipart/form-data">
                                    

                                <div class="mb-4">
    <label class="form-label fw-bold text-secondary small text-uppercase">Store Logo</label>
    <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle border bg-light overflow-hidden d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
            <?php if (!empty($seller['shop_logo'])): ?>
                <img src="../<?php echo $seller['shop_logo']; ?>" class="w-100 h-100 object-fit-cover">
            <?php else: ?>
                <i class="fa-solid fa-store fs-3 text-muted"></i>
            <?php endif; ?>
        </div>
        <div>
            <input type="file" name="shop_logo" class="form-control form-control-sm mb-1">
            <small class="text-muted d-block">Square image recommended (JPG/PNG)</small>
        </div>
    </div>
</div>
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-secondary small text-uppercase">Shop Banner</label>
                                        <div class="position-relative bg-light rounded-3 overflow-hidden border d-flex align-items-center justify-content-center" style="height: 160px;">
                                            <?php if ($seller['shop_banner']): ?>
                                                <img src="../<?php echo $seller['shop_banner']; ?>" class="w-100 h-100 object-fit-cover">
                                            <?php else: ?>
                                                <div class="text-center text-muted">
                                                    <i class="fa-solid fa-image fs-3 mb-2"></i>
                                                    <p class="small mb-0">No banner uploaded</p>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="position-absolute bottom-0 end-0 p-3">
                                                <label class="btn btn-light btn-sm shadow-sm fw-bold">
                                                    <i class="fa-solid fa-camera me-1"></i> Change
                                                    <input type="file" name="shop_banner" class="d-none" onchange="this.form.submit()">
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-secondary small text-uppercase">About your shop</label>
                                        <textarea name="bio" rows="3" class="form-control bg-light border-0" placeholder="Tell customers what you sell..."><?php echo htmlspecialchars($seller['bio']); ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-secondary small text-uppercase">Location</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-map-pin text-muted"></i></span>
                                            <input type="text" name="location" class="form-control bg-light border-0" value="<?php echo htmlspecialchars($seller['location']); ?>" placeholder="City, Region">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-secondary small text-uppercase">Brand Color</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <input type="color" name="theme_color" class="form-control form-control-color border-0 shadow-sm" value="<?php echo $seller['theme_color'] ?? '#2563eb'; ?>" title="Choose your color">
                                            <small class="text-muted">Pick a color that matches your brand.</small>
                                        </div>
                                    </div>

                                    <hr class="my-4 text-muted opacity-25">
                                    
                                    <h6 class="fw-bold mb-3">Social Links</h6>

                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0 text-danger"><i class="fa-brands fa-instagram"></i></span>
                                            <input type="text" name="instagram" class="form-control bg-light border-0" value="<?php echo htmlspecialchars($seller['instagram']); ?>" placeholder="Instagram Username">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0 text-dark"><i class="fa-brands fa-tiktok"></i></span>
                                            <input type="text" name="tiktok" class="form-control bg-light border-0" value="<?php echo htmlspecialchars($seller['tiktok']); ?>" placeholder="TikTok Username">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn text-white fw-bold w-100 py-2 rounded-3" style="background-color: #1a5d47;">
                                        Save Changes
                                    </button>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>