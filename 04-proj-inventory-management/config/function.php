<?php
session_start();
// Date 4/24/2024

if (date_default_timezone_get() != 'Asia/Manila') {
    date_default_timezone_set('Asia/Manila');
}

require 'dbcon.php';

//Validatation 1st 
/**
 * The sanitized inputs are safely used in the query, reducing the risk of SQL injection.
 */
function validate($inputData){ 
     
    global $conn;
    $validateData = mysqli_real_escape_string($conn, $inputData); //remove unwanted code
    return trim($validateData);
}
//*****//
// End //
//*****//

function redirect($url, $status, $status_type = 'success') {
    $_SESSION['status'] = $status;
    $_SESSION['status_type'] = $status_type; // Set the status type (success, error, etc.)
    header('Location: ' . $url);
    exit(0);
}


function alertMessage() {
    if (isset($_SESSION['status'])) {
        // Check if the status contains a type (success or error)
        $alertClass = 'alert-success'; // Default class
        if (isset($_SESSION['status_type'])) {
            // Use a success or error class based on the type
            if ($_SESSION['status_type'] == 'success') {
                $alertClass = 'alert-success'; // Green for success
            } elseif ($_SESSION['status_type'] == 'error') {
                $alertClass = 'alert-danger'; // Red for error
            }
        }

        // Display the alert message with the appropriate class
        echo '
        <div class="alert ' . $alertClass . ' alert-dismissible fade show" role="alert">
            ' . $_SESSION['status'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        
        unset($_SESSION['status']); // Remove status after displaying
        unset($_SESSION['status_type']); // Remove status type after displaying
    }
}


/**
 * Feedback Handling: Sets $_SESSION['status'] to pass feedback messages between pages, such as success or error messages after form processing.
 * URL Redirection: Redirects the user to a specified URL, typically after form submissions or operations, to guide them to the appropriate page.
 * Seamless User Experience: Stores status messages in the session and redirects users to provide feedback automatically, which can then be displayed on the target page.
 */ 
//Redirect from 1 page to another pages 2nd | redirect and alertmesseage are work together
// function redirect($url, $status){ 
//     $_SESSION['status'] = $status;
//     header('Location: '.$url); // Session for status that send messeage in any other files
//     exit (0);
// }
//*****//
// End //
//*****//



/**
 * this function provides a convenient way to display temporary messages to users, 
 * such as confirmation messages or error notifications, and ensures that these messages are only shown once per session.
 */
    //Notification / display message or status after process in any other files 3rd
// function alertMessage(){
//     if (isset($_SESSION['status'])){ 
//         echo '
//         <div class="alert alert-secondary alert-dismissible fade show" role="alert">
//         '. $_SESSION['status'].'
//         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
//         unset($_SESSION ['status']); 
//     }
// }
//*****//
// End //
//*****//


function isResidentPasswordStrong($rpassword) {
    return strlen($rpassword) >= 8 && preg_match('/[A-Za-z]/', $rpassword) && preg_match('/[0-9]/', $rpassword);
}
/**
 * The insert function is used to perform an SQL INSERT operation, adding new records to a specified database table.
 * $tableName - The name of the table in which you want to insert records
 * An associative array where each key represents a column name and each value represents the data to be inserted into that column.
 * For example, ['column1' => 'value1', 'column2' => 'value2'].
 */
// CRUD insert operate 4th 
function insert($tableName, $data){  

    global $conn;
    
    $table = validate ($tableName); //this is the first function

    $columns = array_keys($data);
    $values = array_values($data);

    $finalColumn = implode(',', $columns); // divider or seperator every data with coma
    $finalValues = "'" .implode("','" , $values). "'";

    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)";
    $result = mysqli_query($conn,$query);
    return $result;
}
//*****//
// End //
//*****//

