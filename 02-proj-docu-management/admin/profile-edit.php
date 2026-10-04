<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="fw-bold fs-5">Profile Management</h4>
            <a href="account-view.php" class="btn btn-primary float-end">Go to Account Management</a> 
        </div>
        <div class="card-body">
            <!-- Display alert messages if there are any -->
            <?php alertMessage(); ?>
            
            <form action="code.php" method="POST">

                <?php 
                    // Ensure the user is logged in and fetch their details
                    if (isset($_SESSION['loggedInUser'])) {
                        $adminId = $_SESSION['loggedInUser']['user_id'];

                        // Fetch staff data from the database
                        $adminData = getById('account', $adminId);
                        
                        if ($adminData && $adminData['status'] == 200) {
                            $staff = $adminData['data'];
                        } else {
                            echo '<h5>Staff data not found!</h5>';
                            return false;
                        }
                    } else {
                        echo '<h5>User not logged in!</h5>';
                        return false;
                    }
                ?>
                
                <!-- Hidden field for adminId -->
                <input type="hidden" name="adminId" value="<?= $staff['id']; ?>">

                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="name" class="badge bg-primary bg-gradient rounded-1 mb-2">Name*</label>
                        <input type="text" name="name" value="<?= $staff['name']; ?>" maxlength="50" class="form-control" required>
                    </div>

                    <div class="col-md-12 mb-2">    
                        <label for="email" class="badge bg-primary bg-gradient rounded-1 mb-2">Email*</label>
                        <input type="email" name="remail" value="<?= $staff['email']; ?>" maxlength="50" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-2">    
                        <label for="phone" class="badge bg-primary bg-gradient rounded-1 mb-2">Phone*</label>
                        <input type="tel" name="rphone" value="<?= $staff['phone']; ?>" class="form-control" maxlength="11" required>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="password" class="badge bg-primary bg-gradient rounded-1 mb-2">New Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control">
                            <button type="button" id="togglePassword" class="btn btn-outline-secondary">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="confirmPassword" class="badge bg-primary bg-gradient rounded-1 mb-2">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
                            <button type="button" id="toggleConfirmPassword" class="btn btn-outline-secondary">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-12 d-flex justify-content-end">
                <button type="button" id="generatePassword" class="btn btn-danger "><i class="fas fa-random"></i>Generate Password</button>
                &nbsp;  <button type="submit" name="updateProfile" class="btn btn-primary">
    Save
</button>
</div>

            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle password visibility for the new password field
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

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
