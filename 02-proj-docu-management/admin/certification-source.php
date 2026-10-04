<?php include('includes/header.php'); ?>
<div class="container-fluid">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fs-4">Certification of Source of Income</h4>
            <a href="create-document.php" class="btn btn-primary float-end">Create</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>

            <?php
            // Assuming you have a database connection stored in $conn
            // SQL query to fetch data from certificationofsourceofincome and personal tables
            $query = "
                SELECT 
                    csi.id AS certificationofsourceofincome_id, 
                    csi.personal_Id, 
                    csi.work, 
                    csi.created_at,
                    csi.updated_at,
                    p.name, 
                    p.contnumber, 
                    p.profile_image,
                    p.address
                FROM 
                    certificationofsourceofincome csi
                JOIN 
                    personal p ON csi.personal_Id = p.id
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
                            <th>updated_at</th>
                            <th class="datatables-empty">action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 text-center">
                        <?php while ($ItemCertification = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($ItemCertification['contnumber']) ?></td>
                                <td>
                                    <img src="../<?= htmlspecialchars($ItemCertification['profile_image']) ?>" style="width: 75px; height: 40px; object-fit: cover;" alt="profile image" />
                                </td>
                                <td><?= htmlspecialchars($ItemCertification['address']) ?></td>
                                <td><?= htmlspecialchars($ItemCertification['name']) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($ItemCertification['created_at'])) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($ItemCertification['updated_at'])) ?></td>

                                <td class="datatables-empty">
                                    <a href="edit-certification-of-source-of-income.php?id=<?= $ItemCertification['certificationofsourceofincome_id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                     <a href="generated/generate-certification-of-source-income.php?id=<?= $ItemCertification['certificationofsourceofincome_id']; ?>" class="btn btn-primary btn-sm">Generate</a>
                                   <a href="print-certification-of-source-of-income.php?id=<?= $ItemCertification['certificationofsourceofincome_id']; ?>" class="btn btn-warning btn-sm">Print</a> 
                                    <?php if ($_SESSION['loggedInUser']['role'] === 'secretary' && $ItemCertification['certificationofsourceofincome_id'] !== $_SESSION['loggedInUser']['user_id']): ?>
                                        <a href="#" onclick="confirmDelete('certificationofsourceofincome-delete.php?id=<?= $ItemCertification['certificationofsourceofincome_id']; ?>'); return false;" class="btn btn-danger btn-sm d-none">Delete</a>
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
