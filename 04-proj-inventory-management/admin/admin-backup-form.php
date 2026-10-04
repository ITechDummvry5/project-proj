
<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
            <h4 class="my-1 fw-lighter fs-4">Backup Database Table</h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="admin-backup-code.php" method="POST">
    <div class="row align-items-center">
        <div class="col-md-4 mb-3">
            <label for="table" class="form-label">Select a Table:</label>
            <select name="table" class="form-select" id="table">
            <option value="">Select Table</option>
            <option value="active_sessions">Active Sessions</option>
                            <option value="announcement">Announcement</option>
                            <option value="categories">Categories</option>
                            <option value="customers">Contractors</option>
                            <option value="orders">Orders</option>
                            <option value="order_items">Order Items</option>
                            <option value="payments">Payments</option>
                            <option value="products">Products</option>
                            <option value="product_logs">Product Logs</option>
                            <option value="product_quantity_adjustments">Product Quantity Adjustments</option>
                            <option value="product_quantity_log">Product Quantity Log</option>
                            <option value="request">Request</option>
                            <option value="residents">Residents</option>
            </select>
        </div>
        
        <div class="col-md-3 mb-3">
            <label for="start_date" class="form-label">Start Date:</label>
            <input type="date" name="start_date" class="form-control" id="start_date" required>
        </div>

        <div class="col-md-3 mb-3">
            <label for="end_date" class="form-label">End Date:</label>
            <input type="date" name="end_date" class="form-control" id="end_date" required>
        </div>

        <div class="col-md-2 text-end mt-2">
            <button type="submit" class="btn btn-primary">Export</button>
        </div>
    </div>
</form>

        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>


