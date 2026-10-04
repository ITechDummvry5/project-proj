<?php
require_once '../config/function.php';
// Add a check to restrict access to only secretarys
if ($_SESSION['loggedInUser']['role'] != 'secretary') {
    // Redirect or show an access denied message
    alertMessage();
    redirect('index2.php', 'Access Denied: You do not have permission to access this page.', 'error');
}
?>
<?php include 'includes/header.php'; 

// Retrieve form data from the session if it exists
$name = $_SESSION['form_data']['name'] ?? '';
$email = $_SESSION['form_data']['email'] ?? '';
$phone = $_SESSION['form_data']['phone'] ?? '';
$role = $_SESSION['form_data']['role'] ?? '';

// Display any error message
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}
?>

<!-- 4/25/2024 admin-create.php -->
<div class="container-fluid">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fs-4">Create Account</h4>
            <a href="account-view.php" class="btn btn-primary float-end">View Records</a> 
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">

                <!-- form email check function -->
                <div class="row text-gray-900">
                    <div class="col-md-6 mb-2">
                        <label for="name" class="badge bg-primary bg-gradient rounded-1 mb-2">Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($name); ?>" class="form-control" required id="validationCustom01">
                    </div>

                    <div class="col-md-6 mb-2">    
                        <label for="email" class="badge bg-primary bg-gradient rounded-1 mb-2">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($email); ?>" class="form-control" required>
                    </div>

                
                    <div class="col-md-6 mb-2 position-relative">
    <label class="form-label badge bg-primary bg-gradient rounded-1 mb-2" for="password">Temporary Password</label>
    <input type="password" name="password" id="password" class="form-control" maxlength="40" required autocomplete="new-password" />
    <span id="togglePassword" class="position-absolute" style="right: 20px; top: 40px; cursor: pointer;" onclick="togglePasswordVisibility()">
        <i class="fas fa-eye-slash" id="toggleIcon"></i>
    </span>
</div>

                    <div class="col-md-6 mb-2 align-center">  
                        <label for="phone" class="badge bg-primary bg-gradient rounded-1 mb-2">Phone</label>
                        <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($phone); ?>" maxlength="11" required>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="role" class="form-label badge bg-primary bg-gradient rounded-1 mb-2">Privilege</label>
                        <select name="role" required class="form-select form-control">
                            <option value="">Roles</option>
                            <option value="secretary" <?= $role == 'secretary' ? 'selected' : ''; ?>>Secretary</option>
                            <option value="staff" <?= $role == 'staff' ? 'selected' : ''; ?>>Staff</option>
                        </select>
                    </div>

                    <div class="col-md-4 mt-0" hidden>
                        <label class="checkbox" for="status-checkbox">
                            <input type="checkbox" name="is_ban" id="status-checkbox" checked="">
                            <span class="checkmark"></span>
                            <span class="label">
                                <span class="col-md-4">
                                    Unchecked <span class="badge bg-primary">Active</span>
                                    <br>
                                    Checked <span class="badge bg-secondary">Inactive</span>
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end">
    <!-- Generate Password Button -->
    <button type="button" id="generatePassword" class="btn btn-danger">
        <i class="fas fa-random"></i> Generate Password
    </button>  &nbsp; 
    <!-- Save Button -->
    <button type="submit" name="savedAdmin" class="btn btn-primary">Save</button>
</div>

                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle password visibility for the password field
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', () => {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            togglePassword.innerHTML = type === 'password' 
                ? '<i class="fas fa-eye-slash"></i>' 
                : '<i class="fas fa-eye"></i>';
        });

        // Generate random password
        const generatePasswordButton = document.getElementById('generatePassword');
        generatePasswordButton.addEventListener('click', () => {
            const randomPassword = generateRandomPassword();
            passwordField.value = randomPassword;
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