
<?php
include('../config/function.php'); //This is it 
//return True if the input is valid ( 1 in this case, if it's 'True') and 0 False otherwise. line 13
// <!--modify 4/26/2024 line 18-->
// For creating admin
if (isset($_POST['savedAdmin'])) {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $role = validate($_POST['role']);
    $is_ban = isset($_POST['is_ban']) ? 1 : 0;

    $_SESSION['form_data'] = $_POST; // Save form data to session in case of error

    if ($name != '' && $email != '' && $password != '') {
// Check if email, name, or phone already exists
$emailNamePhoneCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email' OR name='$name' OR phone='$phone'");
if (mysqli_num_rows($emailNamePhoneCheck) > 0) {
    $existing = mysqli_fetch_assoc($emailNamePhoneCheck);
    
    // Check if email already exists
    if ($existing['email'] == $email) {
        redirect('admins-create', 'Email already exists!','error');
    }

    // Check if name already exists
    if ($existing['name'] == $name) {
        redirect('admins-create', 'Name already exists!','error');
    }

    // Check if phone already exists
    if ($existing['phone'] == $phone) {
        redirect('admins-create', 'Phone number already exists!','error');
    }
}
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirect('admins-create', 'Invalid email format!','error');
        }
            // Validate phone number length
            if (strlen($phone) !== 11 || !ctype_digit($phone)) {
                redirect('admins-create', 'Phone number must be 11 digits long','error');
            }

        // Validate password strength
        function isAdminPasswordStrong($password) {
            return strlen($password) >= 8 && preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password);
        }
        if (!isAdminPasswordStrong($password)) {
            redirect('admins-create', 'Password must be at least 8 characters long and include letters and numbers','error');
        }

        // Hash the password
        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

        // Prepare data for insertion
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $bcrypt_password,
            'phone' => $phone,
            'is_ban' => $is_ban,
            'role' => $role
        ];

        $result = insert('admins', $data);
        if ($result) {
            unset($_SESSION['form_data']); // Clear form data on success
            redirect('admins', 'Admin created successfully!','success');
        } else {
            redirect('admins-create', 'Something went wrong! Please try again.','error');
        }
    } else {
        redirect('admins-create', '"Oops! It looks like you missed some required fields!','error');
    }
}

// For updating admin
if (isset($_POST['updateAdmin'])) {
    $adminId = validate($_POST['adminId']);
    $adminData = getById('admins', $adminId);
    if ($adminData['status'] != 200) {
        redirect('admins-edit?id=' . $adminId, '"Oops! It looks like you missed some required fields!','error');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $remark = validate($_POST['remark']);
    $password = validate($_POST['password']);
    // $role = validate($_POST['role']);
    $role = isset($_POST['role']) && !empty($_POST['role']) ? validate($_POST['role']) : $adminData['data']['role']; // Use the current role if not updated
    $is_ban = $adminData['data']['is_ban']; // Keep current value for is_ban

    // Check if editing own account
    $isEditingOwnAccount = $_SESSION['loggedInUser']['user_id'] == $adminId;

    // Only superadmins can change the ban status and role
    if (!$isEditingOwnAccount) {
        $is_ban = isset($_POST['is_ban']) ? 1 : 0;
    }

    // Validate email
    $emailNamePhoneCheck = mysqli_query($conn, "SELECT * FROM admins WHERE (email='$email' OR name='$name' OR phone='$phone') AND id!='$adminId'");
    if (mysqli_num_rows($emailNamePhoneCheck) > 0) {
        $existing = mysqli_fetch_assoc($emailNamePhoneCheck);
        
        if ($existing['email'] == $email) {
            redirect('admins-edit?id=' . $adminId, 'Email already exists!','error');
        }
        
        if ($existing['name'] == $name) {
            redirect('admins-edit?id=' . $adminId, 'Name already exists!','error');
        }
    
        if ($existing['phone'] == $phone) {
            redirect('admins-edit?id=' . $adminId, 'Phone number already exists!','error');
        }
    }

    function isPasswordStrong($password) {
        return strlen($password) >= 8 && preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password);
    }
    // Password validation and hashing if needed
    if (!empty($password)) {
        if (!isPasswordStrong($password)) {
            redirect('admins-edit?id=' . $adminId, 'Password must be at least 8 characters long and include letters and numbers','error');
        }
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password']; // Use current password if not changing
    }
    // Validate phone number length
    if (strlen($phone) !== 11 || !ctype_digit($phone)) {
        redirect('admins-edit?id=' . $adminId, 'Phone numbers must be 11 digits long ','error');
    }

    // Prepare data for update
    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword,
        'phone' => $phone,
        'remark' => $remark,
        'is_ban' => $is_ban
    ];

    if ($_SESSION['loggedInUser']['role'] === 'superadmin') {
        $data['role'] = $role;
    }

    $result = update('admins', $adminId, $data);
    if ($result) {
        redirect('admins-edit?id=' . $adminId, 'Admin updated successfully!','success');
    } else {
        redirect('admins-edit?id=' . $adminId, 'Something went wrong!','error');
    }
}


