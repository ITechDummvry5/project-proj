<?php include('includes/header.php'); ?>
<div class="container-fluid">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fs-4">Barangay Residency</h4>
            <a href="create-document.php" class="btn btn-primary float-end">Create</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>

            <?php
            // Assuming you have a database connection stored in $connection
            // SQL query to fetch data from barangayresidency and personal tables
            $query = "
                SELECT 
                    br.id AS residency_id, 
                    br.personal_Id, 
                    br.since, 
                    br.created_at,
                    br.updated_at,
                    p.name, 
                    p.contnumber, 
                    p.profile_image,
                    p.address
                FROM 
                    barangayresidency br
                JOIN 
                    personal p ON br.personal_Id = p.id
            ";
            
            // Execute the query
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo '<h4>Failed to Fetch</h4>';
                return false;
            }
            ?>
            
            <div class="table-responsive">
                <table id="dataTable4" class="table table-striped">
                    <thead class="text-gray-900">
                        <tr style="text-transform:capitalize;">
                            <th>cont. No</th>
                            <th>profile</th>
                            <th>address</th>
                            <th>fullname</th>
                            <th>created_at</th>
                            <th>update_at</th>
                            <th class="datatables-empty">action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 text-center">
                        <?php while ($Itemresidency = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                             
                                <td><?= htmlspecialchars($Itemresidency['contnumber']) ?></td>
                                <td>
                                    <img src="../<?= htmlspecialchars($Itemresidency['profile_image']) ?>" style="width: 75px; height: 40px; object-fit: cover;" alt="product" />
                                </td>
                                <td><?= htmlspecialchars($Itemresidency['address']) ?></td>
                                <td><?= htmlspecialchars($Itemresidency['name']) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($Itemresidency['created_at'])) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($Itemresidency['updated_at'])) ?></td>

                                <td class="datatables-empty">
                                    <a href="edit-barangay-residency.php?id=<?= $Itemresidency['residency_id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                     <a href="generated/generate-barangay-residency.php?id=<?= $Itemresidency['residency_id']; ?>"  class="btn btn-primary btn-sm">Generate</a>
                                      <a href="print-barangay-residency.php?id=<?= $Itemresidency['residency_id']; ?>" class="btn btn-warning btn-sm">Print</a>
                                    <?php if ($_SESSION['loggedInUser']['role'] === 'secretary' && $Itemresidency['residency_id'] !== $_SESSION['loggedInUser']['user_id']): ?>
                                        <a href="#" onclick="confirmDelete('clearance-delete.php?id=<?= $Itemresidency['residency_id']; ?>'); return false;" class="btn btn-danger btn-sm d-none">Delete</a>
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
