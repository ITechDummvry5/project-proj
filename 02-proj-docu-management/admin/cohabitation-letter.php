<?php include('includes/header.php'); ?>
<div class="container-fluid">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-gradient-primary">
            <h4 class="my-1 fs-4">Cohabitation Letter</h4>
            <a href="create-document.php" class="btn btn-primary float-end">Create</a>
        </div>
        <div class="card-body">
            <!-- alertMessage() function -->
            <?php alertMessage(); ?>

            <?php
            // Assuming you have a database connection stored in $conn
            // SQL query to fetch data from cohabitationletter and personal tables
            $query = "
                SELECT 
                    cl.id AS cohabitationletter_id, 
                    cl.personal_Id, 
                    cl.namefor, 
                    cl.purposefor, 
                    cl.created_at,
                    cl.updated_at,
                    p.name, 
                    p.contnumber, 
                    p.profile_image,
                    p.address
                FROM 
                    cohabitationletter cl
                JOIN 
                    personal p ON cl.personal_Id = p.id
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
                            <th>name for</th>
                            <th>purpose for</th>
                            <th>created_at</th>
                            <th>updated_at</th>
                            <th class="datatables-empty">action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 text-center">
                        <?php while ($Itemcohabitationletter = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($Itemcohabitationletter['contnumber']) ?></td>
                                <td>
                                    <img src="../<?= htmlspecialchars($Itemcohabitationletter['profile_image']) ?>" style="width: 75px; height: 40px; object-fit: cover;" alt="profile image" />
                                </td>
                                <td><?= htmlspecialchars($Itemcohabitationletter['address']) ?></td>
                                <td><?= htmlspecialchars($Itemcohabitationletter['name']) ?></td>
                                <td><?= htmlspecialchars($Itemcohabitationletter['namefor']) ?></td>
                                <td><?= htmlspecialchars($Itemcohabitationletter['purposefor']) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($Itemcohabitationletter['created_at'])) ?></td>
                                <td><?= date('d M Y h:i a', strtotime($Itemcohabitationletter['updated_at'])) ?></td>

                                <td class="datatables-empty">
                                    <a href="edit-cohabitation-letter.php?id=<?= $Itemcohabitationletter['cohabitationletter_id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                    <a href="generated/generate-cohabitation-letter.php?id=<?= $Itemcohabitationletter['cohabitationletter_id']; ?>" class="btn btn-warning btn-sm">Generate</a>
                                   <a href="print-cohabitation-letter.php?id=<?= $Itemcohabitationletter['cohabitationletter_id']; ?>" class="btn btn-warning btn-sm">Print</a>  <?php if ($_SESSION['loggedInUser']['role'] === 'secretary' && $Itemcohabitationletter['cohabitationletter_id'] !== $_SESSION['loggedInUser']['user_id']): ?>
                                        <a href="#" onclick="confirmDelete('cohabitationletter-delete.php?id=<?= $Itemcohabitationletter['cohabitationletter_id']; ?>'); return false;" class="btn btn-danger btn-sm d-none">Delete</a>
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
