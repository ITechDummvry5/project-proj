<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary text-white">
            <h4 class="my-1 fw-lighter fs-4 ">Informational Records</h4>
            <a href="personal-create.php" class="btn btn-primary float-end">Create Personal Information</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>

            <?php
            // Get all account
            $personal = getAll('personal');
            if (!$personal) {
                echo '<h4>Failed to Fetch</h4>';
                return false;
            }
            ?>

            <div class="table-responsive">
                <table id="dataTable1" class="table table-striped">
                    <thead class="text-gray-900">
                        <tr>
                            <th>Cont. No</th>
                            <th>Profile Image</th>
                            <th>Fullname</th>
                           
                            <th>Created_at</th>
                            <th>Update_at</th>
                            <th class="datatables-empty">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 text-center">
                        <?php foreach ($personal as $personalItem) : ?>  <!-- Use $personal here -->
                            <tr>
                                <td><?= htmlspecialchars($personalItem['contnumber']) ?></td>
                                    <td>
                                        <img src="../<?= htmlspecialchars($personalItem['profile_image']) ?>" style="width: 75px; height: 40px; object-fit: cover;" alt="no-image" />
                                    </td>
                                <td><?= htmlspecialchars($personalItem['name']) ?></td>
                             
                                <td><?= date('d M Y', strtotime($personalItem['created_at'])) ?></td>
                                <td><?= date('d M Y h:i', strtotime($personalItem['updated_at'])) ?></td>
                                <td class="datatables-empty">
                                    <a href="personal-edit.php?id=<?= $personalItem['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                    <?php if ($_SESSION['loggedInUser']['role'] === 'secretary' && $personalItem['id'] !== $_SESSION['loggedInUser']['user_id']): ?>
                                        <a href="#" onclick="confirmDelete('personal-delete.php?id=<?= $personalItem['id']; ?>'); return false;" class="btn btn-danger btn-sm d-none">Delete</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
