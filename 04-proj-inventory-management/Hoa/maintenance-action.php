<?php
include('../config/function.php');

// Check if the 'id' and 'action' parameters are set
if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = validate($_GET['id']);
    $action = validate($_GET['action']);

    // Initialize the status and data array
    $status = '';
    $data = [];

    if ($action === 'accept') {
        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['working_date'])) {
            $status = 'Accepted';
            $working_date = validate($_POST['working_date']);

            // Update the request's status and working date in the database
            $data = [
                'status' => $status,
                'working_date' => $working_date,
            ];
            $result = hupdate('request', $data, "id = $id");

            if ($result) {
                redirect('maintenance-view.php', "Request has been $status successfully!");
            } else {
                redirect('maintenance-view.php', "Failed to update the request.",'error');
            }
        } else {
            redirect('maintenance-view.php', "Working date is required.",'error');
        }
    } elseif ($action === 'reject') {
        // Handle rejection with reason
        $status = 'Rejected';
        $reason = isset($_POST['rejection_reason']) ? validate($_POST['rejection_reason']) : NULL;

        $data = [
            'status' => $status,
            'working_date' => NULL, // Clear the working_date
            'reason' => $reason, // Store the rejection reason
        ];
        $result = hupdate('request', $data, "id = $id");

        if ($result) {
            redirect('maintenance-view.php', "Request has been $status successfully!");
        } else {
            redirect('maintenance-view.php', "Failed to $action the request.",'error');
        }
    } elseif ($action === 'reopen') {
        // Handle reopening of the request
        $status = 'Pending';
        $data = [
            'status' => $status,
            'working_date' => NULL, // Clear the working_date
        ];
        $result = hupdate('request', $data, "id = $id");

        if ($result) {
            redirect('maintenance-view.php', "Request has been reopened successfully!");
        } else {
            redirect('maintenance-view.php', "Failed to reopen the request.",'error');
        }
    } else {
        redirect('maintenance-view.php', "Invalid action.",'error');
    }
} else {
    redirect('maintenance-view.php', "Invalid request.",'error');
}
?>
