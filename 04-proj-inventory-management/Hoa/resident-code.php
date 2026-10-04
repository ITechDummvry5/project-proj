<?php
include('../config/function.php'); // Include necessary functions


//Profile Settings 
if (isset($_POST['updateProfile'])) {
    $userId = validate($_POST['adminId']);  // Admin ID will actually be the logged-in user ID
    $userData = getById('admins', $userId); // Assuming your table is 'admins'

    if ($userData['status'] != 200) {
        redirect('profile-settings.php', 'User not found!','error');
    }

    // Getting user inputs from the form
    $name = validate($_POST['name']);
    $email = validate($_POST['remail']);
    $phone = validate($_POST['rphone']);
    $password = validate($_POST['password']);
    $confirmPassword = validate($_POST['confirmPassword']);  // Get the confirmation password field

    // Check if passwords match
    if (!empty($password) && $password !== $confirmPassword) {
        redirect('profile-settings.php', 'Passwords do not match!','error');
    }

    // Password validation (optional)
    if (!empty($password) && strlen($password) < 8) {
        redirect('profile-settings.php', 'Password must be at least 8 characters long!','error');
    }

    // Password strength check (optional)
    function isPasswordStrong($password) {
        return strlen($password) >= 8 && preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password);
    }

    if (!empty($password) && !isPasswordStrong($password)) {
        redirect('profile-settings.php', 'Your password must be at least 8 characters long and include both letters and numbers to ensure account security!','error');
    }

    // If the password is provided, hash it, otherwise use the current password
    $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : $userData['data']['password'];

    // Validate phone number length
    if (strlen($phone) !== 11 || !ctype_digit($phone)) {
        redirect('profile-settings.php', 'Phone number must be 11 digits!','error');
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
        redirect('profile-settings.php', 'Profile updated successfully!');
    } else {
        redirect('profile-settings.php', 'Failed to update profile!','error');
    }
}


// Handle resident creation
if (isset($_POST['savedResident'])) {
    $rname = validate($_POST['rname']);
    $phase = validate($_POST['phase']);
    $block = validate($_POST['block']);
    $lot = validate($_POST['lot']);
    // Combine phase, block, and lot into a single address string
    $address = $phase . ', Block ' . $block . ', Lot ' . $lot;
    $remail = validate($_POST['remail']);
    $rphone = validate($_POST['rphone']);
    $rpassword = validate($_POST['rpassword']);
    $cash_bond_description = validate($_POST['cash_bond_description']);
    $ban_resident = isset($_POST['ban_resident']) ? 1 : 0;

    $rphone = str_replace(' ', '', $rphone);  // Remove all spaces

// Validate that the phone number is exactly 11 digits long and numeric
if (!preg_match('/^\d{11}$/', $rphone)) {
    redirect('resident-create', 'Please enter a valid phone number','error');
}

    // Validate required fields
    if ($rname != '' && $remail != '' && $rpassword != '') {

         
         // Validate email format
         if (!filter_var($remail, FILTER_VALIDATE_EMAIL)) {
            redirect('resident-create', 'Invalid email format!','error');
          
        }
         // Validate password strength
         if (!isResidentPasswordStrong($rpassword)) {
            redirect('resident-create', 'Your password must be at least 8 characters long and include both letters and numbers to ensure account security!','error');
          
        }
       // Check for existing email, name, address, or phone
$residentCheckQuery = "SELECT * FROM residents WHERE remail='$remail' OR rname='$rname' OR address='$address' OR rphone='$rphone'";
$residentCheckResult = mysqli_query($conn, $residentCheckQuery);

if ($residentCheckResult && mysqli_num_rows($residentCheckResult) > 0) {
    $existingResident = mysqli_fetch_assoc($residentCheckResult);

    // Check if email already exists
    if ($existingResident['remail'] == $remail) {
        redirect('resident-create', 'Email already exists!','error');
    }

    // Check if name already exists
    if ($existingResident['rname'] == $rname) {
        redirect('resident-create', 'Name already exists!','error');
    }

    // Check if address already exists
    if ($existingResident['address'] == $address) {
        redirect('resident-create', 'Address already exists!','error');
    }

    // Check if phone already exists
    if ($existingResident['rphone'] == $rphone) {
        redirect('resident-create', 'Phone number already exists!','error');
    }

        } else {
            // Hash the password
            $Rbcrypt_password = password_hash($rpassword, PASSWORD_BCRYPT);
            
                  // Validate phone number length
    if (strlen($rphone) !== 11 || !ctype_digit($rphone)) {
        redirect('resident-create','Phone numbers must be 11 digits long ','error');
    }
            // Prepare the data array for insertion
            $data = [
                'rname' => $rname,
                'address' => $address,  // Combined address
                'remail' => $remail,
                'rphone' => $rphone,
                'rpassword' => $Rbcrypt_password,
                'ban_resident' => $ban_resident,
                'cash_bond_description' => $cash_bond_description,
                'cost' => $cost // Assuming cost is defined elsewhere
            ];

            // Insert the resident
            $result = insert('residents', $data); // Assuming you have an insert function

            if ($result) {
                redirect('resident', 'Resident successfully inserted!');
            } else {
                redirect('resident-create', '500 Something went wrong!','error');
            }
        }
    } else {
        redirect('resident-create', 'Please fill up required fields!','error');
    }
}


