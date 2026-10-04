<?php 
require '../config/function.php';

$hparaResultId = checkParamId('id');
if(is_numeric($hparaResultId)){ 

    $rrequestId = validate($hparaResultId);

    $mrequest = getById('request',$rrequestId);
    if($mrequest['status'] == 200){ 

        $hoaDeletereq = delete('request', $rrequestId);
        if ($hoaDeletereq) {
        
    redirect('maintenance-resident-view.php','Maintenance Request Deleted!');

        }else{
            redirect('maintenance-resident-view.php','Something went Wrong!','error');
        }
    }
    else{
    redirect('maintenance-resident-view.php', $mrequest['message'],'error');
    }
    // echo $adminId; jus checking id it fetch the id
}else{
    redirect('maintenance-resident-view.php','Something went Wrong!');
}


?>