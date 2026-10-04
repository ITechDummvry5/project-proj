<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Update Certification of Legitimacy</h4>
            <a href="certification-legitimacy.php" class="btn btn-primary float-end">View Records</a>
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
                
                // Fetch certificationoflegitimacy data from the database based on the ID
                $certification = getById('certificationoflegitimacy', $paramValue);
                
                // Check if certification data is successfully retrieved
                if ($certification['status'] == 200) { 
                ?>
                <div class="row">
                    <!-- Hidden field to store certification ID -->
                    <input type="hidden" name="certificationoflegitimacy_id" value="<?= htmlspecialchars($certification['data']['id']); ?>">
                    <!-- Work Input -->
                    <div class="col-md-6 mb-3">
                        <label for="work" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Work/s</label>
                        <input type="text" class="form-control" id="work" name="work" 
                               value="<?= htmlspecialchars($certification['data']['work'] ?? ''); ?>" required>
                    </div>

                    <!-- Length of Work (Years) Input -->
                    <div class="col-md-6 mb-3">
                        <label for="yearsofwork" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Length of Work (Years)</label>
                        <input type="number" class="form-control" id="yearsofwork" name="yearsofwork" 
                               value="<?= htmlspecialchars($certification['data']['yearsofwork'] ?? ''); ?>" required>
                    </div>

                     <!-- Length age Input -->
                     <div class="col-md-6 mb-3">
                        <label for="age" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Age</label>
                        <input type="number" class="form-control" id="age" name="age" 
                               value="<?= htmlspecialchars($certification['data']['age'] ?? ''); ?>" required>
                    </div>
                           <!-- Barangay Councilor Dropdown -->
          <div class="col-md-6 mb-3">
    <label for="councilor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Select Yes or No</label>
    <select class="form-control" id="councilor" name="councilor" >
        <option value="">No, Duty Of The Day</option>
        <option value="." <?= isset($certification['data']['councilor']) && $certification['data']['councilor'] === '.' ? 'selected' : ''; ?>>Yes, Duty Of The Day</option>
    </select>
</div>

                     <!-- Used for Input -->
                     <div class="col-md-12 mb-3">
                        <label for="usedfor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Document Whom Used For</label>
                        <input type="text" class="form-control" id="usedfor" name="usedfor" 
                               value="<?= htmlspecialchars($certification['data']['usedfor'] ?? ''); ?>">
                    </div>

                    <!-- Submit button -->
                    <div class="col-md-12 text-right">
                        <button type="submit" name="updatecertificationoflegitimacyinfo" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                } else {
                    // If the certification data was not found, display an error message
                    echo '<h5>'.$certification['message']. '</h5>';
                    return false;
                }
                ?>  
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
