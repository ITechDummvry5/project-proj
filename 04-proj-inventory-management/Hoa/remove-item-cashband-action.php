<?php

include('../config/function.php'); // Include necessary functions

if (isset($_GET['index'])) {
    $index = intval($_GET['index']);

    if (isset($_SESSION['residentItems'][$index])) {
        // Remove the item from the session
        unset($_SESSION['residentItems'][$index]);

        // Re-index the array to fill in the gaps
        $_SESSION['residentItems'] = array_values($_SESSION['residentItems']);

        // Use redirect function to handle redirection with status message
        redirect('hoa-cashier', 'Resident removed successfully!');
    } else {
        redirect('hoa-cashier', 'Resident not found!','error');
    }
} else {
    redirect('hoa-cashier', 'Invalid request!','error');
}