/**
 * The purpose of the update function is to perform an SQL UPDATE operation on a specified table. 
 * It allows you to modify one or more columns of a record identified by a specific ID. 
 * This function dynamically constructs the SQL query based on the provided table name, ID, and data to be updated, 
 * then executes the query using the MySQLi connection.
 * $TableName - The name of the table in which you want to update records
 * $ID: 5 (the unique identifiers and  record to update)
 * $Data: ['email' => 'newemail@exa.com', 'status' => 'active'] the array that associate to id where you want to update
 */
function update($tableName, $id, $data){
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $updateDataString = "";

    foreach($data as $column => $value){
    
        $updateDataString .= $column. '=' . "'$value',";
    }
    $finalUpdateData = substr(trim($updateDataString),0,-1);
        $query = "UPDATE $table SET $finalUpdateData WHERE id='$id'";
        $result = mysqli_query($conn, $query);
        return $result;
}
//*****//
// End //
//*****//

//*********************************************************//
//   This function is used more general and flexible, allowing for the retrieval of multiple records, 
//   function is used to retrieve all records from a specific table or only those records where the status is 0, depending on the value of the $status parameter.
//   If $status is 'status', only records with a status of 0 are selected.
//   If $status is anything else (including NULL), all records from the table are selected.
//*********************************************************//
// GET ALL 6th 
function getAll($tableName, $status = NULL){ 
    global $conn; 

    $table = validate($tableName);
    $status = validate ($status);

    if($status == 'status') //it convert or check  T or F
    {
        $query = "SELECT * FROM $tableName WHERE status='0'";
    }
    else{ 
     $query = "SELECT * FROM $table";
    }
    return mysqli_query($conn, $query);
}
//*****//
// End //
//*****//

//*********************************************************//
//   This function is used to retrieve a single record from a specific table based on the given id. It returns a structured response that includes: 
//   -status: A code indicating the outcome (200 for success, 404 for not found, 500 for error).
//   -data: The record retrieved from the database (only included in a successful response).
//   -message: A message describing the outcome.
//*********************************************************//
//GET BY ID 7th
function getById($tableName, $id){
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1"; //ensures 1 only get the row that matches the specific id you provided.
    $result = mysqli_query($conn, $query);

    if($result){
        if(mysqli_num_rows($result) == 1 ){

            // $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
             $row = mysqli_fetch_assoc($result);
             $response = [
            'status' => 200, 
             'data' => $row, 
             'message' => 'Record Found!'];
             return $response;

        }else{
            $response = ['status' => 404, 'message' => 'No Data Found!'];
            return $response;
        }

    }else{
        $response = ['status' => 500, 
        'message' => 'Something went Wrong!'];
        return $response;
    }
}
//*****//
// End //
//*****//

//*********************************************************//
//   This function deletes a specific record from a given table in the database, 
//   where the record is identified by its id. It first validates the inputs to ensure they are safe,
//   then constructs and executes the SQL DELETE query.
//*********************************************************//
//Delete data from database using ID 8th
function delete($tableName, $id){
    global $conn; 

    $table = validate($tableName);
    $id = validate ($id);

    $query = "DELETE FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn ,$query);
    return $result;
}
//*****//
// End //
//*****//

//*********************************************************//
//   The function checkParamId($type) is used to validate the presence and content of a specific query parameter in the URL.
//   If the parameter exists and is not empty, it returns the parameter's value.
//   If the parameter exists but is empty, it returns a message indicating no ID was found. 
//   If the parameter is completely absent, it returns a message indicating no ID was given.
//
//Diff: The checkParamId($type) function is for validating the presence and content of a URL query parameter (like id or type).
//      The getById($tableName, $id) function is for retrieving a specific record from a database based on an id.
//*********************************************************//
//CHECKING PARAMETER id 9th
function checkParamId($type){ 

 if(isset($_GET[$type])){ 

    if($_GET[$type] != ''){
        return $_GET[$type];     
 }else{
        return '<h5>NO ID FOUND!</h5>';
 }
    }else{
        return '<h5>NO ID Given FOUND!</h5>';
    }
} 
//*****//
// End //
//*****//

