<?php
include('../config/function.php');

// Check if the form was submitted
if (isset($_POST['adjustQuantity'])) {
    $product_id = validate($_POST['product_id']);
    $quantity_adjusted = (int)validate($_POST['quantity']);
    $reason = validate($_POST['reason']);

    if ($quantity_adjusted < 0) {
        redirect('products.php', 'Quantity adjusted cannot be negative','error');
    }

    // Fetch current product data
    $productData = getById('products', $product_id);
    
    if (!$productData) {
        redirect('products.php', 'Material not found.','error');
       
    }

    if (!isset($_SESSION['loggedInUser']['user_id'])) {
        redirect('products.php', 'Error: User not authenticated!','error');
       
    }

    $adjustedBy = $_SESSION['loggedInUser']['user_id'];
    $current_quantity = (int)$productData['data']['quantity'];
    
    // Calculate new quantity
    $new_quantity = $current_quantity - $quantity_adjusted;

    // Prevent negative quantity
    if ($new_quantity < 0) {
        redirect('products.php', 'Error: Quantity cannot be negative!','error');
    }

    // Determine new status
    $status = $new_quantity === 0 ? 1 : 0; // 1 for out of stock, 0 for in stock

    // Update product quantity and status in the database
    $updateData = [
        'quantity' => $new_quantity,
        'status' => $status // Update status based on new quantity
    ];
    $result = updateProducts('products', $product_id, $updateData);
    
    if ($result) {
        // Log the adjustment
        $logData = [
            'product_id' => $product_id,
            'adjustment_reason' => $reason,
            'quantity_adjusted' => $quantity_adjusted,
            'adjusted_by' => $_SESSION['loggedInUser']['user_id'],
            'adjusted_at' => date('Y-m-d H:i:s')
        ];
        $logResult = insert('product_quantity_adjustments', $logData);

        if ($logResult) {
            redirect('products.php', 'Quantity adjusted and logged successfully.','success');
        } else {
            redirect('products.php', 'Failed to log the adjustment.','error');
        }
    } else {
        redirect('products.php', 'Failed to adjust quantity.','error');
    }
}