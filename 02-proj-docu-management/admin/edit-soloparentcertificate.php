<?php include('includes/header.php'); ?>

<div class="container-fluid px-4"> 
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Update Solo Parent Certificate</h4>
            <a href="soloparentcertificate.php" class="btn btn-primary float-end">View Records</a>
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
                
                // Fetch soloparentcertificate data from the database based on the contractor ID
                $soloparentcertificate = getById('soloparentcertificate', $paramValue);
                
                // Check if soloparentcertificate data is successfully retrieved
                if ($soloparentcertificate['status'] == 200) { 
                ?>
               <div class="row">
    <!-- Hidden field to store soloparentcertificate ID -->
    <input type="hidden" name="soloparentcertificate_id" value="<?= htmlspecialchars($soloparentcertificate['data']['id']); ?>">

    <!-- Residence Since Input -->
    <div class="col-md-6 mb-3">
        <label for="since" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Residence since</label>
        <input type="number" class="form-control" id="since" name="since" 
               value="<?= htmlspecialchars($soloparentcertificate['data']['since'] ?? ''); ?>"
              required>
    </div>

    <!-- Age Input -->
    <div class="col-md-6 mb-3">
        <label for="age" class="form-label fw-bolder fs- badge bg-primary bg-gradient rounded-1">Age</label>
        <input type="text" class="form-control" id="age" name="age" 
               value="<?= htmlspecialchars($soloparentcertificate['data']['age'] ?? ''); ?>">
    </div>

    <div class="col-md-6 mb-3">
    <label for="category" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Common law</label>
    <select class="form-control" id="category" name="category" required>
        <option value="a1" <?= ($soloparentcertificate['data']['category'] === 'a1') ? 'selected' : ''; ?>>a1 - Magulang na nagsilang ng bata na biktima ng panggagahasa</option>
        <option value="a2" <?= ($soloparentcertificate['data']['category'] === 'a2') ? 'selected' : ''; ?>>a2 - Biyuda/Biyudo</option>
        <option value="a3" <?= ($soloparentcertificate['data']['category'] === 'a3') ? 'selected' : ''; ?>>a3 - Asawa na nakakulong at / ohinatulang mabilango</option>
        <option value="a4" <?= ($soloparentcertificate['data']['category'] === 'a4') ? 'selected' : ''; ?>>a4 - May mental o pisikal na kapansanan ang asawa / partner</option>
        <option value="a5" <?= ($soloparentcertificate['data']['category'] === 'a5') ? 'selected' : ''; ?>>a5 - Hiwalay sa asawa</option>
        <option value="a6" <?= ($soloparentcertificate['data']['category'] === 'a6') ? 'selected' : ''; ?>>a6 - Napawalang-bisa o annulled ang kasal</option>
        <option value="a7" <?= ($soloparentcertificate['data']['category'] === 'a7') ? 'selected' : ''; ?>>a7 - Inabandona ng asawa o kinakasama</option>
        <option value="b" <?= ($soloparentcertificate['data']['category'] === 'b') ? 'selected' : ''; ?>>b - Asawa ng OFW/Solo Parent na kamag-anak ng OFW</option>
        <option value="c" <?= ($soloparentcertificate['data']['category'] === 'c') ? 'selected' : ''; ?>>c - Hindi kasal na piniling palakihin ang anak na mag-isa</option>
        <option value="d" <?= ($soloparentcertificate['data']['category'] === 'd') ? 'selected' : ''; ?>>d - Solong legal guardian, adoptive or foster parent</option>
        <option value="e" <?= ($soloparentcertificate['data']['category'] === 'e') ? 'selected' : ''; ?>>e - Sinumang miyembrong pamilya within 4th degree na tumatayo bilang head of the family ng mga bata</option>
        <option value="f" <?= ($soloparentcertificate['data']['category'] === 'f') ? 'selected' : ''; ?>>f - Babaeng buntis na mag-isa ng mangangalaga at susuporta sa isisilang pa lang na anak</option>
    </select>
</div>

                         <!-- Barangay Councilor Dropdown -->
                         <div class="col-md-6 mb-3">
    <label for="councilor" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Select Yes or No</label>
    <select class="form-control" id="councilor" name="councilor" >
        <option value="">No, Duty Of The Day</option>
        <option value="." <?= isset($soloparentcertificate['data']['councilor']) && $soloparentcertificate['data']['councilor'] === '.' ? 'selected' : ''; ?>>Yes, Duty Of The Day</option>
    </select>
</div>

    <!-- Children Inputs -->
    <div class="col-md-6 mb-3">
        <label for="children1" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 1 Name</label>
        <input type="text" class="form-control" id="children1" name="children1" 
               value="<?= htmlspecialchars($soloparentcertificate['data']['children1'] ?? ''); ?>"
               placeholder="Enter child 1 name">
    </div>

    <div class="col-md-6 mb-3">
        <label for="children1_birthday" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 1 Birthday</label>
        <input type="date" class="form-control" id="children1_birthday" name="children1_birthday" 
               value="<?= htmlspecialchars($soloparentcertificate['data']['children1_birthday'] ?? ''); ?>" 
               placeholder="Enter child 1 birthday">
    </div>

    <div class="col-md-6 mb-3">
        <label for="children2" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 2 Name</label>
        <input type="text" class="form-control" id="children2" name="children2" 
               value="<?= htmlspecialchars($soloparentcertificate['data']['children2'] ?? ''); ?>"
               placeholder="Enter child 2 name">
    </div>

    <div class="col-md-6 mb-3">
        <label for="children2_birthday" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 2 Birthday</label>
        <input type="date" class="form-control" id="children2_birthday" name="children2_birthday" 
               value="<?= htmlspecialchars($soloparentcertificate['data']['children2_birthday'] ?? ''); ?>" 
               placeholder="Enter child 2 birthday">
    </div>

    <div class="col-md-6 mb-3">
        <label for="children3" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 3 Name</label>
        <input type="text" class="form-control" id="children3" name="children3" 
               value="<?= htmlspecialchars($soloparentcertificate['data']['children3'] ?? ''); ?>"
               placeholder="Enter child 3 name">
    </div>

    <div class="col-md-6 mb-3">
        <label for="children3_birthday" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 3 Birthday</label>
        <input type="date" class="form-control" id="children3_birthday" name="children3_birthday" 
               value="<?= htmlspecialchars($soloparentcertificate['data']['children3_birthday'] ?? ''); ?>" 
               placeholder="Enter child 3 birthday">
    </div>

    <div class="col-md-6 mb-3">
        <label for="children4" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 4 Name</label>
        <input type="text" class="form-control" id="children4" name="children4" 
               value="<?= htmlspecialchars($soloparentcertificate['data']['children4'] ?? ''); ?>"
               placeholder="Enter child 4 name">
    </div>

    <div class="col-md-6 mb-3">
        <label for="children4_birthday" class="form-label fw-bolder fs-6 badge bg-primary bg-gradient rounded-1">Child 4 Birthday</label>
        <input type="date" class="form-control" id="children4_birthday" name="children4_birthday" 
               value="<?= htmlspecialchars($soloparentcertificate['data']['children4_birthday'] ?? ''); ?>" 
               placeholder="Enter child 4 birthday">
    </div>
</div>

                    <!-- Submit button -->
                    <div class="col-md-12 text-right">
                        <button type="submit" name="updatesoloparentcertificateinfo" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                } else {
                    // If the soloparentcertificate data was not found, display an error message
                    echo '<h5>'.$soloparentcertificate['message']. '</h5>';
                    return false;
                }
                ?>  
            </form>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>
