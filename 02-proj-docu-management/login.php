<?php include('includes/header.php'); ?>

<!-- Prevent access to login.php if already logged in -->
<?php
if (isset($_SESSION['loggedIn'])) {
    ?>
    <script>window.location.href = 'index.php';</script>
    <?php
}
if (isset($_SESSION['loggedIn'])) {
    // Check user role and redirect accordingly
    switch ($_SESSION['loggedInUser']['role']) {
        case 'staff':
            redirect('admin/index.php', 'You are already logged in as Staff');
            break;
        case 'secretary':
            redirect('admin/index2.php', 'You are already logged in as Secretary');
            break;
        default:
            redirect('visitor.php', 'Invalid role!');
            break;
    }
    exit;
}
?>

<!-- Page Title Section -->
<div class="page-title dark-background" data-aos="fade">
    <div class="heading">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-4">
                    <h1 id="date"></h1> <!-- Placeholder for the date -->
                </div>
            </div>
        </div>
    </div>
    <nav class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="index.php">Home</a></li>
                <li class="current">Login Page</li>
            </ol>
        </div>
    </nav>
</div><!-- End Page Title -->

<!-- Starter Section with SVG Background -->
<section id="starter-section" class="starter-section section" style="position: relative; overflow: hidden; background-color: transparent;">
    <!-- SVG Wave Background -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" style="position: absolute; top: 220px; left: 0; width: 100%; height: 100%; z-index: -1;">
        <path fill="#08005e" fill-opacity="1" d="M0,192L80,213.3C160,235,320,277,480,261.3C640,245,800,171,960,138.7C1120,107,1280,117,1360,122.7L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
    </svg>

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up" style="position: relative; z-index: 1;">
        <h2>LogIn Section</h2>
        <div><span>Log in </span><span class="description-title">before you proceed</span></div>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img src="assets/img/gallery/gallery-1.jpg" alt="Banadero 2025" class="img-fluid w-100 h-100">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="mb-2 fs-2 text-primary">Log In</h1>
                                        <p class="mb-5 text-muted fs-6">Please enter your email and password to log in.</p>
                                    </div>
                                    <form action="login-code.php" method="POST">
                                      <?php alertMessage(); ?>
                                        <div class="form-group mb-4">
                                            <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Enter Email" required autofocus>
                                        </div>

                                        <div class="mb-4 position-relative">
                                            <input type="password" name="password" id="password" class="form-control form-control-user" placeholder="Enter Password" maxlength="45" required  autocomplete=""/>
                                            <span id="togglePassword" class="position-absolute" style="right: 10px; top: 8px; cursor: pointer;" onclick="togglePasswordVisibility()">
                                                <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" name="login" class="btn btn-primary w-100">Log In</button>
                                        </div>
                                    </form>
                                    
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.php">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>

<script>
  // Get the current date
  const currentDate = new Date();
  
  // Format the date (you can customize the format as needed)
  const formattedDate = currentDate.toLocaleDateString('en-US', {
    weekday: 'long',  // Full weekday name (e.g., Monday)
    year: 'numeric',  // Full year (e.g., 2024)
    month: 'long',  // Full month name (e.g., December)
    day: 'numeric'  // Day of the month (e.g., 18)
  });

  // Set the date to the h1 element
  document.getElementById('date').textContent = formattedDate;

  // Password visibility toggle
  function togglePasswordVisibility() {
      const passwordField = document.getElementById('password');
      const toggleIcon = document.getElementById('toggleIcon');
      
      if (passwordField.type === 'password') {
          passwordField.type = 'text';
          toggleIcon.classList.remove('bi-eye-slash');
          toggleIcon.classList.add('bi-eye');
      } else {
          passwordField.type = 'password';
          toggleIcon.classList.remove('bi-eye');
          toggleIcon.classList.add('bi-eye-slash');
      }
  }
</script>