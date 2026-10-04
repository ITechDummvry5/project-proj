<?php 
require '../config/function.php';

// Define filename for the CSV
$filename = "quantity-adjustment-log_" . date('d M, Y h:i A') . ".csv";

// Set headers to force download of the CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open a file pointer to output the CSV directly
$output = fopen('php://output', 'w');

// Output column headings (including category_name and block_lot)
fputcsv($output, array('Material Name', 'Category Name', 'Block Lot', 'Adjustment Reason', 'Quantity Adjusted', 'Adjusted By', 'Adjustment Date'));

// Fetch quantity adjustments, now including category_name and block_lot
$logQuery = "SELECT p.name AS product_name, 
                     c.name AS category_name, 
                     c.block_lot, 
                     a.adjustment_reason, 
                     a.quantity_adjusted, 
                     a.adjusted_at, 
                     u.name AS adjusted_by
             FROM product_quantity_adjustments a
             JOIN products p ON a.product_id = p.id
             JOIN categories c ON p.category_id = c.id  -- Join with categories table
             JOIN admins u ON a.adjusted_by = u.id  -- Assuming 'admins' table stores users
             ORDER BY a.adjusted_at DESC";

$result = mysqli_query($conn, $logQuery);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Ensure that block_lot is treated as a string and check if it's a valid value
        $row['block_lot'] = (string) $row['block_lot'];

        // Format the adjusted_at date to 'M d Y, h:i A'
        $row['adjusted_at'] = date('M d Y,  h:i A', strtotime($row['adjusted_at']));

        // Format block_lot to 'Block X, Lot Y' format if it contains a hyphen
        if (strpos($row['block_lot'], '-') !== false) {
            // Split the block_lot value into block and lot parts
            list($block, $lot) = explode('-', $row['block_lot']);
            $formattedBlockLot = "Block $block, Lot $lot";
        } else {
            $formattedBlockLot = $row['block_lot']; // Keep as is if no hyphen
        }

        // Output the row with formatted data
        fputcsv($output, array(
            $row['product_name'], 
            $row['category_name'], 
            $formattedBlockLot, // Use the formatted block_lot
            $row['adjustment_reason'], 
            $row['quantity_adjusted'], 
            $row['adjusted_by'], 
            $row['adjusted_at']
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
