<?php include('../config/function.php');  

if (isset($_POST['saveddocument'])) {
    // Validate and sanitize form data
    $documentcategory = validate($_POST['documentcategory']);
    $personalId = validate($_POST['personal_Id']);  // Fetch the selected personal Id
    
    // Check if personal_Id is empty
    if (empty($personalId)) {
        $statusMessage = "Personal ID is required. Please select a personal record.";
        redirect('create-document.php', $statusMessage, 'error');
    }

$requiredCategories = [
    'barangaycertificate',
    'barangayclearance',
];

// Check if the document category is one that requires validation for required fields
if (in_array($documentcategory, $requiredCategories)) {
    // Check if any required field is empty
    $requiredFields = ['since', 'birthday', 'birthplace', 'civilstatus', 'services'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $statusMessage = "Resident ". ucfirst($field) . " is required. <strong>Please fill out all</strong> the required fields.";
            redirect('create-document.php', $statusMessage, 'error');
        }
    }

    // Additional validation for the 'since' field to ensure it's a 4-digit number
    if (!empty($_POST['since']) && !preg_match('/^\d{4}$/', $_POST['since'])) {
        $statusMessage = "Resident since must be a <strong>4-digit number</strong>. Please enter a valid year.";
        redirect('create-document.php', $statusMessage, 'error');
    }
}

    $statusMessage = "";
    $statusType = "error";
    // Initialize the data array for the insert function
    $data = [];

    // Determine which table to insert data into based on document category
    switch ($documentcategory) {
        case 'barangaycertificate':
            // Prepare data for barangaycertificate table
            $data = [
                'personal_Id' => $personalId, 
                'since' => validate($_POST['since']),
                'birthday' => validate($_POST['birthday']),
                'age' => validate($_POST['age']),
                'birthplace' => validate($_POST['birthplace']),
                'civilstatus' => validate($_POST['civilstatus']),
                'services' => validate($_POST['services']), // Added services field
                'optionaluse' => isset($_POST['optionaluse']) ? validate($_POST['optionaluse']) : null, // Make for optional
            ];
            $table = 'barangaycertificate';
            break;

        case 'barangayclearance':
            // Prepare data for barangayclearance table
            $data = [
                'personal_Id' => $personalId, 
                'since' => validate($_POST['since']),
                'birthday' => validate($_POST['birthday']),
                'age' => validate($_POST['age']),
                'birthplace' => validate($_POST['birthplace']),
                'civilstatus' => validate($_POST['civilstatus']),
                'services' => validate($_POST['services']), // Added services field
                'optionaluse' => isset($_POST['optionaluse']) ? validate($_POST['optionaluse']) : null, // Make for optional
           
            ];
            $table = 'barangayclearance';
            break;

        case 'barangayindigency':
            // Prepare data for barangayindigency table
            $data = [
                'personal_Id' => $personalId, 
                'since' => validate($_POST['since']),
                'birthday' => validate($_POST['birthday']),
                'age' => validate($_POST['age']),
                'birthplace' => validate($_POST['birthplace']),
                'civilstatus' => validate($_POST['civilstatus']),
                'optionaluse' => isset($_POST['optionaluse']) ? validate($_POST['optionaluse']) : null, // Make for optional
            ];
            $table = 'barangayindigency';
            break;

        case 'barangayresidency':
            // Prepare data for barangayresidency table
            $data = [
                'personal_Id' => $personalId, 
                'since' => validate($_POST['since']),
                'birthday' => validate($_POST['birthday']),
                'age' => validate($_POST['age']),
                'birthplace' => validate($_POST['birthplace']),
                'civilstatus' => validate($_POST['civilstatus']),
                'optionaluse' => isset($_POST['optionaluse']) ? validate($_POST['optionaluse']) : null, // Make for optional
            ];
            $table = 'barangayresidency';
            break;

        case 'pwdcertificate':
            // Prepare data for pwdcertificate table
            $data = [
                'personal_Id' => $personalId, 
                'age' => validate($_POST['age']),
                'civilstatus' => validate($_POST['civilstatus']),
        
            ];
            $table = 'pwdcertificate';
            break;

            case 'soloparentcertificate':
                // Prepare data for soloparentcertificate table
                $data = [
                    'personal_Id' => $personalId, 
                    'since' => validate($_POST['since']),
                    'category' => validate($_POST['category']),
                    'age' => validate($_POST['age']),
                    'children1' => isset($_POST['children1']) ? validate($_POST['children1']) : null, // Make optional
                    'children1_birthday' => isset($_POST['children1_birthday']) ? validate($_POST['children1_birthday']) : null, // Birthday field
                    'children2' => isset($_POST['children2']) ? validate($_POST['children2']) : null, // Make optional
                    'children2_birthday' => isset($_POST['children2_birthday']) ? validate($_POST['children2_birthday']) : null, // Birthday field
                    'children3' => isset($_POST['children3']) ? validate($_POST['children3']) : null, // Make optional
                    'children3_birthday' => isset($_POST['children3_birthday']) ? validate($_POST['children3_birthday']) : null, // Birthday field
                    'children4' => isset($_POST['children4']) ? validate($_POST['children4']) : null, // Make optional
                    'children4_birthday' => isset($_POST['children4_birthday']) ? validate($_POST['children4_birthday']) : null, // Birthday field
                ];
                $table = 'soloparentcertificate';
                break;
                
            case 'businessclearance':
                // Prepare data for businessclearance table
                $data = [
                    'personal_Id' => $personalId,
                    'businesscode' => validate($_POST['businesscode']),
                    'businessname' => validate($_POST['businessname']),
                    'location' => validate($_POST['location']),
                    'manager' => validate($_POST['manager']),
                    'address' => validate($_POST['address']),
                    'or_number' => validate($_POST['or_number']),
                ];
                $table = 'businessclearance';
            
                // Ensure that the businesscode is numeric
                if (!preg_match('/^\d{4}-\d{4}$/', $data['businesscode'])) {
                    $statusMessage = "The <strong>B-Control No.</strong> must be in the format YYYY-#### (e.g., 2025-0002).";
                    redirect('create-document.php', $statusMessage, 'error');
                }
                
            
                // Check if a record with the same businesscode already exists
                if (recordExistsByColumn($table, 'businesscode', $data['businesscode'])) {
                    $statusMessage = "A record with the same <strong>B-Control No.</strong> already exists in the $table.";
                    redirect('create-document.php', $statusMessage, 'error');
                }
            
                // Check if a record with the same or_number already exists
                if (recordExistsByColumn($table, 'or_number', $data['or_number'])) {
                    $statusMessage = "A record with the same <strong>O.R. Number</strong> already exists in the $table.";
                    redirect('create-document.php', $statusMessage, 'error');
                }
                break;
            

                case 'buildingclearance':
                    // Prepare data for buildingclearance table
                    $data = [
                        'personal_Id' => $personalId,
                        'buildingcode' => validate($_POST['buildingcode']),
                        'floorarea' => validate($_POST['floorarea']),
                        'construction' => validate($_POST['construction']),
                        'usedfor' => validate($_POST['usedfor']),
                        'location' => validate($_POST['location']),
                        'or_number' => !empty($_POST['or_number']) ? validate($_POST['or_number']) : null,
                        'or_date' => !empty($_POST['or_date']) ? validate($_POST['or_date']) : null,
                        'cedula_no' => !empty($_POST['cedula_no']) ? validate($_POST['cedula_no']) : null,
                        'issued_at' => !empty($_POST['issued_at']) ? validate($_POST['issued_at']) : null,
                        'issued_on' => !empty($_POST['issued_on']) ? validate($_POST['issued_on']) : null,
                    ];
                    $table = 'buildingclearance';
                
                    // Ensure that the buildingcode is numeric
                    if (!preg_match('/^\d{4}-\d{4}$/', $data['buildingcode'])) {
                        $statusMessage = "The <strong>B-Control No.</strong> must be in the format YYYY-#### (e.g., 2025-0002).";
                        redirect('create-document.php', $statusMessage, 'error');
                    }
                    
                
                    // Check if a record with the same buildingcode already exists
                    if (recordExistsByColumn($table, 'buildingcode', $data['buildingcode'])) {
                        $statusMessage = "A record with the same <strong>B-Control No.</strong> already exists in the $table.";
                        redirect('create-document.php', $statusMessage, 'error');
                    }
                    break;
                

        case 'franchising':
            $data = [
                'personal_Id' => $personalId,
                'franchisingcode' => validate($_POST['franchisingcode']),  
                'drivername' => validate($_POST['drivername']),           
                'license' => validate($_POST['license']),           
                'platenumber' => validate($_POST['platenumber']),      
                'receiptnumber' => validate($_POST['receiptnumber']),
                  // Additional fields
        'or_number' => validate($_POST['or_number']),
        'or_date' => validate($_POST['or_date']),
        'cedula_no' => validate($_POST['cedula_no']),
        'issued_on' => validate($_POST['issued_on']),
               
            ];
            $table = 'franchising';

              // Ensure that the franchisingcode is numeric
              if (!preg_match('/^\d{4}-\d{4}$/', $data['franchisingcode'])) {
                $statusMessage = "The <strong>F-Control No.</strong> must be in the format YYYY-#### (e.g., 2025-0002).";
                redirect('create-document.php', $statusMessage, 'error');
            }
            
             // Check if a record with the same franchisingcode already exists
    if (recordExistsByColumn($table, 'franchisingcode', $data['franchisingcode'])) {
        $statusMessage = "A record with the same <strong>Franchising Code</strong> already exists.";
        redirect('create-document.php', $statusMessage, 'error');
    }

    // Check if a record with the same receiptnumber already exists
    if (recordExistsByColumn($table, 'receiptnumber', $data['receiptnumber'])) {
        $statusMessage = "A record with the same <strong>Receipt Number</strong> already exists.";
        redirect('create-document.php', $statusMessage, 'error');
    }
            break;
            
            case 'certificationoflegitimacy':
            
                $data = [
                    'personal_Id' => $personalId,
                    'work' => validate($_POST['work']),  // Collecting the work input
                    'yearsofwork' => validate($_POST['yearsofwork']),  // Collecting the length of work (Years)
                    'usedfor' => validate($_POST['usedfor']),  // Collecting the selected document type
                    'age' => validate($_POST['age']),
                ];
                $table = 'certificationoflegitimacy';
                break;
                case 'cohabitationletter':
                    $data = [
                        'personal_Id' => $personalId,
                        'namefor' => validate($_POST['namefor']),  // Name of the partner
                        'purposefor' => validate($_POST['purposefor']),  // Purpose for the document
                        'bornfor' => validate($_POST['bornfor']),  // Date of birth
                        'partnerbornfor' => validate($_POST['partnerbornfor']),  // Partner's date of birth
                        'yearslivein' => validate($_POST['yearslivein']),  // Number of years living together
                        'sincedateliving' => validate($_POST['sincedateliving']),  // Date since living together
                    ];
                    $table = 'cohabitationletter';
                    break;

                    case 'certificationoflowincome':
                       // Prepare data for certification tables (previous case examples)
                     $data = [
                    'personal_Id' => $personalId,
                    'work' => validate($_POST['work']),  // Collecting the job title
                    'age' => validate($_POST['age']),  // Collecting the age
                    'usedfor' => validate($_POST['usedfor']),  // Collecting the document usage
                    'income' => validate($_POST['income']),  // Collecting the income
                     ];
                     // Assign the corresponding table based on the selected value
                    $table = 'certificationoflowincome'; // Dynamic table name: 'certificationoflowincome' or 'certificationofsourceofincome'
                    break;

                    case 'certificationofsourceofincome':
                        // Prepare data for certification tables (previous case examples)
                      $data = [
                     'personal_Id' => $personalId,
                     'work' => validate($_POST['work']),  // Collecting the job title
                     'age' => validate($_POST['age']),  // Collecting the age
                     'usedfor' => validate($_POST['usedfor']),  // Collecting the document usage
                     'income' => validate($_POST['income']),  // Collecting the income
                      ];
                      // Assign the corresponding table based on the selected value
                     $table = 'certificationofsourceofincome'; // Dynamic table name: 'certificationofsourceofincome' or 'certificationofsourceofincome'
                     break;

                     case 'certificateofgoodmoral':
                        // Prepare data for certification tables (previous case examples)
                      $data = [
                     'personal_Id' => $personalId,
                     'usedfor' => validate($_POST['usedfor']),  // Collecting the document usage
                  
                      ];
                      // Assign the corresponding table based on the selected value
                     $table = 'certificateofgoodmoral'; // Dynamic table name: 'certificationofsourceofincome' or 'certificationofsourceofincome'
                     break;

                     case 'certificationofcalamity':
            
                        $data = [
                            'personal_Id' => $personalId,
                            'calamitytypes' => validate($_POST['calamitytypes']),  // Collecting the calamitytypes input
                            'calamitydate' => validate($_POST['calamitydate']),  // Collecting the calamitytypes input
                            'purpose' => validate($_POST['purpose']),
                        ];
                        $table = 'certificationofcalamity';
                        break;
                    
                        case 'certificationofesc':
                            $data = [
                                'personal_Id' => $personalId,
                                'father' => !empty($_POST['father']) ? validate($_POST['father']) : NULL,  // Set to NULL if empty
                                'mother' => !empty($_POST['mother']) ? validate($_POST['mother']) : NULL,  // Set to NULL if empty
                                'child' => validate($_POST['child']),  // Collecting the child input
                                'school' => validate($_POST['school']),  // Collecting the school input
                                'residentsince' => validate($_POST['residentsince']),  // Collecting the residentsince input
                                'purpose' => !empty($_POST['purpose']) ? validate($_POST['purpose']) : NULL,  // Adding purpose field
                            ];
                            $table = 'certificationofesc';
                            break;
                        
                        
                

        default:
            // If the selected document category is invalid
            $statusMessage = "Invalid document category selected.";
            redirect('create-document.php', $statusMessage, 'error');
    }

       // Check if a record with the same personal_Id already exists in the table
       if (recordExists($table, $personalId)) {
        $statusMessage = "A record with the same <strong>Personal Information</strong> already exists in the $documentcategory.";
        redirect('create-document.php', $statusMessage, 'error');
    }

    // Insert the data into the corresponding table
    if (insert($table, $data)) {
        $statusMessage = "Record added successfully!";
        $statusType = 'success';
    } else {
        $statusMessage = "Error adding record. Please try again.";
    }

    // Redirect with the status message
    redirect('create-document.php', $statusMessage, $statusType);
}

