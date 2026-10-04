<?php
include('../config/function.php');

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
$emailNamePhoneCheck = mysqli_query($conn, "SELECT * FROM account WHERE email='$email' OR name='$name' OR phone='$phone'");
if (mysqli_num_rows($emailNamePhoneCheck) > 0) {
    $existing = mysqli_fetch_assoc($emailNamePhoneCheck);
    
    // Check if email already exists
    if ($existing['email'] == $email) {
        redirect('account-create.php', 'Email already exists!','error');
    }

    // Check if name already exists
    if ($existing['name'] == $name) {
        redirect('account-create.php', 'Name already exists!','error');
    }

    // Check if phone already exists
    if ($existing['phone'] == $phone) {
        redirect('account-create.php', 'Phone number already exists!','error');
    }
}
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirect('account-create.php', 'Invalid email format!','error');
        }
            // Validate phone number length
            if (strlen($phone) !== 11 || !ctype_digit($phone)) {
                redirect('account-create.php', 'Phone number must be 11 digits long','error');
            }

        // Validate password strength
        function isAdminPasswordStrong($password) {
            return strlen($password) >= 8 && preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password);
        }
        if (!isAdminPasswordStrong($password)) {
            redirect('account-create.php', 'Password must be at least 8 characters long and include letters and numbers','error');
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

        $result = insert('account', $data);
        if ($result) {
            unset($_SESSION['form_data']); // Clear form data on success
            redirect('account-create.php', 'Admin created successfully!','success');
        } else {
            redirect('account-create.php', 'Failed to Fetch! Please try again.','error');
        }
    } else {
        redirect('account-create.php', '"Oops! It looks like you missed some required fields!','error');
    }
}


// For updating admin
if (isset($_POST['updateaccount'])) {
    $adminId = validate($_POST['adminId']);
    $adminData = getById('account', $adminId);
    if ($adminData['status'] != 200) {
        redirect('account-edit.php?id=' . $adminId, '"Oops! It looks like you missed some required fields!','error');
    }

    $name = validate($_POST['name']);
    $password = validate($_POST['password']);
    $role = isset($_POST['role']) && !empty($_POST['role']) ? validate($_POST['role']) : $adminData['data']['role']; // Use the current role if not updated
    $is_ban = $adminData['data']['is_ban']; // Keep current value for is_ban

    // Check if editing own account
    $isEditingOwnAccount = $_SESSION['loggedInUser']['user_id'] == $adminId;

    // Only secretarys can change the ban status and role
    if (!$isEditingOwnAccount) {
        $is_ban = isset($_POST['is_ban']) ? 1 : 0;
    }

    // Validate email
    $emailNamePhoneCheck = mysqli_query($conn, "SELECT * FROM account WHERE (email='$email' OR name='$name' OR phone='$phone') AND id!='$adminId'");
    if (mysqli_num_rows($emailNamePhoneCheck) > 0) {
        $existing = mysqli_fetch_assoc($emailNamePhoneCheck);
        
  
        
        if ($existing['name'] == $name) {
            redirect('account-edit.php?id=' . $adminId, 'Name already exists!','error');
        }
    
    }

    function isPasswordStrong($password) {
        return strlen($password) >= 8 && preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password);
    }
    // Password validation and hashing if needed
    if (!empty($password)) {
        if (!isPasswordStrong($password)) {
            redirect('account-edit.php?id=' . $adminId, 'Password must be at least 8 characters long and include letters and numbers','error');
        }
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password']; // Use current password if not changing
    }
 

    // Prepare data for update
    $data = [
        'name' => $name,
    
        'password' => $hashedPassword,
     
        'is_ban' => $is_ban
    ];

    if ($_SESSION['loggedInUser']['role'] === 'secretary') {
        $data['role'] = $role;
    }

    $result = update('account', $adminId, $data);
    if ($result) {
        redirect('account-edit.php?id=' . $adminId, 'Admin updated successfully!','success');
    } else {
        redirect('account-edit.php?id=' . $adminId, 'Failed to Fetch!','error');
    }
}


