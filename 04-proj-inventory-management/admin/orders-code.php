<?php 
//  5/5/2024 
include('../config/function.php');

// Product items start here
if (!isset($_SESSION['productItems'])) {
    $_SESSION['productItems'] = [];
}

if (!isset($_SESSION['productItemIds'])) {
    $_SESSION['productItemIds'] = [];
}

if (isset($_POST['addItem'])) { // Validate name order-create.php section 41
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    if ($quantity < 0) {
        redirect('order-create', 'Quantity cannot be negative!','error');
    }
    
    // Positive
    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId' LIMIT 1");
    if ($checkProduct) {
        if (mysqli_num_rows($checkProduct) > 0) { 
            $row = mysqli_fetch_assoc($checkProduct);
            if ($row['quantity'] < $quantity) {
                redirect('order-create', 'Products is currently ' . $row['quantity'] . ' quantity!','error');
            }

            $productData = [
                'product_id' => $row['id'],
                'name' => $row['name'],
                'image' => $row['image'],
                'description' => $row['description'],
                'quantity' => $quantity, // Removed 'price' from here
            ];

            if (!in_array($row['id'], $_SESSION['productItemIds'])) { 
                array_push($_SESSION['productItemIds'], $row['id']);
                array_push($_SESSION['productItems'], $productData);
            } else {
                // Updating quantity if the product already exists in the session
                foreach ($_SESSION['productItems'] as $key => $prodSessionItem) { 
                    if ($prodSessionItem['product_id'] == $row['id']) { 
                        $newQuantity = $prodSessionItem['quantity'] + $quantity;
                        $productData = [
                            'product_id' => $row['id'],
                            'name' => $row['name'],
                            'image' => $row['image'],
                            'description' => $row['description'],
                            'quantity' => $newQuantity, // Removed 'price' from here
                        ];
                        $_SESSION['productItems'][$key] = $productData;
                    }   
                }
            }
            redirect('order-create', 'Item added in ' . $row['name']);
        } else { 
            redirect('order-create', 'No product order found','error');
        }
    } else { 
        redirect('order-create', 'Something went wrong','error');
    }
}

// 5/8/2024 Ajax code js updated debugg /5/9/2024
if (isset($_POST['productIncDec'])) { // Validate from JS.custom Ajax section 42
    $productId = validate($_POST['product_Id']);
    $quantity = validate($_POST['quantity']);

    $flag = false;
    foreach ($_SESSION['productItems'] as $key => $item) {
        if ($item['product_id'] == $productId) {
            $flag = true; // Key is for specify value
            $_SESSION['productItems'][$key]['quantity'] = $quantity;
        }
    }

    if ($flag) { 
        jsonResponse(200, 'success', 'Quantity Updated');
    } else {
        jsonResponse(500, 'error', 'Something went wrong. Refresh and go to Orders-code');
    }
}

// Validate from JS.custom Ajax section 87
if (isset($_POST['proceedToPlaceBtn'])) {
    // Validate phone number length
    $phone = $_POST['cphone'];
    if (strlen($phone) !== 11) {
        jsonResponse(400, 'error', 'Phone number must be 11 digits!');
        exit; // Stop further execution
    }

    // Further validation and processing
    $phone = validate($phone);


    // Checking customer exist
    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");
    if ($checkCustomer) { 
        if (mysqli_num_rows($checkCustomer) > 0) { 
            $_SESSION['invoice_no'] = rand(1111111, 9999999);
            $_SESSION['cphone'] = $phone;
        
            // This code format for function.php
            jsonResponse(200, 'success', 'Proceed contractor found');
        } else { 
            $_SESSION['cphone'] = $phone;
            jsonResponse(404, 'warning', 'Phone does not exist');
        }
    } else { 
        jsonResponse(500, 'error', 'Something went wrong');
    } 
}

