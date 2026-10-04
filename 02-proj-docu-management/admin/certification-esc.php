<?php include('includes/header.php'); ?>
<div class="container-fluid">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fs-4">Certification of ESC</h4>
            <a href="create-document.php" class="btn btn-primary float-end">Create</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>

            <?php
            // SQL query to fetch data from certificationofesc and personal tables
            $query = "
                SELECT 
                    ce.id AS certificationofesc_id, 
                    ce.personal_Id, 
                    ce.created_at,
                    ce.updated_at,
                    p.name, 
                    p.contnumber, 
                    p.profile_image
                FROM 
                    certificationofesc ce
                JOIN 
                    personal p ON ce.personal_Id = p.id
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
                            <th>fullname</th>
                       
                            <th>created</th>
                            <th>updated</th>
                            <th class="datatables-empty">action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 text-center">
                        <?php while ($esc = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($esc['contnumber']) ?></td>
                                <td>
                                    <img src="../<?= htmlspecialchars($esc['profile_image']) ?>" style="width: 75px; height: 40px; object-fit: cover;" alt="profile image" />
                                </td>
                                <td><?= htmlspecialchars($esc['name']) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($esc['created_at'])) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($esc['updated_at'])) ?></td>

                                <td class="datatables-empty">
                                    <a href="edit-esc.php?id=<?= $esc['certificationofesc_id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                     <a href="generated/generate-certificate-esc.php?id=<?= $esc['certificationofesc_id']; ?>"  class="btn btn-primary btn-sm">Generate</a>
                                  <a href="print-certification-of-esc.php?id=<?= $esc['certificationofesc_id']; ?>" class="btn btn-warning btn-sm">Print</a> 
                                    <?php if ($_SESSION['loggedInUser']['role'] === 'secretary' && $esc['certificationofesc_id'] !== $_SESSION['loggedInUser']['user_id']): ?>
                                        <a href="#" onclick="confirmDelete('certificationofesc-delete.php?id=<?= $esc['certificationofesc_id']; ?>'); return false;" class="btn btn-danger btn-sm d-none">Delete</a>
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