//*********************************************************//
// The purpose of this function is to log a user out by ensuring that any session variables related
// to their login status are removed. It also makes sure a session is started if one wasn’t already, 
//so it can safely unset those variables
//*********************************************************//
//for logout in superadmin, stockman and Hoa
function logoutSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
   // session_destroy(); // Destroy the session completely
}
//*****//
// End //
//*****//

//*********************************************************//
// Function for Resident-logout.php and resident-authen.php 
//*********************************************************//
// For logout in resident
function rlogoutSession(){
    unset($_SESSION['rloggedIn']);
    unset($_SESSION['rloggedInUser']);
    // session_destroy(); // Destroy the session completely
}
//*****//
// End //
//*****//

//*******************************************************//
// Function for Orders-code.php inorder to fetch response
//*******************************************************//
// 5/8/2024 order ajax code js shorterm for orders-code  message custom  11th
function jsonResponse($status, $status_type, $message){
    $response = [
        'status' => $status, 
        'status_type' => $status_type,
        'message' => $message
    ];
    echo json_encode($response);
    return;
}
//*****//
// End //
//*****//



//*****************************//
// Function for Index Dashboard **??System And Stockman
//*****************************//

// Ensure you have a PDO instance or MySQLi connection in your global scope
function getCount($tableName) {
    global $conn;
    $table = mysqli_real_escape_string($conn, $tableName);
    $query = "SELECT * FROM $table";
    $query_run = mysqli_query($conn, $query);

    if (!$query_run) {
        error_log("Query Error: " . mysqli_error($conn));
    }

    return $query_run ? mysqli_num_rows($query_run) : 0;
}


function getCountonly($tableName) {
    global $conn;
    $table = mysqli_real_escape_string($conn, $tableName);
    $query = "SELECT * FROM $table WHERE order_status = 'Booked'"; // Ensure 'Booked' is in quotes
    $query_run = mysqli_query($conn, $query);

    if (!$query_run) {
        error_log("Query Error: " . mysqli_error($conn));
    }

    return $query_run ? mysqli_num_rows($query_run) : 0;
}

function getCountComplete($tableName) {
    global $conn;
    $table = mysqli_real_escape_string($conn, $tableName);
    $query = "SELECT * FROM $table WHERE status = 0"; // Ensure 'Booked' is in quotes
    $query_run = mysqli_query($conn, $query);

    if (!$query_run) {
        error_log("Query Error: " . mysqli_error($conn));
    }

    return $query_run ? mysqli_num_rows($query_run) : 0;
}


function getCountifarchived($tableName) {
    global $conn;
    $table = mysqli_real_escape_string($conn, $tableName);
    $query = "SELECT * FROM $table WHERE is_archived = 0";
    $query_run = mysqli_query($conn, $query);

    if (!$query_run) {
        error_log("Query Error: " . mysqli_error($conn));
    }

    return $query_run ? mysqli_num_rows($query_run) : 0;
}


