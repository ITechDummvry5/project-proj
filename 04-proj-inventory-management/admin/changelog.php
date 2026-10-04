<?php
include('includes/header.php');


// Fetch product change logs
$product_logs = getProductChangeLogs($conn);
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">

            <h4 class="my-1 fw-lighter fs-4">Inventory Report Log</h4>
            
</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <!-- Form for date range input -->
                    <form method="GET" action="backup_logs" class="d-flex flex-wrap align-items-center">
                    <div class="input-group">
    <div class="row w-100">
        <!-- Date Inputs with small width -->
        <div class="col-md-3">
            <input type="date" name="start_date" class="form-control" placeholder="Start Date" required>
        </div>
       
        <div class="col-md-3">
            <input type="date" name="end_date" class="form-control" placeholder="End Date" required>
        </div>

        <!-- Buttons -->
        <div class="col-md-auto d-flex align-items-center ">
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-file-export"></i></button>
            <a href="quantity-added-log" class="btn btn-primary ms-2"><i class="fa-solid fa-cart-plus"></i></a>
            <a href="quantity-products-loss" class="btn btn-warning ms-2"><i class="fa-solid fa-person-circle-minus"></i></a>
        </div>
    </div>
</div>

                    </form>
                </div>
            </div>

            <!-- Table for displaying logs -->
            <div class="table-responsive">
                <table id="datatablesSimple" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-start">Changed At</th>
                            <th class="text-start">ID</th>
                            <th class="text-start">Change Description</th>
                            <th class="text-start">Changed By</th>
                            <th class="text-start">Old Quantity</th>
                            <th class="text-start">New Quantity</th>
                            
                          
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($product_logs)) : ?>
                            <?php foreach ($product_logs as $log) : ?>
                                <tr>
                                    <td class="text-start"><?= date('M j Y, h:i A', strtotime($log['changed_at'])) ?></td>
                                    <td class="text-start"><?= htmlspecialchars($log['product_id']) ?></td>
                                    <td class="text-start"><?= htmlspecialchars($log['change_description']) ?></td>
                                    <td class="text-start"><?= htmlspecialchars($log['changed_by']) ?></td>
                                    <td class="text-start"><?= htmlspecialchars($log['old_quantity']) ?></td>
                                    <td class="text-start"><?= htmlspecialchars($log['new_quantity']) ?></td>
                                  
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class=" text-center fw-light fs-5">No Changed Products Found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>


