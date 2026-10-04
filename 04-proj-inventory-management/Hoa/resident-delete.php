<?php 
require '../config/function.php';

$rparaResultId = checkParamId('id');
if(is_numeric($rparaResultId)){ 

    $residentId = validate($rparaResultId);

    $resident = getById('residents',$residentId);
    if($resident['status'] == 200){ 

        $residentDeleteRes = delete('residents', $residentId);
        if ($residentDeleteRes) {
        
    redirect('resident','Resident Deleted!');

        }else{
            redirect('resident','Something went Wrong.','error');
        }
    }
    else{
    redirect('resident', $resident['message'],'error');
    }
    // echo $adminId; jus checking id it fetch the id
}else{
    redirect('resident','Something went Wrong.','error');
}


?>