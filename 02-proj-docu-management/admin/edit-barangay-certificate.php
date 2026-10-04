<?php include('includes/header.php'); ?>

<div class="container-fluid px-4"> 
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Update Barangay Certificate</h4>
            <a href="barangay-certificate.php" class="btn btn-primary float-end">View Records</a>
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
                
                // Fetch brgycertificate data from the database based on the contractor ID
                $brgycertificate = getById('barangaycertificate', $paramValue);
                
                // Check if brgycertificate data is successfully retrieved
                if ($brgycertificate['status'] == 200) { 
                ?>
                <div class="row">
                    <!-- Hidden field to store brgycertificate ID -->
                    <input type="hidden" name="brgycertificate_id" value="<?= htmlspecialchars($brgycertificate['data']['id']); ?>">

                    <!-- Residence Since Input -->
                    <div class="col-md-6 mb-3">
                        <label for="since" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Residence since</label>
                        <input type="number" class="form-control" id="since" name="since" 
                               value="<?= htmlspecialchars($brgycertificate['data']['since'] ?? ''); ?>"
                              required>
                    </div>

                  

                    <!-- Birthday Input -->
                    <div class="col-md-6 mb-3">
                        <label for="birthday" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Birthday</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" 
                               value="<?= htmlspecialchars($brgycertificate['data']['birthday'] ?? ''); ?>" 
                               required min="1960-01-01" max="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <!-- Age Input -->
                    <div class="col-md-6 mb-3">
                        <label for="age" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Age</label>
                        <input type="text" class="form-control" id="age" name="age" 
                               value="<?= htmlspecialchars($brgycertificate['data']['age'] ?? ''); ?>" 
                               readonly>
                    </div>

                    <!-- Civil Status Input -->
<div class="col-md-6 mb-3">
    <label for="civilstatus" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Civil Status</label>
    <select class="form-control" id="civilstatus" name="civilstatus" required>
        <option value="">Select Civil Status</option>
        <option value="single" <?= isset($brgycertificate['data']['civilstatus']) && $brgycertificate['data']['civilstatus'] === 'single' ? 'selected' : ''; ?>>Single</option>
        <option value="married" <?= isset($brgycertificate['data']['civilstatus']) && $brgycertificate['data']['civilstatus'] === 'married' ? 'selected' : ''; ?>>Married</option>
        <option value="widow" <?= isset($brgycertificate['data']['civilstatus']) && $brgycertificate['data']['civilstatus'] === 'widow' ? 'selected' : ''; ?>>Widow</option>
        <option value="separated" <?= isset($brgycertificate['data']['civilstatus']) && $brgycertificate['data']['civilstatus'] === 'separated' ? 'selected' : ''; ?>>Separated</option>
    </select>
</div>


                    <!-- Birthplace Input -->
                    <div class="col-md-6 mb-3">
                        <label for="birthplace" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Birthplace</label>
                        <input type="text" class="form-control" id="birthplace" name="birthplace" 
                               value="<?= htmlspecialchars($brgycertificate['data']['birthplace'] ?? ''); ?>" required>
                    </div>

              

                    <div class="col-md-6 mb-3">
        <label for="services" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Select Service</label>
        <select class="form-control" id="services" name="services">
        <option value="school_sss_residential_id" <?= isset($brgycertificate['data']['services']) && $brgycertificate['data']['services'] === 'school_sss_residential_id' ? 'selected' : ''; ?>>School/SSS/Residential Identification</option>
<option value="local_overseas_employment" <?= isset($brgycertificate['data']['services']) && $brgycertificate['data']['services'] === 'local_overseas_employment' ? 'selected' : ''; ?>>Local/Overseas Employment</option>
<option value="electrical_water_connection" <?= isset($brgycertificate['data']['services']) && $brgycertificate['data']['services'] === 'electrical_water_connection' ? 'selected' : ''; ?>>Electrical/Water Connection</option>
<option value="bank_lending_transactions" <?= isset($brgycertificate['data']['services']) && $brgycertificate['data']['services'] === 'bank_lending_transactions' ? 'selected' : ''; ?>>Transactions with the Bank or Lending Institution</option>
<option value="firearms_drivers_license" <?= isset($brgycertificate['data']['services']) && $brgycertificate['data']['services'] === 'firearms_drivers_license' ? 'selected' : ''; ?>>Firearms Licensing/Driver's License</option>
<option value="financial_medical_burial_assistance" <?= isset($brgycertificate['data']['services']) && $brgycertificate['data']['services'] === 'financial_medical_burial_assistance' ? 'selected' : ''; ?>>Financial/Medical/Burial Assistance</option>
<option value="travel_transfer_residence" <?= isset($brgycertificate['data']['services']) && $brgycertificate['data']['services'] === 'travel_transfer_residence' ? 'selected' : ''; ?>>Travel/Transfer of Residence</option>
<option value="others" <?= isset($brgycertificate['data']['services']) && $brgycertificate['data']['services'] === 'others' ? 'selected' : ''; ?>>Others</option>

        </select>
    </div>
         <!-- DOCUMENT PUPOSE Input -->
         <div class="col-md-6 mb-3">
                        <label for="optionaluse" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Specify document type if <B>'Others'</B> is selected</label>
                        <input type="text" class="form-control" id="optionaluse" name="optionaluse" 
                               value="<?= htmlspecialchars($brgycertificate['data']['optionaluse'] ?? ''); ?>">
                    </div>

                                        <!-- Barangay Councilor Dropdown -->
<div class="col-md-6 mb-3">
    <label for="councilor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Select Yes or No</label>
    <select class="form-control" id="councilor" name="councilor" >
        <option value="">No, Duty Of The Day</option>
        <option value="." <?= isset($brgycertificate['data']['councilor']) && $brgycertificate['data']['councilor'] === '.' ? 'selected' : ''; ?>>Yes, Duty Of The Day</option>
    </select>
</div>


                    <!-- Submit button -->
                    <div class="col-md-12 text-right">
                        <button type="submit" name="updatebrgycertificateinfo" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                } else {
                    // If the brgycertificate data was not found, display an error message
                    echo '<h5>'.$brgycertificate['message']. '</h5>';
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
