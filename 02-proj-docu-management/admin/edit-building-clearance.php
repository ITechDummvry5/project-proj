<?php include('includes/header.php'); ?>

<div class="container-fluid px-4"> 
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Update Building Clearance</h4>
            <a href="building-clearance.php" class="btn btn-primary float-end">View Records</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <form action="doc-code.php" method="POST" enctype="multipart/form-data">
            <?php 
                // Fetch building clearance ID from URL and check if it's valid
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>'.$paramValue.'</h5>';
                    return false;     
                }
                
                // Fetch building clearance data from the database based on the ID
                $buildingclearance = getById('buildingclearance', $paramValue);
                
                // Check if building clearance data is successfully retrieved
                if ($buildingclearance['status'] == 200) { 
                ?>
       <div class="row">
    <!-- Hidden field to store building clearance ID -->
    <input type="hidden" name="buildingclearance_id" 
           value="<?= htmlspecialchars($buildingclearance['data']['id']); ?>">        

    <div class="col-md-12 mb-3">
        <label for="buildingcode" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Building Code</label>
        <input type="text" class="form-control" id="buildingcode" name="buildingcode" 
               value="<?= htmlspecialchars($buildingclearance['data']['buildingcode'] ?? ''); ?>" readonly>
    </div>

    <div class="col-md-6 mb-3">
        <label for="floorarea" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Floor Area</label>
        <input type="text" class="form-control" id="floorarea" name="floorarea" 
               value="<?= htmlspecialchars($buildingclearance['data']['floorarea'] ?? ''); ?>" required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="construction" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Construction</label>
        <input type="text" class="form-control" id="construction" name="construction" 
               value="<?= htmlspecialchars($buildingclearance['data']['construction'] ?? ''); ?>" required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="usedfor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Used For</label>
        <input type="text" class="form-control" id="usedfor" name="usedfor" 
               value="<?= htmlspecialchars($buildingclearance['data']['usedfor'] ?? ''); ?>" required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="location" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Location</label>
        <input type="text" class="form-control" id="location" name="location" 
               value="<?= htmlspecialchars($buildingclearance['data']['location'] ?? ''); ?>" required>
    </div>

    <div class="col-md-6 mb-3">
    <fieldset class="border p-2 rounded">
        <legend class="w-auto px-2 text-primary fw-bold fs-6">O.R. Details</legend>

        <label for="or_number" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">O.R. Number (Optional)</label>
        <input type="text" class="form-control" id="or_number" name="or_number"
               value="<?= htmlspecialchars($buildingclearance['data']['or_number'] ?? ''); ?>" >

        <label for="or_date" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1 mt-2">O.R. Date (Optional)</label>
        <input type="date" class="form-control" id="or_date" name="or_date"
               value="<?= htmlspecialchars($buildingclearance['data']['or_date'] ?? ''); ?>" >
    </fieldset>
</div>

<div class="col-md-6 mb-3">
    <fieldset class="border p-2 rounded">
        <legend class="w-auto px-2 text-primary fw-bold fs-6">Cedula Details</legend>

        <label for="cedula_no" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Cedula Number (Optional)</label>
        <input type="text" class="form-control" id="cedula_no" name="cedula_no"
               value="<?= htmlspecialchars($buildingclearance['data']['cedula_no'] ?? ''); ?>" >

        <label for="issued_at" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1 mt-2">Issued At (Optional)</label>
        <input type="text" class="form-control" id="issued_at" name="issued_at"
               value="<?= htmlspecialchars($buildingclearance['data']['issued_at'] ?? ''); ?>" >

        <label for="issued_on" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1 mt-2">Issued On (Optional)</label>
        <input type="date" class="form-control" id="issued_on" name="issued_on"
               value="<?= htmlspecialchars($buildingclearance['data']['issued_on'] ?? ''); ?>" >
    </fieldset>
</div>

</div>

                               
                    <div class="col-md-12 text-right">
                        <button type="submit" name="updatebuildingclearanceinfo" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                } else {
                    // If building clearance data was not found, display an error message
                    echo '<h5>'.$buildingclearance['message']. '</h5>';
                    return false;
                }
                ?>  
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
