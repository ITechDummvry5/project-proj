<?php include('includes/header.php'); ?>

<section id="hero" class="hero section dark-background">
    <div class="hero-bg-container">
        <img src="assets/img/municipal.jpg" alt="Hero Image" class="hero-bg img-fluid w-100 h-100">
    </div>
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img src="assets/img/gallery/gallery-3.jpg" alt="Gallery Image" class="img-fluid w-100 h-100">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="mb-2 fs-4 text-primary">Change Your Password</h1>
                                        <p class="mb-4 text-muted fs-6">Please enter your new password and confirm it.</p>
                                    </div>

                                    <?php alertMessage(); ?>
                                    
                                    <form method="POST" action="forgot-password-reset-code.php" class="rounded">
                                        <input type="hidden" name="password_token" value="<?php if(isset($_GET['token'])){ echo $_GET['token']; } ?>">
                                        
                                        <div class="form-group mb-2">
                                            <label for="email" class="fs-6 fw-light text-muted">Email</label>
                                            <input type="text" name="email" value="<?php if(isset($_GET['email'])){ echo $_GET['email']; } ?>" class="form-control" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="new_password" class="fs-6 fw-light text-muted">New Password</label>
                                            <input type="password" name="new_password" id="new_password" class="form-control" required autocomplete="new-password">
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="confirm_password" class="fs-6 fw-light text-muted">Confirm Password</label>
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required autocomplete="new-password">
                                        </div>

                                        <button class="btn btn-primary w-100 mt-3" type="submit" name="password_update">Update Password</button>
                                    </form>

                                    <hr>
                                    <div class="text-center">
                                        <button class="btn w-100 mt-2" type="button" onclick="location.href='login.php'">
                                            Do You Remember now? <span class="text-primary"> ─ Cancel It</span>
                                        </button>
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
