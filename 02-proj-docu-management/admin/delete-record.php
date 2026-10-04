<?php
// Include the necessary files
require '../vendor/autoload.php';
require '../config/function.php';

// Ensure the user is logged in and has the role of either secretary or staff
if (!isset($_SESSION['loggedInUser']) || ($_SESSION['loggedInUser']['role'] !== 'secretary' && $_SESSION['loggedInUser']['role'] !== 'staff')) {
    redirect('activity-logs.php', 'Unauthorized access.', 'error');
}

// Check if form is submitted with required fields
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'], $_POST['start_date'], $_POST['end_date'])) {
    $table_name = mysqli_real_escape_string($conn, $_POST['table']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (empty($table_name)) {
        redirect('activity-logs.php', 'No table selected.', 'error');
    }

    $timestamp_columns = ['created_at'];

    // Check if the timestamp column exists
    $found_column = null;
    foreach ($timestamp_columns as $column) {
        $check_column_sql = "SHOW COLUMNS FROM `$table_name` LIKE '$column'";
        if ($result = $conn->query($check_column_sql)) {
            if ($result->num_rows > 0) {
                $found_column = $column;
                break;
            }
        }
    }

    if (!$found_column) {
        redirect('activity-logs.php', 'No valid timestamp column found.', 'error');
    }

    $end_date .= ' 23:59:59';

    // SQL query to delete data within the selected date range
    $sql = "DELETE FROM `$table_name` WHERE `$found_column` BETWEEN '$start_date' AND '$end_date'";
    $result = $conn->query($sql);

    // ✅ CHECK IF RECORDS WERE DELETED
    if ($conn->affected_rows > 0) {
        redirect('activity-logs.php', "Records deleted successfully for the date range ($start_date to $end_date).", 'success');
    } else {
        redirect('activity-logs.php', "No records found to delete in the selected date range ($start_date to $end_date).", 'error');
    }
}

$conn->close();
?>
