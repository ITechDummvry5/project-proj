<!--Date 4/24/2024-->

<!-- For Admin -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
  <!-- Navbar Brand-->
  <a class="navbar-brand ps-3 fs-5 fw-bold" id="navbarBrand" href="#">
    <?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
      System Admin
    <?php elseif($_SESSION['loggedInUser']['role'] === 'admin'): ?>
      Stockman
    <?php endif; ?>    
  </a>

  <!-- Sidebar Toggle-->
  <button class="btn btn-link btn-lg order-1 order-lg-0 me-0 me-lg-0 ms-2" id="sidebarToggle" href="#!">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Navbar Search -->
  <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
    <!-- Search input can be added here if needed -->
  </form>

  <!-- Navbar-->
  <ul class="navbar-nav ms-auto ms-md-0 me-1 me-lg-4">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        &nbsp;<i class="fas fa-user fa-fw"></i>&nbsp;<?= $_SESSION['loggedInUser']['name'];?>
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="../index">Homepage</a></li>  
        <li><a class="dropdown-item" href="profile-setting">Profile Setting</a></li>
        <li><hr class="dropdown-divider" /></li>
        <li><a class="dropdown-item" href="../logout">Logout</a></li>
      </ul>
    </li>
  </ul>
</nav>

<script>
  function updateNavbarBrand() {
    const navbarBrand = document.getElementById('navbarBrand');
    const widthThreshold = 460; // Set the threshold width

    if (window.innerWidth < widthThreshold) {
      navbarBrand.textContent = 'IMS SYSTEM'; // Change to 'IMS SYSTEM'
    } else {
      // Restore original text based on role
      <?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
        navbarBrand.textContent = 'System Admin';
      <?php elseif($_SESSION['loggedInUser']['role'] === 'admin'): ?>
        navbarBrand.textContent = 'Stockman';
      <?php endif; ?> 
    }
  }

  // Run on load and on resize
  window.addEventListener('load', updateNavbarBrand);
  window.addEventListener('resize', updateNavbarBrand);
</script>
