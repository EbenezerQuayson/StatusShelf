<div class="offcanvas-md offcanvas-start bg-white border-end vh-100 sticky-top overflow-hidden" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel" style="width: 250px;">
    
    <div class="d-flex flex-column h-100">
        
        <div class="p-4 border-bottom d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex justify-content-center align-items-center text-white fw-bold" style="width: 40px; height: 40px; background-color: #1a5d47;">
                    <?php echo strtoupper(substr($seller['business_name'], 0, 1)); ?>
                </div>
                <div class="overflow-hidden">
                    <h5 class="fw-bold text-dark text-truncate mb-0" style="max-width: 140px; font-size: 1rem;">
                        <?php echo htmlspecialchars($seller['business_name']); ?>
                    </h5>
                    <small class="text-muted">Store Admin</small>
                </div>
            </div>

            <button type="button" class="btn-close d-md-none" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body p-0 d-flex flex-column overflow-hidden">
            <nav class="nav flex-column p-3 gap-2">
                <a class="nav-link rounded px-3 py-2 d-flex align-items-center gap-3 fw-medium <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active-nav' : 'text-secondary'; ?>" href="dashboard.php">
                    <i class="fa-solid fa-home" style="width: 20px;"></i> Dashboard
                </a>
                
                <a class="nav-link text-secondary rounded px-3 py-2 d-flex align-items-center gap-3 fw-medium <?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active-nav' : 'text-secondary'; ?>" href="products.php">
                    <i class="fa-solid fa-box-archive" style="width: 20px;"></i> Products
                </a>

                <a class="nav-link rounded px-3 py-2 d-flex align-items-center gap-3 fw-medium <?php echo basename($_SERVER['PHP_SELF']) == 'shop_settings.php' ? 'active-nav' : 'text-secondary'; ?>" href="shop_settings.php">
                    <i class="fa-solid fa-palette" style="width: 20px;"></i> Appearance
                </a>

                <a class="nav-link text-secondary rounded px-3 py-2 d-flex align-items-center gap-3 fw-medium opacity-50 cursor-not-allowed" href="#" title="Coming Soon">
                    <i class="fa-solid fa-cart-shopping" style="width: 20px;"></i> Orders
                </a>

                <a class="nav-link text-secondary rounded px-3 py-2 d-flex align-items-center gap-3 fw-medium opacity-50 cursor-not-allowed" href="#" title="Coming Soon">
                    <i class="fa-solid fa-chart-line" style="width: 20px;"></i> Analytics
                </a>
            </nav>
        </div>

        <div class="p-3 border-top mt-auto">
            <a href="../logout.php" class="nav-link text-danger rounded px-3 py-2 d-flex align-items-center gap-3 fw-medium hover-danger">
                <i class="fa-solid fa-right-from-bracket" style="width: 20px;"></i> Logout
            </a>
        </div>
    </div>
</div>
