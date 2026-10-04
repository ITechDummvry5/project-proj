<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Update Certification of Source of Income</h4>
            <a href="certification-source.php" class="btn btn-primary float-end">View Records</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <form action="doc-code.php" method="POST" enctype="multipart/form-data">
            <?php 
                // Fetch certification ID from URL and check if it's valid
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>'.$paramValue.'</h5>';
                    return false;     
                }
                
                // Fetch certification data from the database based on the ID
                $certificationsource = getById('certificationofsourceofincome', $paramValue);
                
                // Check if certification data is successfully retrieved
                if ($certificationsource['status'] == 200) { 
                ?>
                <div class="row">
                    <!-- Hidden field to store certification ID -->
                    <input type="hidden" name="certificationsource_id" 
                    value="<?= htmlspecialchars($certificationsource['data']['id']); ?>">        

                    <div class="col-md-6 mb-3">
                        <label for="work" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Job</label>
                        <input type="text" class="form-control" id="work" name="work" 
                        value="<?= htmlspecialchars($certificationsource['data']['work'] ?? ''); ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="age" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Age</label>
                        <input type="number" class="form-control" id="age" name="age" 
                        value="<?= htmlspecialchars($certificationsource['data']['age'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="usedfor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Select document whom used for</label>
                        <input type="text" class="form-control" id="usedfor" name="usedfor" 
                        value="<?= htmlspecialchars($certificationsource['data']['usedfor'] ?? ''); ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="income" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Monthly Income</label>
                        <input type="text" class="form-control" id="income" name="income" 
                        value="<?= htmlspecialchars($certificationsource['data']['income'] ?? ''); ?>" required>
                    </div>
                
                       <!-- Barangay Councilor Dropdown -->
          <div class="col-md-12 mb-3">
    <label for="councilor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Select Yes or No</label>
    <select class="form-control" id="councilor" name="councilor" >
        <option value="">No, Duty Of The Day</option>
        <option value="." <?= isset($certificationsource['data']['councilor']) && $certificationsource['data']['councilor'] === '.' ? 'selected' : ''; ?>>Yes, Duty Of The Day</option>
    </select>
</div>
</div>

                <div class="row">                   
                    <!-- Submit button -->
                    <div class="col-md-12 text-right">
                        <button type="submit" name="updatecertificationsourceinfo" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                } else {
                    // If the certification data was not found, display an error message
                    echo '<h5>'.$certificationsource['message']. '</h5>';
                    return false;
                }
                ?>  
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