if (isset($_POST['savedCategory'])) {
    // Validate inputs
    $name = validate($_POST['name']);
    $floorarea = validate($_POST['floorarea']);
    $block = validate($_POST['block']); // Get the selected block
    $lot = validate($_POST['lot']); // Get the selected lot
    $fenceOption = isset($_POST['fence_option']) ? $_POST['fence_option'] : ''; // Get the selected fence option
    $status = isset($_POST['status']) ? 1 : 0; // Status handling (checked = 1, unchecked = 0)

    // Check if the required fields are filled
    if ($name != '' && $floorarea != '' && $block != '' && $lot != '') {
        // Combine block and lot into a single string
        $blockLot = "$block-$lot"; // e.g., "Blk 1-Lot 35"

        // Query to check if the category already exists with the same block-lot combination
        $categoryCheck = mysqli_query($conn, "SELECT * FROM categories WHERE block_lot='$blockLot'");

        // Check if the category with the same block-lot combination exists
        if ($categoryCheck && mysqli_num_rows($categoryCheck) > 0) {
            redirect('categories-create', 'This Project already exists!','error');
        }

        // Prepare description by adding the optional fence and gate if selected
        $description = $floorarea; // Start with the base floor area description
        if ($fenceOption === "With Fence and Gate") {
            $description .= "\nOptional: $fenceOption"; // Append only once
        }
      
        // Prepare data for insertion
        $data = [
            'name' => $name,
            'floorarea' => $description, // Store the combined description (floor area + optional fence info)
            'block_lot' => $blockLot, // Save combined value
            'status' => $status
        ];

        // Insert into the database
        $result = insert('categories', $data);

        if ($result) {
            redirect('categories', 'Project created successfully!','success');
        } else {
            redirect('categories', 'Could not create Project!','error');
        }
    } else {
        // Redirect with an error message if inputs are empty
        redirect('categories-create', '"Oops! It looks like you missed some required fields!','error');
    }
}



if (isset($_POST['UpdateCategory'])) {
    // Validate inputs
    $categoryId = validate($_POST['categoryId']);
    $name = validate($_POST['name']);
    $floorarea = validate($_POST['floorarea']);
    $block_lot = validate($_POST['block_lot']); // Combined block and lot
    $status = isset($_POST['status']) ? 1 : 0; // Status handling (checked = 1, unchecked = 0)

    // Check if the required fields are filled
    if ($name != '' && $floorarea != '' && $block_lot != '') {
        
        // Query to check if the same block_lot already exists for another category (excluding the current category being updated)
        $categoryCheck = mysqli_query($conn, "SELECT * FROM categories WHERE block_lot='$block_lot' AND id != '$categoryId'");

        // If a category with the same block_lot exists, prevent the update
        if ($categoryCheck && mysqli_num_rows($categoryCheck) > 0) {
            redirect('categories-edit?id=' . $categoryId, 'This Project already exists!','error');
            exit; // Prevent further execution
        }

        // Prepare data for updating
        $data = [
            'name' => $name,
            'floorarea' => $floorarea,
            'block_lot' => $block_lot, // Ensure block_lot is included
            'status' => $status
        ];

        // Perform the update
        $result = update('categories', $categoryId, $data);

        if ($result) {
            redirect('categories-edit?id=' . $categoryId, 'Project updated successfully!','success');
        } else {
            redirect('categories-edit?id=' . $categoryId, 'Could not update Project!','error');
        }
    } else {
        // Redirect with an error message if inputs are empty
        redirect('categories-edit?id=' . $categoryId, '"Oops! It looks like you missed some required fields!','error');
    }
}


