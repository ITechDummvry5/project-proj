<?php  
include('../config/function.php');


if (isset($_POST['announcement_id'])) {
    $announcement_id = intval($_POST['announcement_id']);

    // Update the already_read status in the database
    $query = "UPDATE announcement SET already_read = 1 WHERE id = $announcement_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        // Include an error message for debugging if needed
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Announcement ID not provided']);
}


if (isset($_POST['saveRequest']))
 {
    $resident_id = $_SESSION['rloggedInUser']['ruser_id']; 
    $rservices = validate($_POST['rservices']);
    $rdescription = validate($_POST['rdescription']);
  

    $data = [
        'resident_id' => $resident_id, 
        'rservices' => $rservices, 
        'rdescription' => $rdescription,
        
        ];                     //databased name //cell
        $result = insert('request', $data);
        if($result){
                redirect('maintenance-request', 'Request created successfully!');
            }else {
                redirect('maintenance-request', 'Couldnt request for a moment!','error');
            }
}


if (isset($_POST['submitFeedback'])) {
    $request_id = intval($_POST['requestId']);
    $feedback = validate($_POST['feedbackText']);
    $rating = intval($_POST['ratingValue']);  // Get the rating value from the form

    // Update the request with feedback and rating
    $query = "UPDATE request SET feedback = '$feedback', rating = $rating WHERE id = $request_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        redirect('maintenance-resident-view', 'Feedback submitted successfully!');
    } else {
        redirect('maintenance-resident-view', 'Could not submit feedback at the moment!','error');
    }
}




if (isset($_POST['updateProfile'])) 
{
    $residentId = $_SESSION['rloggedInUser']['ruser_id'];  // Get logged-in user's ID
    $residentData = getById('residents', $residentId);     // Fetch resident data from DB

    if ($residentData['status'] != 200) {
        redirect('profile-setting.php', 'Error retrieving profile information!','error');
    }

    // Validate form inputs
    $rname = validate($_POST['rname']);
    $address = validate($_POST['address']);
    $remail = validate($_POST['remail']);
    $rphone = validate($_POST['rphone']);
    $rpassword = validate($_POST['rpassword']);
    $confirmPassword = validate($_POST['confirmPassword']);  // Add confirm password validation

    // Check if email or name already exists in another account
    $remailCheckQuery = "SELECT * FROM residents WHERE (remail='$remail' OR rname='$rname') AND id != '$residentId'";
    $rcheckResult = mysqli_query($conn, $remailCheckQuery);
    if ($rcheckResult && mysqli_num_rows($rcheckResult) > 0) {
        redirect('profile-settings.php', 'Email or Name already exists!','error');
    }

    if (!empty($rpassword)) {
        // Check if passwords match
        if ($rpassword !== $confirmPassword) {
            redirect('profile-setting.php', 'Passwords do not match!','error');
        }
        // Check password strength
        if (!isResidentPasswordStrong($rpassword)) {
            redirect('profile-setting.php', 'Password must be at least 8 characters long and include letters and numbers!','error');
        }
        $rhashedPassword = password_hash($rpassword, PASSWORD_BCRYPT);
    } else {
        $rhashedPassword = $residentData['data']['rpassword'];  // Keep current password if not changing
    }
    // Validate email format
    if (!filter_var($remail, FILTER_VALIDATE_EMAIL)) {
        redirect('profile-setting?id=' . $residentId, 'Invalid email format!','error');
    }

    // Validate phone number length
    if (strlen($rphone) !== 11 || !ctype_digit($rphone)) {
        redirect('profile-setting?id=' . $residentId, 'Phone numbers must be 11 digits long','error');
    }

    // Validate that name and email are not empty
    if (!empty($rname) && !empty($remail)) {
        // Prepare data for updating
        $data = [
            'rname' => $rname,
            'address' => $address,
            'remail' => $remail,
            'rphone' => $rphone,
            'rpassword' => $rhashedPassword,
        ];

        // Update resident info
        $result = update('residents', $residentId, $data);

        if ($result) {
            redirect('profile-setting.php', 'Profile updated successfully!');
        } else {
            redirect('profile-setting.php', 'Error updating profile!','error');
        }
    } else {
        redirect('profile-setting.php', '"Oops! It looks like you missed some required fields!','error');
    }
}

if (isset($_POST['submit_payment'])) {
    $resident_id = $_SESSION['rloggedInUser']['ruser_id']; // Logged-in resident's ID
    $gcash_number = validate($_POST['gcash_number']);
    $resident_amountpaid = validate($_POST['resident_amountpaid']);

     // Prevent the letter "e" from being entered in the payment amount
     if (strpos($resident_amountpaid, 'e') !== false) {
        redirect('resident-view-payment.php', 'The letter "e" is not allowed in the payment amount!', 'error');
    }

    // Validate that the payment amount is not negative
    if ($resident_amountpaid < 0) {
        redirect('resident-view-payment.php', 'Payment amount cannot be negative!', 'error');
    }

    // Define file upload logic
    $target_dir = "../assets/uploads/resident_images/";
    $imageFileType = strtolower(pathinfo($_FILES["proof_image"]["name"], PATHINFO_EXTENSION));

    // Allow only JPG, JPEG, PNG files
    $allowedFileTypes = ['jpg', 'jpeg', 'png'];
    if (!in_array($imageFileType, $allowedFileTypes)) {
        redirect('resident-view-payment.php', 'Only JPG, JPEG, and PNG file types are allowed for proof image!', 'error');
    }

    $unique_name = uniqid('proof_' . $gcash_number . '_') . '.' . $imageFileType;
    $target_file = $target_dir . $unique_name;
    $image_path = "assets/uploads/resident_images/" . $unique_name;

    // Ensure the payment doesn't exceed the current cost
    $query = "SELECT cost FROM residents WHERE id = $resident_id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $resident = mysqli_fetch_assoc($result);
        if ($resident_amountpaid > $resident['cost']) {
            redirect('resident-view-payment.php', 'Payment exceeds the remaining balance!', 'error');
        }

        // Upload proof image
        if (move_uploaded_file($_FILES["proof_image"]["tmp_name"], $target_file)) {
          
            $insertQuery = "INSERT INTO resident_pay (resident_id, gcash_number, resident_amountpaid, proof_image, status)
                            VALUES ($resident_id, '$gcash_number', '$resident_amountpaid', '$image_path', 'pending')";
            if (mysqli_query($conn, $insertQuery)) {
                redirect('resident-view-payment.php', 'Payment submitted for verification.');
            } else {
                redirect('resident-view-payment.php', 'Error saving payment details: ' . mysqli_error($conn), 'error');
            }
        } else {
            redirect('resident-view-payment.php', 'Error uploading proof image!', 'error');
        }
    } else {
        redirect('resident-view-payment.php', 'Resident not found!', 'error');
    }
}



?>