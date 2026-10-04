<?php include('frontincludes/header.php'); 

if (isset($_SESSION['rloggedIn'])) {
    echo "<script>window.location.href = 'index.php';</script>";
}

if (isset($_SESSION['loggedIn'])) {
    echo "<script>window.location.href = 'login.php';</script>";
} 

if (isset($_SESSION['rloggedIn'])) {
    switch ($_SESSION['rloggedInUser']['role']) {
        case 'residents':
            redirect('Hoa/index.php', 'You are already logged in as resident!','success');
            break;
        default:
            redirect('visitor.php', 'Invalid role!', 'error');
            break;
    }
}
?>
<head>
    <title>IMS CASA</title>
    <link rel="stylesheet" type="text/css" href="assets/css/login.css">
</head>

<body>
<section class="intro">
  <div class="bg-image h-100">
    <div class="mask d-flex align-items-center h-100" style="background-color: #f3f2f2;">
      <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col-12 col-lg-9 col-xl-8">
            <div class="card" style="border-radius: 1rem;">
              <div class="row g-0">
                <div class="col-md-4 d-none d-md-block">
                  <section class="copy">
                    <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                      <div class="carousel-inner">
                        <div class="carousel-item active">
                          <img src="assets/image/undraw_login_2.svg" alt="Login image">
                        </div>
                        <div class="carousel-item">
                          <img src="assets/image/undraw_login_3.svg" alt="Authentication image">
                        </div>
                      </div>
                      <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                      </button>
                    </div>
                  </section>
                </div>
                <div class="col-md-8 d-flex align-items-center">
                  <div class="card-body py-5 px-4 p-md-5">
                    <form method="POST" action="resident-login-code.php" id="loginForm">
                      <h4 class="fw-bold mb-4 text-warning">Resident Login</h4>
                      <p class="mb-4 text-dark">To log in, please enter your email address and password.</p>

                      <!-- Display the logout message if it exists -->
                      <?php alertMessage(); ?>

                      <div class="form-outline mb-1 position-relative">
    <input type="email" name="remail" id="remail" class="form-control" required autocomplete="email" />
    <label class="form-label" for="remail">Email address</label>
</div>

<div class="form-outline mb-2 position-relative">
    <input type="password" name="rpassword" id="rpassword" class="form-control" required autocomplete="current-password" />
    <label class="form-label" for="rpassword">Password</label>
    <span id="togglePassword" class="position-absolute" style="right: 10px; top: 10px; cursor: pointer;" onclick="togglePasswordVisibility()">
        <i class="fas fa-eye-slash" id="toggleIcon"></i>
    </span>
</div>
<p><a href="resident-password-reset.php" style="text-decoration: none;">Forgot Password?</a></p> <!-- Added link -->
                      <div class="d-flex justify-content-end pt-1 mb-4">
                      <button class="bbtn w-100" type="submit" name="rloginBtn">Submit <span class="bbtn-span"> ─ Log In</span></button>
                      </div>
                      <hr>
                      <a class="link float-end" style="text-decoration: none;" href="index.php"><i class="fa-solid fa-left-long"></i> Go Back</a>
                    </form>
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
</body>

<script>
function togglePasswordVisibility() {
    var passwordField = document.getElementById('rpassword');
    var toggleIcon = document.getElementById('toggleIcon');

    if (passwordField.type === 'password') {
        passwordField.type = 'text'; // Show password
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password'; // Hide password
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>


<?php include('frontincludes/footer.php'); ?>