if (isset($_POST['saveProduct'])) 
{
    $category_id = validate($_POST['category_id']);// Project category ID
    $materialcategory = validate($_POST['materialcategory']); // Material category (this could be a name)
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $quantity = validate($_POST['quantity']);
    $status = $quantity == 0 ? 1 : 0;
    $premark = validate($_POST['premark']); 

     // Check if 'e' is present in the quantity field
     if (strpos($quantity, 'e') !== false) {
        redirect('products-create', 'Quantity cannot contain the letter "e"!','error');
    }
           // Check for negative quantity
    if ($quantity < 0) {
        redirect('products-create', 'Quantity cannot be negative!','error');
    }

        // Handle image upload
        if ($_FILES['image']['size'] > 0) { 
             // Define allowed extensions and MIME types
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $allowed_mime_types = ['image/jpeg', 'image/png'];

            $path = "../assets/uploads/products";
            $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image_mime_type = mime_content_type($_FILES['image']['tmp_name']); // Get the MIME type of the uploaded file
             // Check if the file extension and MIME type are allowed
             if (!in_array(strtolower($image_ext), $allowed_extensions) || !in_array($image_mime_type, $allowed_mime_types)) {
                redirect('products-create', 'Please upload a valid image file (JPG, PNG, JPEG formats only)!','error');
            }
            $filename = time().'.'.$image_ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $path."/".$filename);
            $finalImage = "assets/uploads/products/".$filename;
        } else {
            $finalImage = '';
        }

        // Data for product insertion
        $data = [
            'category_id' => $category_id, // Project category
            'materialcategory' => $materialcategory, // Material category (name)
            'name' => $name,
            'description' => $description,
            'quantity' => $quantity,
            'image' => $finalImage,
            'status' => $status,
            'premark' => $premark
        ];

 
        // Insert into products table
        $result = insert('products', $data);
        
        if ($result) {
            // Get the last inserted product ID
            $product_id = mysqli_insert_id($conn); // This gets the last inserted ID

            // Log the quantity added in the product_quantity_log table
            $logData = [
                'product_id' => $product_id,
                'quantity_added' => $quantity,
                'added_by' => $_SESSION['loggedInUser']['name'] . ' (new material)',  // Assuming you have user ID in session
                'created_at' => date('Y-m-d H:i:s')  // Current timestamp
            ];

            // Insert into quantity log
            $logResult = insert('product_quantity_log', $logData);
            
            if ($logResult) {
                redirect('products', 'Material created successfully','success');
            } else {
                redirect('products', 'Material created but failed to log quantity!','error');
            }
        } else {
            redirect('products', 'Couldn\'t create Material!','error');
        }
    }





    if (isset($_POST['updateProduct'])) { 
        $product_id = validate($_POST['product_id']);
        $productData = getById('products', $product_id);
        
        if (!$productData) {
            redirect('products', 'No such product found');
        }
    
        $category_id = validate($_POST['category_id']);   
        $materialcategory = validate($_POST['materialcategory']);   
        $name = validate($_POST['name']);
        $description = validate($_POST['description']);
        $quantity_add = isset($_POST['quantity_add']) ? (int)$_POST['quantity_add'] : 0; // Ensure it's an integer
        $premark = validate($_POST['premark']);
    
        // Check for negative quantity
        if ($quantity_add < 0) {
            redirect('products-edit?id=' . $product_id, 'Quantity cannot be negative!','error');
        }
    
        // Check if an image is being updated
        if ($_FILES['image']['size'] > 0) { 
            // Allowed file extensions and MIME types
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'svg'];
            $allowed_mime_types = ['image/jpeg', 'image/png', 'image/svg+xml'];
    
            // Get the file's extension
            $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image_mime_type = mime_content_type($_FILES['image']['tmp_name']); // Get the MIME type of the uploaded file
    
            // Check if the file extension and MIME type are allowed
            if (!in_array(strtolower($image_ext), $allowed_extensions) || !in_array($image_mime_type, $allowed_mime_types)) {
                redirect('products-edit?id=' . $product_id, 'Please upload a valid image file (JPG, PNG, JPEG formats only)!','error');
            }
    
            // Generate new filename and move the file
            $path = "../assets/uploads/products"; 
            $filename = time() . '.' . $image_ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $filename); 
            $finalImage = "assets/uploads/products/" . $filename;
    
            // Delete the old image if exists
            $deleteImage = "../" . $productData['data']['image']; 
            if (file_exists($deleteImage)) { 
                unlink($deleteImage);
            }
        } else {
            $finalImage = $productData['data']['image']; // Keep old image if no new image uploaded
        }
    
        // Calculate new quantity
        $current_quantity = (int)$productData['data']['quantity']; // Ensure it's an integer
        $new_quantity = $current_quantity + $quantity_add;
    
        // Update status if the product is out of stock
        $status = $new_quantity == 0 ? 1 : 0;
    
        // Prepare data for updating the product
        $data = [
            'category_id' => $category_id,
            'materialcategory' => $materialcategory,
            'name' => $name,
            'description' => $description,
            'quantity' => $new_quantity,
            'image' => $finalImage,
            'status' => $status,
            'premark' => $premark
        ];
    
        // Update the product in the database //ADD +++ THIS FOR MATERIAL ENTRY
        $result = updateProducts('products', $product_id, $data);
    
        // Log the added quantity
        if ($quantity_add > 0) { // Only log if there's an addition
            $quantityLogData  = [
                'product_id' => $product_id,
                'quantity_added' => $quantity_add,
                'added_by' => $_SESSION['loggedInUser']['name'],
                'created_at' => date('Y-m-d H:i:s') // Create timestamp directly here
            ];
            
            // Call the insert function for logging
            if (!insert('product_quantity_log', $quantityLogData )) {
                error_log("Failed to log quantity addition for material ID: $product_id");
            }
        }
    
        if ($result) {
            redirect('products-edit?id=' . $product_id, 'Material updated successfully!');
        } else {
            redirect('products-edit?id=' . $product_id, 'Could not update material!','error');
        }
    }
    
           
                
