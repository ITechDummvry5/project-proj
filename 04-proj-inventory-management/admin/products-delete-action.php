<?php 

require '../config/function.php';

$paraResultId = checkParamId('id');
if(is_numeric($paraResultId)){ 

    $product_id = validate($paraResultId);
    // check if product exist
    $products = getById('products',$product_id);
    if($products['status'] == 200){ 

        $response = delete('products', $product_id);
        if ($response) {
            $deleteImage = "../".$products['data']['image']; //delete the image in the upload folder
            if(file_exists($deleteImage)){  //checking  if the file is exist then delete
                unlink($deleteImage);
            }
    redirect('products-archive-view','Material has been Deleted!','success');

        }else{
            redirect('products-archive-view','Something went Wrong.','error');
        }
    }
    else{
    redirect('products-archive-view', $product_id['message'],'error');
    }
   
}else{
    redirect('products-archive-view','Something went Wrong.','error');
}


?>