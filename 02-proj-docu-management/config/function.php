<?php 
session_start();

if (date_default_timezone_get() != 'Asia/Manila') {
    date_default_timezone_set('Asia/Manila');
}
require 'dbcon.php';

//Validatation
function validate($inputData){ 
     
    global $conn;
    $validateData = mysqli_real_escape_string($conn, $inputData); //remove unwanted code
    return trim($validateData);
}
//Redirect
function redirect($url, $status, $status_type = 'success') {
    $_SESSION['status'] = $status;
    $_SESSION['status_type'] = $status_type; // Set the status type (success, error, etc.)
    header('Location: ' . $url);
    exit(0);
}
//Alert Status
function alertMessage() {
    if (isset($_SESSION['status'])) {
        // Determine the alert class based on the status type
        $alertClass = 'alert-success'; // Default class
        if (isset($_SESSION['status_type'])) {
            if ($_SESSION['status_type'] == 'success') {
                $alertClass = 'alert-primary'; // Blue for success
            } elseif ($_SESSION['status_type'] == 'error') {
                $alertClass = 'alert-danger'; // Red for error
            }
        }

        // Check if the current page is login.php
        $isLoginPage =  in_array(basename($_SERVER['PHP_SELF']), ['login.php', 'forgot-password.php']);

        if ($isLoginPage) {
            // Show simple alert format
            echo '
            <div class="alert ' . $alertClass . '" role="alert">
                ' . $_SESSION['status'] . '
            </div>';
        } else {
            // Show alert with dismiss button
            echo '
            <div class="alert ' . $alertClass . ' alert-dismissible fade show" role="alert">
                ' . $_SESSION['status'] . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        }

        // Clear session status variables after displaying
        unset($_SESSION['status']);
        unset($_SESSION['status_type']);
    }
}
//CRUD Insert Operation
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
//CRUD Update Operation
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
//CRUD Delete Operation
function delete($tableName, $id){
    global $conn; 

    $table = validate($tableName);
    $id = validate ($id);

    $query = "DELETE FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn ,$query);
    return $result;
}
//GetAll Operation Associate
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
//GetById Operation Specific Record
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
        'message' => 'Failed to Fetch!'];
        return $response;
    }
}
// Check Id If It is Empty or Not Present in URL
function checkParamId($type) {
    // Check if the parameter is set in the URL
    if (isset($_GET[$type])) {
        // Check if the parameter is not empty
        if ($_GET[$type] != '') {
            // Return the parameter value
            return $_GET[$type];
        } else {
            // Return a message if the parameter is empty
            return '<h5>No Id Found</h5>';
        }
    } else {
        // Return a message if the parameter is not present in the URL
        return '<h5>No Id Given</h5>';
    }
}
//validate column
function recordExistsByColumn($tableName, $columnName, $value) {
    global $conn;
    
    $table = validate($tableName);
    $column = validate($columnName);
    $value = validate($value);
    
    $query = "SELECT COUNT(*) as count FROM $table WHERE $column = '$value'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'] > 0; // Return true if the count is greater than 0
    }
    return false;
}

//Logout
function logoutSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
//    session_destroy(); // Destroy the session completely
}
// Function to check if a record with the same personal_Id already exists in the table
function recordExists($table, $personalId) {
    global $conn;  // Assuming $conn is your MySQLi connection
    // Sanitize the input to prevent SQL injection
    $personalId = mysqli_real_escape_string($conn, $personalId);
    // Create a safe SQL query using the personalId
    $query = "SELECT COUNT(*) FROM $table WHERE personal_Id = '$personalId'";

    // Execute the query and fetch the result
    $result = mysqli_query($conn, $query);

    // Return true if a record exists (count > 0), false otherwise
    if ($result) {
        $row = mysqli_fetch_row($result);
        return $row[0] > 0;
    }
    return false;
}
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

// Ensure you have a PDO instance or MySQLi connection in your global scope
function getMultipleCount($tableNames) {
    global $conn;
    
    // If $tableNames is a string (single table), convert it to an array
    if (is_string($tableNames)) {
        $tableNames = [$tableNames];
    }

    $totalCount = 0;

    // Loop through each table name and get the count
    foreach ($tableNames as $table) {
        $table = mysqli_real_escape_string($conn, $table); // Sanitize the table name

        $query = "SELECT COUNT(*) AS count FROM $table";
        $query_run = mysqli_query($conn, $query);

        if (!$query_run) {
            // Log an error if the query fails
            error_log("Query Error: " . mysqli_error($conn));
        } else {
            // Add the count of the current table to the total
            $row = mysqli_fetch_assoc($query_run);
            $totalCount += $row['count'];
        }
    }

    return $totalCount;
}








?>