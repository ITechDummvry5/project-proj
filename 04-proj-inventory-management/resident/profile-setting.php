<?php include('rinclude/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="fw-bold fs-5">Profile Settings</h4>
            <a href="resident-view-payment.php" class="btn btn-primary">Go Back</a>
        </div>
        <div class="card-body">
            <!-- Display alert messages if there are any -->
            <?php alertMessage(); ?>
            
            <form action="rcode.php" method="POST">

                <?php 
                    // Ensure the user is logged in and fetch their details
                    if(isset($_SESSION['rloggedInUser'])) {
                        $residentId = $_SESSION['rloggedInUser']['ruser_id'];

                        // Fetch resident data from the database
                        $residentData = getById('residents', $residentId);
                        
                        if ($residentData && $residentData['status'] == 200) {
                            $resident = $residentData['data'];
                        } else {
                            echo '<h5>Resident data not found!</h5>';
                            return false;
                        }
                    } else {
                        echo '<h5>User not logged in!</h5>';
                        return false;
                    }
                ?>
                
                <!-- Hidden field for residentId -->
                <input type="hidden" name="residentId" value="<?php echo $resident['id']; ?>">

                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="rname" class="badge bg-primary bg-gradient rounded-1 mb-2">Name *</label>
                        <input type="text" name="rname" value="<?php echo $resident['rname']; ?>" class="form-control" required>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="address" class="badge bg-primary bg-gradient rounded-1 mb-2">Address</label>
                        <input type="text" name="address" value="<?php echo $resident['address']; ?>" class="form-control" required>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="remail" class="badge bg-primary bg-gradient rounded-1 mb-2">Email *</label>
                        <input type="email" name="remail" value="<?php echo $resident['remail']; ?>" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="rphone" class="badge bg-primary bg-gradient rounded-1 mb-2">Phone *</label>
                        <input type="tel" name="rphone" value="<?php echo $resident['rphone']; ?>" class="form-control" maxlength="11" required>
                    </div>

                    <div class="col-md-4 mb-2">
    <label for="rpassword" class="badge bg-primary bg-gradient rounded-1 mb-2">New Password</label>
    <div class="input-group">
        <input type="password" name="rpassword" id="rpassword" class="form-control">
        <!-- Add a button/icon to toggle visibility -->
        <button type="button" id="togglePassword" class="btn btn-outline-secondary">
            <i class="fas fa-eye-slash"></i>
        </button>
    </div>
</div>

<div class="col-md-4 mb-4">
    <label for="confirmPassword" class="badge bg-primary bg-gradient rounded-1 mb-2">Confirm New Password</label>
    <div class="input-group">
        <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
        <!-- Add a button/icon to toggle visibility -->
        <button type="button" id="toggleConfirmPassword" class="btn btn-outline-secondary">
            <i class="fas fa-eye-slash"></i>
        </button>
    </div>
</div>


                <div class="col-md-12 mb-4 text-end">
                <button type="button" id="generatePassword" class="btn btn-danger "><i class="fas fa-random"></i>Generate Password</button>
                    <button type="submit" name="updateProfile" class="btn btn-primary">Update Profile</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle password visibility for the new password field
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('rpassword');

        togglePassword.addEventListener('click', () => {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            togglePassword.innerHTML = type === 'password' 
                ? '<i class="fas fa-eye-slash"></i>' 
                : '<i class="fas fa-eye"></i>';
        });

        // Toggle password visibility for the confirm password field
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordField = document.getElementById('confirmPassword');

        toggleConfirmPassword.addEventListener('click', () => {
            const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordField.setAttribute('type', type);
            toggleConfirmPassword.innerHTML = type === 'password' 
                ? '<i class="fas fa-eye-slash"></i>' 
                : '<i class="fas fa-eye"></i>';
        });

           // Generate random password
           const generatePassword = document.getElementById('generatePassword');
        generatePassword.addEventListener('click', () => {
            const randomPassword = generateRandomPassword();
            passwordField.value = randomPassword;
            confirmPasswordField.value = randomPassword;
        });

        // Random password generation logic
        function generateRandomPassword() {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const passwordLength = 12;
            let password = '';
            for (let i = 0; i < passwordLength; i++) {
                password += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            return password;
        }

    });
</script>