// Handle resident update
if (isset($_POST['updateResident'])) {
    $residentId = intval($_POST['residentId']);
    $rname = validate($_POST['rname']);
    $address = validate($_POST['address']);
    $remail = validate($_POST['remail']);
    $rphone = validate($_POST['rphone']);
    $rpassword = validate($_POST['rpassword']);
    $ban_resident = isset($_POST['ban_resident']) ? 1 : 0;

    $rphone = str_replace(' ', '', $rphone);  // Remove all spaces

    // Validate that the phone number is exactly 11 digits long and numeric
    if (!preg_match('/^\d{11}$/', $rphone)) {
        redirect('resident-edit?id=' . $residentId, 'Please enter a valid phone number!','error');
    }

    // Fetch resident data
    $residentData = getById('residents', $residentId);

    if (!$residentData) {
        redirect('resident-edit?id=' . $residentId, 'Resident not found!','error');
    }

    // Validate email format
    if (!filter_var($remail, FILTER_VALIDATE_EMAIL)) {
        redirect('resident-edit?id=' . $residentId, 'Invalid email format!','error');
       
    }
  // Check for existing email, name, address, or phone (excluding current resident)
  $residentCheckQuery = "SELECT * FROM residents WHERE (remail='$remail' OR rname='$rname' OR address='$address' OR rphone='$rphone') AND id != $residentId";
  $residentCheckResult = mysqli_query($conn, $residentCheckQuery);

  if ($residentCheckResult && mysqli_num_rows($residentCheckResult) > 0) {
      $existingResident = mysqli_fetch_assoc($residentCheckResult);

      // Check if email already exists
      if ($existingResident['remail'] == $remail) {
          redirect('resident-edit?id=' . $residentId, 'Email already exists!','error');
      }

      // Check if name already exists
      if ($existingResident['rname'] == $rname) {
          redirect('resident-edit?id=' . $residentId, 'Name already exists!','error');
      }

      // Check if address already exists
      if ($existingResident['address'] == $address) {
          redirect('resident-edit?id=' . $residentId, 'Address already exists!','error');
      }

      // Check if phone already exists
      if ($existingResident['rphone'] == $rphone) {
          redirect('resident-edit?id=' . $residentId, 'Phone number already exists!','error');
      }
  }
    // If password is provided, validate strength and hash it. Otherwise, use the old password.
    if (!empty($rpassword)) {
        if (!isResidentPasswordStrong($rpassword)) {
            redirect('resident-edit?id=' . $residentId, 'Your password must be at least 8 characters long and include both letters and numbers to ensure account security!','error');
        }
        $rhashedPassword = password_hash($rpassword, PASSWORD_BCRYPT);
    } else {
        $rhashedPassword = $residentData['data']['rpassword'];
    }
    // Validate phone number length
    if (strlen($rphone) !== 11 || !ctype_digit($rphone)) {
        redirect('resident-edit?id=' . $residentId, 'Phone numbers must be 11 digits long!','error');
    }

    // Validate required fields
    if (!empty($rname) && !empty($remail)) {
        $data = [
            'rname' => $rname,
            'address' => $address,
            'remail' => $remail,
            'rphone' => $rphone,
            'rpassword' => $rhashedPassword,
            'ban_resident' => $ban_resident
        ];

        // Update the resident
        $result = update('residents', $residentId, $data); // Assuming you have an update function

        if ($result) {
            redirect('resident-edit?id=' . $residentId, 'Resident updated successfully!');
        } else {
            redirect('resident-edit?id=' . $residentId, 'Something went wrong while updating!','error');
        }
    } else {
        redirect('resident-edit?id=' . $residentId, 'Please fill up required fields.');
       
    }
}



