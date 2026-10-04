<?php 
include('includes/header.php'); // Include header and database connection
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Material Adjustment Log</h4>
            <a href="changelog" class="btn btn-primary">Go Back</a>
        </div>

        <div class="card-body">
            <!-- Function to fetch quantity adjustments -->
            <?php
            function getAllAdjustments() {
                global $conn;  // Using global to access the connection

                // Fetch quantity adjustments, including category name and block_lot
                $query = "SELECT p.name AS product_name, 
                                 c.name AS category_name, 
                                 c.block_lot, 
                                 a.adjustment_reason, 
                                 a.quantity_adjusted, 
                                 a.adjusted_at, 
                                 u.name AS adjusted_by
                          FROM product_quantity_adjustments a
                          JOIN products p ON a.product_id = p.id
                          JOIN categories c ON p.category_id = c.id  -- Join with categories table
                          JOIN admins u ON a.adjusted_by = u.id  -- Assuming 'admins' table stores users
                          ORDER BY a.adjusted_at DESC";
                          
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    echo '<h5 class="fw-bolder fs-4">Error fetching quantity adjustments!</h5>';
                    return false;
                }

                return $result;
            }

            // Fetch adjustments
            $adjustments = getAllAdjustments();
            ?>

            <!-- Display adjustments in a table -->
            <?php if ($adjustments && mysqli_num_rows($adjustments) > 0) : ?>
                <div class="table-responsive">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Material Name</th>
                                <th>Category Name</th>
                                <th>Block Lot</th>
                                <th>Reason</th>
                                <th>Quantity Adjusted</th>
                                <th>Adjusted By</th>
                                <th>Adjustment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($adjustments)) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                                    <td><?= htmlspecialchars($row['category_name']) ?></td>
                                    <td><?= htmlspecialchars($row['block_lot']) ?></td> <!-- Display block and lot -->
                                    <td><?= ucfirst(htmlspecialchars($row['adjustment_reason'])) ?></td>
                                    <td><?= htmlspecialchars($row['quantity_adjusted']) ?></td>
                                    <td><?= htmlspecialchars($row['adjusted_by']) ?></td> <!-- Display adjusted by user's name -->
                                    <td><?= date('M d Y, h:i A', strtotime($row['adjusted_at'])) ?></td> <!-- Format for display -->
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <h5 class="fw-bolder fs-4">No quantity adjustments found.</h5>
            <?php endif; ?>
<?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
            <div class="col-md-12 text-end">
                <a href="quantity-export-adjustment-log.php" class="btn btn-success">Export Table</a>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<!-- Include footer -->
<?php include('includes/footer.php'); ?>
