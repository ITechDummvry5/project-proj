<?php 
//5/9/2024
 require '../config/function.php';
 $paramResult = checkParamId('index');

 if(is_numeric($paramResult)){

    $indexValue = validate($paramResult);
    if(isset($_SESSION['productItems']) && isset($_SESSION['productItemIds']) ){

        unset($_SESSION['productItems'][$indexValue]);
        unset($_SESSION['productItemIds'][$indexValue]);

        redirect('order-create', 'Item has been removed','success');
    }else{
    redirect('order-create' , 'There no such item exist','error');
    }

 }else{ 
    redirect('order-create' , 'param not numeric','error');
 }
?>