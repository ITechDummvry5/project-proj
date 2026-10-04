<?php 
require '../config/function.php';

// Check if the 'id' parameter is set
$RestoresparaResultId = checkParamId('id');
if (is_numeric($RestoresparaResultId)) {

    $customersresId = validate($RestoresparaResultId);

    $customersRestore = getById('customers', $customersresId);
    if ($customersRestore['status'] == 200 && $customersRestore['data']['is_archived'] == 1) {

        // Restore the customers
        $restorecustomers = contractorrestore('customers', $customersresId);
        if ($restorecustomers) {
            redirect('customers-archive-view', 'Contractor restored!','success');
        } else {
            redirect('customers-archive-view', 'Something went wrong.','error');
        }
    } else {
        redirect('customers-archive-view', 'Contractor not found or not archived.','error');
    }
} else {
    redirect('customers-archive-view', 'Something went wrong.','error');
}