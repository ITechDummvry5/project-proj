<?php include('includes/header.php'); ?>

<div class="container-fluid px-4"> 
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Update Certification of Calamity Information</h4>
            <a href="certification-calamity.php" class="btn btn-primary float-end">View Records</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <form action="doc-code.php" method="POST" enctype="multipart/form-data">
            <?php 
                // Fetch calamity record ID from URL and validate it
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>'.$paramValue.'</h5>';
                    return false;     
                }
                
                // Fetch calamity record data from the database based on the ID
                $calamityRecord = getById('certificationofcalamity', $paramValue);
                
                // Check if calamity record data is successfully retrieved
                if ($calamityRecord['status'] == 200) { 
                ?>
                <div class="row">
                    <!-- Hidden field to store calamity record ID -->
                    <input type="hidden" name="calamity_id" 
                    value="<?= htmlspecialchars($calamityRecord['data']['id']); ?>">        

                    <div class="col-md-6 mb-3">
                        <label for="calamitytypes" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Calamity Type</label>
                        <input type="text" class="form-control" id="calamitytypes" name="calamitytypes" 
                        value="<?= htmlspecialchars($calamityRecord['data']['calamitytypes'] ?? ''); ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="calamitydate" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Calamity Date</label>
                        <input type="date" class="form-control" id="calamitydate" name="calamitydate" 
                        value="<?= htmlspecialchars($calamityRecord['data']['calamitydate'] ?? ''); ?>" required>
                    </div>
                
                 <!-- Adding purpose field -->
    <div class="col-md-6 mb-3">
        <label for="purpose" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Purpose</label>
        <input type="text" class="form-control" id="purpose" name="purpose" 
        value="<?= htmlspecialchars($calamityRecord['data']['purpose'] ?? ''); ?>" required>
    </div>

          <!-- Barangay Councilor Dropdown -->
          <div class="col-md-6 mb-3">
    <label for="councilor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Select Yes or No</label>
    <select class="form-control" id="councilor" name="councilor" >
        <option value="">No, Duty Of The Day</option>
        <option value="." <?= isset($calamityRecord['data']['councilor']) && $calamityRecord['data']['councilor'] === '.' ? 'selected' : ''; ?>>Yes, Duty Of The Day</option>
    </select>
</div>

</div>
                <div class="row">
                    <!-- Submit button -->
                    <div class="col-md-12 text-right">
                        <button type="submit" name="updatecalamityinfo" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                } else {
                    // If the calamity record data was not found, display an error message
                    echo '<h5>'.$calamityRecord['message']. '</h5>';
                    return false;
                }
                ?>  
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>  