function getRecentActivities($limit = 1) {
    global $conn;

    // Prepare separate queries for each type of activity with a limit of 5
    $queryRequests = "
        SELECT 'Request' AS type, rdescription AS detail, created_at AS date 
        FROM request 
        WHERE is_archived = 0 
        ORDER BY created_at DESC 
        LIMIT " . intval($limit);

    $queryPayments = "
        SELECT 'Payments' AS type, amount_paid AS detail, payment_date AS date 
        FROM payments 
        WHERE acknowledged = 1 
        ORDER BY payment_date DESC 
        LIMIT " . intval($limit);

    $queryAnnouncements = "
        SELECT 'Announcement' AS type, heading AS detail, hcreated_at AS date 
        FROM announcement 
        ORDER BY hcreated_at DESC 
        LIMIT " . intval($limit);

    $queryResidents = "
        SELECT 'Add Resident' AS type, rname AS detail, rcreated_at AS date 
        FROM residents 
        ORDER BY rcreated_at DESC 
        LIMIT " . intval($limit);

    // Execute all four queries
    $resultRequests = mysqli_query($conn, $queryRequests);
    $resultPayments = mysqli_query($conn, $queryPayments);
    $resultAnnouncements = mysqli_query($conn, $queryAnnouncements);
    $resultResidents = mysqli_query($conn, $queryResidents);

    // Initialize an array to hold all activities
    $activities = [];

    // Fetch and merge results for each query
    if ($resultRequests) {
        $activities = array_merge($activities, mysqli_fetch_all($resultRequests, MYSQLI_ASSOC));
    } else {
        error_log("Requests Query Error: " . mysqli_error($conn));
    }

    if ($resultPayments) {
        $activities = array_merge($activities, mysqli_fetch_all($resultPayments, MYSQLI_ASSOC));
    } else {
        error_log("Payments Query Error: " . mysqli_error($conn));
    }

    if ($resultAnnouncements) {
        $activities = array_merge($activities, mysqli_fetch_all($resultAnnouncements, MYSQLI_ASSOC));
    } else {
        error_log("Announcements Query Error: " . mysqli_error($conn));
    }

    if ($resultResidents) {
        $activities = array_merge($activities, mysqli_fetch_all($resultResidents, MYSQLI_ASSOC));
    } else {
        error_log("Residents Query Error: " . mysqli_error($conn));
    }

    // Sort the activities by date descending
    usort($activities, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    // Limit the number of activities to the total requested
    return array_slice($activities, 0, $limit * 4); // Adjust as needed to ensure diversity
}


function getRecentActivitiesSystem($limit = 5) {
    global $conn;

    // Prepare the query for retrieving recent orders with tracking number
    $queryOrders = "
        SELECT 'order' AS type, name AS detail, invoice_no, order_date AS date 
        FROM orders 
        ORDER BY order_date DESC 
        LIMIT " . intval($limit);

    // Execute the query
    $resultOrders = mysqli_query($conn, $queryOrders);

    // Initialize an array to hold all activities
    $activities = [];

    // Fetch results for the orders query
    if ($resultOrders) {
        $activities = mysqli_fetch_all($resultOrders, MYSQLI_ASSOC);
    } else {
        error_log("Orders Query Error: " . mysqli_error($conn));
    }

    // Sort the activities by date descending
    usort($activities, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    // Limit the number of activities to the total requested
    return array_slice($activities, 0, $limit); // Adjust as needed
}

function getRecentActivitiesStockman($limit = 5) {
    global $conn;

    // Prepare the query for retrieving recent material additions
    $queryMaterials = "
        SELECT 'Material_Added' AS type, product_id AS detail, quantity_added, added_by, created_at AS date 
        FROM product_quantity_log
        ORDER BY created_at DESC";

    // Prepare the query for retrieving recent category creations
    $queryCategories = "
       SELECT 'Category_Created' AS type, name AS detail, block_lot, created_at AS date 
FROM categories
ORDER BY created_at DESC;";

    // Execute the material additions query
    $resultMaterials = mysqli_query($conn, $queryMaterials);
    $materials = $resultMaterials ? mysqli_fetch_all($resultMaterials, MYSQLI_ASSOC) : [];

    if (!$resultMaterials) {
        error_log("Material Add Query Error: " . mysqli_error($conn));
    }

    // Execute the categories query
    $resultCategories = mysqli_query($conn, $queryCategories);
    $categories = $resultCategories ? mysqli_fetch_all($resultCategories, MYSQLI_ASSOC) : [];

    if (!$resultCategories) {
        error_log("Category Query Error: " . mysqli_error($conn));
    }

    // Combine all activities into a single array
    $activities = array_merge($materials, $categories);

    // Sort the activities by date descending
    usort($activities, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    // Limit the number of activities to the total requested
    return array_slice($activities, 0, $limit);
}



function getMonthlyRequests($tableName, $isArchived) {
    global $conn;
    $table = mysqli_real_escape_string($conn, $tableName);
    $query = "
        SELECT MONTHNAME(created_at) AS month, COUNT(*) AS total 
        FROM $table 
        WHERE is_archived = $isArchived 
        GROUP BY MONTH(created_at) 
        ORDER BY MONTH(created_at)";
    
    $result = mysqli_query($conn, $query);
    $monthlyData = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $monthlyData[$row['month']] = $row['total'];
        }
    }

    return $monthlyData;
}


function getTodayOrders() {
    global $conn;
    $todayDate = date('Y-m-d');
    $todayOrdersQuery = mysqli_query($conn, "
        SELECT * FROM orders WHERE DATE(order_date) = '$todayDate'
    ");

    if (!$todayOrdersQuery) {
        error_log("Query Error: " . mysqli_error($conn));
    }

    return $todayOrdersQuery ? mysqli_num_rows($todayOrdersQuery) : 0;
}


function getRecentWeekOrdersByDay() {
    global $conn;
    $today = date('Y-m-d'); // Current date
    $sevenDaysAgo = date('Y-m-d', strtotime('-7 days')); // Date 7 days ago

    $weekOrdersQuery = mysqli_query($conn, "
        SELECT DATE(order_date) AS order_day, COUNT(*) AS order_count
        FROM orders
        WHERE order_date BETWEEN '$sevenDaysAgo' AND '$today 23:59:59'
        GROUP BY order_day
        ORDER BY order_day
    ");

    if (!$weekOrdersQuery) {
        error_log("Query Error: " . mysqli_error($conn));
    }

    $ordersByDay = [
        'Monday' => 0,
        'Tuesday' => 0,
        'Wednesday' => 0,
        'Thursday' => 0,
        'Friday' => 0,
        'Saturday' => 0,
        'Sunday' => 0
    ];

    while ($row = mysqli_fetch_assoc($weekOrdersQuery)) {
        $dayOfWeek = date('l', strtotime($row['order_day']));
        if (array_key_exists($dayOfWeek, $ordersByDay)) {
            $ordersByDay[$dayOfWeek] += $row['order_count'];
        }
    }

    return $ordersByDay;
}

function getMonthName($monthNumber) {
    $months = [
        '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
        '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
        '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
    ];
    return isset($months[$monthNumber]) ? $months[$monthNumber] : 'Unknown';
}

function getMonthlyOrderData() {
    global $conn;
    $monthlyData = [];

    $query = "
        SELECT DATE_FORMAT(order_date, '%Y-%m') AS month, COUNT(*) AS total
        FROM orders
        GROUP BY month
        ORDER BY month
    ";
    $query_run = mysqli_query($conn, $query);

    if (!$query_run) {
        error_log("Query Error: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($query_run)) {
        $monthNumber = substr($row['month'], 5, 2);
        $row['month'] = getMonthName($monthNumber) . ' ' . substr($row['month'], 0, 4); // e.g., 'January 2024'
        $monthlyData[] = $row;
    }

    return $monthlyData;
}


function getMonthlyProductData() {
    global $conn;
    $monthlyData = [];

    $query = "
        SELECT 
            DATE_FORMAT(created_at, '%Y-%m') AS month, 
            COUNT(*) AS total 
        FROM 
            products 
        GROUP BY 
            DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY 
            DATE_FORMAT(created_at, '%Y-%m') ASC
    ";
    $query_run = mysqli_query($conn, $query);

    if (!$query_run) {
        error_log("Query Error: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($query_run)) {
        $monthNumber = substr($row['month'], 5, 2);
        $row['month'] = getMonthName($monthNumber) . ' ' . substr($row['month'], 0, 4); // e.g., 'January 2024'
        $monthlyData[] = $row;
    }

    return $monthlyData;
}

  
//*****//
// End //
//*****//


//***************************//
// Function for Products Logs **?? System
//**************************//
// Product Logs this where the stockman when it input in the product it will records it

// Function to fetch product change logs with optional date range
function getProductChangeLogs($conn, $startDate = null, $endDate = null) {
    // Check if $conn is valid
    if (!$conn) {
        die('Database connection is not established.');
    }

    // Base query
    $query = "SELECT product_id, change_description, changed_by, old_quantity, new_quantity, changed_at FROM product_logs";
    
    // Add date range filter if provided
    if ($startDate && $endDate) {
        // Make sure endDate includes the whole day by setting time to 23:59:59
        $startDate = mysqli_real_escape_string($conn, $startDate);
        $endDate = mysqli_real_escape_string($conn, $endDate . ' 23:59:59'); // Extend endDate to include the whole day
        $query .= " WHERE changed_at BETWEEN '$startDate' AND '$endDate'";
    }

    $query .= " ORDER BY changed_at DESC";
    
    $result = mysqli_query($conn, $query);
    $logs = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $logs[] = $row;
        }
    }

    return $logs;
}


// Function to output CSV file export
function exportToCSV($filename, $data) {
    // Set headers to force download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Open output stream for writing
    $output = fopen('php://output', 'w');

    // Output column headings
    fputcsv($output, ['Changed At', 'ID', 'Change Description', 'Changed By', 'Old Quantity', 'New Quantity']);

    // Output data
    foreach ($data as $row) {
        // Format date properly and ensure numeric values are formatted correctly
        $formattedDate = date('m/d/Y H:i', strtotime($row['changed_at']));
        fputcsv($output, [
            $formattedDate,
            $row['product_id'],
            $row['change_description'],
            $row['changed_by'],
            $row['old_quantity'],
            $row['new_quantity'],
        ]);
    }

    // Close output stream
    fclose($output);
    exit;
}



//***************************//
// Function for Products Logs **?? Stockman and Some System for changelog 
//**************************//
// another update products  this where all and view the product changed like  quantity 
function updateProducts($tableName, $id, $data) {
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    // Get current product data to retrieve old values
    $productData = getById($tableName, $id);
    $oldQuantity = $productData['data']['quantity'];
    $oldName = $productData['data']['name'];
    $oldMaterialCategory = $productData['data']['materialcategory'];  // Add this line to capture the old category
    $oldCategory = $productData['data']['category_id'];  // Add this line to capture the old category

     // Fetch block_lot for the old category
     $oldCategoryQuery = "SELECT name, block_lot FROM categories WHERE id = '$oldCategory'";
     $oldCategoryResult = mysqli_query($conn, $oldCategoryQuery);
     $oldCategoryData = mysqli_fetch_assoc($oldCategoryResult);
     $oldCategoryName = $oldCategoryData['name'];
     $oldBlockLot = $oldCategoryData['block_lot'];

    $updateDataString = "";
    foreach ($data as $column => $value) {
        $updateDataString .= $column . '=' . "'$value',";
    }
    $finalUpdateData = substr(trim($updateDataString), 0, -1);

    $query = "UPDATE $table SET $finalUpdateData WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Check which fields have changed
        $newQuantity = isset($data['quantity']) ? $data['quantity'] : $oldQuantity;
        $newName = isset($data['name']) ? $data['name'] : $oldName;
        $newMaterialCategory = isset($data['materialcategory']) ? $data['materialcategory'] : $oldMaterialCategory; // Capture the new category
        $newCategory = isset($data['category_id']) ? $data['category_id'] : $oldCategory; // Capture the new category

        // Fetch block_lot for the new category
        $newCategoryQuery = "SELECT name, block_lot FROM categories WHERE id = '$newCategory'";
        $newCategoryResult = mysqli_query($conn, $newCategoryQuery);
        $newCategoryData = mysqli_fetch_assoc($newCategoryResult);
        $newCategoryName = $newCategoryData['name'];
        $newBlockLot = $newCategoryData['block_lot'];

        // Build change description based on changed fields
        $changeDescription = '';
        if ($oldQuantity != $newQuantity) {
            $changeDescription .= "Quantity changed from $oldQuantity to $newQuantity. ";
        }
        if ($oldName != $newName) {
            $changeDescription .= "Replacement from $oldName to $newName. ";
        }
        if ($oldMaterialCategory != $newMaterialCategory) {  // Check if the material category has changed
            $changeDescription .= "Material Category changed from $oldMaterialCategory to $newMaterialCategory. ";
        } 
        if ($oldCategory != $newCategory) {
            $changeDescription .= "Material project moved from $oldCategoryName $oldBlockLot to $newCategoryName $newBlockLot ";
        }

        if ($changeDescription) {
            $changedBy = 'Admin'; // Replace with actual user identifier or session data
            $logResult = logProductChange($id, trim($changeDescription), $changedBy, $oldQuantity, $newQuantity);
            if (!$logResult) {
                // Handle if logging fails (optional)
            }
        }
    }

    return $result;
}


// Function to log product change including quantity changes
function logProductChange($productId, $changeDescription, $changedBy, $oldQuantity, $newQuantity) {
    global $conn;

    $productId = validate($productId);
    $changeDescription = validate($changeDescription);
    $changedBy = $_SESSION['loggedInUser']['name'];
    $oldQuantity = validate($oldQuantity);
    $newQuantity = validate($newQuantity);
 $query = "INSERT INTO product_logs (product_id, change_description, changed_by, old_quantity, new_quantity) 
              VALUES ('$productId', '$changeDescription', '$changedBy', '$oldQuantity', '$newQuantity')";
    
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Handle error if insertion fails
        return false;
    }
    return true;
}
//*****//
// End //
//*****//

/**
 * HOA 
 */////////

/**
 * The hupdate function is used to update records in a specified database table. It simplifies the process of 
 * constructing and executing SQL UPDATE queries by dynamically generating the query based on provided input data.
 * This function is useful for making changes to existing records in a table, such as updating user profiles,
 * modifying statuses, or adjusting any other fields in your database.
 * Parameters:
 * $table: Specifies which table in the database you want to update.
 * $data: An associative array where the keys are column names and the values are the new values you want to set. This array provides the data for the columns you want to update.
 * $where: A condition that determines which rows in the table should be updated. This is a crucial part of the query to ensure you only update the intended records.
 */
function hupdate($table, $data, $where) {
    global $conn; // Ensure you have a valid database connection

    $setClause = '';
    foreach ($data as $column => $value) {
        $setClause .= "`$column` = '".mysqli_real_escape_string($conn, $value)."', ";
    }
    $setClause = rtrim($setClause, ', ');

    $sql = "UPDATE `$table` SET $setClause WHERE $where";
    
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        // Output SQL error
        echo "SQL Error: " . mysqli_error($conn);
        return false;
    }
}


