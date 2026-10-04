<?php 

require '../config/function.php';

$paraResultId = checkParamId('id');
if(is_numeric($paraResultId)){ 

    $announcement_id = validate($paraResultId);

    $announcement = getById('announcement',$announcement_id);
    if($announcement['status'] == 200){ 

        $response = delete('announcement', $announcement_id);
        if ($response) {
            $hdeleteImage = "../".$announcement['data']['image']; //delete image path
            if(file_exists($hdeleteImage)){  //checking  if the file is exist then delete
                unlink($hdeleteImage);
            }
    redirect('announcement-view','Announcement has been Deleted!');

        }else{
            redirect('announcement-view','Something went Wrong','error');
        }
    }
    else{
    redirect('announcement-view', $announcement_id['message'],'error');
    }
   
}else{
    redirect('announcement-view','Something went Wrong ','error');
}


?>