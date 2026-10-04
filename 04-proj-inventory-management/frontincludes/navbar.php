<!--Date 4/24/2024-->
<nav class="navbar shadow navbar-dark bg-dark">
  <div class="container-fluid"> <!-- Use container-fluid for full width -->
    <a class="navbar-brand" href="#">
      <h3 class="navbar-title">LOGO</h3>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
    aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span> 
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-1 mb-lg-1"> <!-- Use me-auto for alignment -->
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index">Home</a>
        </li>

        <?php if(isset($_SESSION['loggedIn'])) : ?>
        <li class="nav-item">
          <a class="nav-link active" style="text-transform:uppercase;">
            <b style="text-transform:lowercase">user:</b> <?= $_SESSION['loggedInUser']['name'];?>
          </a>
        </li>
        <!-- Add <li> to wrap the Logout button -->
          <a class="btn btn-danger" href="logout">Logout</a>
        </li>

        <?php else: ?> 
        <li class="nav-item">
          <a class="nav-link" href="login">Login</a>
        </li>
        <?php endif; ?>

        <!-- Resident Login -->
        <?php if(isset($_SESSION['rloggedIn'])) : ?>
        <li class="nav-item">
          <a class="nav-link active" style="text-transform:uppercase;">
            <b style="text-transform:lowercase">user:</b> <?= $_SESSION['rloggedInUser']['rname'];?>
          </a>
        </li>
        <li class="nav-item"> <!-- Add <li> to wrap the Logout button -->
          <a class="btn btn-danger" href="resident-logout">Logout</a>
        </li>
        <?php else: ?> 
        <li class="nav-item">
          <!-- <a class="nav-link" href="resident-login.php">Resident Login</a> -->
        </li>
        <?php endif; ?>
      </ul> 
    </div>
  </div>
</nav>

<style>
  /* Responsive font size */
  .navbar-title {
    font-size: 1.7rem; /* Base size for larger screens */
  }


  @media (max-width: 480px) { /* Specific adjustment for very small screens */
    .navbar-title {
      font-size: 4vw; /* Font size based on viewport width */
      text-align: center; /* Centering for better alignment */
    }
  }
</style>
