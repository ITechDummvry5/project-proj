<?php 
require '../config/function.php';

// Check if the 'id' parameter is set
$RestoreparaResultId = checkParamId('id');
if (is_numeric($RestoreparaResultId)) {

    $productsresId = validate($RestoreparaResultId);

    $productsRestore = getById('products', $productsresId);
    if ($productsRestore['status'] == 200 && $productsRestore['data']['is_archived'] == 1) {

        // Restore the products
        $restoreproducts = restore('products', $productsresId);
        if ($restoreproducts) {
            redirect('products-archive-view', 'Products Restored!','success');
        } else {
            redirect('products-archive-view', 'Something went wrong.','error');
        }
    } else {
        redirect('products-archive-view', 'products not found or not archived.','error');
    }
} else {
    redirect('products-archive-view', 'Something went wrong.','error');
}