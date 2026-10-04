<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Project List</h4>
            <a href="categories-create" class="btn btn-primary mt-2 mt-md-0">Add Project</a>
        </div>

        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>
            <?php 
                $categories = getAll('categories'); // Looping in function getAll
                if (!$categories) {
                    echo '<h4>Error retrieving categories!</h4>';
                    return false;
                }
                if (mysqli_num_rows($categories) > 0) { 
            ?>
            <div class="table-responsive">
                <table class="text-center" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Model</th>
                            <th>Block/Lot No.</th> <!-- Update column header -->
                            <th>Description</th>
                            <th>Date Created</th>

                            <th>Status</th>
                            <?php if ($_SESSION['loggedInUser']['role'] === 'admin'): ?>
                            <th class="text-center">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $item): ?>
                        <tr>
                            <td><?= $item['id']; ?></td>
                            <td><?= htmlspecialchars($item['name']); ?></td>
                            <td class="text-truncate" style="max-width: 150px;" data-bs-placement="bottom" data-bs-toggle="tooltip" title="<?= htmlspecialchars($item['block_lot']); ?>"> <!-- Update to display block_lot -->
                                <?= htmlspecialchars($item['block_lot']); ?>
                            </td>
                            <td><?= htmlspecialchars($item['floorarea']); ?></td>
                            <td><?= date('d M, Y h:i A', strtotime($item['created_at']));  ?></td>

                            
                            <td>
                                <?php if ($item['status'] == 1): ?>
                                 <span class="badge bg-success">Completed</span>
                                <?php else: ?>
                               <span class="badge bg-warning">Ongoing</span>
                                <?php endif; ?>
                            </td>


                            
                            <?php if ($_SESSION['loggedInUser']['role'] === 'admin'): ?>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="categories-edit?id=<?= $item['id']; ?>" class="btn btn-success btn-sm me-2">Edit</a>
                                    <a hidden href="#" 
                                           onclick="confirmDelete('categories-delete?id=<?= $item['id']; ?>'); return false;" 
                                           class="btn btn-danger btn-sm">Delete</a>
                                </div>
                            </td>
                            <?php endif; ?>



                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php 
                } else { 
            ?>
            <h5 class="fw-bolder fs-4">No Project Model found</h5>
            <?php } ?>
        </div>
    </div>
</div>
<script src="../assets/js/sweetalert2.min.js"></script>
<?php include('includes/footer.php'); ?>
