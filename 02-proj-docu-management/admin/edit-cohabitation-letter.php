<?php include('includes/header.php'); ?>

<div class="container-fluid px-4"> 
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Update Cohabitation Letter Information</h4>
            <a href="cohabitation-letter.php" class="btn btn-primary float-end">View Records</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <form action="doc-code.php" method="POST" enctype="multipart/form-data">
            <?php 
                // Fetch cohabitation letter ID from URL and check if it's valid
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>'.$paramValue.'</h5>';
                    return false;     
                }
                
                // Fetch cohabitation letter data from the database based on the ID
                $cohabitationLetter = getById('cohabitationletter', $paramValue);
                
                // Check if cohabitation letter data is successfully retrieved
                if ($cohabitationLetter['status'] == 200) { 
                ?>
                <div class="row">
                    <!-- Hidden field to store cohabitation letter ID -->
                    <input type="hidden" name="cohabitationletter_id" 
                    value="<?= htmlspecialchars($cohabitationLetter['data']['id']); ?>">        

                    <div class="col-md-6 mb-3">
                        <label for="namefor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Name of Partner</label>
                        <input type="text" class="form-control" id="namefor" name="namefor" 
                        value="<?= htmlspecialchars($cohabitationLetter['data']['namefor'] ?? ''); ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="purposefor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Purpose For</label>
                        <input type="text" class="form-control" id="purposefor" name="purposefor" 
                        value="<?= htmlspecialchars($cohabitationLetter['data']['purposefor'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="bornfor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Born</label>
                        <input type="date" class="form-control" id="bornfor" name="bornfor" 
                        value="<?= htmlspecialchars($cohabitationLetter['data']['bornfor'] ?? ''); ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="partnerbornfor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Partner Born</label>
                        <input type="date" class="form-control" id="partnerbornfor" name="partnerbornfor" 
                        value="<?= htmlspecialchars($cohabitationLetter['data']['partnerbornfor'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="yearslivein" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Years Live In</label>
                        <input type="number" class="form-control" id="yearslivein" name="yearslivein" 
                        value="<?= htmlspecialchars($cohabitationLetter['data']['yearslivein'] ?? ''); ?>" min="0" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="sincedateliving" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Since Date Living</label>
                        <input type="date" class="form-control" id="sincedateliving" name="sincedateliving" 
                        value="<?= htmlspecialchars($cohabitationLetter['data']['sincedateliving'] ?? ''); ?>" required>
                    </div>


                              <!-- Barangay Councilor Dropdown -->
          <div class="col-md-12 mb-3">
    <label for="councilor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Select Yes or No</label>
    <select class="form-control" id="councilor" name="councilor" >
        <option value="">No, Duty Of The Day</option>
        <option value="." <?= isset($cohabitationLetter['data']['councilor']) && $cohabitationLetter['data']['councilor'] === '.' ? 'selected' : ''; ?>>Yes, Duty Of The Day</option>
    </select>
</div>
</div>

                <div class="row">
                    <!-- Submit button -->
                    <div class="col-md-12 text-right">
                        <button type="submit" name="updatecohabitationletterinfo" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                } else {
                    // If the cohabitation letter data was not found, display an error message
                    echo '<h5>'.$cohabitationLetter['message']. '</h5>';
                    return false;
                }
                ?>  
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?> 
