<!-- 5/19/2024 -->
<?php include('includes/header.php');?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
    <div class="card-header text-white bg-dark">
    <div class="col-md-12 d-flex align-items-center">
        <h4 class="my-1 fw-lighter fs-4">Withdrawal History</h4>
    </div>
</div>

        <div class="col-md-12 ">
                    <form action="" method="GET">
                        <div class="row g-1 mt-2 px-3">
                            <div class="col-md-2">
                             <input type="date" name="start_date" class="form-control"
                                       value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>" />
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="end_date" class="form-control"
                                       value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>" />
                            </div>
                          
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                                <a href="orders" class="btn btn-danger">Reset</a>
                            <?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>

                                <a href="orders-withdrawal-history-csv.php?start_date=<?= isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>&end_date=<?= isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>" class="btn btn-success">
    Export Table
</a>
<?php endif; ?>

                            </div>
                        </div>
                    </form>
                </div>

        <div class="card-body mb-0">
            <?php
            if (isset($_GET['start_date']) || isset($_GET['end_date'])) {
                $startDate = validate($_GET['start_date']);
                $endDate = validate($_GET['end_date']);
              

                $conditions = [];
                if ($startDate != '') {
                    $conditions[] = "o.order_date >= '$startDate'";
                }
                if ($endDate != '') {
                    $conditions[] = "o.order_date <= '$endDate'";
                }
                
                $query = "SELECT o.*, c.* FROM orders o, customers c 
                          WHERE c.id = o.customer_id";
                
                if (count($conditions) > 0) {
                    $query .= " AND " . implode(" AND ", $conditions);
                }

                $query .= " ORDER BY o.id DESC";
            } else {
                $query = "SELECT o.*, c.* FROM orders o, customers c 
                          WHERE c.id = o.customer_id ORDER BY o.id DESC";
            }

            $orders = mysqli_query($conn, $query);
            if ($orders) {
                if (mysqli_num_rows($orders) > 0) {
                    ?>
                    <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-stripted align-items-center justify-content-center">
                        <thead>
                            <tr>
                                <th class="text-start">Order Date</th>
                                <th class="text-start">Tracking No.</th>
                                <th class="text-start">Order Status</th>
                                <th class="text-start">Company name</th>
                                <th class="text-start">Contractor Phone</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $orderItem) : ?>
                                <tr> 
                                    <td class="text-start"><?= date('d M, Y h:i A', strtotime($orderItem['order_date'])); ?></td>
                                    <td class="text-start" ><?= htmlspecialchars($orderItem['invoice_no']); ?></td>
                                  
                                    <td class="text-start"><?= htmlspecialchars($orderItem['order_status']); ?></td>
                                    <td class="text-start"><?= htmlspecialchars($orderItem['name']); ?></td>
                                   
                                    
                                    <td class="text-start"><?= htmlspecialchars($orderItem['phone']); ?></td>

                                    <td class="text-center">
                                        <a href="orders-view.php?track=<?= htmlspecialchars($orderItem['tracking_no']); ?>" class="btn btn-primary mb-0 px-2 btn-sm">Order Details</a>
                                        <a href="orders-print.php?track=<?= htmlspecialchars($orderItem['tracking_no']); ?>" class="btn btn-warning mb-0 px-2 btn-sm">Receipt</a>
                                    </td>

                                    
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                    <?php
                } else {
                    echo "<h5 class='fw-bolder fs-4'>No Records Order found</h5>";
                }
            } else {
                echo "<h5 class='fw-bolder fs-4'>Something Went Wrong!</h5>";
            }
            ?>
            <!-- Add this within the container or just above the table -->
        
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>