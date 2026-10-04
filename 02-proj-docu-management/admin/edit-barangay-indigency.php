<?php include('includes/header.php'); ?>

<div class="container-fluid px-4"> 
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Update Barangay Indigency</h4>
            <a href="barangay-indigency.php" class="btn btn-primary float-end">View Records</a>
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
                
                // Fetch brgyindigency data from the database based on the contractor ID
                $brgyindigency = getById('barangayindigency', $paramValue);
                
                // Check if brgyindigency data is successfully retrieved
                if ($brgyindigency['status'] == 200) { 
                ?>
                <div class="row">
                    <!-- Hidden field to store brgyindigency ID -->
                    <input type="hidden" name="brgyindigency_id" value="<?= htmlspecialchars($brgyindigency['data']['id']); ?>">

                    <!-- Residence Since Input -->
                    <div class="col-md-6 mb-3">
                        <label for="since" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Residence since</label>
                        <input type="number" class="form-control" id="since" name="since" 
                               value="<?= htmlspecialchars($brgyindigency['data']['since'] ?? ''); ?>"
                              required>
                    </div>

                   

                    <!-- Birthday Input -->
                    <div class="col-md-6 mb-3">
                        <label for="birthday" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Birthday</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" 
                               value="<?= htmlspecialchars($brgyindigency['data']['birthday'] ?? ''); ?>" 
                               required min="1960-01-01" max="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <!-- Age Input -->
                    <div class="col-md-6 mb-3">
                        <label for="age" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Age</label>
                        <input type="text" class="form-control" id="age" name="age" 
                               value="<?= htmlspecialchars($brgyindigency['data']['age'] ?? ''); ?>" 
                               readonly>
                    </div>

                    <!-- Civil Status Input -->
                   <div class="col-md-6 mb-3">
    <label for="civilstatus" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Civil Status</label>
    <select class="form-control" id="civilstatus" name="civilstatus" required>
        <option value="">Select Civil Status</option>
        <option value="single" <?= isset($brgyindigency['data']['civilstatus']) && $brgyindigency['data']['civilstatus'] === 'single' ? 'selected' : ''; ?>>Single</option>
        <option value="married" <?= isset($brgyindigency['data']['civilstatus']) && $brgyindigency['data']['civilstatus'] === 'married' ? 'selected' : ''; ?>>Married</option>
        <option value="widow" <?= isset($brgyindigency['data']['civilstatus']) && $brgyindigency['data']['civilstatus'] === 'widow' ? 'selected' : ''; ?>>Widow</option>
        <option value="separated" <?= isset($brgyindigency['data']['civilstatus']) && $brgyindigency['data']['civilstatus'] === 'separated' ? 'selected' : ''; ?>>Separated</option>
    </select>
</div>


                    <!-- Birthplace Input -->
                    <div class="col-md-6 mb-3">
                        <label for="birthplace" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Birthplace</label>
                        <input type="text" class="form-control" id="birthplace" name="birthplace" 
                               value="<?= htmlspecialchars($brgyindigency['data']['birthplace'] ?? ''); ?>" required>
                    </div>

                  
                                        
                    <!-- Barangay Councilor Dropdown -->
<div class="col-md-6 mb-3">
    <label for="councilor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Select Yes or No</label>
    <select class="form-control" id="councilor" name="councilor" >
        <option value="">No, Duty Of The Day</option>
        <option value="." <?= isset($brgyindigency['data']['councilor']) && $brgyindigency['data']['councilor'] === '.' ? 'selected' : ''; ?>>Yes, Duty Of The Day</option>
    </select>
</div>

     <!-- DOCUMENT PUPOSE Input -->
     <div class="col-md-12 mb-3">
                        <label for="optionaluse" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Document Used For</label>
                        <input type="text" class="form-control" id="optionaluse" name="optionaluse" 
                               value="<?= htmlspecialchars($brgyindigency['data']['optionaluse'] ?? ''); ?>">
                    </div>



                    <!-- Submit button -->
                    <div class="col-md-12 text-right">
                        <button type="submit" name="updatebrgyindigencyinfo" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                } else {
                    // If the brgyindigency data was not found, display an error message
                    echo '<h5>'.$brgyindigency['message']. '</h5>';
                    return false;
                }
                ?>  
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('birthday').addEventListener('change', function () {
        const birthday = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - birthday.getFullYear();
        const monthDiff = today.getMonth() - birthday.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthday.getDate())) {
            age--;
        }
        
        document.getElementById('age').value = age;
    });

    // Auto calculate age if birthday already exists
    const existingBirthday = document.getElementById('birthday').value;
    if (existingBirthday) {
        const birthdayEvent = new Event('change');
        document.getElementById('birthday').dispatchEvent(birthdayEvent);
    }
</script>

<?php include('includes/footer.php'); ?>
