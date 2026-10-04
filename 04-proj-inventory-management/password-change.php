<?php include('frontincludes/header.php'); ?>
<!-- change-password.php -->

<link rel="stylesheet" type="text/css" href="assets/css/login.css">
<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6"><?php alertMessage(); ?>
            <h1 class="text-center">Change Your Password</h1>
            <p class="text-center">Please enter your new password and confirm it.</p>

            <form method="POST" action="password-reset-code.php" class="bg-dark p-3 rounded">
    <input type="hidden" name="password_token" value="<?php if(isset($_GET['token'])){echo $_GET['token'];}?>">

            <div class="mb-3">
                    <label for="email" class="fs-6 fw-light text-white">Email</label>
                    <input type="text" name="email"  value="<?php if(isset($_GET['email'])){echo $_GET['email'];} 
                        ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="fs-6 fw-light text-white">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" required autocomplete="new-password">
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="fs-6 fw-light text-white">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required autocomplete="new-password">
                </div>
                <button class="w-100 btn btn-primary" type="submit" name="password_update">Update Password</button>
            </form>
            <button class="bbtn w-100 mt-3" type="button" onclick="location.href='login.php'">Do You Remember now ?<span class="bbtn-span"> ─ Cancel It</span></button>
        </div>
    </div>
</div>


<?php include('frontincludes/footer.php'); ?>