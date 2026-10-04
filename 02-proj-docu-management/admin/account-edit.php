<?php
require_once '../config/function.php';
// Add a check to restrict access to only secretarys
if ($_SESSION['loggedInUser']['role'] != 'secretary') {
    // Redirect or show an access denied message
    alertMessage();
    redirect('index2.php', 'Access Denied: You do not have permission to access this page.', 'error');
} ?> 

<?php include('includes/header.php'); ?>

<div class="container-fluid px-4"> 
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fw-lighter fs-4">Update Account</h4>
            <a href="account-view.php" class="btn btn-primary float-end">View Records</a>
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
                    $adminData = getById('account', $adminId);
                    if ($adminData) {
                        if ($adminData['status'] == 200) {
                            // Check if the logged-in user is editing their own account
                            $isEditingOwnAccount = $_SESSION['loggedInUser']['user_id'] == $adminId;

                            ?> 
                            <!-- hidden id -->
                            <input type="hidden" name="adminId" value="<?= $adminData['data']['id']; ?>">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="badge bg-primary bg-gradient rounded-1">Name*</label>
                                    <input type="text" name="name" value="<?= $adminData['data']['name']; ?>" class="form-control text-muted" required>
                                </div>

                    

                             
                                <div class="col-md-3 mb-2 d-none">
                                    <label class="badge bg-primary bg-gradient rounded-1">Password *</label>
                                    <input type="password" name="password" class="form-control" maxlength="40" minlength="8"  autocomplete="current-password">
                                </div>
                               

                                <?php if ($_SESSION['loggedInUser']['user_id'] !== $adminId && $_SESSION['loggedInUser']['role'] === 'secretary'): ?>
    <div class="col-md-6 mb-2">
        <label class="badge bg-primary bg-gradient rounded-1">Privilege*</label>
        <select name="role" class="form-select form-control"  required>
            <option value="">Role</option>
            <option value="secretary" <?= ($adminData['data']['role'] == 'secretary') ? 'selected' : ''; ?>>Secretary</option>
            <option value="staff" <?= ($adminData['data']['role'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
        </select>
    </div>



                                <!-- Conditionally render or disable the is_ban checkbox -->
                                <div class="col-md-1 mt-1">
    <div class="checkbox-wrapper">
        <?php if ($isEditingOwnAccount): ?>
            <!-- Disable checkbox if editing own account -->
            <input type="checkbox" id="status-checkbox" name="is_ban" value="0" <?= $adminData['data']['is_ban'] == 1 ? 'checked' : ''; ?> disabled>
            <label for="status-checkbox">
                <span class="tick_mark"></span>
            </label>
            <span class="badge mt-2 d-block text-center">Inactive</span>
        <?php else: ?>
            <!-- Allow checkbox to be checked or unchecked -->
            <input type="checkbox" id="status-checkbox" name="is_ban" value="0" <?= $adminData['data']['is_ban'] == 1 ? 'checked' : ''; ?>>
            <label for="status-checkbox">
                <span class="tick_mark"></span>
            </label>
            <span class="badge mt-2 d-block text-center">Inactive</span>
        <?php endif; ?>
    </div>
</div>

                                
                                <?php endif; ?>

                                <div class="col-md-12 mb-4 d-flex justify-content-end">
                                    <button type="submit" name="updateaccount" class="btn btn-primary">Update</button>
                                </div>
                            </div>

                            <?php
                        } else {
                            echo '<h5>' . $adminData['message'] . '</h5>';
                        }
                    } else {
                        echo 'Failed to Fetch!';
                        return false;
                    }
                ?>

                <!-- form email check function -->
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