//Profile Settings 
if (isset($_POST['updateProfile'])) {
    $userId = validate($_POST['adminId']);  // Admin ID will actually be the logged-in user ID
    $userData = getById('account', $userId); // Assuming your table is 'admins'

    if ($userData['status'] != 200) {
        redirect('profile-edit.php', 'User not found!','error');
    }

    // Getting user inputs from the form
    $name = validate($_POST['name']);
    $email = validate($_POST['remail']);
    $phone = validate($_POST['rphone']);
    $password = validate($_POST['password']);
    $confirmPassword = validate($_POST['confirmPassword']);  // Get the confirmation password field

    // Check if passwords match
    if (!empty($password) && $password !== $confirmPassword) {
        redirect('profile-edit.php', 'Passwords do not match!','error');
    }

    // Password validation (optional)
    if (!empty($password) && strlen($password) < 8) {
        redirect('profile-edit.php', 'Password must be at least 8 characters long','error');
    }

    // Password strength check (optional)
    function isPasswordStrong($password) {
        return strlen($password) >= 8 && preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password);
    }

    if (!empty($password) && !isPasswordStrong($password)) {
        redirect('profile-edit.php', 'Your password must be at least 8 characters long and include both letters and numbers to ensure account security','error');
    }

    // If the password is provided, hash it, otherwise use the current password
    $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : $userData['data']['password'];

    // Validate phone number length
    if (strlen($phone) !== 11 || !ctype_digit($phone)) {
        redirect('profile-edit.php', 'Phone number must be 11 digits.','error');
    }

    // Prepare data for update
    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword,
        'phone' => $phone
    ];

    // Update the user in the database
    $result = update('account', $userId, $data);

    if ($result) {
        redirect('profile-edit.php', 'Profile updated successfully!');
    } else {
        redirect('profile-edit.php', 'Failed to update profile.','error');
    }
}


if (isset($_POST['personalInfo'])) {
    $name = validate($_POST['name']);
    $address = validate($_POST['address']);
    $profileImg = $_FILES['profileImg'];
    $capturedImage = $_POST['capturedImage']; // Captured image (base64)
    $length_of_years = (int)$_POST['length_of_years']; // Cast to integer


    $_SESSION['form_data'] = $_POST; // Save form data to session in case of error

    if ($name != '' && $address != '') {
        // Check for duplicate name or address
        $CheckData = mysqli_query($conn, "SELECT * FROM personal WHERE name='$name'");
        if (mysqli_num_rows($CheckData) > 0) {
            $existing = mysqli_fetch_assoc($CheckData);

            if ($existing['name'] == $name) {
                redirect('personal-create.php', 'Name already exists!', 'error');
            }
        } else {
            // Handle profile image upload or capture
            $finalImage = '';

            if ($capturedImage) {
                // If captured image (base64)
                $imageData = base64_decode(str_replace('data:image/png;base64,', '', $capturedImage));
                $imageName = 'captured_' . time() . '.png';
                $imagePath = '../uploads/' . $imageName;
                file_put_contents($imagePath, $imageData);
                $finalImage = "uploads/" . $imageName;
            } elseif ($_FILES['profileImg']['size'] > 0) {
                // If file upload
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'svg'];
                $image_ext = strtolower(pathinfo($_FILES['profileImg']['name'], PATHINFO_EXTENSION));

                // Validate file extension
                if (!in_array($image_ext, $allowed_extensions)) {
                    redirect('personal-create.php', 'Invalid file extension!', 'error');
                }

                // File upload handling
                $path = "../uploads/";
                $filename = time() . '.' . $image_ext;
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                move_uploaded_file($_FILES['profileImg']['tmp_name'], $path . "/" . $filename);
                $finalImage = "uploads/" . $filename;
            }

            // Insert data (without Contnumber initially)
            $data = [
                'name' => $name,
                'address' => $address,
                'profile_image' => $finalImage,
                'length_of_years' => $length_of_years,
            ];

            $result = insert('personal', $data); // Assuming this inserts and returns true if successful
            if ($result) {
                // Get the last inserted ID
                $lastInsertedId = mysqli_insert_id($conn);

                // Generate Contnumber based on ID
                $Contnumber = 'BC-' . str_pad($lastInsertedId, 5, '0', STR_PAD_LEFT);

                // Update the record with the generated Contnumber
                $updateQuery = "UPDATE personal SET contnumber = '$Contnumber' WHERE id = '$lastInsertedId'";
                mysqli_query($conn, $updateQuery);

                // Log the activity
                $performed_By = $_SESSION['loggedInUser']['name'];
                $logQuery = "INSERT INTO activity_logs (personal_id, action_type, name, address, length_of_years, performed_by)
                             VALUES ('$lastInsertedId', 'insert', '$name', '$address', '$length_of_years', '$performed_By')";
                mysqli_query($conn, $logQuery);

                unset($_SESSION['form_data']); // Clear form data on success
                redirect('personal-create.php', 'Personal information saved successfully!', 'success');
            } else {
                redirect('personal-create.php', 'Failed to save! Please try again.', 'error');
            }
        }
    } else {
        redirect('personal-create.php', 'Oops! It looks like you missed some required fields!', 'error');
    }
}


