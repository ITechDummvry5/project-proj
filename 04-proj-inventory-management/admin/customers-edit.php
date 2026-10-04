<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Edit Contractor</h4>
            <a href="customers" class="btn btn-primary float-end">Go Back</a>
        </div>
        <div class="card-body">
            <!-- Displaying alert messages if there are any -->
            <?php alertMessage(); ?>

            <form action="code.php" method="POST">
                <?php 
                // Fetch contractor ID from URL and check if it's valid
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>'.$paramValue.'</h5>';
                    return false;     
                }
                
                // Fetch customer data from the database based on the contractor ID
                $customer = getById('customers', $paramValue);
                
                // Check if customer data is successfully retrieved
                if ($customer['status'] == 200) { 
                ?>
                <div class="row">
                    <!-- Hidden field to store customer ID -->
                    <input type="hidden" name="customersId" value="<?= htmlspecialchars($customer['data']['id']); ?>">

                    <!-- Company Name dropdown (select input) -->
                    <div class="col-md-6 mb-3">
    <label class="badge bg-primary bg-gradient rounded-1">Company Name *</label>
    <select name="name" class="form-select" <?= $_SESSION['loggedInUser']['role'] === 'superadmin' ? '' : 'disabled'; ?> required>
        <option value="Jp Luis Construction" <?= $customer['data']['name'] === 'Jp Luis Construction' ? 'selected' : ''; ?>>Jp Luis Construction</option>
        <option value="Dexter Construction" <?= $customer['data']['name'] === 'Dexter Construction' ? 'selected' : ''; ?>>Dexter Construction</option>
        <option value="Coxx Construction" <?= $customer['data']['name'] === 'Coxx Construction' ? 'selected' : ''; ?>>Coxx Construction</option>
    </select>
    <?php if ($_SESSION['loggedInUser']['role'] !== 'superadmin'): ?>
    <!-- Hidden input to ensure value is submitted -->
    <input type="hidden" name="name" value="<?= htmlspecialchars($customer['data']['name']); ?>">
    <?php endif; ?>
</div>


                    <!-- Email input -->
                    <div class="col-md-6 mb-3">
                        <label class="badge bg-primary bg-gradient rounded-1">Email *</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($customer['data']['email']); ?>" class="form-control text-muted" <?= $_SESSION['loggedInUser']['role'] === 'superadmin' ? '' : 'readonly'; ?>>
                    </div>

                    <!-- Phone input -->
                    <div class="col-md-6 mb-3">
                        <label class="badge bg-primary bg-gradient rounded-1">Phone *</label>
                        <input type="tel" name="phone" value="<?= htmlspecialchars($customer['data']['phone']); ?>" class="form-control text-muted" minlength="11" maxlength="11" <?= $_SESSION['loggedInUser']['role'] === 'superadmin' ? '' : 'readonly'; ?> required>
                    </div>

                    <!-- Status checkbox for admin role -->
                    <?php if ($_SESSION['loggedInUser']['role'] === 'admin'): ?>
                    <div class="col-md-5 mt-3">
                        <label class="checkbox" for="status-checkbox">
                            <input type="checkbox" id="status-checkbox" name="status" value="1" <?= $customer['data']['status'] == 1 ? 'checked' : ''; ?> style="width:45px; height:25px;">
                          <span class="checkmark"></span>
                            <span class="label">
                            &nbsp;<span class="badge bg-primary">Complete Transaction</span>
                            </span>
                        </label>
                    </div>
                    <?php endif; ?>

                    <!-- Submit button -->
                    <div class="col-md-12 text-end">
                        <button type="submit" name="updateCustomers" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                } else {
                    // If the customer data was not found, display an error message
                    echo '<h5>'.$customer['message']. '</h5>';
                    return false;
                }
                ?>  
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