if (isset($_POST['saveAnnouncement'])) { 
    $heading = validate($_POST['heading']);
    $body = validate($_POST['body']);
    $startDate = $_POST['start_date']; // Get start date
    $endDate = $_POST['end_date']; // Get end date
    $imagePaths = [];

     // Handle missing end date if start date is provided
     if (!empty($startDate) && empty($endDate)) {
        redirect('announcement-create', 'End date cannot be left blank when a start date is entered!','error');
    }

    // Directory for uploads
    $path = "../assets/uploads/announcement";
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    // Check if there are files uploaded
    if (isset($_FILES['images']) && count($_FILES['images']['name']) >= 1) {
        $images = $_FILES['images'];
        $numFiles = count($images['name']);

          // Check the maximum file count limit
          if ($numFiles > 3) {
            redirect('announcement-create', 'You can only upload a maximum of 3 images!','error');
        }
        // Limit to a maximum of 3 files
        for ($i = 0; $i < min($numFiles, 3); $i++) {
            if ($images['size'][$i] > 0) {
                $image_ext = pathinfo($images['name'][$i], PATHINFO_EXTENSION);
                if (!in_array($image_ext, ['jpg', 'jpeg', 'png' , 'svg'])) {
                    redirect('announcement-create', 'Please upload a valid image file jpg, png, jpeg formats only!','error');
                }
                $hfilename = time() . "_$i." . $image_ext;
                $fullPath = "$path/$hfilename";

                // Move uploaded file
                if (move_uploaded_file($images['tmp_name'][$i], $fullPath)) {
                    // Store the relative path for database
                    $imagePaths[] = "assets/uploads/announcement/$hfilename";
                }
            }
        }
    } else {
        redirect('announcement-create', 'Please upload at least one image!','error');
      
    }
    // Join image paths with a comma separator for multiple images
    $hfinalImage = implode(",", $imagePaths);

    // Prepare data array
    $data = [
        'heading' => $heading,
        'body' => $body,
        'image' => $hfinalImage, // Store concatenated paths
        'start_date' => $startDate,
        'end_date' => $endDate,
        'hcreated_at' => date('Y-m-d h:i A')
    ];

    // Insert into database
    $result = insert('announcement', $data);
    if ($result) {
        redirect('announcement-create', 'Announcement created successfully!');
    } else {
        redirect('announcement-create', 'Could not create announcement!','error');
    }
}


// Update Announcement
if (isset($_POST['updateAnnouncement'])) {  
    $announcement_id = validate($_POST['announcement_id']);
    $himage = getById('announcement', $announcement_id);

    if (!$himage) {
        redirect('announcement-view', 'No such announcement found!','error');
    
    }

    $heading = validate($_POST['heading']);
    $body = validate($_POST['body']);
    $hfinalImages = []; // Array to hold final image paths

    // Check if new images are uploaded
    if (isset($_FILES['images']) && !empty(array_filter($_FILES['images']['name']))) { 
        $path = "../assets/uploads/announcement";

        // Validate the number of uploaded images
        $numFiles = count(array_filter($_FILES['images']['name']));
        if ($numFiles > 3) {
            redirect('announcement-edit?id=' . $announcement_id, 'You can only upload up to 3 images!','error');
           
        }

        // Loop through each uploaded image and process it
        foreach ($_FILES['images']['name'] as $key => $imageName) {
            if ($_FILES['images']['error'][$key] == UPLOAD_ERR_OK) { // Check for upload errors
                $image_ext = pathinfo($imageName, PATHINFO_EXTENSION);
                if (!in_array($image_ext, ['jpg', 'jpeg', 'png' , 'svg'])) {
                    redirect('announcement-edit?id=' . $announcement_id, 'Please upload a valid image file jpg, png, jpeg formats only!','error');
                    
                }          
                $hfilename = time() . '_' . $key . '.' . $image_ext; // Generate unique filename
                $fullPath = $path . "/" . $hfilename;

                // Upload the new image
                if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $fullPath)) {
                    $hfinalImages[] = "assets/uploads/announcement/" . $hfilename; // Add to final images array
                }
            }
        }

        // Delete old images only if new images are uploaded
        $existingImages = explode(',', $himage['data']['image']);
        foreach ($existingImages as $oldImage) {
            $hdeleteImage = "../" . $oldImage; 
            if (file_exists($hdeleteImage)) { 
                unlink($hdeleteImage); // Delete old image files
            }
        }
    } else {
        // If no new images are uploaded, retain the existing images
        $hfinalImages = explode(',', $himage['data']['image']);
    }

    // Convert final images array back to a comma-separated string for database storage
    $data = [
        'heading' => $heading,
        'body' => $body,
        'image' => implode(',', $hfinalImages) // Store images as a comma-separated string
    ];                    

    // Update the database with new data
    $result = update('announcement', $announcement_id, $data);

    // Redirect based on update result
    if ($result) {
        redirect('announcement-edit?id=' . $announcement_id, 'Announcement updated successfully!');
    } else {
        redirect('announcement-edit?id=' . $announcement_id, 'Couldn\'t update announcement!','error');
    }
}

