<!-- forgot-password.php -->
<?php include('frontincludes/header.php'); ?>
<link rel="stylesheet" type="text/css" href="assets/css/login.css">
<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6"><?php alertMessage();?>
            <h1 class=" text-center">Forgot Your Password? </h1>
            <p class=" text-center">Please enter your email address. We will send you a link to reset your password.</p>
            <form method="POST" action="password-reset-code.php" class="bg-dark p-3 rounded">
                <div class="mb-3">
                    <label for="email" class="fs-6 fw-light text-white">Enter Email</label>
                    <input type="email" name="email" id="email" class="form-control" required autocomplete="email">
                </div>
                <button class="w-100 btn btn-primary" type="submit" name="pass_reset_link">Send Reset Link</button>
            </form>
            <button class="bbtn w-100 mt-3" type="button" onclick="location.href='login.php'">Back to<span class="bbtn-span"> ─ Log In</span></button>
        </div>
    </div>
</div>

<?php include('frontincludes/footer.php'); ?>
