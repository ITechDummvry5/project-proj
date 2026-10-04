<?php

require_once '../config/function.php'; // Include functions

// Check if $conn is valid
if (!$conn) {
    die('Database connection failed.');
}

// Get start and end dates from query parameters
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Fetch logs based on date range
$product_logs = getProductChangeLogs($conn, $startDate, $endDate);

// Generate filename based on date range
if ($startDate && $endDate) {
    $filename = 'product_change_logs_' . date('Y-m-d', strtotime($startDate)) . '_to_' . date('Y-m-d', strtotime($endDate)) . '.csv';
} else {
    $filename = 'product_change_logs_' . date('Y/m/d') . '.csv'; // Fallback filename if no date range provided
}

// Export data to CSV
exportToCSV($filename, $product_logs);
?>