//*****//
// End //
//*****//

//***************************//
// Function For Announcement
//**************************//
function fetchAll($table, $columns = '*', $additional = '') {
    global $conn; // Assuming you have a $conn variable for your database connection

    $query = "SELECT $columns FROM $table $additional";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return [];
    }
}

//***************************//
// Function For Sort and unsort Announcement in Hoa
//**************************//
function hgetAll($tableName, $orderBy = NULL) { 
    global $conn; 

    $table = validate($tableName);
    $orderBy = validate($orderBy);

    $query = "SELECT * FROM $table";
    
    if($orderBy) { 
        $query .= " $orderBy";
    }

    return mysqli_query($conn, $query);
}
//*****//
// End //
//*****//


//***************************//
// Function For fetch maintenance requests filtered by each resident_id 
// issues with filtering maintenance requests by resident_id, ensuring that each resident only sees their own requests.
//**************************//

function rgetAll($tableName, $columns = '*', $condition = null) { 
    global $conn; 

    // Validate the inputs
    $table = validate($tableName);
    $columns = validate($columns);

    // Construct the base query
    $query = "SELECT $columns FROM $table";

    // Append the condition if provided
    if ($condition) {
        $query .= " $condition";
    }

    // Execute the query
    return mysqli_query($conn, $query);
}
//*****//
// End //
//*****//

