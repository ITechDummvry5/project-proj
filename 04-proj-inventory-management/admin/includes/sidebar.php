<?php 
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/")+1);
?>

<!-- <div id="layoutSidenav"> -->

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
            <div id="layoutSidenav_nav" >
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core Features</div>
                            <?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
                            <a class="nav-link <?= $page == 'index.php' ? 'active':''; ?>" href="index">
                                <div class="sb-nav-link-icon"><i class="fas  fa-chart-column"></i></div>
                                Dashboard 
                            </a>
                            <?php endif; ?>

                            <?php if($_SESSION['loggedInUser']['role'] === 'admin'): ?>
                            <a class="nav-link <?= $page == 'index2.php' ? 'active':''; ?>" href="index2">
                                <div class="sb-nav-link-icon"><i class="fas  fa-chart-column"></i></div>
                                Dashboard 
                            </a>
                            <?php endif; ?>

                            

                            <a class="nav-link <?= $page == 'orders.php' ? 'active':''; ?>" href="orders">
                                <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                               Withdrawal
                            </a>

                            <?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
                            <a class="nav-link <?= $page == 'order-create.php' ? 'active':''; ?>" href="order-create">
                                <div class="sb-nav-link-icon"><i class="fas fa-folder-plus"></i></div>
                                Withdrawal Process
                            </a>
                            <?php endif; ?>

                            

<!--  inventory category  5/1/2024-->
                            <?php if($_SESSION['loggedInUser']['role'] === 'admin'): ?>
                            <div class="sb-sidenav-menu-heading">Inventory Management</div>
                            <a class="nav-link 
                                <?= ($page == 'categories-create.php') ||  ($page == 'categories.php') ? 'collapse active':'collapsed'; ?>"
        
                                href="#" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
                                <div class="sb-nav-link-icon"><i class="fas fa-layer-group"></i></div>
                                Projects
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-caret-down"></i></div></a>

                            <div class="collapse
                             <?= ($page == 'categories-create.php') ||  ($page == 'categories.php') ? 'show':''; ?>"

                                id="collapseCategory" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= $page == 'categories-create.php' ? 'active':''; ?>" href="categories-create"><i class="fas fa-circle-plus"></i>&nbsp;Create Project</a>
                                    <a class="nav-link <?= $page == 'categories.php' ? 'active':''; ?>" href="categories"> <i class="fas fa-eye"></i>&nbsp;View Project</a>
                                </nav>
                            </div>
                            <?php endif; ?>
   


    <?php                        // Function to get out-of-stock product count
function getOutOfStockCount() {
    global $conn;
    $query = "SELECT COUNT(*) AS out_of_stock_count FROM products WHERE quantity = 0";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['out_of_stock_count'];
    }
    return 0;
}

$outOfStockCount = getOutOfStockCount();
?>
        <?php if($_SESSION['loggedInUser']['role'] === 'admin'): ?>
<!-- Sidebar HTML -->
<div id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <a class="nav-link <?= ($page == 'products-create.php') || ($page == 'products.php') || ($page == 'products-archive-view.php') ? 'collapse active':'collapsed'; ?>" 
               href="#" 
               data-bs-toggle="collapse" 
               data-bs-target="#collapseProduct" aria-expanded="false" aria-controls="collapseProduct">
                <div class="sb-nav-link-icon"><i class="fas fa-boxes-packing"></i></div>
                Materials
                <?php if ($outOfStockCount > 0) : ?>
                    <span class="badge bg-danger"><?= $outOfStockCount; ?></span>
                <?php endif; ?>
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-caret-down"></i></div>
            </a>
            <div class="collapse <?= ($page == 'products-create.php') ||($page == 'products-folder.php') || ($page == 'products.php') || ($page == 'products-archive-view.php') ? 'show':''; ?>" id="collapseProduct" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link <?= $page == 'products-create.php' ? 'active':''; ?>" href="products-create.php"><i class="fas fa-circle-plus"></i>&nbsp;Create Materials</a>
                    <a class="nav-link <?= $page == 'products-folder.php' ? 'active':''; ?>" href="products-folder.php"><i class="fas fa-window-maximize"></i>&nbsp;Project Materials</a>
                    <a class="nav-link <?= $page == 'products.php' ? 'active':''; ?>" href="products.php"><i class="fas fa-eye"></i>&nbsp;View All Materials</a>
                    <a class="nav-link d-none<?= $page == 'products-archive-view.php' ? 'active':''; ?>" href="products-archive-view.php"><i class="fa-regular fa-folder-open"></i>&nbsp;Archive Materials</a>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

                           

                            <?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
                                <a class="nav-link <?= $page == 'products-folder.php' ? 'active':''; ?>" href="products-folder">
                                <div class="sb-nav-link-icon"><i class="fas fa-window-maximize"></i></div>
                                Project Materials
                            </a>
                            <?php endif; ?>

                            <?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
                                <a class="nav-link 
                                 <?= $page == 'changelog.php' ? 'active':''; ?>"
                                  href="changelog">
                                <div class="sb-nav-link-icon"><i class="fas fa-timeline"></i></div>
                                Inventory Report Logs
                            </a>
                            <?php endif; ?>

