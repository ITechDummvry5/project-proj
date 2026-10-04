<?php include('includes/header.php'); ?>

<div class="container-fluid px-4"> 
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Edit Account</h4>
            <a href="admins" class="btn btn-primary float-end">Go Back</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">

                <?php 
                    if (isset($_GET['id'])) {
                        if ($_GET['id'] != '') {
                            $adminId = $_GET['id'];
                        } else {
                            echo '<h5>No Id Found!</h5>';
                            return false;
                        }
                    } else { 
                        echo '<h5>Go BACK And SEE!!</h5>';
                        return false;
                    }
                    $adminData = getById('admins', $adminId);
                    if ($adminData) {
                        if ($adminData['status'] == 200) {
                            // Check if the logged-in user is editing their own account
                            $isEditingOwnAccount = $_SESSION['loggedInUser']['user_id'] == $adminId;

                            ?> 
                            <!-- hidden id -->
                            <input type="hidden" name="adminId" value="<?= $adminData['data']['id']; ?>">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="badge bg-primary bg-gradient rounded-1">Name *</label>
                                    <input type="text" name="name" value="<?= $adminData['data']['name']; ?>" class="form-control text-muted" required>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="badge bg-primary bg-gradient rounded-1">Remark</label>
                                    <input type="text" name="remark" value="<?= $adminData['data']['remark']; ?>" class="form-control text-muted">
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="badge bg-primary bg-gradient rounded-1">Email *</label>
                                    <input type="email" name="email" value="<?= $adminData['data']['email']; ?>" class="form-control text-muted" required>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="badge bg-primary bg-gradient rounded-1">Phone *</label>
                                    <input type="tel"  name="phone"  value="<?= $adminData['data']['phone']; ?>" class="form-control text-muted"  maxlength="11" required>
                                </div>

                             
                                <div class="col-md-3 mb-2 d-none">
                                    <label class="badge bg-primary bg-gradient rounded-1">Password *</label>
                                    <input type="password" name="password" class="form-control" maxlength="40" minlength="8"  autocomplete="current-password">
                                </div>
                               

                                <?php if ($_SESSION['loggedInUser']['user_id'] !== $adminId && $_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
    <div class="col-md-6 mb-2">
        <label class="badge bg-primary bg-gradient rounded-1">Privilege</label>
        <select name="role" class="form-select" required>
            <option value="">Role</option>
            <option value="superadmin" <?= ($adminData['data']['role'] == 'superadmin') ? 'selected' : ''; ?>>Systemadmin/System Admin</option>
            <option value="admin" <?= ($adminData['data']['role'] == 'admin') ? 'selected' : ''; ?>>Stockman/Warehouseman</option>
            <option value="hoa" <?= ($adminData['data']['role'] == 'hoa') ? 'selected' : ''; ?>>Hoa/Homeowner Officer</option>
        </select>
    </div>



                                <!-- Conditionally render or disable the is_ban checkbox -->
                                <div class="col-md-5 mt-3">
                                    <label class="checkbox"  for="status-checkbox">
                                        <?php if ($isEditingOwnAccount): ?>
                                            <!-- Disable checkbox if editing own account -->
                                            <input type="checkbox" id="status-checkbox" name="is_ban" value="0" <?= $adminData['data']['is_ban']  == 1  ? 'checked' : ''; ?> style="width:45px; height:25px;" disabled>
                                            <span class="checkmark"></span>
                                            <span class="label">
                                            <span class="col-md-5">
                                                &nbsp; 
                                                 <span class="badge bg-secondary">Inactive</span>
    
                                                </span>
                                            </span>
                                        <?php else: ?>
                                            <!-- Allow checkbox to be checked or unchecked -->
                                            <input type="checkbox" id="status-checkbox"  name="is_ban" value="0" <?= $adminData['data']['is_ban']  == 1 ? 'checked' : ''; ?> style="width:45px; height:25px;">
                                            <span class="checkmark"></span>
                                            <span class="label">
                                                <span class="col-md-5">
                                                &nbsp; 
                                                 <span class="badge bg-secondary">Inactive</span>
                                                </span>
                                            </span>
                                        <?php endif; ?>
                                    </label>
                                </div>
                                <?php endif; ?>

                                <div class="col-md-12 mb-4 text-end">
                                    <button type="submit" name="updateAdmin" class="btn btn-primary">Update</button>
                                </div>
                            </div>

                            <?php
                        } else {
                            echo '<h5>' . $adminData['message'] . '</h5>';
                        }
                    } else {
                        echo 'Something Went Wrong!';
                        return false;
                    }
                ?>

                <!-- form email check function -->
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