//**UPDATE SECTION START */

// Update Barangay Certificate or Other Records
if (isset($_POST['updatebrgycertificateinfo'])) {
    $brgycertificateId = validate($_POST['brgycertificate_id']); // Hidden field with the ID
    $since = validate($_POST['since']);
    $birthday = validate($_POST['birthday']);
    $age = validate($_POST['age']);
    $birthplace = validate($_POST['birthplace']);
    $civilstatus = validate($_POST['civilstatus']);
    $services = validate($_POST['services']); // Get services field value
    $optionaluse = isset($_POST['optionaluse']) ? validate($_POST['optionaluse']) : null; // Set to null if not provided  
    $councilor = isset($_POST['councilor']) && !empty($_POST['councilor']) ? validate($_POST['councilor']) : null;

    // Validate inputs
    if (empty($since) || empty($birthday) || empty($birthplace) || empty($civilstatus)) {
        redirect('edit-barangay-certificate.php?id=' . $brgycertificateId, 'Please fill out all required fields.', 'error');
    }

    if (!preg_match('/^\d{4}$/', $since)) {
        redirect('edit-barangay-certificate.php?id=' . $brgycertificateId, 'Invalid year format for "Residence Since". Please enter a valid 4-digit year.', 'error');
    }

    // Check if the record exists
    $brgycertificate = getById('barangaycertificate', $brgycertificateId);
    if ($brgycertificate['status'] != 200) {
        redirect('barangay-certificate.php', 'Record not found!', 'error');
    }

    // Prepare data for updating
    $data = [
        'since' => $since,
        'birthday' => $birthday,
        'age' => $age,
        'birthplace' => $birthplace,
        'civilstatus' => $civilstatus,
        'services' => $services, // Added services field to the update data
        'optionaluse' => $optionaluse,
        'councilor' => $councilor, // New field for Barangay Councilor
    ];

   // Update the record in the database
   $result = update('barangaycertificate', $brgycertificateId, $data);

   if ($result) {
       redirect('edit-barangay-certificate.php?id=' . $brgycertificateId, 'Barangay certificate updated successfully!', 'success');
   } else {
       redirect('edit-barangay-certificate.php?id=' . $brgycertificateId, 'Failed to update the record. Please try again.', 'error');
   }
}


