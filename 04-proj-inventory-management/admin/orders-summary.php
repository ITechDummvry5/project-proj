<?php 
include('includes/header.php');

// Prevent access to orders-summary.php while in admin or if no order has been placed
if (!isset($_SESSION['productItems'])) { 
    echo '<script>window.location.href = "order-create.php";</script>';
    exit; // Ensure no further execution after redirect
}
?>

<div class="modal fade" id="orderSuccessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div class="container-fluid px-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header d-flex justify-content-between align-items-center text-white bg-dark">
                    <h4 class="my-1 fw-lighter fs-4">Withdrawal Summary</h4>  
                    <a href="order-create.php" class="btn btn-primary float-end">Go Back</a>
                </div>
                <div class="card-body px-4">
                    <?php alertMessage(); ?>

                    <div id="myBillingArea">
                        <?php 
                        if (isset($_SESSION['cphone'])) {
                            $phone = validate($_SESSION['cphone']);
                            $invoiceNo = validate($_SESSION['invoice_no']);
                            $customerQuery = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");
                            
                            if ($customerQuery && mysqli_num_rows($customerQuery) > 0) { 
                                $cRowData = mysqli_fetch_assoc($customerQuery);
                                ?>
                                <table style="width: 100%; margin-bottom:20px;">
                                    <tbody> 
                                        <tr>
                                            <td style="text-align:center" colspan="2">
                                                <h4 style="font-size: 25px; line-height:32px; margin:2px; padding:0;">INSERT TITLE HERE</h4>
                                                <p style="font-size: 16px; line-height:24px; margin:2px; padding:0;">COMPANY INC.</p>
                                                <p style="font-size: 16px; line-height:24px; margin:2px; padding:0;">#ADDRESS Philippines</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h5 style="font-size: 18px; line-height:30px; margin:0px; padding:0;"><strong>Contractor Details</strong> </h5>
                                                <p style="font-size: 17px; line-height:20px; margin:0px; padding:0;">Company Name: <?= $cRowData['name'] ?></p>
                                                <p style="font-size: 17px; line-height:20px; margin:0px; padding:0;">Phone: <?= $cRowData['phone'] ?></p>
                                                <p style="font-size: 16px; line-height:20px; margin:0px; padding:0;">Email: <?= $cRowData['email'] ?></p>
                                            </td>
                                            <td align="end">
                                                <h5 style="font-size: 18px; line-height:30px; margin:0px; padding:0;"><strong>Dispatch Details</strong> </h5>
                                                <p style="font-size: 17px; line-height:20px; margin:0px; padding:0;">Date: <?= date('d M Y  g:i A'); ?></p>
                                                <p style="font-size: 17px; line-height:20px; margin:0px; padding:0;">Track No: <?= $invoiceNo; ?></p>
                                                <p style="font-size: 16px; line-height:20px; margin:0px; padding:0;">Location: "INSERT HERE"</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                            } else {
                                echo "<h5>No Contractor Found!</h5>";
                            }
                        }
                        ?>

                        <?php 
                        if (isset($_SESSION['productItems'])) {
                            $sessionProducts = $_SESSION['productItems'];
                            ?>
                            <div class="table-responsive mb-3">
                                <table style="width:100%">
                                    <thead>
                                        <tr>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="5%">ID</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;">Material Name</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="16%">Product Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i = 1;
                                        foreach ($sessionProducts as $row) :
                                        ?>
                                        <tr>
                                            <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                            <td style="border-bottom: 1px solid #ccc;"><?= $row['name']; ?></td>
                                            <td style="border-bottom: 1px solid #ccc;"><?= $row['quantity']; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo '<h5>No Items added</h5>';
                        }
                        ?>
                    </div>

                    <!-- Save Button -->
                    <?php if (isset($_SESSION['productItems'])): ?>
                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-success px-4 mx-1" id="saveOrder">Save</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script>
document.getElementById('saveOrder').addEventListener('click', function() {
    // Add functionality for saving the order here
});
</script>
