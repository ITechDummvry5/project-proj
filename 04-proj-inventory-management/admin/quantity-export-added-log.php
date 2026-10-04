<?php
require '../config/function.php';

// Define filename for the CSV
$filename = "quantity-added-log_" . date('d M, Y h:i A') . ".csv";

// Set headers to force download of the CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open a file pointer to output the CSV directly
$output = fopen('php://output', 'w');

// Output column headings (including category_name and block_lot)
fputcsv($output, array('Materials Name', 'Category Name', 'Block Lot', 'Quantity Added', 'Added By', 'Added Date'));

// Fetch product quantity logs, now including category_name and block_lot
$logQuery = "SELECT p.name AS product_name, c.name AS category_name, 
                     CAST(c.block_lot AS CHAR) AS block_lot, l.quantity_added, l.added_by, l.created_at 
             FROM product_quantity_log l
             JOIN products p ON l.product_id = p.id
             JOIN categories c ON p.category_id = c.id
             ORDER BY l.created_at DESC";

$result = mysqli_query($conn, $logQuery);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Ensure that block_lot is treated as a string and check if it's a valid value
        $row['block_lot'] = (string) $row['block_lot'];

        // Format the created_at date to 'M d Y, h:i A'
        $row['created_at'] = date('M d Y,  h:i A', strtotime($row['created_at']));

        // Format block_lot to 'Block X, Lot Y' format
        if (strpos($row['block_lot'], '-') !== false) {
            // Split the block_lot value into block and lot parts
            list($block, $lot) = explode('-', $row['block_lot']);
            $formattedBlockLot = "Block $block, Lot $lot";
        } else {
            $formattedBlockLot = $row['block_lot']; // Keep as is if no hyphen
        }

        // Output the row with formatted data
        fputcsv($output, array($row['product_name'], 
        $row['category_name'], $formattedBlockLot, $row['quantity_added'], $row['added_by'], $row['created_at']));
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