// Update Barangay Clearance or Other Records
if (isset($_POST['updatebrgyclearanceinfo'])) {
    $brgyclearanceId = validate($_POST['brgyclearance_id']); // Hidden field with the ID
    $since = validate($_POST['since']);
    $birthday = validate($_POST['birthday']);
    $age = validate($_POST['age']);
    $birthplace = validate($_POST['birthplace']);
    $civilstatus = validate($_POST['civilstatus']);
    $services = validate($_POST['services']); // Get services field value
    $optionaluse = isset($_POST['optionaluse']) ? validate($_POST['optionaluse']) : null; // Set to null if not provided 
    $councilor = isset($_POST['councilor']) && !empty($_POST['councilor']) ? validate($_POST['councilor']) : null;


    // Validate inputs
    if (empty($since) || empty($birthday) || empty($birthplace) || empty($civilstatus)) {
        redirect('edit-barangay-clearance.php?id=' . $brgyclearanceId, 'Please fill out all required fields.', 'error');
    }

    if (!preg_match('/^\d{4}$/', $since)) {
        redirect('edit-barangay-clearance.php?id=' . $brgyclearanceId, 'Invalid year format for "Residence Since". Please enter a valid 4-digit year.', 'error');
    }

    // Check if the record exists
    $brgyclearance = getById('barangayclearance', $brgyclearanceId);
    if ($brgyclearance['status'] != 200) {
        redirect('barangay-clearance.php', 'Record not found!', 'error');
    }

    // Prepare data for updating
    $data = [
        'since' => $since,
        'birthday' => $birthday,
        'age' => $age,
        'birthplace' => $birthplace,
        'civilstatus' => $civilstatus,
        'services' => $services, // Added services field to the update data
        'optionaluse' => $optionaluse,
        'councilor' => $councilor, // New field for Barangay Councilor
    ];

   // Update the record in the database
   $result = update('barangayclearance', $brgyclearanceId, $data);

   if ($result) {
       redirect('edit-barangay-clearance.php?id=' . $brgyclearanceId, 'Barangay clearance updated successfully!', 'success');
   } else {
       redirect('edit-barangay-clearance.php?id=' . $brgyclearanceId, 'Failed to update the record. Please try again.', 'error');
   }
}

