<?php include('hoainclude/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Edit Resident</h4>
            <a href="resident" class="btn btn-primary float-end">Go Back</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <form action="resident-code.php" method="POST">
                <?php 
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $residentId = $_GET['id'];
                } else {
                    echo '<h5>No ID Found! Please go back and try again.</h5>';
                    return false;
                }

                $residentData = getById('residents', $residentId);
                if ($residentData) {
                    if ($residentData['status'] == 200) {
                ?> 
                <!-- hidden id -->
                <input type="hidden" name="residentId" value="<?= $residentData['data']['id'] ?? ''; ?>">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="badge bg-primary bg-gradient rounded-1 mb-2">Name *</label>
                        <input type="text" name="rname" value="<?= $residentData['data']['rname'] ?? ''; ?>" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label class="badge bg-primary bg-gradient rounded-1 mb-2">Address</label>
                        <input type="text" name="address" value="<?= $residentData['data']['address'] ?? ''; ?>" class="form-control" required>
                    </div>
               
                    <div class="col-md-6 mb-2">    
                        <label class="badge bg-primary bg-gradient rounded-1 mb-2">Email</label>
                        <input type="email" name="remail" value="<?= $residentData['data']['remail'] ?? ''; ?>" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label class="badge bg-primary bg-gradient rounded-1 mb-2">Phone *</label>
                        <input type="tel" name="rphone" value="<?= $residentData['data']['rphone'] ?? ''; ?>" class="form-control" minlength="11" maxlength="11" required>
                    </div>

                    <div class="col-md-3 mb-2 d-none">  
                        <label class="badge bg-primary bg-gradient rounded-1 mb-2">Password</label>
                        <input hidden type="password" name="rpassword" class="form-control">
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="checkbox" for="status-checkbox">
                            <input type="checkbox" id="status-checkbox" name="ban_resident" <?= ($residentData['data']['ban_resident'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <span class="checkmark"></span>
                            <span class="label">
                                <span class="col-md-5">
                                    &nbsp;<span class="badge bg-secondary">Inactive</span>
                                </span>
                            </span>
                        </label>
                    </div>

                    <div class="col-md-12 mt-1 text-end">
                        <button type="submit" name="updateResident" class="btn btn-primary">Update</button>
                    </div>
                </div>

                <?php
                    } else {
                        echo '<h5>' . htmlspecialchars($residentData['message']) . '</h5>';
                    }
                } else {
                    echo '<h5>Something Went Wrong! Please try again.</h5>';
                    return false;
                }
                ?>
            </form>
        </div>
    </div>
</div>

<?php include('hoainclude/footer.php'); ?>
