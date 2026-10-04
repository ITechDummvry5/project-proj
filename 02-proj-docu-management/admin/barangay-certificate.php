<?php include('includes/header.php'); ?>
<div class="container-fluid">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fs-4">Barangay Certificate</h4>
            <a href="create-document.php" class="btn btn-primary float-end">Create</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>

            <?php
            // Assuming you have a database connection stored in $connection
            // SQL query to fetch data from barangaycertificate and personal tables
            $query = "
                SELECT 
                    bc.id AS certificate_id, 
                    bc.personal_Id, 
                    bc.since, 
                    bc.created_at,
                    bc.updated_at,
                    p.name, 
                    p.contnumber, 
                    p.profile_image,
                    p.address
                FROM 
                    barangaycertificate bc
                JOIN 
                    personal p ON bc.personal_Id = p.id
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
                            <th>name</th>
                            <th>created_at</th>
                            <th>update_at</th>
                            <th class="datatables-empty">action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 text-center">
                        <?php while ($Itemcertificate = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                             
                                <td><?= htmlspecialchars($Itemcertificate['contnumber']) ?></td>
                                <td>
                                    <img src="../<?= htmlspecialchars($Itemcertificate['profile_image']) ?>" style="width: 75px; height: 40px; object-fit: cover;" alt="product" />
                                </td>
                                <td><?= htmlspecialchars($Itemcertificate['address']) ?></td>
                                <td><?= htmlspecialchars($Itemcertificate['name']) ?></td>

                                <td><?= date('d, M Y g:i a', strtotime($Itemcertificate['created_at'])) ?></td>
                                <td><?= date('d, M Y g:i a', strtotime($Itemcertificate['updated_at'])) ?></td>

                                <td class="datatables-empty">
                                    <a href="edit-barangay-certificate.php?id=<?= $Itemcertificate['certificate_id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                    <a href="generated/generate-barangay-certificate.php?id=<?= $Itemcertificate['certificate_id']; ?>"  class="btn btn-primary btn-sm">Generate</a>
     <a href="print-barangay-certificate.php?id=<?= $Itemcertificate['certificate_id']; ?>" class="btn btn-warning btn-sm">Print</a>
                                   
                                    <?php if ($_SESSION['loggedInUser']['role'] === 'secretary' && $Itemcertificate['certificate_id'] !== $_SESSION['loggedInUser']['user_id']): ?>
                                        <a href="#" onclick="confirmDelete('certificate-delete.php?id=<?= $Itemcertificate['certificate_id']; ?>'); return false;" class="btn btn-danger btn-sm d-none">Delete</a>
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
