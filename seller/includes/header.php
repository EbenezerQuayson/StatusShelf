<header class="bg-white border-bottom py-3 px-4 sticky-top z-3">
    <div class="d-flex justify-content-between align-items-center">
        
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-light d-md-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div>
                <h1 class="h5 fw-bold mb-0 text-dark">
                    <?php 
                        $hour = date('H');
                        if ($hour < 12) echo "Good Morning";
                        elseif ($hour < 17) echo "Good Afternoon";
                        else echo "Good Evening";
                    ?>
                </h1>
                <small class="text-muted d-none d-md-block"><?php echo date("l, F j, Y"); ?></small>
            </div>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            <a href="../shop.php?u=<?php echo $seller['username']; ?>" target="_blank" class="text-decoration-none text-secondary fw-bold small d-none d-md-block">
                <i class="fa-solid fa-external-link-alt me-1"></i> View Shop
            </a>
            
            <div class="rounded-circle bg-light d-flex justify-content-center align-items-center fw-bold border text-secondary" style="width: 40px; height: 40px;">
                <?php echo strtoupper(substr($seller_name, 0, 2)); ?>
            </div>
        </div>
    </div>
</header>