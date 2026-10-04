<?php

// Require Composer's autoload file and other dependencies
require '../vendor/autoload.php'; 
require '../config/function.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');  
$dotenv->load();

// Check if the user is logged in and is a superadmin
if ($_SESSION['loggedInUser']['role'] !== 'superadmin') {
    redirect('admin-backup-form', 'Unauthorized access. You do not have permission to perform this action.','error');
}

// Ensure a table is selected and dates are provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'], $_POST['start_date'], $_POST['end_date'])) {
    $table_name = $_POST['table'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Define possible timestamp columns
    $timestamp_columns = ['created_at', 'rcreated_at', 'hcreated_at', 'adjusted_at', 'changed_at', 'payment_date', 'order_date'];

    // Query to check for the existence of the timestamp column
    $found_column = null;
    foreach ($timestamp_columns as $column) {
        $check_column_sql = "SHOW COLUMNS FROM $table_name LIKE '$column'";
        if ($result = $conn->query($check_column_sql)) {
            if ($result->num_rows > 0) {
                $found_column = $column;
                break;
            }
        }
    }

    // If no valid timestamp column is found, redirect with an error
    if (!$found_column) {
        redirect('admin-backup-form.php', 'No valid timestamp column found in the selected table.','error');
    }

    // Modify the end date to include the entire day of the end date (23:59:59)
$end_date = $end_date . ' 23:59:59';

    // Format dates as '2024Nov23' and '2024Nov24'
   // Format dates as '2024-Nov-23' and '2024-Nov-24' (with month abbreviation)
$start_date_formatted = date('Y-M-d', strtotime($start_date));
$end_date_formatted = date('Y-M-d', strtotime($end_date));


    // Create the backup file name and path
    $backup_dir = __DIR__ . "/backups";
    if (!is_dir($backup_dir)) {
        mkdir($backup_dir, 0777, true);  // Create directory if it doesn't exist
    }
    $backup_file = $backup_dir . "/{$table_name}-{$start_date_formatted}-to-{$end_date_formatted}.sql";

    // SQL to fetch data from the specified table within the date range
    $sql = "SELECT * FROM $table_name WHERE $found_column BETWEEN '$start_date' AND '$end_date'";

    // Execute the query
    if ($result = $conn->query($sql)) {
        // Open file for writing
        $file = fopen($backup_file, 'w');
        if ($file) {
            // Write SQL statements to file
            while ($row = $result->fetch_assoc()) {
                $columns = implode(', ', array_keys($row));
                $values = implode(', ', array_map(function($value) {
                    return "'{$value}'";
                }, array_values($row)));

                $insert_sql = "INSERT INTO $table_name ($columns) VALUES ($values);\n";
                fwrite($file, $insert_sql);
            }
            fclose($file);
            redirect('admin-backup-form.php', 'Backup for table ' . $table_name . ' successfully created.','success');
        } else {
            redirect('admin-backup-form.php', 'Could not open backup file for writing.','error');
        }
    } else {
        redirect('admin-backup-form.php', 'Could not take data backup: ' . $conn->error ,'error');
    }
} else {
    redirect('admin-backup-form.php', 'No table selected for backup or dates not provided.' ,'error');
}

// Close connection
$conn->close();


?>
