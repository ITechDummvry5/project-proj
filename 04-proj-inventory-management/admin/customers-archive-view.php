<?php 
include('includes/header.php');
?>

<div class="container-fluid px-4 mt-4">
    <div class="card shadow-sm">
 
                <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
                    <h4 class="my-1 mb-0 fw-lighter fs-4">Done Contractor</h4>
                    <a href="customers" class="btn btn-primary float-end"> Go Back</a>
                </div>
           
        

        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            // Function to fetch archived customers
            function getArchivedCustomers()
            {
                global $conn;
                $query = "SELECT * FROM customers WHERE is_archived = 1 ORDER BY id ASC";
                $result = mysqli_query($conn, $query);
                return $result;
            }

            // Fetch all archived products
            $archivedCustomers = getArchivedCustomers();

            if (!$archivedCustomers) {
                echo '<h4 class="fw-bolder fs-4">Error fetching archived products!</h4>';
                return false;
            }
            ?>

            <!-- Display Archived Products Table -->
            <?php if (mysqli_num_rows($archivedCustomers) > 0) : ?>
                <div class="table-responsive">
                    <table id="datatablesSimple" class="text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Company Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date Created</th>
                                    <th class="text-center">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($archivedCustomers as $item) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['id']) ?></td>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td><?= htmlspecialchars($item['email']) ?></td>
                                    <td><?= htmlspecialchars($item['phone']) ?></td>
                                    <td class="text-start"><?= date('d M, Y h:i A', strtotime($item['created_at'])); ?></td>

                                  
                                   
                                        <td class="text-center">
                                        <a href="#" 
             onclick="confirmRestore('customers-restore-action?id=<?= $item['id']; ?>'); return false;" 
             class="btn btn-restore btn-sm">Restore</a>

             <a class="d-none" href="#" onclick="confirmDelete('customers-delete?id=<?= $item['id']; ?>'); return false;" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <h5 class="fw-bolder fs-4">No archived Contractor found</h5>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../assets/js/sweetalert2.min.js"></script>

<!-- Include footer -->
<?php include('includes/footer.php'); ?>