// Add Cash
if (isset($_POST['addResidentCash'])) {
    // Fetch current data
    $residentId = intval($_POST['resident_id']);
    $newCost = intval(validate($_POST['cost']));
    $currentCost = intval(validate($_POST['current_cost']));
    $cashBondDescription = validate($_POST['cash_bond_description']);

    // Check for negative values
    if ($newCost < 0 || $currentCost < 0) {
        redirect('create-cashband.php', 'Cannot be negative!','error');
    }

    // 419

    // Calculate the total cost
    $totalCost = $currentCost + $newCost;

    // Prepare data for updating the resident record
    $data = [
        'cost' => $totalCost,
        'cash_bond_description' => $cashBondDescription,
    ];

    // Update the database with the new cost and possibly updated image
    $result = update('residents', $residentId, $data);

    if ($result) {
        redirect('create-cashband.php', "Payment '$newCost' added successfully!");
    } else {
        $error = mysqli_error($conn);
        redirect('create-cashband.php', "SQL Error: $error", 'error');
    }
}



// Billing System start here
// Add Cash (Update Resident's Cost)
if (isset($_POST['addResidentCash'])) {
    // Fetch current data
    $residentId = intval($_POST['resident_id']);
    $newCost = intval(validate($_POST['cost']));
    $currentCost = intval(validate($_POST['current_cost']));
    $cashBondDescription = validate($_POST['cash_bond_description']);

    // Check for negative values
    if ($newCost < 0 || $currentCost < 0) {
        redirect('create-cashband.php', 'Cannot be negative!', 'error');
    }

    // Calculate the total cost
    $totalCost = $currentCost + $newCost;

    // Prepare data for updating the resident record
    $data = [
        'cost' => $totalCost,
        'cash_bond_description' => $cashBondDescription,
    ];

    // Update the database with the new cost and cash bond description
    $result = update('residents', $residentId, $data);

    if ($result) {
        redirect('create-cashband.php', "Payment '$newCost' added successfully!");
    } else {
        $error = mysqli_error($conn);
        redirect('create-cashband.php', "SQL Error: $error", 'error');
    }
}

