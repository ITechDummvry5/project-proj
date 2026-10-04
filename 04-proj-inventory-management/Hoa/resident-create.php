<?php include('hoainclude/header.php'); ?>
<!-- 4/25/2024 admin-create.php -->
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Add Resident</h4>
            <a href="resident.php" class="btn btn-primary float-end">View Resident</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <form action="resident-code.php" method="POST">

                <!-- Form fields -->
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="" class="badge bg-primary bg-gradient rounded-1">Name</label>
                        <input type="text" name="rname" class="form-control" required>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="" class="badge bg-primary bg-gradient rounded-1">Street Name</label>
                        <select name="phase" class="form-control form-select" required>
                            <option value="">Select Address</option>
                            <option value="amapola">Amapola</option>
                            <option value="margarita">Margarita</option>
                            <option value="aguada">Aguada</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="" class="badge bg-primary bg-gradient rounded-1">Block</label>
                        <select id="blockSelect" name="block" class="form-control form-select" required>
                            <option value="">Select Block</option>
                            <option value="1">Block 1</option>
                            <option value="2">Block 2</option>
                            <option value="3">Block 3</option>
                            <option value="4">Block 4</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="" class="badge bg-primary bg-gradient rounded-1">Lot</label>
                        <select id="lotSelect" name="lot" class="form-control form-select" required>
                            <option value="">Select Lot</option>
                            <!-- Options will be populated dynamically via JavaScript -->
                        </select>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="" class="badge bg-primary bg-gradient rounded-1">Email</label>
                        <input type="email" name="remail" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-2 allign-center">
                        <label for="" class="badge bg-primary bg-gradient rounded-1">Phone</label>
                        <input type="tel" name="rphone" class="form-control" minlength="11" maxlength="11" required>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="" class="badge bg-primary bg-gradient rounded-1">Temporary Password</label>
                        <div class="input-group">
                            <input type="password" name="rpassword" id="rpassword" class="form-control" required>
                            <button type="button" id="generatePassword" class="btn btn-outline-secondary">
                                Generate
                            </button>
                            <button type="button" id="togglePassword" class="btn btn-outline-secondary">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1 mt-3 d-none">
                        <label class="checkbox" for="status-checkbox">
                            <input type="checkbox" name="ban_resident" id="status-checkbox" checked="">
                            <span class="checkmark"></span>
                            <span class="label">
                                <span class="col-md-4">
                                    &nbsp;<span class="badge bg-secondary">Inactive</span>
                                </span>
                            </span>
                        </label>
                    </div>

                    <div class="col-md-12 mb-1 mt-3 text-end">
                        <button type="submit" name="savedResident" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('hoainclude/footer.php'); ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Password visibility toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('rpassword');

        togglePassword.addEventListener('click', () => {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            togglePassword.innerHTML = type === 'password' 
                ? '<i class="fas fa-eye-slash"></i>' 
                : '<i class="fas fa-eye"></i>';
        });

        // Password generator button
        const generatePasswordButton = document.getElementById('generatePassword');
        
        generatePasswordButton.addEventListener('click', function () {
            const password = generateRandomPassword();
            passwordField.value = password;
        });

        // Function to generate random password
        function generateRandomPassword() {
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            let password = "";
            for (let i = 0; i < 12; i++) {  // 12 characters long password
                const randomIndex = Math.floor(Math.random() * charset.length);
                password += charset[randomIndex];
            }
            return password;
        }
    });
</script>
