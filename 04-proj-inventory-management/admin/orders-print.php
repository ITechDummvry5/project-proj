<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
            <h4 class="my-1 fw-lighter fs-4">Withdrawal Receipt</h4>
            <a href="orders.php" class="btn btn-primary float-end">Go Back</a>
        </div>
        <div class="card-body px-4"> 

            <div id="myBillingArea">

                <?php 
                if (isset($_GET['track'])) {
                    $trackingNo = validate($_GET['track']);
                    if ($trackingNo == '') {
                        ?> 
                        <div class="text-center py-5">
                            <h4>Provide Tracking Number</h4>               
                            <div><a href="orders.php" class="btn btn-secondary w-50">Go back</a></div>
                        </div>
                        <?php
                    } else {
                        $orderQuery = "SELECT o.*, c.* FROM orders o, customers c WHERE c.id=o.customer_id AND tracking_no='$trackingNo' LIMIT 1";  
                        $orderQueryRes = mysqli_query($conn, $orderQuery);

                        if (!$orderQueryRes) {
                            echo "<h5>Something Went Wrong</h5>";
                            return false;
                        }

                        if (mysqli_num_rows($orderQueryRes) > 0) {
                            $orderDataRow = mysqli_fetch_assoc($orderQueryRes);
                            ?>
                            <table style="width: 100%; margin-bottom:20px;">
                                <tbody> 
                                <tr>
            <td style="text-align:center;" colspan="2">
                <h4 style="font-size: 25px;  line-height:32px; margin:2px; padding:0;">
                    INSERT TITLE HERE
                </h4>
                <p style="font-size: 16px; line-height:24px; margin:2px; padding:0;">
                    ELNOR INVESTMENT CO. INC.
                </p>
                <p style="font-size: 19px; line-height:24px; margin:2px; padding:0;">
                    #65F8+59M, Calamba, 4027 Laguna, Philippines
                </p>
            </td>
        </tr>
                                        <td>
                                        <h5 style="font-size: 18px; line-height:30px; margin:0px; padding:0;"><strong>Contractor Information</strong></h5>
                                        <p style="font-size: 17px; line-height:20px; margin:0px; padding:0;">Company Name: <?= $orderDataRow['name']?></p>
                                        <p style="font-size: 17px; line-height:20px; margin:0px; padding:0;">Phone: <?= $orderDataRow['phone']?></p>
                                        <p style="font-size: 16px; line-height:20px; margin:0px; padding:0;">Email: <?= $orderDataRow['email']?></p>

                                        </td>
                                        <td align="end">
                                        <h5 style="font-size: 18px; line-height:30px; margin:0px; padding:0;"><strong>Dispatch Information</strong></h5>
                                        <p style="font-size: 17px; line-height:20px; margin:0px; padding:0;">Date: <?=(new DateTime($orderDataRow['order_date']))->format('d M, Y g:i A'); ?></p>
                                        <p style="font-size: 17px; line-height:20px; margin:0px; padding:0;">Track No: <?= $orderDataRow['invoice_no']; ?></p>
                                        <p style="font-size: 16px; line-height:20px; margin:0px; padding:0;">Location: Banadero</p>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php

                            $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, oi.*, p.* FROM order_items oi, products p WHERE p.id=oi.product_id AND oi.order_id=(SELECT id FROM orders WHERE tracking_no='$trackingNo')";

                            $orderItemQueryRes = mysqli_query($conn, $orderItemQuery);

                            if ($orderItemQueryRes) {
                                if (mysqli_num_rows($orderItemQueryRes) > 0) {
                                    ?>
                                    <div class="table-responsive mb-3">
                                        <table style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th align="start" style="border-bottom: 1px solid #ccc;" width="5%">ID</th>
                                                    <th align="start" style="border-bottom: 1px solid #ccc;">Material Name</th>
                                                    <th align="end" style="border-bottom: 1px solid #ccc;" width="15%">Material Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $i = 1;
                                                foreach ($orderItemQueryRes as $row) {
                                                ?>
                                                <tr>
                                                    <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                                    <td style="border-bottom: 1px solid #ccc;"><?= $row['name']; ?></td>
                                                    <td align="center"; style="border-bottom: 2px solid #ccc;"><?= $row['orderItemQuantity']; ?></td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="2" align="end" style="font-weight: bolder;" class="fw-bold pt-3">Total Quantity:</td>
                                                    <td class="pt-3 fw-bold" align="center" style="border-bottom: 1px solid #ccc; font-weight:bolder;">
                                                        <?php 
                                                        $totalQuantity = 0;
                                                        mysqli_data_seek($orderItemQueryRes, 0); // Reset pointer
                                                        while ($row = mysqli_fetch_assoc($orderItemQueryRes)) {
                                                            $totalQuantity += $row['orderItemQuantity'];
                                                        }
                                                        echo $totalQuantity;
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                <tr>
    <td colspan="5" class="pt-3 text-muted"> <span> Print Date: <?= date('d M Y g:i A');?>
        </span>
    </td>
</tr>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                } else {
                                    echo "<h5>No data Found!</h5>";
                                    return false;
                                }
                            } else {
                                echo "<h5>Something Went Wrong!</h5>";
                                return false;
                            }
                        } else {
                            ?>
                            <div class="text-center py-3">
                                <h4>No Track Param ID Found</h4>
                                <a href="orders.php" class="btn btn-secondary w-50">Go back</a>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>

            <div class="mt-4 text-end">
                <button class="btn btn-warning px4 mx-1" onclick="printMyBillingArea()">Print</button>
                <button class="btn btn-danger" onclick="downloadPDF('Withdrawal_Receipt_<?= $orderDataRow['invoice_no']; ?>')">Download PDF</button>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>
<script>
    var invoiceNumber = "<?= $orderDataRow['invoice_no']; ?>";
</script>