// Your existing code here...

if (isset($_POST['updatePersonalinfo'])) {
    $personalId = validate($_POST['personalId']);
    $name = validate($_POST['name']);
    $address = validate($_POST['address']);
    $profileImg = $_FILES['profileImg'];
    $capturedProfileImage = isset($_POST['capturedProfileImage']) ? $_POST['capturedProfileImage'] : null;
    $length_of_years = (int)$_POST['length_of_years'];

    // Fetch the current personal data
$personalData = getById('personal', $personalId);
if ($personalData['status'] != 200) {
    redirect('personal-edit.php?id=' . $personalId, 'Personal data not found!', 'error');
}

$profileImgPath = $personalData['data']['profile_image']; // Existing profile image path

// Handle the captured image (base64 string)
if ($capturedProfileImage) {
    // Decode the captured base64 image
    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $capturedProfileImage));
    $uploadDir = '../uploads/';
    $filename = time() . '.png';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Delete old profile image if exists
    if ($profileImgPath && file_exists('../' . $profileImgPath)) {
        unlink('../' . $profileImgPath); // Delete the old image
    }

    // Save the new captured image
    file_put_contents($uploadDir . $filename, $data);
    $profileImgPath = 'uploads/' . $filename;
}

// Handle the uploaded file (if any)
if ($_FILES['profileImg']['size'] > 0) {
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'svg'];
    $allowed_mime_types = ['image/jpeg', 'image/png', 'image/svg+xml'];

    $file_extension = strtolower(pathinfo($_FILES['profileImg']['name'], PATHINFO_EXTENSION));
    $file_mime_type = mime_content_type($_FILES['profileImg']['tmp_name']);

    if (!in_array($file_extension, $allowed_extensions)) {
        redirect('personal-edit.php?id=' . $personalId, 'Invalid file extension!', 'error');
    }

    if (!in_array($file_mime_type, $allowed_mime_types)) {
        redirect('personal-edit.php?id=' . $personalId, 'Invalid MIME type!', 'error');
    }

    $uploadDir = '../uploads/';
    $filename = time() . '.' . $file_extension;

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    move_uploaded_file($_FILES['profileImg']['tmp_name'], $uploadDir . $filename);

    // Delete old profile image if exists
    if ($profileImgPath && file_exists('../' . $profileImgPath)) {
        unlink('../' . $profileImgPath); // Delete the old image
    }

    $profileImgPath = 'uploads/' . $filename;
}

// Update personal information in the database
$data = [
    'name' => $name,
    'address' => $address,
    'profile_image' => $profileImgPath,
    'length_of_years' => $length_of_years,
];

$result = update('personal', $personalId, $data);

if ($result) {
    $performed_By = $_SESSION['loggedInUser']['name'];
    $logQuery = "INSERT INTO activity_logs (personal_id, action_type, name, address, length_of_years, performed_by) 
    VALUES ('$personalId', 'update', '$name', '$address', '$length_of_years', '$performed_By')";
    mysqli_query($conn, $logQuery);

    redirect('personal-edit.php?id=' . $personalId, 'Personal information updated successfully!', 'success');
} else {
    redirect('personal-edit.php?id=' . $personalId, 'Failed to update personal information.', 'error');
}
}









?>