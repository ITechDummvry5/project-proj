<?php include('includes/header.php'); ?>
<div class="container-fluid">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fs-4">Barangay Solo Parent Certificate</h4>
            <a href="create-document.php" class="btn btn-primary float-end">Create</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>

            <?php
            // Assuming you have a database connection stored in $connection
            // SQL query to fetch data from solocertificate and personal tables
            $query = "
            SELECT 
                so.id AS soloparentcertificate_id, 
                so.personal_Id, 
                so.since, 
                so.category,
                so.age,
                so.created_at,
                so.updated_at,
                so.children1, 
                so.children1_birthday, 
                so.children2, 
                so.children2_birthday, 
                so.children3, 
                so.children3_birthday, 
                so.children4, 
                so.children4_birthday,
                p.contnumber, 
                p.profile_image,
                p.name,
                p.address
            FROM 
                soloparentcertificate so
            JOIN 
                personal p ON so.personal_Id = p.id
        ";
        
            
            // Execute the query
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo '<h4>Failed to Fetch</h4>';
                return false;
            }
            ?>
            
            <div class="table-responsive">
                <table id="dataTable5" class="table table-striped">
                    <thead class="text-gray-900">
                        <tr style="text-transform:capitalize;">
                            <th>cont. No</th>
                            <th>profile</th>
                            <th>name</th>
                            <th>created_at</th>
                            <th>update_at</th>
                            <th class="datatables-empty">action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 text-center">
                        <?php while ($Itemssoloparentcertificate = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                             
                                <td><?= htmlspecialchars($Itemssoloparentcertificate['contnumber']) ?></td>
                                
                                <td>
                                    <img src="../<?= htmlspecialchars($Itemssoloparentcertificate['profile_image']) ?>" style="width: 75px; height: 40px; object-fit: cover;" alt="product" />
                                </td>
                                <td><?= htmlspecialchars($Itemssoloparentcertificate['name']) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($Itemssoloparentcertificate['created_at'])) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($Itemssoloparentcertificate['updated_at'])) ?></td>

                                <td class="datatables-empty">
                                    <a href="edit-soloparentcertificate.php?id=<?= $Itemssoloparentcertificate['soloparentcertificate_id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                          <a href="generated/generate-soloparent.php?id=<?= $Itemssoloparentcertificate['soloparentcertificate_id']; ?>" class="btn btn-primary btn-sm">Generate</a>
                                    <a href="print-soloparentcertificate.php?id=<?= $Itemssoloparentcertificate['soloparentcertificate_id']; ?>" class="btn btn-warning btn-sm">Print</a>
                                    <?php if ($_SESSION['loggedInUser']['role'] === 'secretary' && $Itemssoloparentcertificate['soloparentcertificate_id'] !== $_SESSION['loggedInUser']['user_id']): ?>
                                        <a href="#" onclick="confirmDelete('clearance-delete.php?id=<?= $Itemssoloparentcertificate['soloparentcertificate_id']; ?>'); return false;" class="btn btn-danger btn-sm d-none">Delete</a>
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
