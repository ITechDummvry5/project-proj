<?php
// Include the database connection and functions
include('../config/function.php'); // adjust path if function.php is in config/

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitize the POST data
    $name = trim($_POST['name']);  // changed from author_name to name
    $email = trim($_POST['email']);

    // Call the insert function
    $inserted = insertAuthor($name, $email);

    if ($inserted) {
        // Success message and redirect to root index.php
        echo "<script>
                alert('Author added successfully!');
                window.location.href='../index.php';
              </script>";
    } else {
        // Error message and redirect to root index.php
        echo "<script>
                alert('Failed to add author!');
                window.location.href='../index.php';
              </script>";
    }
} else {
    // If someone tries to access this page directly
    header("Location: ../index.php");
    exit();
}