// Update Barangay Indigency or Other Records
if (isset($_POST['updatebrgyindigencyinfo'])) {
    $brgyindigencyId = validate($_POST['brgyindigency_id']); // Hidden field with the ID
    $since = validate($_POST['since']);
    $birthday = validate($_POST['birthday']);
    $age = validate($_POST['age']);
    $birthplace = validate($_POST['birthplace']);
    $civilstatus = validate($_POST['civilstatus']);
    $optionaluse = isset($_POST['optionaluse']) ? validate($_POST['optionaluse']) : null; // Set to null if not provided  
    $councilor = isset($_POST['councilor']) && !empty($_POST['councilor']) ? validate($_POST['councilor']) : null;

    // Validate inputs
    if (empty($since) || empty($birthday) || empty($birthplace) || empty($civilstatus)) {
        redirect('edit-barangay-indigency.php?id=' . $brgyindigencyId, 'Please fill out all required fields.', 'error');
    }

    if (!preg_match('/^\d{4}$/', $since)) {
        redirect('edit-barangay-indigency.php?id=' . $brgyindigencyId, 'Invalid year format for "Residence Since". Please enter a valid 4-digit year.', 'error');
    }

    // Check if the record exists
    $brgyindigency = getById('barangayindigency', $brgyindigencyId);
    if ($brgyindigency['status'] != 200) {
        redirect('barangay-indigency.php', 'Record not found!', 'error');
    }

    // Prepare data for updating
    $data = [
        'since' => $since,
        'birthday' => $birthday,
        'age' => $age,
        'birthplace' => $birthplace,
        'civilstatus' => $civilstatus,
        'optionaluse' => $optionaluse,
        'councilor' => $councilor, // New field for Barangay Councilor

        
    ];

   // Update the record in the database
   $result = update('barangayindigency', $brgyindigencyId, $data);

   if ($result) {
       redirect('edit-barangay-indigency.php?id=' . $brgyindigencyId, 'Barangay indigency updated successfully!', 'success');
   } else {
       redirect('edit-barangay-indigency.php?id=' . $brgyindigencyId, 'Failed to update the record. Please try again.', 'error');
   }
}

// Update Barangay Residency or Other Records
if (isset($_POST['updatebrgyresidencyinfo'])) {
    $brgyresidencyId = validate($_POST['brgyresidency_id']); // Hidden field with the ID
    $since = validate($_POST['since']);
    $birthday = validate($_POST['birthday']);
    $age = validate($_POST['age']);
    $birthplace = validate($_POST['birthplace']);
    $civilstatus = validate($_POST['civilstatus']);
    $optionaluse = isset($_POST['optionaluse']) ? validate($_POST['optionaluse']) : null; // Set to null if not provided  
    $councilor = isset($_POST['councilor']) && !empty($_POST['councilor']) ? validate($_POST['councilor']) : null;

    // Validate inputs
    if (empty($since) || empty($birthday) || empty($birthplace) || empty($civilstatus)) {
        redirect('edit-barangay-residency.php?id=' . $brgyresidencyId, 'Please fill out all required fields.', 'error');
    }

    if (!preg_match('/^\d{4}$/', $since)) {
        redirect('edit-barangay-residency.php?id=' . $brgyresidencyId, 'Invalid year format for "Residence Since". Please enter a valid 4-digit year.', 'error');
    }

    // Check if the record exists
    $brgyresidency = getById('barangayresidency', $brgyresidencyId);
    if ($brgyresidency['status'] != 200) {
        redirect('barangay-residency.php', 'Record not found!', 'error');
    }

    // Prepare data for updating
    $data = [
        'since' => $since,
        'birthday' => $birthday,
        'age' => $age,
        'birthplace' => $birthplace,
        'civilstatus' => $civilstatus,
        'optionaluse' => $optionaluse,
        'councilor' => $councilor, // New field for Barangay Councilor


    ];

   // Update the record in the database
   $result = update('barangayresidency', $brgyresidencyId, $data);

   if ($result) {
       redirect('edit-barangay-residency.php?id=' . $brgyresidencyId, 'Barangay residency updated successfully!', 'success');
   } else {
       redirect('edit-barangay-residency.php?id=' . $brgyresidencyId, 'Failed to update the record. Please try again.', 'error');
   }
}

