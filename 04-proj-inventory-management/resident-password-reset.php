<?php include('frontincludes/header.php'); ?>
<link rel="stylesheet" type="text/css" href="assets/css/login.css">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php alertMessage(); ?>
            <h1 class="text-center">Resident Password Reset</h1>
            <p class="text-center">Enter your email to receive a password reset link.</p>
            <form method="POST" action="resident-password-reset-code.php" class="bg-dark p-3 rounded">
                <div class="mb-3">
                    <label class="text-white">Email</label>
                    <input type="email" name="remail" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100" name="resident_reset_link">Send Reset Link</button>
            </form>
            <button class="bbtn w-100 mt-3" type="button" onclick="location.href='resident-login.php'">Back to<span class="bbtn-span"> ─ Log In</span></button>
        </div>
    </div>
</div>
<?php include('frontincludes/footer.php'); ?>
