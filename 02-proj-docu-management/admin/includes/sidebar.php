<?php 
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/")+1);
?>
       <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index2.php">
                <div class="sidebar-brand-icon rotate-n-55">
                <i class="fas fa-hand-peace"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Banadero<sup>2025</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link <?= $page == 'index2.php' ? 'active':''; ?>" href="index2.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Core
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
    <a class="nav-link <?= ($page == 'personal-create.php' || $page == 'personal-view.php') ? 'active' : 'collapsed'; ?>"
       href="#" data-toggle="collapse" data-target="#collapseTwo"
       aria-expanded="<?= ($page == 'personal-create.php' || $page == 'personal-view.php') ? 'true' : 'false'; ?>"
       aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Personal Information</span>
    </a>
    <div id="collapseTwo" class="collapse <?= ($page == 'personal-create.php' || $page == 'personal-view.php') ? 'show' : ''; ?>"
         aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Create Information:</h6>
            <a class="collapse-item <?= $page == 'personal-create.php' ? 'active' : ''; ?>" href="personal-create.php">Information Slip</a>
            <a class="collapse-item <?= $page == 'personal-view.php' ? 'active' : ''; ?>" href="personal-view.php">Records</a>
        </div>
    </div>
</li>

     <!-- Nav Item - Charts -->
     <li class="nav-item">
                <a class="nav-link <?= $page == 'create-document.php' ? 'active':''; ?>" href="create-document.php">
              <i class="bi bi-file-earmark-medical-fill"></i>
                    <span>Document Create</span></a>
            </li>
<hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
                Storage
            </div>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link <?= ($page == 'barangay-certificate.php' || $page == 'barangay-clearance.php' || $page == 'barangay-indigency.php' || $page == 'barangay-residency.php' || $page == 'soloparentcertificate.php' || $page == 'pwdcertificate.php') ? 'active' : 'collapsed'; ?>"
       href="#" data-toggle="collapse" data-target="#collapseUtilities"
       aria-expanded="<?= ($page == 'barangay-certificate.php' || $page == 'barangay-clearance.php' || $page == 'barangay-indigency.php' || $page == 'barangay-residency.php' || $page == 'soloparentcertificate.php' || $page == 'pwdcertificate.php') ? 'true' : 'false'; ?>"
       aria-controls="collapseUtilities">
        <i class="bi bi-collection-fill"></i>
        <span>Barangay</span>
    </a>
    <div id="collapseUtilities" class="collapse <?= ($page == 'barangay-certificate.php' || $page == 'barangay-clearance.php' || $page == 'barangay-indigency.php' || $page == 'barangay-residency.php' || $page == 'soloparentcertificate.php' || $page == 'pwdcertificate.php') ? 'show' : ''; ?>"
         aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Section: Barangay</h6>
            <a class="collapse-item <?= $page == 'barangay-certificate.php' ? 'active' : ''; ?>" href="barangay-certificate.php">Barangay Certificate</a>
            <a class="collapse-item <?= $page == 'barangay-clearance.php' ? 'active' : ''; ?>" href="barangay-clearance.php">Barangay Clearance</a>
            <a class="collapse-item <?= $page == 'barangay-indigency.php' ? 'active' : ''; ?>" href="barangay-indigency.php">Barangay Indigency</a>
            <a class="collapse-item <?= $page == 'barangay-residency.php' ? 'active' : ''; ?>" href="barangay-residency.php">Barangay Residency</a>
            <h6 class="collapse-header">Section: Others</h6>
            <a class="collapse-item <?= $page == 'soloparentcertificate.php' ? 'active' : ''; ?>" href="soloparentcertificate.php">Solo Parent Certificate</a>
            <a class="collapse-item <?= $page == 'pwdcertificate.php' ? 'active' : ''; ?>" href="pwdcertificate.php">PWD Certificate</a>
        </div>
    </div>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link <?= ($page == 'business-clearance.php' || $page == 'building-clearance.php' || $page == 'franchising.php') ? 'active' : 'collapsed'; ?>"
       href="#" data-toggle="collapse" data-target="#collapsePages"
       aria-expanded="<?= ($page == 'business-clearance.php' || $page == 'building-clearance.php' || $page == 'franchising.php') ? 'true' : 'false'; ?>"
       aria-controls="collapsePages">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Business</span>
    </a>
    <div id="collapsePages" class="collapse <?= ($page == 'business-clearance.php' || $page == 'building-clearance.php' || $page == 'franchising.php') ? 'show' : ''; ?>"
         aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Section: Business</h6>
            <a class="collapse-item <?= $page == 'business-clearance.php' ? 'active' : ''; ?>" href="business-clearance.php">Business Clearance</a>
            <a class="collapse-item <?= $page == 'building-clearance.php' ? 'active' : ''; ?>" href="building-clearance.php">Building Clearance</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Section: Other</h6>
            <a class="collapse-item <?= $page == 'franchising.php' ? 'active' : ''; ?>" href="franchising.php">Franchising</a>
        </div>
    </div>
