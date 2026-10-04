<?php include('includes/header.php'); ?>

<div class="container-fluid px-4"> 
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Update franchising Information</h4>
            <a href="franchising.php" class="btn btn-primary float-end">View Records</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <form action="doc-code.php" method="POST" enctype="multipart/form-data">
            <?php 
                // Fetch franchising ID from URL and check if it's valid
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>'.$paramValue.'</h5>';
                    return false;     
                }
                
                // Fetch franchising data from the database based on the ID
                $franchising = getById('franchising', $paramValue);
                
                // Check if franchising data is successfully retrieved
                if ($franchising['status'] == 200) { 
                ?>
                <div class="row">
                    <!-- Hidden field to store franchising ID -->
                    <input type="hidden" name="franchising_id" 
                    value="<?= htmlspecialchars($franchising['data']['id']); ?>">        

    <!-- Existing Franchising Code and Driver Name Fields -->
    <div class="col-md-12 mb-3">
        <label for="franchisingcode" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Franchising Cont No.</label>
        <input type="text" class="form-control" id="franchisingcode" name="franchisingcode" 
        value="<?= htmlspecialchars($franchising['data']['franchisingcode'] ?? ''); ?>" readonly>
    </div>

    <div class="col-md-6 mb-3">
        <label for="drivername" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Driver's Full Name</label>
        <input type="text" class="form-control" id="drivername" name="drivername" 
        value="<?= htmlspecialchars($franchising['data']['drivername'] ?? ''); ?>" required>
    </div>



    <!-- Existing License and Plate Number Fields -->
    <div class="col-md-6 mb-3">
        <label for="license" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Driver's License Number</label>
        <input type="text" class="form-control" id="license" name="license" maxlength="12" 
        value="<?= htmlspecialchars($franchising['data']['license'] ?? ''); ?>" required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="platenumber" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Plate Number</label>
        <input type="text" class="form-control" id="platenumber" name="platenumber" maxlength="7"
        value="<?= htmlspecialchars($franchising['data']['platenumber'] ?? ''); ?>" required>
    </div>


    <!-- Official Receipt and Additional Details Fields -->
    <div class="col-md-6 mb-3">
        <label for="receiptnumber" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Official Receipt Number</label>
        <input type="text" class="form-control" id="receiptnumber" name="receiptnumber"  
        value="<?= htmlspecialchars($franchising['data']['receiptnumber'] ?? ''); ?>" required>
    </div>

    <!-- New fields for OR Number, OR Date, Cedula No, Issued At, and Issued On -->
    <div class="col-md-6 mb-3">
        <label for="or_number" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">O.R. Number</label>
        <input type="text" class="form-control" id="or_number" name="or_number"  
        value="<?= htmlspecialchars($franchising['data']['or_number'] ?? ''); ?>" required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="or_date" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">O.R. Date</label>
        <input type="date" class="form-control" id="or_date" name="or_date" 
        value="<?= htmlspecialchars($franchising['data']['or_date'] ?? ''); ?>" required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="cedula_no" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Cedula Number</label>
        <input type="text" class="form-control" id="cedula_no" name="cedula_no" 
        value="<?= htmlspecialchars($franchising['data']['cedula_no'] ?? ''); ?>" required>
    </div>

  

    <div class="col-md-6 mb-3">
        <label for="issued_on" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Issued On</label>
        <input type="date" class="form-control" id="issued_on" name="issued_on" 
        value="<?= htmlspecialchars($franchising['data']['issued_on'] ?? ''); ?>" required>
    </div>
</div>

                    <!-- Submit button -->
                    <div class="col-md-12 text-right">
                        <button type="submit" name="updatefranchisinginfo" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                } else {
                    // If the franchising data was not found, display an error message
                    echo '<h5>'.$franchising['message']. '</h5>';
                    return false;
                }
                ?>  
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
