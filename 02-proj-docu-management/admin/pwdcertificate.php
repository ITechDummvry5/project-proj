<?php include('includes/header.php'); ?>
<div class="container-fluid">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fs-4"> Pwd Certificate</h4>
            <a href="create-document.php" class="btn btn-primary float-end">Create</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>

            <?php
            // Assuming you have a database connection stored in $connection
            // SQL query to fetch data from pwdcertificate and personal tables
            $query = "
                SELECT 
                    pw.id AS pwdcertificate_id, 
                    pw.personal_Id, 
                    pw.created_at,
                    pw.updated_at,
                    p.name, 
                    p.contnumber, 
                    p.profile_image,
                    p.address
                FROM 
                    pwdcertificate pw
                JOIN 
                    personal p ON pw.personal_Id = p.id
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
                        <?php while ($Itempwdcertificate = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                             
                                <td><?= htmlspecialchars($Itempwdcertificate['contnumber']) ?></td>
                                <td>
                                    <img src="../<?= htmlspecialchars($Itempwdcertificate['profile_image']) ?>" style="width: 75px; height: 40px; object-fit: cover;" alt="product" />
                                </td>
                                <td><?= htmlspecialchars($Itempwdcertificate['address']) ?></td>
                                <td><?= htmlspecialchars($Itempwdcertificate['name']) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($Itempwdcertificate['created_at'])) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($Itempwdcertificate['updated_at'])) ?></td>

                                <td class="datatables-empty">
                                    <a href="edit-pwdcertificate.php?id=<?= $Itempwdcertificate['pwdcertificate_id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                    <a href="print-pwdcertificate.php?id=<?= $Itempwdcertificate['pwdcertificate_id']; ?>" class="btn btn-warning btn-sm">Print</a>
                                    <?php if ($_SESSION['loggedInUser']['role'] === 'secretary' && $Itempwdcertificate['pwdcertificate_id'] !== $_SESSION['loggedInUser']['user_id']): ?>
                                        <a href="#" onclick="confirmDelete('clearance-delete.php?id=<?= $Itempwdcertificate['pwdcertificate_id']; ?>'); return false;" class="btn btn-danger btn-sm d-none">Delete</a>
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
