<?php include('includes/header.php'); ?>

<div class="container-fluid px-4"> 
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Update Pwd Certificate</h4>
            <a href="pwdcertificate.php" class="btn btn-primary float-end">View Records</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <form action="doc-code.php" method="POST" enctype="multipart/form-data">
            <?php 
                // Fetch contractor ID from URL and check if it's valid
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>'.$paramValue.'</h5>';
                    return false;     
                }
                
                // Fetch pwd data from the database based on the contractor ID
                $pwd = getById('pwdcertificate', $paramValue);
                
                // Check if pwd data is successfully retrieved
                if ($pwd['status'] == 200) { 
                ?>
                <div class="row">
                    <!-- Hidden field to store pwd ID  also the id is walang kinalaman sa pag lalagay ng id sa pwdcertification.php since fetching lang sya para malaman kung sino tinatarget na id pwede ma iba or same take note that id is hidden so when e edit or update it should be same the id in here and update backend process-->
                    <input type="hidden" name="pwd_id" value="<?= htmlspecialchars($pwd['data']['id']); ?>">

                  

                    <!-- Age Input -->
                    <div class="col-md-6 mb-3">
                        <label for="age" class="form-label fw-bolder fs-6">Age</label>
                        <input type="text" class="form-control" id="age" name="age" 
                               value="<?= htmlspecialchars($pwd['data']['age'] ?? ''); ?>" 
                               readonly>
                    </div>

                    <!-- Civil Status Input -->
                    <div class="col-md-6 mb-3">
                        <label for="civilstatus" class="form-label fw-bolder fs-6">Civil Status</label>
                        <select class="form-control" id="civilstatus" name="civilstatus" required>
                            <option value="">Select Civil Status</option>
                            <option value="single" <?= isset($pwd['data']['civilstatus']) && $pwd['data']['civilstatus'] === 'single' ? 'selected' : ''; ?>>Single</option>
                            <option value="married" <?= isset($pwd['data']['civilstatus']) && $pwd['data']['civilstatus'] === 'married' ? 'selected' : ''; ?>>Married</option>
                        </select>
                    </div>

                    <!-- Submit button -->
                    <div class="col-md-12 text-right">
                        <button type="submit" name="updatepwdinfo" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                } else {
                    // If the pwd data was not found, display an error message
                    echo '<h5>'.$pwd['message']. '</h5>';
                    return false;
                }
                ?>  
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
