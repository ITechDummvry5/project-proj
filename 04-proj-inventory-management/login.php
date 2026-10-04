<?php include('frontincludes/header.php'); 
// Prevent access to login.php if already logged in
if(isset($_SESSION['loggedIn'])){
    ?>
    <script>window.location.href = 'index.php';</script>
    <?php
}
if(isset($_SESSION['rloggedIn'])){
    ?>
    <script>window.location.href = 'index.php';</script>
    <?php
}

// Prevent access to login.php if already logged in
if (isset($_SESSION['loggedIn'])) {
    // Check user role and redirect accordingly using the redirect function
    switch ($_SESSION['loggedInUser']['role']) {
        case 'admin':
            redirect('admin/index2.php', 'You are already logged in as stockman');
            break;
        case 'superadmin':
            redirect('admin/index.php', 'You are already logged in as superadmin');
            break;
        case 'hoa':
            redirect('Hoa/index.php', 'You are already logged in as hoa officer');
            break;
        default:
            redirect('visitor.php', 'Invalid role!');
            break;
    }
    exit; // Ensure no further code is executed after redirection
}
?>




<head>
    <title>IMS CASA</title>
    <link rel="stylesheet" type="text/css" href="assets/css/login.css">
</head>
<body> 
<main>
    <div class="split">
        <div class="sidepic"> 
            <section class="copy"> <!--selection-->
                <h1 class="fw-bolder fs-1">INSERT TITLE HERE</h1>
                <p>- since 2017</p>
            </section>
        </div>   
        
        <div class="sideform">
            <form method="POST" action="login-code.php" id="loginForm">
              
            <section class="copy">
                        <!-- Display the logout message if it exists -->
                    
                         <img src="assets/image/undraw_login_1.svg" height="100" class="mb-2">

                        <?php alertMessage();?>
                        <div class="mb-0">
                           <label for="email" class="fs-6 fw-light">Enter Email</label>
                            <input type="email" name="email" id="email"  required autocomplete="email" required >
                        </div>

                        <div class="mb-0">
    <label for="password" class="fs-6 fw-light">Enter Password</label>
    <div class="input-group">
        <input type="password" name="password" id="password" autocomplete="current-password" required>
        <button type="button" id="togglePassword" class="btn btn-outline-secondary">
            <i class="fa fa-eye-slash" id="toggleIcon"></i>
        </button>
    </div>
</div>

                        <p><a href="password-reset.php" style="text-decoration: none;">Forgot Password?</a></p> <!-- Added link -->
                        
                        
                        <button class="bbtn w-100" type="submit" name="login">Submit <span class="bbtn-span"> ─ Log In</span></button>
                        <hr>
                        <a class="link float-end" style="text-decoration: none;" href="index.php"><i class="fa-solid fa-left-long"></i> Go Back</a>
                </section>
            </form>
        </div>
        </div>
</main>
</body>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        // Toggle the type attribute
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle the eye icon
        toggleIcon.classList.toggle('fa-eye');
        toggleIcon.classList.toggle('fa-eye-slash');
    });
</script>

<?php include('frontincludes/footer.php'); ?>