// Update  PWD Certificate or Other Records
if (isset($_POST['updatepwdinfo'])) {
    $brgyresidencyId = validate($_POST['pwd_id']); // Hidden field with the ID
    $age = validate($_POST['age']);
    $civilstatus = validate($_POST['civilstatus']);



    // Validate inputs
    if (empty($age) || empty($civilstatus)) {
        redirect('edit-pwdcertificate.php?id=' . $brgyresidencyId, 'Please fill out all required fields.', 'error');
    }

    if (!preg_match('/^\d{4}$/', $since)) {
        redirect('edit-pwdcertificate.php?id=' . $brgyresidencyId, 'Invalid year format for "Residence Since". Please enter a valid 4-digit year.', 'error');
    }

    // Check if the record exists
    $brgyresidency = getById('pwdcertificate', $brgyresidencyId);
    if ($brgyresidency['status'] != 200) {
        redirect('pwdcertificate.php', 'Record not found!', 'error');
    }

    // Prepare data for updating
    $data = [
        'since' => $since,
        'birthday' => $birthday,
        'age' => $age,
        'birthplace' => $birthplace,
        'civilstatus' => $civilstatus,
 
    ];

   // Update the record in the database
   $result = update('pwdcertificate', $brgyresidencyId, $data);

   if ($result) {
       redirect('edit-pwdcertificate.php?id=' . $brgyresidencyId, 'Barangay residency updated successfully!', 'success');
   } else {
       redirect('edit-pwdcertificate.php?id=' . $brgyresidencyId, 'Failed to update the record. Please try again.', 'error');
   }
}

// Update Solo Parent Certificate or Other Records
if (isset($_POST['updatesoloparentcertificateinfo'])) {
    $soloparentcertificateId = validate($_POST['soloparentcertificate_id']); // Hidden field with the ID
    $since = validate($_POST['since']);
    $age = validate($_POST['age']);
    $category = validate($_POST['category']);
    // Children fields (optional)
    $children1 = isset($_POST['children1']) ? validate($_POST['children1']) : null;
    $children1_birthday = isset($_POST['children1_birthday']) ? validate($_POST['children1_birthday']) : null;
    $children2 = isset($_POST['children2']) ? validate($_POST['children2']) : null;
    $children2_birthday = isset($_POST['children2_birthday']) ? validate($_POST['children2_birthday']) : null;
    $children3 = isset($_POST['children3']) ? validate($_POST['children3']) : null;
    $children3_birthday = isset($_POST['children3_birthday']) ? validate($_POST['children3_birthday']) : null;
    $children4 = isset($_POST['children4']) ? validate($_POST['children4']) : null;
    $children4_birthday = isset($_POST['children4_birthday']) ? validate($_POST['children4_birthday']) : null;
    $councilor = isset($_POST['councilor']) && !empty($_POST['councilor']) ? validate($_POST['councilor']) : null;


    // Validate inputs
    if (empty($since) || empty($age) || empty($category)) {
        redirect('edit-soloparentcertificate.php?id=' . $soloparentcertificateId, 'Please fill out all required fields.', 'error');
    }

    if (!preg_match('/^\d{4}$/', $since)) {
        redirect('edit-soloparentcertificate.php?id=' . $soloparentcertificateId, 'Invalid year format for "Residence Since". Please enter a valid 4-digit year.', 'error');
    }

    // Check if the record exists
    $brgyresidency = getById('soloparentcertificate', $soloparentcertificateId);
    if ($brgyresidency['status'] != 200) {
        redirect('soloparentcertificate.php', 'Record not found!', 'error');
    }

    // Prepare data for updating
    $data = [
        'since' => $since,
        'age' => $age,
        'category' => $category,
        'children1' => $children1,
        'children1_birthday' => $children1_birthday,
        'children2' => $children2,
        'children2_birthday' => $children2_birthday,
        'children3' => $children3,
        'children3_birthday' => $children3_birthday,
        'children4' => $children4,
        'children4_birthday' => $children4_birthday,
        'councilor'=> $councilor,
    ];

    // Update the record in the database
    $result = update('soloparentcertificate', $soloparentcertificateId, $data);

    if ($result) {
        redirect('edit-soloparentcertificate.php?id=' . $soloparentcertificateId, 'Solo parent certificate updated successfully!', 'success');
    } else {
        redirect('edit-soloparentcertificate.php?id=' . $soloparentcertificateId, 'Failed to update the record. Please try again.', 'error');
    }
}

 

// Update Business Clearance or Other Records
if (isset($_POST['updatebusinessclearanceinfo'])) {
    // Retrieve and sanitize inputs
    $businessclearanceId = validate($_POST['businessclearance_id']); // Hidden field with the ID
    $businesscode = validate($_POST['businesscode']);
    $businessname = validate($_POST['businessname']);
    $location = validate($_POST['location']);
    $manager = validate($_POST['manager']);
    $address = validate($_POST['address']);
    $or_number = validate($_POST['or_number']);


    // Validate required fields
    if (empty($businessname) || empty($location) || empty($manager) || empty($address) || empty($or_number)) {
        redirect('edit-business-clearance.php?id=' . $businessclearanceId, 'Please fill out all required fields.', 'error');
    }

    // Check if the record exists in the database
    $businessclearance = getById('businessclearance', $businessclearanceId);
    if ($businessclearance['status'] != 200) {
        redirect('businessclearance.php', 'Record not found!', 'error');
    }

         // Check if the buildingcode already exists in another record (excluding the current record)
         $query = "SELECT COUNT(*) AS count FROM businessclearance WHERE businesscode = '$businesscode' AND id != '$businessclearanceId'";
         $result = mysqli_query($conn, $query);
         $data = mysqli_fetch_assoc($result);
     
         if ($data['count'] > 0) {
             // The buildingcode already exists in another record
             redirect('edit-business-clearance.php?id=' . $businessclearanceId, 'The building code already exists. Please choose a different code.', 'error');
         }

    // Prepare data for updating
    $data = [
        'businesscode' => $businesscode,
        'businessname' => $businessname,
        'location' => $location,
        'manager' => $manager,
        'address' => $address,
        'or_number' => $or_number,
    ];

    // Perform the update operation
    $result = update('businessclearance', $businessclearanceId, $data);

    // Check if the update was successful
    if ($result) {
        redirect('edit-business-clearance.php?id=' . $businessclearanceId, 'Business clearance updated successfully!', 'success');
    } else {
        redirect('edit-business-clearance.php?id=' . $businessclearanceId, 'Failed to update the record. Please try again.', 'error');
    }
}