if (isset($_POST['saveCustomerBtn'])) { // Validate from AJAX section
    // Retrieve and validate inputs
    $name = validate($_POST['name']);
    $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);
    $customer_placed_by_id = isset($_SESSION['loggedInUser']['name']) ? validate($_SESSION['loggedInUser']['name']) : null;

    // Check if all required fields are present
    if ($name != '' && $phone != '' && $email != '' && $customer_placed_by_id) {
        // Validate phone number length
        if (strlen($phone) != 11) {
            jsonResponse(400, 'warning', 'Phone number must be 11 digits');
            exit;
        }

        // Validate email structure
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            jsonResponse(400, 'warning', 'Invalid email format');
            exit;
        }

        // Check if email already exists
        $emailCheck = mysqli_query($conn, "SELECT * FROM customers WHERE email='$email'");
        if ($emailCheck && mysqli_num_rows($emailCheck)) {
            jsonResponse(409, 'info', 'Email already exists');
            exit;
        }

        // Check if phone number already exists
        $phoneCheck = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone'");
        if ($phoneCheck && mysqli_num_rows($phoneCheck)) {
            jsonResponse(409, 'info', 'Phone number already exists');
            exit;
        }

        // Check if name already exists
        // $nameCheck = mysqli_query($conn, "SELECT * FROM customers WHERE name='$name'");
        // if ($nameCheck && mysqli_num_rows($nameCheck)) {
        //     jsonResponse(409, 'info', 'Name already exists');
        //     exit;
        // }

        // Proceed with insertion
        $data = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'customer_placed_by_id' => $customer_placed_by_id // Add this line
        ];

        $result = insert('customers', $data);
        if ($result) {
            jsonResponse(200, 'success', 'Contractor has been saved');
        } else {
            jsonResponse(500, 'error', 'Failed to save contractor');
        }
    } else {
        jsonResponse(403, 'warning', 'Please complete the required fields');
    }
}

// 5/15/2024
// Validate from js.custom ajax section 177 positive saveOrder
if (isset($_POST['saveOrder'])) { 
    $phone = validate($_SESSION['cphone']); 
    $invoice_no = validate($_SESSION['invoice_no']);
    $order_placed_by_id = $_SESSION['loggedInUser']['name']; // User who processes the order

    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");
    if (!$checkCustomer) { 
        jsonResponse(500, 'error', 'Something Went Wrong!');
    }

    if (mysqli_num_rows($checkCustomer) > 0) { 
        $customerData = mysqli_fetch_assoc($checkCustomer);

        if (!isset($_SESSION['productItems'])) { 
            jsonResponse(404, 'warning', 'No items to place order!'); 
        }

        $sessionProducts = $_SESSION['productItems'];
        // Removed price calculations

        $data = [
            'customer_id' => $customerData['id'],
            'name' => $customerData['name'],
            'tracking_no' => rand(111111, 999999),
            'invoice_no' => $invoice_no,
            // 'order_date' => date('Y-m-d'),
            'order_date' => date('Y-m-d H:i:s'), // This will store date and time
            'order_status' => 'Booked',
            'order_placed_by_id' => $order_placed_by_id // For user monitoring
        ];

        $result = insert('orders', $data); 
        $lastOrderId = mysqli_insert_id($conn);

        // Insert order items without price
        foreach ($sessionProducts as $prodItem) {
            $productId = $prodItem['product_id'];
            $name = $prodItem['name'];
            $quantity = $prodItem['quantity'];

            $dataOrderItem = [
                'order_id' => $lastOrderId,
                'product_name' => $name,
                'product_id' => $productId,
                'quantity' => $quantity,
            ];
            $orderItemQuery = insert('order_items', $dataOrderItem);

            // Update product quantity
            $checkProductQuantityQuery = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId'");
            $productQtyData = mysqli_fetch_assoc($checkProductQuantityQuery);
            $totalProductQuantity = $productQtyData['quantity'] - $quantity;
            $productStatus = ($totalProductQuantity <= 0) ? 1 : 0; 

            $dataUpdate = [
                'quantity' => $totalProductQuantity,
                'status' => $productStatus // Update product status
            ];

            $updateProductQty = update('products', $productId, $dataUpdate);
        }

        // Clear session data
        unset($_SESSION['productItemIds']);
        unset($_SESSION['productItems']);
        unset($_SESSION['cphone']);
        unset($_SESSION['invoice_no']);  

        jsonResponse(200, 'success', 'Order saved');
    } else {
        jsonResponse(404, 'warning', 'No contractor found!');
    } 
}
?>