//***************************//
// custom direct table , columns , where the change , and orderby and custom limit
//**************************//

function fetchDataPosition($tableName, $columns = '*', $where = '', $orderBy = '', $limit = '') {
    global $conn;

    // Validate input parameters
    $tableName = validate($tableName);
    $columns = validate($columns);
    $where = validate($where);
    $orderBy = validate($orderBy);
    $limit = validate($limit);

    // Start building the query
    $query = "SELECT $columns FROM $tableName";
    
    // Add WHERE clause if provided
    if ($where) {
        $query .= " WHERE $where";
    }

    // Add ORDER BY clause if provided
    if ($orderBy) {
        $query .= " ORDER BY $orderBy";
    }

    // Add LIMIT clause if provided
    if ($limit) {
        $query .= " LIMIT $limit";
    }

    // Execute the query and return the result
    $result = mysqli_query($conn, $query);

    // Check for query errors
    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

//*****//
// End //
//*****//

/**Archiving */
function archive($tableName, $id){
    global $conn; 

    $table = validate($tableName);
    $id = validate($id);

    $query = "UPDATE $table SET is_archived='1' WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn ,$query);
    return $result;
}


function restore($tableName, $id){
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "UPDATE $table SET is_archived='0' WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;
}

function contractorrestore($tableName, $id){
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    // Update both the status and is_archived fields
    $query = "UPDATE $table SET is_archived='0', status='0' WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;
}



function getAllDesc($tableName, $status = NULL, $orderBy = '') {
    global $conn;

    // Validate the input parameters
    $table = validate($tableName);
    $status = validate($status);
    $orderBy = validate($orderBy); // Validate the order by clause

    // Initialize the query variable
    $query = "SELECT * FROM $table";

    // Add condition for status if specified
    if ($status === 'status') {
        $query .= " WHERE status='0'";
    }

    // Add ORDER BY clause if provided
    if ($orderBy) {
        $query .= " ORDER BY $orderBy";
    }

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check for query errors
    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }

    return $result; // Return the result set
}

