<?php include('includes/header.php'); ?>

<div class="container-fluid">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fs-4">Building Clearance</h4>
            <a href="create-document.php" class="btn btn-primary float-end">Create</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>

            <?php
            // Assuming you have a database connection stored in $conn
            $query = "
            SELECT 
                bui.id AS buildingclearance_id,   
                bui.personal_id,                  
                bui.buildingcode, 
                bui.created_at, 
                bui.updated_at,
                p.contnumber, 
                p.profile_image,
                p.address
            FROM 
                buildingclearance bui  
            JOIN 
                personal p ON bui.personal_id = p.id; 
            ";

            // Execute the query
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo '<h4>Failed to Fetch</h4>';
                return false;
            }
            ?>
            
            <div class="table-responsive">
                <table id="dataTable2" class="table table-striped">
                    <thead class="text-gray-900">
                        <tr style="text-transform:capitalize;">
                            <th>Cont. No</th>
                            <th>Profile</th>
                            <th>B-Control No</th>                   
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th class="datatables-empty">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 text-center">
                        <?php while ($ItemBuildingClearance = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($ItemBuildingClearance['contnumber']) ?></td>
                                <td>
                                    <img src="../<?= htmlspecialchars($ItemBuildingClearance['profile_image']) ?>" style="width: 75px; height: 40px; object-fit: cover;" alt="profile" />
                                </td>
                 
                                <td><?= htmlspecialchars($ItemBuildingClearance['buildingcode']) ?></td>
                     
                                <td><?= date('d M Y h:i a', strtotime($ItemBuildingClearance['created_at'])) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($ItemBuildingClearance['updated_at'])) ?></td>

                                <td class="datatables-empty">
                                    <a href="edit-building-clearance.php?id=<?= $ItemBuildingClearance['buildingclearance_id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                 <a href="generated/generate-building-clearance.php?id=<?= $ItemBuildingClearance['buildingclearance_id']; ?>"  class="btn btn-primary btn-sm">Generate</a>
                                  <a href="print-building-clearance.php?id=<?= $ItemBuildingClearance['buildingclearance_id']; ?>" class="btn btn-warning btn-sm">Print</a>
                                    <?php if ($_SESSION['loggedInUser']['role'] === 'secretary' && $ItemBuildingClearance['buildingclearance_id'] !== $_SESSION['loggedInUser']['user_id']): ?>
                                        <a href="#" onclick="confirmDelete('clearance-delete.php?id=<?= $ItemBuildingClearance['buildingclearance_id']; ?>'); return false;" class="btn btn-danger btn-sm d-none">Delete</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php' ?>
