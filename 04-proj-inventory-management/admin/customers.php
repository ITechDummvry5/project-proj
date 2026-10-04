<!-- 5/1/2024 -->
<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
        <?php if($_SESSION['loggedInUser']['role'] === 'admin'): ?>
             <h4 class="my-1 fw-lighter fs-4">Contractor for Material Pickup</h4>
            <?php endif; ?>
            <?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
            <h4 class="my-1 fw-lighter fs-4">Contractor</h4>
                <a href="customers-create" class="btn btn-primary float-end">Add Contractor</a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>

            <?php 
            // Fetch only non-archived contractors
            $customers = fetchDataPosition('customers', '*', 'is_archived = 0', 'id DESC'); 
            
            // Check for fetch errors
            if ($customers === false) {
                echo '<h4 class="fw-bolder fs-4">Contractor Fetching error</h4>';
                return true; // Exit the script if fetching failed
            }

            // Check if there are contractors
            if (count($customers) > 0) { ?>
                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-hover compact text-center">
                        <thead>
                            <tr>
                                <th class="text-start">ID</th>
                                <th class="text-start">Company name</th> 
                                <th class="text-start">Phone</th> 
                                <th class="text-start">Transaction Status</th>
                                <th class="text-start">Date Created</th>
                                <?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
                                    <th class="text-start">Created Contractor</th>
                                <?php endif; ?>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>  
                            <?php foreach($customers as $item) : ?>
                                <tr>
                                    <td class="text-start"><?= htmlspecialchars($item['id']) ?></td> 
                                    <td class="text-start"><?= htmlspecialchars($item['name']) ?></td>  
                                    <td class="text-start"><?= htmlspecialchars($item['phone']) ?></td>
                                    <td class="text-start">
                                        <?php 
                                        if($item['status'] == 1){
                                            echo '<span class="badge bg-primary text-white">Completed</span>';
                                        } else { 
                                            echo '<span class="badge bg-warning text-white">Pending</span>';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-start"><?= date('d M, Y h:i A', strtotime($item['created_at'])); ?></td>
                                    <?php if($_SESSION['loggedInUser']['role'] == 'superadmin'): ?>
                                        <td>
                                            <label class="mb-1">
                                                <span class="fw-bold"><?= htmlspecialchars($item['customer_placed_by_id']); ?></span>
                                            </label>
                                        </td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <a href="customers-edit?id=<?= $item['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                        <?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?> 
                                            <a href="#" 
                                               onclick="confirmContractor('customers-archive-action.php?id=<?= $item['id']; ?>'); return false;" 
                                               class="btn btn-archive btn-sm">Done</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody> 
                    </table>
                </div> 
            <?php } else { ?> 
                <h5 class="fw-bolder fs-4">No Contractors found</h5> 
            <?php } ?>
        </div>                     
    </div>
</div>

<script src="../assets/js/sweetalert2.min.js"></script>
<?php include('includes/footer.php'); ?>
