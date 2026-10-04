<?php
include('../config/dbcon.php');

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['receipt_id'])) {
    $receipt_id = intval($data['receipt_id']);

    $update_query = "UPDATE payments SET acknowledged = 1, acknowledged_date = NOW() WHERE id = $receipt_id";

    if ($conn->query($update_query) === TRUE) {
        $acknowledged_date = date('F j, Y, g:i a');
        echo json_encode(['success' => true, 'acknowledged_date' => $acknowledged_date]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}

mysqli_close($conn);
?>
