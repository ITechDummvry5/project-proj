<?php 
require '../config/function.php';

$archiveCustomerparaResultId = checkParamId('id');
if (is_numeric($archiveCustomerparaResultId)) { 

    $CarchiveCustomerId = validate($archiveCustomerparaResultId);

    $archiveCustomer = getById('customers', $CarchiveCustomerId);
    if ($archiveCustomer['status'] == 200) { 
        // Check if the status is 1 then archive else if not 
        if ($archiveCustomer['data']['status'] == 1) {
            $ArchiveCus = archive('customers', $CarchiveCustomerId);
            if ($ArchiveCus) {
                redirect('customers', 'Contractor Done!','success');
            } else {
                redirect('customers', 'Something went wrong.','error');
            }
        } else {
            redirect('customers', 'Cannot archive contractor without being completed the task','error'); // Changed to reflect the correct status
        }
    } else {
        redirect('customers', $archiveCustomer['message'],'error');
    }
} else {
    redirect('customers', 'Something went wrong.','error');
}
?>
