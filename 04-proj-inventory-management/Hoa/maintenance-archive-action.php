<?php 
require '../config/function.php';

$ArchiveparaResultId = checkParamId('id');
if(is_numeric($ArchiveparaResultId)){ 

    $hArchiveId = validate($ArchiveparaResultId);

    $mArchive = getById('request',$hArchiveId);
    if($mArchive['status'] == 200){ 
        if ($mArchive['data']['status'] == 'Accepted') {
        $hoaArchiveReq = archive('request', $hArchiveId);
        if ($hoaArchiveReq) {
            redirect('maintenance-view','Maintenance Request Archived!','');
        }else{
            redirect('maintenance-view','Something went wrong.','error');
        }
    } else {
        redirect('maintenance-view', 'Cannot archive request without being Accepted ','error'); // Changed to reflect the correct status
    }
}else{
        redirect('maintenance-view', $mArchive['message'],'error');
    }
}else{
    redirect('maintenance-view','Something went wrong.','error');
}
?>