</li>


            
        
            <!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link <?= ($page == 'certification-source.php' || $page == 'certification-low.php' || $page == 'certification-goodmoral.php' || $page == 'certification-esc.php' || $page == 'certification-calamity.php' || $page == 'certification-legitimacy.php' || $page == 'cohabitation-letter.php') ? 'active' : 'collapsed'; ?>"
       href="#" data-toggle="collapse" data-target="#collapsePages1"
       aria-expanded="<?= ($page == 'certification-source.php' ||$page == 'certification-low.php' || $page == 'certification-goodmoral.php' || $page == 'certification-esc.php' || $page == 'certification-calamity.php' || $page == 'certification-legitimacy.php' || $page == 'cohabitation-letter.php') ? 'true' : 'false'; ?>"
       aria-controls="collapsePages1">
        <i class="bi bi-inboxes"></i>
        <span>Certification</span>
    </a>
    <div id="collapsePages1" class="collapse <?= ($page == 'certification-source.php' ||$page == 'certification-low.php' || $page == 'certification-goodmoral.php' || $page == 'certification-esc.php' || $page == 'certification-calamity.php' || $page == 'certification-legitimacy.php' || $page == 'cohabitation-letter.php') ? 'show' : ''; ?>"
         aria-labelledby="headingPagesadds" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Section: Certificate</h6>
            <a class="collapse-item <?= $page == 'certification-calamity.php' ? 'active' : ''; ?>" href="certification-calamity.php">Certification of Calamity</a>
            <a class="collapse-item <?= $page == 'certification-esc.php' ? 'active' : ''; ?>" href="certification-esc.php">Certification of Esc</a>
            <a class="collapse-item <?= $page == 'certification-goodmoral.php' ? 'active' : ''; ?>" href="certification-goodmoral.php">Certificate of Good Moral</a>
            <a class="collapse-item <?= $page == 'certification-legitimacy.php' ? 'active' : ''; ?>" href="certification-legitimacy.php">Certification of Legitimacy</a>
            <a class="collapse-item <?= $page == 'certification-low.php' ? 'active' : ''; ?>" href="certification-low.php">Certification of Low Income</a>
            <a class="collapse-item <?= $page == 'certification-source.php' ? 'active' : ''; ?>" href="certification-source.php">Certification of Source of Income</a>
            <h6 class="collapse-header">Section: Other</h6>
            <a class="collapse-item <?= $page == 'cohabitation-letter.php' ? 'active' : ''; ?>" href="cohabitation-letter.php">Cohabitation Letter</a>
        </div>
    </div>
</li>

            <style>
                /* Make sure the collapse items are restricted in width */
.collapse-item {
    width: 183px; /* Adjust the width as needed */
    white-space: nowrap; /* Prevent the text from wrapping */
    overflow: hidden; /* Hide anything that overflows */
    text-overflow: ellipsis; /* Show ellipsis (...) for overflowed text */
}

            </style>
         
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Heading --> <?php if($_SESSION['loggedInUser']['role'] === 'secretary'): ?>
<div class="sidebar-heading">
    <span class="d-none d-md-inline">ACCOUNT MANAGEMENT</span>
    <span class="d-inline d-md-none">ACCOUNT</span>
</div>

<!-- Account  -->
<li class="nav-item">
    <a class="nav-link <?= ($page == 'account-create.php') || ($page == 'account-view.php') ? 'active' : 'collapsed'; ?>"
       href="#" data-toggle="collapse" data-target="#collapseAccount"
       aria-expanded="<?= ($page == 'account-create.php') || ($page == 'account-view.php') ? 'true' : 'false'; ?>"
       aria-controls="collapseAccount">
        <i class="fas fa-fw fa-cog"></i>
        <span>Account</span>
    </a>
    <div id="collapseAccount" class="collapse <?= ($page == 'account-create.php') || ($page == 'account-view.php') ? 'show' : ''; ?>"
         aria-labelledby="headingAccount" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Add Or Edit Account</h6>
            <a class="collapse-item <?= ($page == 'account-create.php') ? 'active' : ''; ?>" href="account-create.php">Create Account</a>
            <a class="collapse-item <?= ($page == 'account-view.php') ? 'active' : ''; ?>" href="account-view.php">Records</a>
        </div>
    </div>
</li>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
                <?php endif; ?>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
            
            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="../assets/img/favicon.png" alt="...">
                <p class="text-center mb-2"><strong>Account</strong> Logged in as: </p>
              <a href="profile-edit.php" class="btn btn-success btn-sm text-capitalize text-truncate" style="max-width: 100%;">
    <?= htmlspecialchars($_SESSION['loggedInUser']['name']); ?>
</a>

            </div>

        </ul>
        <!-- End of Sidebar -->