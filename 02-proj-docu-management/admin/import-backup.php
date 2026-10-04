<?php

require '../config/function.php';
require '../config/dbcon.php'; // Ensure your database connection file is included

// Ensure the user is logged in and has the role of either secretary or staff
if (!isset($_SESSION['loggedInUser']) || ($_SESSION['loggedInUser']['role'] !== 'secretary' && $_SESSION['loggedInUser']['role'] !== 'staff')) {
    redirect('activity-logs.php', 'Unauthorized access.', 'error');
}

// Check if a file was uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['sql_file'])) {
    $file = $_FILES['sql_file'];

    // Validate file type
    $allowed_ext = ['sql'];
    $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);

    if (!in_array($file_ext, $allowed_ext)) {
        redirect('activity-logs.php', 'Invalid file type. Please upload a .sql file.', 'error');
    }

    // Move uploaded file to a temp location
    $upload_dir = __DIR__ . "/uploads";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $file_path = $upload_dir . "/" . basename($file['name']);
    if (!move_uploaded_file($file['tmp_name'], $file_path)) {
        redirect('activity-logs.php', 'Failed to upload file.', 'error');
    }

    // Read SQL file and execute queries
    $sql_content = file_get_contents($file_path);
    if (mysqli_multi_query($conn, $sql_content)) {
        redirect('activity-logs.php', 'Backup successfully imported!', 'success');
    } else {
        redirect('activity-logs.php', 'Error importing backup: ' . mysqli_error($conn), 'error');
    }
}

// Close database connection
$conn->close();
?>