if (isset($_POST['saveRemark'])) {
    $product_id = validate($_POST['product_id']);
    $premark = validate($_POST['premark']);
    $data = [
        'premark' => $premark,
    ];
    $result = update('products', $product_id, $data);
    if ($result) {
        redirect('products', 'Remark added successfully!');
    } else {
        redirect('products', 'Could not add remark!','error');
    }
}

//5/4/2024
if (isset($_POST['savedCustomers']))  //validate name customers-create.php
{
    
        $name = validate($_POST['name']);
        $email = validate($_POST['email']);
        $phone = validate($_POST['phone']);
        $status = isset($_POST['status'])  ? 1:0;
        $customer_placed_by_id = $_SESSION['loggedInUser']['name'];

            // Checking if its not empty
            if ($name != '' && $email != '' && $phone != '') {
                // Check if email already exists
                $emailCheck = mysqli_query($conn, "SELECT * FROM customers WHERE email='$email' AND id!='$customersId'");
                if ($emailCheck) {
                    if (mysqli_num_rows($emailCheck)) {
                        redirect('customers-create'.$customersId, 'Email already exists!','error');
                    }
                }
                 // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirect('customers-create', 'Invalid email format!','error');
    }

         // Validate phone number length
         if (strlen($phone) !== 11 || !ctype_digit($phone)) {
            redirect('customers-create', 'Phone number must be 11 digits long','error');
        }

        
                // Check if phone number already exists
                $phoneCheck = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone' AND id!='$customersId'");
                if ($phoneCheck) {
                    if (mysqli_num_rows($phoneCheck)) {
                        redirect('customers-create' . $customersId, 'Phone number already exists!','error');
                    }
                }
    
                  // Check if phone number already exists
                //   $nameCheck = mysqli_query($conn, "SELECT * FROM customers WHERE name='$name' AND id!='$customersId'");
                //   if ($nameCheck) {
                //       if (mysqli_num_rows($nameCheck)) {
                //           redirect('customers-create' . $customersId, 'Company name already exists!');
                //       }
                //   }
                $data = [
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'status' => $status,
                        'customer_placed_by_id' => $customer_placed_by_id
                        
                        ];                     //databased name //cell
                        $result = insert('customers', $data);
                        if($result){
                                redirect('customers', 'Contractor created successfully!');
                            }else {
                                redirect('customers', 'Couldnt created contractor!','error');
                            }
        }else{ 
                redirect('customers','Fill up the required input fields');
        }   
} 



