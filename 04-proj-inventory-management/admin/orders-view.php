<?php 
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
            <h4 class="my-1 fw-lighter fs-4">Order Details</h4>
            <a href="orders.php" class="btn btn-primary float-end">Go Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <?php 
            if (isset($_GET['track'])) {
                $trackingNo = validate($_GET['track']);
                $query = "SELECT o.*, c.* FROM orders o, customers c WHERE c.id = o.customer_id AND tracking_no='$trackingNo' ORDER BY o.id DESC";
                $orders = mysqli_query($conn, $query);
                if ($orders) {
                    if (mysqli_num_rows($orders) > 0) {
                        $orderData = mysqli_fetch_assoc($orders);
                        $orderId = $orderData['id'];
                        ?> 
                        <div class="card card-body shadow border-1 mb-4">
                            <div class="row">
                                <div class="col-md-7">
                                    <h5 class="fw-lighter fs-5">Order Details</h5>
                                    <label class="mb-1">
                                        Tracking No: <span class=""><?= $orderData['invoice_no']; ?></span>
                                    </label>
                                    <br/>
                                    <label class="mb-1">
    Order Date:
    <span class=""><?= (new DateTime($orderData['order_date']))->format('d M, Y g:i A'); ?></span>
</label>
                                    <br/>
                                    <label class="mb-1">
                                        Order Status:
                                        <span class=""><?= $orderData['order_status']; ?></span>
                                    </label>
                              

                                    <br/>
                                    <?php if($_SESSION['loggedInUser']['role'] === 'superadmin'): ?>
                                    <label class="mb-1">
                                        Process by:
                                        <span class=""><?= $orderData['order_placed_by_id']; ?></span>
                                    </label>
                                    <br/>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-5">
                                    <h5 class="fw-lighter fs-5">Contractor Details</h5>
                                    <label class="mb-1">
                                        Company Name:
                                        <span class=""><?= $orderData['name']; ?></span>
                                    </label>
                                    <br/>
                                    <label class="mb-1">
                                        Email Address:
                                        <span class=""><?= $orderData['email']; ?></span>
                                    </label>
                                    <br/>
                                    <label class="mb-1">
                                        Phone Number:
                                        <span class=""><?= $orderData['phone']; ?></span>
                                    </label>
                                    <br/>
                                </div>
                            </div>
                        </div>
                        
                        <?php 
                        // $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, o.*, oi.*, p.* 
                        //                    FROM orders as o, order_items as oi, products as p 
                        //                    WHERE oi.order_id = o.id AND oi.product_id = p.id AND o.tracking_no='$trackingNo'";
                        $orderItemQuery = "SELECT 
                                                oi.quantity as orderItemQuantity, 
                                                o.*, 
                                                oi.*, 
                                                p.*, 
                                                p.description as productDescription,
                                                   p.category_id
                                            FROM orders as o 
                                            JOIN order_items as oi ON oi.order_id = o.id 
                                            JOIN products as p ON oi.product_id = p.id 
                                            WHERE o.tracking_no='$trackingNo'";
                        $orderItemRes = mysqli_query($conn, $orderItemQuery);
                        if ($orderItemRes) {
                            if (mysqli_num_rows($orderItemRes) > 0) {
                                ?> 
                               
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Image &nbsp; &nbsp; &nbsp; &nbsp; Material Name</th>
                                            <th class="col-2">Project ID</th> <!-- Adjusted width -->
                                            <th class="col-1 text-end">Quantity</th> <!-- Adjusted width -->
                                           
                                        </tr>
                                    </thead>  
                                    <tbody>
                                    <?php foreach ($orderItemRes as $orderItemRow) :
                                            
                                            $description = $orderItemRow['productDescription'];
                                            // Find the last occurrence of "(" and ")", and extract the unit
                                            if (preg_match_all('/\((.*?)\)/', $description, $matches)) {
                                                // Get the last match from the array
                                                $unit = end($matches[1]); // Fetch the last element
                                            } else {
                                                $unit = '';  // If no parentheses, leave it empty
                                            }
                                            ?>
                                            <tr>
                                                <td>
                        <img src="<?= $orderItemRow['image'] != '' ? '../'.$orderItemRow['image'] : '../assets/uploads/no-image.png'; ?>"
                                                    style="width:80px; height:65px; object-fit:cover;" alt="product"/>
                                                    &nbsp;<?= $orderItemRow['name']; ?> <?= $unit ? "($unit)" : ''; ?>
                                                </td>
                                                <td>
                        <?= $orderItemRow['category_id']; ?> 
                    </td>
                                                <td class="text-end">
                                                    <?= $orderItemRow['orderItemQuantity']; ?>
                                                </td>
                                           
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody> 
                                </table>
                                <?php
                            } else {
                                echo '<h5>No Order Items Found!</h5>';
                            }
                        } else {
                            echo '<h5>Something went wrong with fetching order items!</h5>';
                        }
                    } else {
                        echo '<h5>No Record Found!</h5>';
                    }
                } else {
                    echo '<h5>Something went wrong with fetching orders!</h5>';
                }
            } else {
                ?>
                <div class="text-center py-3">
                    <h4>No Track ID Found</h4>
                    <a href="orders.php" class="btn btn-secondary w-50">Go back</a>
                </div>
                <?php
            }
            // Check if the order status is 'Booked' and allow status update
            if (isset($orderData['order_status']) && $orderData['order_status'] == 'Booked') {
                if ($_SESSION['loggedInUser']['role'] === 'admin') :
                ?>
                
                <div class="text-center mt-4">
    
<a href="update_order_status.php?track=<?= $orderData['tracking_no']; ?>" class="btn btn-success">Mark as Complete</a>

                </div>
                <?php  
                endif; // End role check
            }
            ?> 
        </div>
    </div>
</div>                               
<?php include('includes/footer.php'); ?>
