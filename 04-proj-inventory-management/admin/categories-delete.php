<?php 

require '../config/function.php';

$paraResultId = checkParamId('id');
if(is_numeric($paraResultId)){ 

    $categoryId = validate($paraResultId);

    $category = getById('categories',$categoryId);
    if($category['status'] == 200){ 

        $response = delete('categories', $categoryId);
        if ($response) {
        
    redirect('categories.php','Category has been Deleted!');

        }else{
            redirect('categories.php','Something went Wrong.');
        }
    }
    else{
    redirect('categories.php', $categoryId['message']);
    }
   
}else{
    redirect('categories.php','Something went Wrong.');
}


?>