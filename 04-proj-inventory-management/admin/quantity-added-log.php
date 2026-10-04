<?php 
include('includes/header.php'); // This includes the database connection and functions
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
            <h4 class="my-1 fw-lighter fs-4">Material Entry Log</h4>
            <a href="changelog" class="btn btn-primary">Go Back</a>
        </div>

        <div class="card-body">
            <?php 
            // Fetch product quantity logs with category name
            // Fetch product quantity logs with category name
// Fetch product quantity logs with category name and block_lot
$logQuery = "SELECT p.name AS product_name, c.name AS category_name, c.block_lot, l.quantity_added, l.added_by, l.created_at 
              FROM product_quantity_log l
              JOIN products p ON l.product_id = p.id
              JOIN categories c ON p.category_id = c.id  -- Join with categories table
              ORDER BY l.created_at DESC";



            $result = mysqli_query($conn, $logQuery);

            if (!$result) {
                die("Database query failed: " . mysqli_error($conn));
            }
            ?>

<div class="table-responsive">
    <table id="datatablesSimple">
        <thead>
            <tr>
                <th>Materials Name</th>
                <th>Category Model Name</th>
                <th>Block Lot</th>
                <th>Quantity Added</th>
                <th>Added By</th>
                <th>Added Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['product_name']) ?></td>
                        <td><?= htmlspecialchars($row['category_name']) ?></td>
                        <td><?= htmlspecialchars($row['block_lot']) ?></td>
                        <td><?= htmlspecialchars($row['quantity_added']) ?></td>
                        <td><?= htmlspecialchars($row['added_by']) ?></td>
                        <td><?= date('M d Y, h:i A', strtotime($row['created_at'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">No quantity logs found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
            <div class="col-md-12 text-end">
                <a href="quantity-export-added-log.php" class="btn btn-success">Export Table</a>
            </div>
<?php endif; ?>

        </div>
    </div>
</div>

<!-- Include footer -->
<?php include('includes/footer.php'); // Include footer ?>
