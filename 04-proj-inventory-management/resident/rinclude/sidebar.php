<!--Date 4/24/2024-->

<?php 
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/")+1);
$resident_id = $_SESSION['rloggedInUser']['ruser_id'];

// Functions to get unpaid and unacknowledged counts
function getInpaidStstusCount($resident_id) {
    global $conn;
    $query = "SELECT COUNT(*) AS in_paidStatus_count FROM residents WHERE id = $resident_id AND cost > 0";
    $result = mysqli_query($conn, $query);
    return $result ? mysqli_fetch_assoc($result)['in_paidStatus_count'] : 0;
}



$getCountPaidstatus = getInpaidStstusCount($resident_id);

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

                        <div class="sb-sidenav-menu-heading">Payment Status</div>


                            <a class="nav-link
                               <?= $page == 'resident-view-payment.php' ? 'active':''; ?>"
                             href="resident-view-payment">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-money-bills"></i></div>
                               Billing 
                <?php if ($getCountPaidstatus > 0) : ?>
                                <span class="badge bg-danger"><?= $getCountPaidstatus; ?></span>
                                <?php endif; ?>
                            </a>



                            <div class="sb-sidenav-menu-heading">MAINTENANCE</div>

                            <a class="nav-link 
                             <?= ($page == 'maintenance-request.php') ||  ($page == 'maintenance-resident-view.php') ? 'collapse active':'collapsed'; ?>" 
                            href="#" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseResidentreq" aria-expanded="false" aria-controls="collapseResidentreq">
                                <div class="sb-nav-link-icon"><i class="fas fa-inbox"></i></div>
                                Request Form
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse
                             <?= ($page == 'maintenance-request.php') ||  ($page == 'maintenance-resident-view.php') ? 'show':''; ?>" 
                            id="collapseResidentreq" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link  <?= $page == 'maintenance-request.php' ? 'active':''; ?>
                                    " href="maintenance-request"><div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                                     Request</a>
                                    <a class="nav-link  <?= $page == 'maintenance-resident-view.php' ? 'active':''; ?>
                                    " href="maintenance-resident-view">  <div class="sb-nav-link-icon"><i class="fas fa-calendar-day"></i></div>
                                     Schedule</a>
                                </nav>
                            </div>
                            
                            <?php 
                            // Functions to get unpaid and unacknowledged counts
function getreadstatusCount() {
    global $conn;
    $query = "SELECT COUNT(*) AS get_read_status_count FROM announcement WHERE already_read =0";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['get_read_status_count'];
    }
    return 0;
}
$getreadststuscount = getreadstatusCount();
                            ?>
                            <a class="nav-link
                              <?= $page == 'announcement.php' ? 'active':''; ?>
                              " href="announcement">
                                <div class="sb-nav-link-icon"><i class="fas fa-bullhorn"></i></div>
                               Announcement
                               <?php if ($getreadststuscount > 0) : ?>
                                <span class="badge bg-danger"><?= $getreadststuscount; ?></span>
                                <?php endif; ?>
                            </a>
    
                            <div class="collapse" id="collapseResidentreq" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            </div>  
                        </div>
                   

                    </div>
                    <div class="sb-sidenav-footer">
                    <div class="small">Logged in as: <h6 style="font-weight: 700;">
                    <?= $_SESSION['rloggedInUser']['rname'];?></h6></div>
                
                </nav>
            </div>
            



<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script> -->




            