// Billing System (Add Bill Item and Handle Proof Image)
if (isset($_POST['addItem'])) {
    $id_resident = intval($_POST['id_resident']);
    $amount_paid = floatval($_POST['amount_paid']);
    $proof_image = isset($_FILES['proof_image']) ? $_FILES['proof_image'] : null; // Handle proof image upload

    // Fetch resident details
    $result = mysqli_query($conn, "SELECT * FROM residents WHERE id=$id_resident LIMIT 1");

    if (mysqli_num_rows($result) === 0) {
        $_SESSION['status'] = "Resident not found!";
        redirect('hoa-cashier.php', 'danger', 'error');
    }

    $resident = mysqli_fetch_assoc($result);

    // Initialize session items if not set
    if (!isset($_SESSION['residentItems'])) {
        $_SESSION['residentItems'] = [];
    }

    // Add the item to session
    $_SESSION['residentItems'][] = [
        'id_resident' => $id_resident,
        'rname' => $resident['rname'],
        'remail' => $resident['remail'],
        'rphone' => $resident['rphone'],
        'cost' => $resident['cost'],
        'cash_bond_description' => $resident['cash_bond_description'],
        'proof_image' => $resident['proof_image'],  // Store the current proof image from the resident table
        'amount_paid' => $amount_paid
    ];

    // If a new proof image is uploaded, save it
    if ($proof_image) {
        // Handle file upload for proof image
        $upload_dir = 'uploads/proof_images/';
        $target_file = $upload_dir . basename($proof_image['name']);
        move_uploaded_file($proof_image['tmp_name'], $target_file);

        // Update proof image in session for this resident
        $_SESSION['residentItems'][count($_SESSION['residentItems'])-1]['proof_image'] = $target_file;
    }

    $_SESSION['status'] = "Item added successfully!";
    redirect('hoa-cashier.php', 'Resident Added ' ,'success');
}



// Proceed to Payment (Finalize the Payment and Store Data)
if (isset($_POST['proceedToPaymentCashband'])) {
    $payment_mode = validate($_POST['payment_mode']);
    
    if (empty($payment_mode)) {
        jsonResponse(400, 'danger', 'Payment method is required!');
    }

    foreach ($_SESSION['residentItems'] as $item) {
        $id_resident = $item['id_resident'];
        $current_cost = floatval($item['cost']);
        $amount_paid = floatval($item['amount_paid']);
        $remaining_balance = $current_cost - $amount_paid; // Calculate remaining balance

        // Step 1: Generate a random `ref_number`
        $ref_number = 'REF-' . rand(100, 999) . ' ' . rand(100, 999) . ' ' . rand(100, 999) . ' ' . rand(100, 999);

        // Step 2: Update the resident's remaining balance
        $result = mysqli_query($conn, "UPDATE residents SET cost = $remaining_balance WHERE id = $id_resident");
        if (!$result) {
            jsonResponse(500, 'danger', 'Error updating resident cost!');
        }

        // Step 3: Retrieve the `proof_image` from the `resident_pay` table
        $proof_image = NULL;
        $getProofImageQuery = "SELECT proof_image FROM resident_pay WHERE resident_id = $id_resident AND status = 'pending' ORDER BY payment_date ASC LIMIT 1";
        $proofImageResult = mysqli_query($conn, $getProofImageQuery);

        if ($proofImageResult && mysqli_num_rows($proofImageResult) > 0) {
            $proof_image_row = mysqli_fetch_assoc($proofImageResult);
            $proof_image = $proof_image_row['proof_image'];
        } else {
            // If no proof image is found, you can handle the case here (e.g., default image or error)
            $proof_image = NULL;  // Or provide a default proof image if necessary
        }

        // Step 4: Insert payment details into `payments` table, including `proof_image` from `resident_pay`
        $cash_bond_description = isset($item['cash_bond_description']) ? "'{$item['cash_bond_description']}'" : "NULL";

        $paymentResult = mysqli_query($conn, "INSERT INTO payments (resident_id, amount_paid, payment_date, payment_mode, cash_bond_description, remaining_balance, proof_image, ref_number) 
            VALUES ($id_resident, $amount_paid, NOW(), '$payment_mode', $cash_bond_description, $remaining_balance, '$proof_image', '$ref_number')");

        if (!$paymentResult) {
            jsonResponse(500, 'danger', 'Error recording payment! ' . mysqli_error($conn));  // Display error if insertion fails
        }

        // Step 5: Update status in the `resident_pay` table to 'completed'
        $updateStatusQuery = "UPDATE resident_pay 
                              SET status = 'completed', payment_date = NOW() 
                              WHERE resident_id = $id_resident 
                              AND status = 'pending' 
                              ORDER BY payment_date ASC LIMIT 1";

        $updateStatusResult = mysqli_query($conn, $updateStatusQuery);

        if (!$updateStatusResult) {
            jsonResponse(500, 'danger', 'Error updating payment status!');
        }
    }

    // Clear session items and return success
    unset($_SESSION['residentItems']);
    $_SESSION['status'] = "Payment successful!";
    echo json_encode(['status' => 200, 'message' => 'Payment successful!']);
    exit();
}




?>