// Update Building Clearance or Other Records
if (isset($_POST['updatebuildingclearanceinfo'])) {
    // Retrieve and sanitize inputs
    $buildingclearanceId = validate($_POST['buildingclearance_id']); // Hidden field with the ID
    $buildingcode = validate($_POST['buildingcode']);
    $floorarea = validate($_POST['floorarea']);
    $construction = validate($_POST['construction']);
    $usedfor = validate($_POST['usedfor']);
    $location = validate($_POST['location']);
    $or_number = !empty($_POST['or_number']) ? validate($_POST['or_number']) : null;
    $or_date = !empty($_POST['or_date']) ? validate($_POST['or_date']) : null;
    $cedula_no = !empty($_POST['cedula_no']) ? validate($_POST['cedula_no']) : null;
    $issued_at = !empty($_POST['issued_at']) ? validate($_POST['issued_at']) : null;
    $issued_on = !empty($_POST['issued_on']) ? validate($_POST['issued_on']) : null;

    // Validate required fields
    if (empty($buildingcode) || empty($floorarea) || empty($construction) || empty($usedfor) || empty($location)) {
        redirect('edit-building-clearance.php?id=' . $buildingclearanceId, 'Please fill out all required fields.', 'error');
    }

    // Check if the record exists in the database
    $buildingclearance = getById('buildingclearance', $buildingclearanceId);
    if ($buildingclearance['status'] != 200) {
        redirect('building-clearance.php', 'Record not found!', 'error');
    }

    // Check if the buildingcode already exists in another record (excluding the current record)
    $query = "SELECT COUNT(*) AS count FROM buildingclearance WHERE buildingcode = '$buildingcode' AND id != '$buildingclearanceId'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data['count'] > 0) {
        // The buildingcode already exists in another record
        redirect('edit-building-clearance.php?id=' . $buildingclearanceId, 'The building code already exists. Please choose a different code.', 'error');
    }

    // Prepare data for updating
    $data = [
        'buildingcode' => $buildingcode,
        'floorarea' => $floorarea,
        'construction' => $construction,
        'usedfor' => $usedfor,
        'location' => $location,
        'or_number' => $or_number,
        'or_date' => $or_date,
        'cedula_no' => $cedula_no,
        'issued_at' => $issued_at,
        'issued_on' => $issued_on,
    ];

    // Perform the update operation
    $result = update('buildingclearance', $buildingclearanceId, $data);

    // Check if the update was successful
    if ($result) {
        redirect('edit-building-clearance.php?id=' . $buildingclearanceId, 'Building clearance updated successfully!', 'success');
    } else {
        redirect('edit-building-clearance.php?id=' . $buildingclearanceId, 'Failed to update the record. Please try again.', 'error');
    }
}


// Update Franchising Information
if (isset($_POST['updatefranchisinginfo'])) {
    // Retrieve and sanitize inputs
    $franchisingId = validate($_POST['franchising_id']); // Hidden field with the ID
    $franchisingcode = validate($_POST['franchisingcode']);
    $drivername = validate($_POST['drivername']);
    $license = validate($_POST['license']);
    $platenumber = validate($_POST['platenumber']);
    $receiptnumber = validate($_POST['receiptnumber']);
    // Additional fields
    $or_number = validate($_POST['or_number']);
    $or_date = validate($_POST['or_date']);
    $cedula_no = validate($_POST['cedula_no']);
    $issued_on = validate($_POST['issued_on']);

    // Validate required fields
    if (empty($franchisingcode) || empty($drivername) || empty($license) || empty($platenumber) || empty($receiptnumber)) {
        redirect('edit-franchising.php?id=' . $franchisingId, 'Please fill out all required fields.', 'error');
    }

    // Check if the record exists in the database
    $franchising = getById('franchising', $franchisingId);
    if ($franchising['status'] != 200) {
        redirect('franchising.php', 'Record not found!', 'error');
    }

    // Check for duplicate franchisingcode in another record
    $query = "SELECT COUNT(*) AS count FROM franchising WHERE franchisingcode = '$franchisingcode' AND id != '$franchisingId'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    if ($data['count'] > 0) {
        redirect('edit-franchising.php?id=' . $franchisingId, 'The franchising code already exists. Please use a unique code.', 'error');
    }

    // Check for duplicate receiptnumber in another record
    $query = "SELECT COUNT(*) AS count FROM franchising WHERE receiptnumber = '$receiptnumber' AND id != '$franchisingId'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    if ($data['count'] > 0) {
        redirect('edit-franchising.php?id=' . $franchisingId, 'The receipt number already exists. Please use a unique receipt number.', 'error');
    }

    // Prepare data for updating
    $data = [
        'franchisingcode' => $franchisingcode,
        'drivername' => $drivername,
        'license' => $license,
        'platenumber' => $platenumber,
        'receiptnumber' => $receiptnumber,
        'or_number' => $or_number,
        'or_date' => $or_date,
        'cedula_no' => $cedula_no,
        'issued_on' => $issued_on,
    ];

    // Perform the update operation
    $result = update('franchising', $franchisingId, $data);

    // Check if the update was successful
    if ($result) {
        redirect('edit-franchising.php?id=' . $franchisingId, 'Franchising information updated successfully!', 'success');
    } else {
        redirect('edit-franchising.php?id=' . $franchisingId, 'Failed to update the record. Please try again.', 'error');
    }
}

