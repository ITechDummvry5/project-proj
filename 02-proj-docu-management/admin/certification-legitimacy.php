<?php include('includes/header.php'); ?>
<div class="container-fluid">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fs-4">Certification of Legitimacy</h4>
            <a href="create-document.php" class="btn btn-primary float-end">Create</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>

            <?php
            // Assuming you have a database connection stored in $conn
            $query = "
              SELECT 
                cl.id AS certificationlegitimacy_id, 
                cl.personal_Id, 
                cl.work, 
                cl.usedfor, 
                cl.created_at, 
                cl.updated_at, 
                p.name, 
                p.contnumber, 
                p.profile_image,
                p.address
              FROM 
                certificationoflegitimacy cl
              JOIN 
                personal p ON cl.personal_Id = p.id;
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
                            <th>fullname</th>
                            <th>Work</th>
                            <th>Used For</th>
                            <th>created_at</th>
                            <th>update_at</th>
                            <th class="datatables-empty">action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 text-center">
                        <?php while ($Itemcertification = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($Itemcertification['contnumber']) ?></td>
                                <td>
                                    <img src="../<?= htmlspecialchars($Itemcertification['profile_image']) ?>" style="width: 75px; height: 40px; object-fit: cover;" alt="profile image" />
                                </td>
                                <td><?= htmlspecialchars($Itemcertification['name']) ?></td>
                                <td><?= htmlspecialchars($Itemcertification['work']) ?></td>
                                <td><?= htmlspecialchars($Itemcertification['usedfor']) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($Itemcertification['created_at'])) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($Itemcertification['updated_at'])) ?></td>

                                <td class="datatables-empty">
                                    <a href="edit-certification-legitimacy.php?id=<?= $Itemcertification['certificationlegitimacy_id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                       <a href="generated/generate-certificate-legitimacy.php?id=<?= $Itemcertification['certificationlegitimacy_id']; ?>" class="btn btn-primary btn-sm">Generate</a>
                                   <a href="print-certification-legitimacy.php?id=<?= $Itemcertification['certificationlegitimacy_id']; ?>" class="btn btn-warning btn-sm">Print</a>  
                                    
                                    <?php if ($_SESSION['loggedInUser']['role'] === 'secretary' && $Itemcertification['certificationlegitimacy_id'] !== $_SESSION['loggedInUser']['user_id']): ?>
                                        <a href="#" onclick="confirmDelete('certification-delete.php?id=<?= $Itemcertification['certificationlegitimacy_id']; ?>'); return false;" class="btn btn-danger btn-sm d-none">Delete</a>
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