function getAllProductsfolder($categoryId = '', $block = '', $lot = '')
{
    global $conn;
    $role = $_SESSION['loggedInUser']['role'];  // Get logged-in user role

    // Prepare query based on category, block, lot, and role
    $query = "SELECT * FROM products WHERE 1=1 ";
    
    if ($categoryId) {
        $query .= "AND category_id = " . intval($categoryId) . " ";
    }

    if ($block) {
        $query .= "AND block LIKE '%" . mysqli_real_escape_string($conn, $block) . "%' ";
    }

    if ($lot) {
        $query .= "AND lot LIKE '%" . mysqli_real_escape_string($conn, $lot) . "%' ";
    }

 
    $query .= "ORDER BY id ASC";

    // Execute the query directly
    $result = mysqli_query($conn, $query);
    return $result;
}


// Function to get out-of-stock product count for a specific category
function getOutOfStockCountByCategory($categoryId) {
    global $conn;
    $query = "SELECT COUNT(*) AS out_of_stock_count FROM products WHERE quantity = 0 AND category_id = " . intval($categoryId);
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['out_of_stock_count'];
    }
    return 0;
}
function getcountremarkMessage($categoryId) {
    global $conn;

    // Query to count rows where 'premark' is not null and not an empty string
    $query = "SELECT COUNT(*) AS remarkMessage 
              FROM products 
              WHERE premark IS NOT NULL 
              AND premark != '' 
              AND category_id = " . intval($categoryId);

    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['remarkMessage']; // Return the accurate count
    }

    return 0; // Return 0 if query fails
}



?>