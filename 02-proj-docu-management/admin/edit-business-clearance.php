<?php include('includes/header.php'); ?>

<div class="container-fluid px-4"> 
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Update Business Clearance</h4>
            <a href="business-clearance.php" class="btn btn-primary float-end">View Records</a>
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
                
                // Fetch businessclearance data from the database based on the contractor ID
                $businessclearance = getById('businessclearance', $paramValue);
                
                // Check if businessclearance data is successfully retrieved
                if ($businessclearance['status'] == 200) { 
                ?>
                <div class="row">
                    <!-- Hidden field to store businessclearance ID -->
                    <input type="hidden" name="businessclearance_id" 
                    value="<?= htmlspecialchars($businessclearance['data']['id']); ?>">        

<div class="col-md-6 mb-3">
    <label for="businesscode" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Business Code</label>
    <input type="text" class="form-control" id="businesscode" name="businesscode" 
    value="<?= htmlspecialchars($businessclearance['data']['businesscode'] ?? ''); ?>" readonly>
</div>

<div class="col-md-6 mb-3">
    <label for="businessname" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Business Name</label>
    <input type="text" class="form-control" id="businessname" name="businessname" 
    value="<?= htmlspecialchars($businessclearance['data']['businessname'] ?? ''); ?>" required>
</div>
</div>

<div class="row">                   
<div class="col-md-6 mb-3">
    <label for="location" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Location</label>
    <input type="text" class="form-control" id="location" name="location"
     value="<?= htmlspecialchars($businessclearance['data']['location'] ?? ''); ?>" required>
</div>

<div class="col-md-6 mb-3">
    <label for="manager" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Operation/Manager</label>
    <input type="text" class="form-control" id="manager" name="manager" 
    value="<?= htmlspecialchars($businessclearance['data']['manager'] ?? ''); ?>" required>
</div>
</div>

<div class="row">                   
<div class="col-md-6 mb-3">
    <label for="address" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Address/Business</label>
    <input type="text" class="form-control" id="address" name="address" 
    value="<?= htmlspecialchars($businessclearance['data']['address'] ?? ''); ?>" required>
</div>

<div class="col-md-6 mb-3">
    <label for="or_number" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">O.R Number</label>
    <input type="text" class="form-control" id="or_number" name="or_number"
     value="<?= htmlspecialchars($businessclearance['data']['or_number'] ?? ''); ?>" required>
</div>
                    <!-- Submit button -->
                    <div class="col-md-12 text-right">
                        <button type="submit" name="updatebusinessclearanceinfo" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                } else {
                    // If the businessclearance data was not found, display an error message
                    echo '<h5>'.$businessclearance['message']. '</h5>';
                    return false;
                }
                ?>  
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
