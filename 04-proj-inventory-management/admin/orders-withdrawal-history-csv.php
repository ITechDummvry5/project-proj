<?php
require '../config/function.php';

// Define filename for the CSV
$filename = "orders_withdrawal_history_" . date('d M, Y h:i A') . ".csv";

// Set headers to force download of the CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open a file pointer to output the CSV directly
$output = fopen('php://output', 'w');

// Output column headings
fputcsv($output, array('Order Date', 'Tracking No.', 'Company name', 'Contractor Phone', 'Process By'));

// Check if filter is applied from URL
$conditions = [];
if (isset($_GET['start_date']) || isset($_GET['end_date'])) {
    $startDate = validate($_GET['start_date']);
    $endDate = validate($_GET['end_date']);

    if ($startDate != '') {
        $conditions[] = "o.order_date >= '$startDate'";
    }
    if ($endDate != '') {
        $conditions[] = "o.order_date <= '$endDate'";
    }
}

$query = "SELECT o.*, c.* FROM orders o JOIN customers c ON c.id = o.customer_id";

if (count($conditions) > 0) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$query .= " ORDER BY o.id DESC";

// Execute query
$orders = mysqli_query($conn, $query);

if ($orders) {
    while ($row = mysqli_fetch_assoc($orders)) {
        // Format the order date
        $orderDate = date('d M, Y h:i A', strtotime($row['order_date']));

        // Write row to CSV
        fputcsv($output, array(
            $orderDate,
            htmlspecialchars($row['invoice_no']),
            htmlspecialchars($row['name']),
            htmlspecialchars($row['phone']),
            htmlspecialchars($row['order_placed_by_id']),
        ));
    }
} else {
    die("Database query failed: " . mysqli_error($conn));
}

// Close file pointer
fclose($output);

// Close the database connection
mysqli_close($conn);
exit();
?>
