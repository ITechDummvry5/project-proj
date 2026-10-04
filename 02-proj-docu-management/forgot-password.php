<?php include 'includes/header.php'?>

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
                                <img src="assets/img/gallery/gallery-3.jpg" alt="Apple Icon" class="img-fluid w-100 h-100">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="mb-2 fs-4 text-primary">Forgot Your Password?</h1>
                                        <p class="mb-4 text-muted fs-6">Just enter your email address below and we'll send you a link to reset your password!</p>
                                    </div>
                                   
                                    <?php alertMessage();?>
                                    <form method="POST" action="forgot-password-reset-code.php" class=" rounded">
                                        <div class="form-group">
                                            <input type="email" name="email"  class="form-control form-control-user" id="forgotemail" aria-describedby="emailHelp" placeholder="Enter Email..." autocomplete="email">
                                        </div>
                                        <button class="col-md-12 btn btn-primary btn-user btn-block mt-3 float-end mb-2" type="submit" name="pass_reset_link">Send Password Reset</button>

                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Already Password Changed? Login!</a>
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

<?php include 'includes/footer.php'?>
