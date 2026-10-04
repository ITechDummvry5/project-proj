<?php
require_once '../config/function.php';
// Add a check to restrict access to only superadmins
if ($_SESSION['loggedInUser']['role'] != 'superadmin') {
    // Redirect or show an access denied message
    alertMessage();
    redirect('index2.php', 'Access Denied: You do not have permission to access this page.');
}
?>
<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
            <h4 class="my-1 fw-lighter fs-4 ">Account</h4>
            <a href="admins-create" class="btn btn-primary float-end">Add Account</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>

            <?php
// Get all admins
$admins = getAll('admins');
if (!$admins) {
    echo '<h4>Something Went ERROR</h4>';
    return false;
}

// Function to sort the admins by role hierarchy
function sortAdminsByRole($a, $b) {
    $roleHierarchy = ['superadmin' => 1, 'admin' => 2, 'hoa' => 3];
    return $roleHierarchy[$a['role']] <=> $roleHierarchy[$b['role']];
}

// Convert result to an array and sort it
$adminsArray = [];
while ($row = mysqli_fetch_assoc($admins)) {
    // Only add non-superadmin accounts if the logged-in user is a superadmin
    if ($_SESSION['loggedInUser']['role'] === 'superadmin') {
       
        if ($row['role'] === 'superadmin') {
            continue; // Skip this superadmin account
        }
    }
    $adminsArray[] = $row;
}
usort($adminsArray, 'sortAdminsByRole');

if (count($adminsArray) > 0) { 
?>
<div class="table-responsive">
    <table id="datatablesSimple" class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th class="datatables-empty">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($adminsArray as $adminItem) : ?>
                <tr>
                    <td hidden><?= htmlspecialchars($adminItem['id']) ?></td>
                    <td><?= htmlspecialchars($adminItem['name']) ?></td>
                    <td><?= htmlspecialchars($adminItem['email']) ?></td>
                    <td>
                        <?php 
                            if ($adminItem['is_ban'] == 1) {
                                echo '<span class="badge bg-secondary">Inactive</span>';
                            } else { 
                                echo '<span class="badge bg-primary">Active</span>';
                            }
                        ?>
                    </td>
                    <td class="datatables-empty">
                        <a href="admins-edit?id=<?= $adminItem['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                        <?php if ($_SESSION['loggedInUser']['role'] === 'superadmin' && $adminItem['id'] !== $_SESSION['loggedInUser']['user_id']): ?>
                            <a href="#" onclick="confirmDelete('admins-delete.php?id=<?= $adminItem['id']; ?>'); return false;" class="btn btn-danger btn-sm d-none">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php 
} else { 
?> 
    <h5 class="mb-0">No account records found</h5> 
<?php 
}
?>

        </div>
    </div>
</div>
<script src="../assets/js/sweetalert2.min.js"></script>
<?php include('includes/footer.php'); ?>
