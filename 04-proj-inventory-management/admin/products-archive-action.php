<?php 
require '../config/function.php';

$archiveProductparaResultId = checkParamId('id');
if(is_numeric($archiveProductparaResultId)){ 

    $ParchiveProductId = validate($archiveProductparaResultId);

    $archiveProduct = getById('products',$ParchiveProductId);
    if($archiveProduct['status'] == 200){ 

        $ArchivePro = archive('products', $ParchiveProductId);
        if ($ArchivePro) {
            redirect('products','Material Archived!','success');
        }else{
            redirect('products','Something went wrong.','error');
        }
    }
    else{
        redirect('products', $archiveProduct['message'],'error');
    }
}else{
    redirect('products','Something went wrong.','error');
}



?>