<!-- systemadmin side -->  <?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
                            <div class="sb-sidenav-menu-heading">Account Manage Users</div>

                            
                           
                            <a class="nav-link 
                                 <?= $page == 'admin-backup-form.php' ? 'active':''; ?>"
                                  href="admin-backup-form">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-download"></i></div>
                                Backup Table
                            </a>

<?php 
                      // Function to get count of active (non-archived) contractors
function getCompleteContractor() {
    global $conn;
    $query = "SELECT COUNT(*) AS complete_contractor FROM customers WHERE status = 1 AND is_archived = 0"; // Change here
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['complete_contractor'];
    }
    return 0; // Return 0 if the query fails
}

// Call the function to get the count
$statusCompleteOfContractor = getCompleteContractor();

?>
                            <a class="nav-link 
                             <?= ($page == 'customers-create.php') ||  ($page == 'customers.php')  ||  ($page == 'customers-archive-view.php') ? 'collapse active':'collapsed'; ?>"
                            href="#" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseCustomer" 
                            aria-expanded="false" aria-controls="collapseCustomer">


                                <div class="sb-nav-link-icon"><i class="fas fa-user-check"></i></div>
                                Contractor
                                <?php if ($statusCompleteOfContractor > 0) : ?>
                    <span class="badge bg-primary"><?= $statusCompleteOfContractor; ?></span>
                <?php endif; ?>
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-caret-down"></i></div>
                            </a>

                            <div class="collapse
                            <?= ($page == 'customers-create.php') ||  ($page == 'customers.php') ||  ($page == 'customers-archive-view.php') ? 'show':''; ?>"
                            id="collapseCustomer" 
                            aria-labelledby="headingOne" 
                            data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= $page == 'customers-create.php' ? 'active':''; ?>" href="customers-create"><i class="fas fa-user-plus"></i>&nbsp;Add Contractor</a>
                                    <a class="nav-link <?= $page == 'customers.php' ? 'active':''; ?>" href="customers"><i class="fas  fa-users"></i>&nbsp;View Contractor</a>
                                    <a class="nav-link <?= $page == 'customers-archive-view.php' ? 'active':''; ?>" href="customers-archive-view.php"><i class="fa-regular fa-folder-open"></i>&nbsp;Done</a>
                                </nav>
                            </div>
                            <?php endif; ?>
                            

<!-- Stockman side -->  <?php if($_SESSION['loggedInUser']['role'] === 'admin'): ?>
    <div class="sb-sidenav-menu-heading">CONTRACTOR STATUS</div>

    <?php 
                      // Function to get count of active (non-archived) contractors
function getPendingContractor() {
    global $conn;
    $query = "SELECT COUNT(*) AS pending_contractor FROM customers WHERE status = 0 AND is_archived = 0"; // Change here
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['pending_contractor'];
    }
    return 0; // Return 0 if the query fails
}

// Call the function to get the count
$statusPendingOfContractor = getPendingContractor();

?>
                                <a class="nav-link <?= $page == 'customers.php' ? 'active':''; ?>" href="customers">
                                <div class="sb-nav-link-icon"><i class="fas fa-eye"></i></div>
                              Contractor 
                              <?php if ($statusPendingOfContractor > 0) : ?>
                    <span class="badge bg-warning"><?= $statusPendingOfContractor; ?></span>
                <?php endif; ?>
                            </a>
                            <?php endif; ?>
                            
<!-- admin side -->
<?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
                            <a class="nav-link 
                            <?= ($page == 'admins-create.php') ||  ($page == 'admins.php') ? 'collapse active':'collapsed'; ?>"
                            
                            href="#" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseAdmins" 
                            aria-expanded="false" aria-controls="collapseAdmins">

                                <div class="sb-nav-link-icon"><i class="fas fa-users-gear"></i></div>
                                Admins/Staff
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-caret-down"></i></div>
                            </a>

                            <div class="collapse
                             <?= ($page == 'admins-create.php') ||  ($page == 'admins.php') ? 'show':''; ?>"
                            
                             id="collapseAdmins" 
                            aria-labelledby="headingOne" 
                            data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= $page == 'admins-create.php' ? 'active':''; ?>" href="admins-create"><i class="fas fa-user-plus"></i>&nbsp;Add Admin</a>
                                    <a class="nav-link <?= $page == 'admins.php' ? 'active':''; ?>" href="admins"><i class="fas fa-users-line"></i>&nbsp;View Admins</a>
                                </nav>
                            </div>
                            <?php endif; ?>
                           
                        </div>
                    </div>


                    <div class="sb-sidenav-footer">
                    <div class="small">Logged in as: <h6 style="font-weight: 700;">
                    <?= $_SESSION['loggedInUser']['name'];?></h6></div>
                    
                    </div>
                </nav>
            </div>
            