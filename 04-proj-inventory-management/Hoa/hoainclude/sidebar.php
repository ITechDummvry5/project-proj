<!--Date 8/30/2024-->
<?php 
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/")+1);
?>
<style>
#layoutSidenav_nav {
    height: 100vh; /* Ensure the sidebar takes the full height of the viewport */
    overflow-y: scroll; /* Enable vertical scrolling */
}

/* Hide scrollbar for Webkit browsers (Chrome, Safari) */
#layoutSidenav_nav::-webkit-scrollbar {
    width: 0;
    height: 0;
}

/* Hide scrollbar for Firefox */
#layoutSidenav_nav {
    scrollbar-width: none; /* Firefox */
}

/* Hide scrollbar for Internet Explorer and Edge */
#layoutSidenav_nav {
    -ms-overflow-style: none; /* IE and Edge */
}

.sb-sidenav-menu {
    max-height: 100%; /* Ensure the menu doesn't exceed the sidebar height */
    overflow-y: scroll; /* Enable vertical scrolling within the menu if needed */
}

/* Hide scrollbar for Webkit browsers (Chrome, Safari) */
.sb-sidenav-menu::-webkit-scrollbar {
    width: 0;
    height: 0;
}

/* Hide scrollbar for Firefox */
.sb-sidenav-menu {
    scrollbar-width: none; /* Firefox */
}

/* Hide scrollbar for Internet Explorer and Edge */
.sb-sidenav-menu {
    -ms-overflow-style: none; /* IE and Edge */
}

</style>

<!-- <div id="layoutSidenav"> -->
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">DASHBOARD</div>
                            <a class="nav-link
                             <?= $page == 'index.php' ? 'active':''; ?>
                             " href="index">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-simple"></i></div>
                                Dashboard
                            </a>

                            <?php
function getInimageCount() {
    global $conn;

    // Query to count residents where proof_image is not NULL or empty and the status is 'pending'
    $query = "SELECT COUNT(*) AS in_image_count 
              FROM resident_pay 
              WHERE proof_image IS NOT NULL 
              AND proof_image != '' 
              AND status = 'pending'"; // Adding condition for 'pending' status

    $result = mysqli_query($conn, $query);

  // Check if the query was successful
  if ($result) {
    $row = mysqli_fetch_assoc($result);
    return $row['in_image_count'];
}
    
    // Return 0 if the query fails or no matching records are found
    return 0;
}

// Example usage to check the image count
$getImage = getInimageCount();

        ?>                   
                            <a class="nav-link <?= $page == 'hoa-cashier.php' ? 'active':''; ?>" href="hoa-cashier">
                                <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                                Payment Features
                                <?php if ($getImage > 0) : ?>
                    <span class="badge bg-primary"><?= $getImage; ?></span>
                <?php endif; ?>
                            </a>

                            <a class="nav-link <?= $page == 'payment-history.php' ? 'active':''; ?>" href="payment-history">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                                Payment History
                            </a>

                         

                            <div class="sb-sidenav-menu-heading">CORE FEATURES</div>
                <a class="nav-link <?= ($page == 'announcement-create.php') ||  ($page == 'announcement-view.php') ? 'collapse active':'collapsed'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAnnouncement" aria-expanded="false" aria-controls="collapseAnnouncement">
                    <div class="sb-nav-link-icon"><i class="fas fa-bullhorn"></i></div>
                    Announcement
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= ($page == 'announcement-create.php') ||  ($page == 'announcement-view.php') ? 'show':''; ?>" id="collapseAnnouncement" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'announcement-create.php' ? 'active':''; ?>" href="announcement-create"><i class="fa-solid fa-scroll"></i>&nbsp;Post Announcement</a>
                        <a class="nav-link <?= $page == 'announcement-view.php' ? 'active':''; ?>" href="announcement-view"><i class="fa-solid fa-chalkboard-user"></i>&nbsp;View Announcement</a>
                    </nav>
                </div>
                            

                <?php 
                
                // Function to get in-stock product count
function getInMaintenanceCount() {
    global $conn;

    // Query to count products where the quantity is 1 or more
    $query = "SELECT COUNT(*) AS in_maintenance_count FROM request WHERE status = 'Pending'";

    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['in_maintenance_count'];
    }
    return 0;
}
$getCountMaintenance = getInMaintenanceCount(); 
                ?>
                            <a class="nav-link 
                             <?= ($page == 'maintenance-view.php') ||  ($page == 'archive-request-view.php') ? 'collapse active':'collapsed'; ?> 
                            " href="#" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseMaintenance" aria-expanded="false" aria-controls="collapseMaintenance">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-toolbox"></i></div>
                                Maintenance 
                                <?php if ($getCountMaintenance > 0) : ?>
                    <span class="badge bg-primary"><?= $getCountMaintenance; ?></span>
                <?php endif; ?>
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>

                            <div class="collapse 
                            <?= ($page == 'maintenance-view.php') ||  ($page == 'archived-requests-view.php') ? 'show':''; ?>
                            " id="collapseMaintenance" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link
                                    <?= $page == 'maintenance-view.php' ? 'active':''; ?>
                                    " href="maintenance-view"><i class="fas fa-inbox"></i>&nbsp; Request Inbox</a>
                                    <a class="nav-link
                                    <?= $page == 'archived-requests-view.php' ? 'active':''; ?>
                                    " href="archived-requests-view"><i class="fa-regular fa-folder-open"></i>&nbsp;Complete Request</a>
                                </nav>
                            </div>
                        
                      
                   
                         
                        
                            <div class="sb-sidenav-menu-heading">ACCOUNT MANAGEMENT</div>
            
                            <a class="nav-link 
                            <?= ($page == 'resident-create.php') ||  ($page == 'resident.php') ? 'collapse active':'collapsed'; ?>
                            " href="#" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseResident" aria-expanded="false" aria-controls="collapseResident">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Resident
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>

                            <div class="collapse
                                 <?= ($page == 'resident-create.php') ||  ($page == 'resident.php') ? 'show':''; ?>
                            " id="collapseResident" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link
                                       <?= $page == 'resident-create.php' ? 'active':''; ?>
                                    " href="resident-create"><i class="fas fa-user-plus"></i>&nbsp;Create Resident</a>
                                    <a class="nav-link
                                      <?= $page == 'resident.php' ? 'active':''; ?>
                                    " href="resident"><i class="fas  fa-users"></i>&nbsp;View Resident</a>
                                </nav>
                            </div>
                            
                            

                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                    <div class="small">Logged in as: <h6 style="font-weight: 700;">
                    <?= $_SESSION['loggedInUser']['name'];?></h6></div>
                
                </nav>
            </div>

            