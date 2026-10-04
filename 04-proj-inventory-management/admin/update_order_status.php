<?php
require '../config/function.php';

if (isset($_GET['track'])) {
    $trackingNo = mysqli_real_escape_string($conn, $_GET['track']);

    // Update the order status to 'Complete'
    $query = "UPDATE orders SET order_status = 'Complete' WHERE tracking_no = '$trackingNo'";

    // Execute the query and check for errors
    if (mysqli_query($conn, $query)) {
        redirect('orders-view.php?track=' . $trackingNo, 'Order status updated successfully.','success');
    } else {
        redirect('orders-view.php?track=' . $trackingNo, 'Couldn\'t update the order status!','error');
    }
} else {
    redirect('orders-view.php', 'Invalid Order ID or Tracking Number.','error');
}
?>



