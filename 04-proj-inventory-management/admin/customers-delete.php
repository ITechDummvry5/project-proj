<?php 

require '../config/function.php';

$paraResultId = checkParamId('id');
if(is_numeric($paraResultId)){ 

    $customersId = validate($paraResultId);
                        //table then ID
    $customer = getById('customers',$customersId);
    if($customer['status'] == 200){ 
                    //custom getbyId and delete 
        $response = delete('customers', $customersId);
        if ($response) {
        
    redirect('customers-archive-view','Contractor has been Deleted!','success');

        }else{
            redirect('customers.php','Something went Wrong.','error');
        }
    }
    else{
    redirect('customers.php', $customersId['message'],'error');
    }
   
}else{
    redirect('customers.php','Something went Wrong.','error');
}


?>