// Update Certification of Legitimacy Information
if (isset($_POST['updatecertificationoflegitimacyinfo'])) {
    // Retrieve and sanitize inputs
    $legitimacyId = validate($_POST['certificationoflegitimacy_id']); // Hidden field with the ID
    $work = validate($_POST['work']);
    $yearsofwork = validate($_POST['yearsofwork']);
    $usedfor = validate($_POST['usedfor']);
    $age = validate($_POST['age']);
    $councilor = isset($_POST['councilor']) && !empty($_POST['councilor']) ? validate($_POST['councilor']) : null;


    // Validate required fields
    if (empty($work) || empty($yearsofwork) || empty($usedfor) || empty($age)) {
        redirect('edit-certification-legitimacy.php?id=' . $legitimacyId, 'Please fill out all required fields.', 'error');
    }

    // Check if the record exists in the database
    $certification = getById('certificationoflegitimacy', $legitimacyId);
    if ($certification['status'] != 200) {
        redirect('certification-legitimacy.php', 'Record not found!', 'error');
    }

    // Prepare data for updating
    $data = [
        'work' => $work,
        'yearsofwork' => $yearsofwork,
        'usedfor' => $usedfor,
        'age' => $age,
        'councilor'=> $councilor,
    ];

    // Perform the update operation using your update() function
    $result = update('certificationoflegitimacy', $legitimacyId, $data);

    // Check if the update was successful
    if ($result) {
        redirect('edit-certification-legitimacy.php?id=' . $legitimacyId, 'Certification of Legitimacy information updated successfully!', 'success');
    } else {
        redirect('edit-certification-legitimacy.php?id=' . $legitimacyId, 'Failed to <strong>update</strong> the record. Please try again.', 'error');
    }
}

// Update Cohabitation Letter Information
if (isset($_POST['updatecohabitationletterinfo'])) {
    // Retrieve and sanitize inputs
    $cohabitationLetterId = validate($_POST['cohabitationletter_id']); // Hidden field with the ID
    $namefor = validate($_POST['namefor']);
    $purposefor = validate($_POST['purposefor']);
    $bornfor = validate($_POST['bornfor']);
    $partnerbornfor = validate($_POST['partnerbornfor']);
    $yearslivein = validate($_POST['yearslivein']);
    $sincedateliving = validate($_POST['sincedateliving']);
    $councilor = isset($_POST['councilor']) && !empty($_POST['councilor']) ? validate($_POST['councilor']) : null;


    // Validate required fields
    if (empty($namefor) || empty($purposefor)) {
        redirect('edit-cohabitation-letter.php?id=' . $cohabitationLetterId, 'Please fill out all required fields.', 'error');
    }

    // Check if the record exists in the database
    $cohabitationLetter = getById('cohabitationletter', $cohabitationLetterId);
    if ($cohabitationLetter['status'] != 200) {
        redirect('cohabitation-letter.php', 'Record not found!', 'error');
    }

    // Prepare data for updating
    $data = [
        'namefor' => $namefor,
        'purposefor' => $purposefor,
        'bornfor' => $bornfor,
        'partnerbornfor' => $partnerbornfor,
        'yearslivein' => $yearslivein,
        'sincedateliving' => $sincedateliving,
        'councilor' => $councilor,
    ];

    // Perform the update operation using your update() function
    $result = update('cohabitationletter', $cohabitationLetterId, $data);

    // Check if the update was successful
    if ($result) {
        redirect('edit-cohabitation-letter.php?id=' . $cohabitationLetterId, 'Cohabitation Letter information updated successfully!', 'success');
    } else {
        redirect('edit-cohabitation-letter.php?id=' . $cohabitationLetterId, 'Failed to <strong>update</strong> the record. Please try again.', 'error');
    }
}


// Update Certification of Low Income
if (isset($_POST['updatecertificationsourceinfo'])) {
    $certificationsource_id = validate($_POST['certificationsource_id']); // Hidden field with the ID
    $work = validate($_POST['work']);
    $age = validate($_POST['age']);
    $usedfor = validate($_POST['usedfor']);
    $income = validate($_POST['income']);
    $councilor = isset($_POST['councilor']) && !empty($_POST['councilor']) ? validate($_POST['councilor']) : null;


    // Validate inputs
    if (empty($work) || empty($age) || empty($usedfor) || empty($income)) {
        redirect('edit-certification-of-low-income.php?id=' . $certificationsource_id, 'Please fill out all required fields.', 'error');
    }

    if (!is_numeric($age) || $age <= 0) {
        redirect('edit-certification-of-low-income.php?id=' . $certificationsource_id, 'Please enter a valid age.', 'error');
    }

    if (!is_numeric($income) || $income <= 0) {
        redirect('edit-certification-of-low-income.php?id=' . $certificationsource_id, 'Please enter a valid income amount.', 'error');
    }

    // Check if the record exists
    $certification = getById('certificationoflowincome', $certificationsource_id);
    if ($certification['status'] != 200) {
        redirect('certification-of-low-income.php', 'Record not found!', 'error');
    }

    // Prepare data for updating
    $data = [
        'work' => $work,
        'age' => $age,
        'usedfor' => $usedfor,
        'income' => $income,
        'councilor'=> $councilor,
    ];

    // Update the record in the database
    $result = update('certificationoflowincome', $certificationsource_id, $data);

    if ($result) {
        redirect('edit-certification-of-low-income.php?id=' . $certificationsource_id, 'Certification of Low Income updated successfully!', 'success');
    } else {
        redirect('edit-certification-of-low-income.php?id=' . $certificationsource_id, 'Failed to update the record. Please try again.', 'error');
    }
}

