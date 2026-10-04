<?php 
require '../config/function.php';

// Check if the 'id' parameter is set
$RestoreparaResultId = checkParamId('id');
if (is_numeric($RestoreparaResultId)) {

    $mrequestId = validate($RestoreparaResultId);

    $requestRestore = getById('request', $mrequestId);
    if ($requestRestore['status'] == 200 && $requestRestore['data']['is_archived'] == 1) {

        // Restore the request
        $restoreRequest = restore('request', $mrequestId);
        if ($restoreRequest) {
            redirect('archived-requests-view', 'Maintenance Request Restored!');
        } else {
            redirect('archived-requests-view', 'Something went wrong.','error');
        }
    } else {
        redirect('archived-requests-view', 'Request not found or not archived.','error');
    }
} else {
    redirect('archived-requests-view', 'Something went wrong.','error');
}
?>
