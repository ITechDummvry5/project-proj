
<?php
require_once '../config/function.php';
// Add a check to restrict access to only secretarys
if ($_SESSION['loggedInUser']['role'] != 'secretary') {
    // Redirect or show an access denied message
    alertMessage();
    redirect('index2.php', 'Access Denied: You do not have permission to access this page.', 'error');
}
?>
<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary text-white">
            <h4 class="my-1 fw-lighter fs-4">Records</h4>
            <a href="account-create.php" class="btn btn-primary float-end">Create Account</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>

            <?php
// Get all account
$account = getAll('account');
if (!$account) {
    echo '<h4>Something Went ERROR</h4>';
    return false;
}

// Function to sort the account by role hierarchy
function sortaccountByRole($a, $b) {
    $roleHierarchy = ['secretary' => 1, 'staff' => 2];
    return $roleHierarchy[$a['role']] <=> $roleHierarchy[$b['role']];
}

// Convert result to an array and sort it
$accountArray = [];
while ($row = mysqli_fetch_assoc($account)) {
    // Only add non-secretary accounts if the logged-in user is a secretary
    if ($_SESSION['loggedInUser']['role'] === 'secretary') {
       
        if ($row['role'] === 'secretary') {
            continue; // Skip this secretary account
        }
    }
    $accountArray[] = $row;
}
usort($accountArray, 'sortaccountByRole');

if (count($accountArray) > 0) { 
?>
<div class="table-responsive">
    <table id="dataTable" class="table table-striped">
        <thead class="text-gray-900">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Date Created</th>
                <th class="datatables-empty">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-800 text-center">
            <?php foreach ($accountArray as $adminItem) : ?>
                <tr>
                    <td><?= htmlspecialchars($adminItem['id']) ?></td>
                    <td><?= htmlspecialchars($adminItem['name']) ?></td>
                    
                    <td>
                        <?php 
                            if ($adminItem['is_ban'] == 1) {
                                echo '<span class="badge bg-danger">Inactive</span>';
                            } else { 
                                echo '<span class="badge bg-primary">Active</span>';
                            }
                        ?>
                    </td>
                    <td><?= date('d M Y', strtotime($adminItem['created_at'])) ?></td>
                    <td class="datatables-empty">
                        <a href="account-edit.php?id=<?= $adminItem['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                        <?php if ($_SESSION['loggedInUser']['role'] === 'secretary' && $adminItem['id'] !== $_SESSION['loggedInUser']['user_id']): ?>
                            <a href="#" onclick="confirmDelete('account-delete.php?id=<?= $adminItem['id']; ?>'); return false;" class="btn btn-danger btn-sm d-none">Delete</a>
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
<?php include 'includes/footer.php'?>