// Update Certification of Source of Income
if (isset($_POST['updatecertificationlowinfo'])) {
    $certificationlow_id = validate($_POST['certificationlow_id']); // Hidden field with the ID
    $work = validate($_POST['work']);
    $age = validate($_POST['age']);
    $usedfor = validate($_POST['usedfor']);
    $income = validate($_POST['income']);
    $councilor = isset($_POST['councilor']) && !empty($_POST['councilor']) ? validate($_POST['councilor']) : null;


    // Validate inputs
    if (empty($work) || empty($age) || empty($usedfor) || empty($income)) {
        redirect('edit-certification-of-source-of-income.php?id=' . $certificationlow_id, 'Please fill out all required fields.', 'error');
    }

    if (!is_numeric($age) || $age <= 0) {
        redirect('edit-certification-of-source-of-income.php?id=' . $certificationlow_id, 'Please enter a valid age.', 'error');
    }

    if (!is_numeric($income) || $income <= 0) {
        redirect('edit-certification-of-source-of-income.php?id=' . $certificationlow_id, 'Please enter a valid income amount.', 'error');
    }

    // Check if the record exists
    $certification = getById('certificationofsourceofincome', $certificationlow_id);
    if ($certification['status'] != 200) {
        redirect('certification-of-source-of-income.php', 'Record not found!', 'error');
    }

    // Prepare data for updating
    $data = [
        'work' => $work,
        'age' => $age,
        'usedfor' => $usedfor,
        'income' => $income,
        'councilor'=> $councilor
    ];

    // Update the record in the database
    $result = update('certificationofsourceofincome', $certificationlow_id, $data);

    if ($result) {
        redirect('edit-certification-of-source-of-income.php?id=' . $certificationlow_id, 'Certification of Source of Income updated successfully!', 'success');
    } else {
        redirect('edit-certification-of-source-of-income.php?id=' . $certificationlow_id, 'Failed to update the record. Please try again.', 'error');
    }
}

// Update Certification of Good Moral
if (isset($_POST['updatecertificationgoodmoralinfo'])) {
    $goodmoral_id = validate($_POST['goodmoral_id']); // Hidden field with the ID
    $usedfor = validate($_POST['usedfor']);
    $councilor = isset($_POST['councilor']) && !empty($_POST['councilor']) ? validate($_POST['councilor']) : null;


    // Validate inputs
    if (empty($usedfor)) {
        redirect('edit-certification-goodmoral.php?id=' . $goodmoral_id, 'Please fill out all required fields.', 'error');
    }

    // Check if the record exists
    $goodmoral = getById('certificateofgoodmoral', $goodmoral_id);
    if ($goodmoral['status'] != 200) {
        redirect('certification-goodmoral.php', 'Record not found!', 'error');
    }

    // Prepare data for updating
    $data = [
        'usedfor' => $usedfor,
        'councilor' => $councilor, // New field for Barangay Councilor

    ];

    // Update the record in the database
    $result = update('certificateofgoodmoral', $goodmoral_id, $data);

    if ($result) {
        redirect('edit-certification-goodmoral.php?id=' . $goodmoral_id, 'Certification of Good Moral updated successfully!', 'success');
    } else {
        redirect('edit-certification-goodmoral.php?id=' . $goodmoral_id, 'Failed to update the record. Please try again.', 'error');
    }
}

// Update Certification of Calamity
if (isset($_POST['updatecalamityinfo'])) {
    $calamity_id = validate($_POST['calamity_id']); // Hidden field with the ID
    $calamitytypes = validate($_POST['calamitytypes']);
    $calamitydate = validate($_POST['calamitydate']);
    $purpose = validate($_POST['purpose']); // Capture the 'purpose' field
    $councilor = isset($_POST['councilor']) && !empty($_POST['councilor']) ? validate($_POST['councilor']) : null;

    // Validate inputs
    if (empty($calamitytypes) || empty($calamitydate) || empty($purpose)) {
        redirect('edit-calamity.php?id=' . $calamity_id, 'Please fill out all required fields.', 'error');
    }

    // Check if the record exists
    $calamity = getById('certificationofcalamity', $calamity_id);
    if ($calamity['status'] != 200) {
        redirect('calamity-records.php', 'Record not found!', 'error');
    }

    // Prepare data for updating
    $data = [
        'calamitytypes' => $calamitytypes,
        'calamitydate' => $calamitydate,
        'purpose' => $purpose, // Add the purpose field to the update
        'councilor' => $councilor, // New field for Barangay Councilor

    ];

    // Update the record in the database
    $result = update('certificationofcalamity', $calamity_id, $data);

    if ($result) {
        redirect('edit-calamity.php?id=' . $calamity_id, 'Certification of Calamity updated successfully!', 'success');
    } else {
        redirect('edit-calamity.php?id=' . $calamity_id, 'Failed to update the record. Please try again.', 'error');
    }
}

// Update Certification of ESC
if (isset($_POST['updateescinfo'])) {
    $esc_id = validate($_POST['esc_id']); // Hidden field with the ID
    $purpose = validate($_POST['purpose']); // Capture the 'purpose' field
    $father = !empty($_POST['father']) ? validate($_POST['father']) : NULL; // Set father to NULL if empty
    $mother = !empty($_POST['mother']) ? validate($_POST['mother']) : NULL; // Set mother to NULL if empty
    $child = validate($_POST['child']);  // Collecting the child input
    $school = validate($_POST['school']);  // Collecting the school input
    $residentsince = validate($_POST['residentsince']);  // Collecting the residentsince input
    $councilor = isset($_POST['councilor']) && !empty($_POST['councilor']) ? validate($_POST['councilor']) : null;


    // Validate inputs
    if (empty($purpose) || empty($child) || empty($school) || empty($residentsince)) {
        redirect('edit-esc.php?id=' . $esc_id, 'Please fill out all required fields.', 'error');
    }

    // Check if the record exists
    $esc = getById('certificationofesc', $esc_id);
    if ($esc['status'] != 200) {
        redirect('esc-records.php', 'Record not found!', 'error');
    }

    // Prepare data for updating
    $data = [
        'purpose' => $purpose, // Update the purpose field
        'father' => $father,  // Update the father field
        'mother' => $mother,  // Update the mother field
        'child' => $child,    // Update the child field
        'school' => $school,  // Update the school field
        'residentsince' => $residentsince, // Update the residentsince field
        'councilor' => $councilor,
    ];

    // Update the record in the database
    $result = update('certificationofesc', $esc_id, $data);

    if ($result) {
        redirect('edit-esc.php?id=' . $esc_id, 'Certification of ESC updated successfully!', 'success');
    } else {
        redirect('edit-esc.php?id=' . $esc_id, 'Failed to update the record. Please try again.', 'error');
    }
}











?>
