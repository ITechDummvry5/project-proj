<?php include('frontincludes/header.php'); ?>
<link rel="stylesheet" type="text/css" href="assets/css/login.css">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php alertMessage(); ?>
            <h1 class="text-center">Reset Your Password</h1>
            <form method="POST" action="resident-password-reset-code.php" class="bg-dark p-3 rounded">
                <input type="hidden" name="token_password" value="<?php if(isset($_GET['rtoken'])){echo $_GET['rtoken'];}?>">
                <div class="mb-3">
                    <label for="email" class="fs-6 fw-light text-white">Email</label>
                    <!-- Set the value of the email input to the email parameter from the URL -->
                    <input type="text" name="remail" value="<?php if(isset($_GET['remail'])){echo $_GET['remail'];} ?>" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="text-white">New Password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="text-white">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" name="update_password" class="btn btn-primary w-100">Update Password</button>
            </form>

            <button class="bbtn w-100 mt-3" type="button" onclick="location.href='resident-login.php'">Do You Remember now ?<span class="bbtn-span"> ─ Cancel It</span></button>
        </div>
    </div>
</div>
<?php include('frontincludes/footer.php'); ?>