//5/4/2024/ updateCustomers ,customersId
if (isset($_POST['updateCustomers'])) {
    $customersId = validate($_POST['customersId']);
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);

    // Check if the user is a superadmin
    $issuperadmin = $_SESSION['loggedInUser']['role'] === 'superadmin';
    
    // Set status based on whether checkbox is checked, but only if the user is an admin
    $status = isset($_POST['status']) && $_SESSION['loggedInUser']['role'] === 'admin' ? 1 : 0;

    // Checking if the inputs are not empty
    if ($name != '' && $email != '' && $phone != '') {
        // Check if email already exists
        $emailCheck = mysqli_query($conn, "SELECT * FROM customers WHERE email='$email' AND id!='$customersId'");
        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck)) {
                redirect('customers-edit?id='.$customersId, 'Email already exists!','error');
            }
        }

        // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirect('customers-edit?id=' . $customersId, 'Invalid email format!','error');
    }

        // Check if phone number already exists
        $phoneCheck = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone' AND id!='$customersId'");
        if ($phoneCheck) {
            if (mysqli_num_rows($phoneCheck)) {
                redirect('customers-edit?id=' . $customersId, 'Phone number already exists!','error');
            }
        }

     
            // Validate phone number length
    if (strlen($phone) !== 11 || !ctype_digit($phone)) {
        redirect('customers-edit?id=' . $customersId, 'Phone numbers must be 11 digits long ','error');
    }


        // Prepare data for update
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];
        
        // If the user is an admin, include the status in the data array
        if ($_SESSION['loggedInUser']['role'] === 'admin') {
            $data['status'] = $status; // status can be set or updated
        }

        // Perform the update
        $result = update('customers', $customersId, $data);

        if ($result) {
            redirect('customers-edit?id=' . $customersId, 'Contractor updated successfully!');
        } else {
            redirect('customers-edit?id='. $customersId, 'Cant update contractor!','error');
        }
    } else {
        redirect('customers', 'Fill the required input fields','error');
    }
}


//Profile Settings 
if (isset($_POST['updateProfile'])) {
    $userId = validate($_POST['adminId']);  // Admin ID will actually be the logged-in user ID
    $userData = getById('admins', $userId); // Assuming your table is 'admins'

    if ($userData['status'] != 200) {
        redirect('profile-setting.php', 'User not found!','error');
    }

    // Getting user inputs from the form
    $name = validate($_POST['name']);
    $email = validate($_POST['remail']);
    $phone = validate($_POST['rphone']);
    $password = validate($_POST['password']);
    $confirmPassword = validate($_POST['confirmPassword']);  // Get the confirmation password field

    // Check if passwords match
    if (!empty($password) && $password !== $confirmPassword) {
        redirect('profile-setting.php', 'Passwords do not match!','error');
    }

    // Password validation (optional)
    if (!empty($password) && strlen($password) < 8) {
        redirect('profile-setting.php', 'Password must be at least 8 characters long','error');
    }

    // Password strength check (optional)
    function isPasswordStrong($password) {
        return strlen($password) >= 8 && preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password);
    }

    if (!empty($password) && !isPasswordStrong($password)) {
        redirect('profile-settings.php', 'Your password must be at least 8 characters long and include both letters and numbers to ensure account security','error');
    }

    // If the password is provided, hash it, otherwise use the current password
    $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : $userData['data']['password'];

    // Validate phone number length
    if (strlen($phone) !== 11 || !ctype_digit($phone)) {
        redirect('profile-settings.php', 'Phone number must be 11 digits.','error');
    }

    // Prepare data for update
    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword,
        'phone' => $phone
    ];

    // Update the user in the database
    $result = update('admins', $userId, $data);

    if ($result) {
        redirect('profile-setting.php', 'Profile updated successfully!');
    } else {
        redirect('profile-setting.php', 'Failed to update profile.','error');
    }
}

?>