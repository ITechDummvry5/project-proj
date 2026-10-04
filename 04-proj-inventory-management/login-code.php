<?php 
// Include function.php which already starts the session
require 'config/function.php';

// If the form is submitted
if (isset($_POST['login'])) {
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    // Prepare and Execute Query
    if ($email != '' && $password != '') {

        // Check if user exists
        $query = "SELECT * FROM admins WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $query);

        // Check if query executed successfully
        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                // Fetch user data
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password'];

                // Check if the user is banned
                if ($row['is_ban'] == 1) {
                    redirect('login', 'The user is currently Inactive', 'error');
                }

                // Verify password
                if (!password_verify($password, $hashedPassword)) {
                    redirect('login', 'Invalid Password!', 'error');
                }

                // Regenerate session ID
                session_regenerate_id(true);

                // Set session variables
                $_SESSION['loggedIn'] = true;
                $_SESSION['loggedInUser'] = [
                    'user_id' => $row['id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'role' => $row['role'],
                ];

                // Insert into active_sessions table
                $sessionId = session_id();
                $loginTime = date('Y-m-d H:i:s');
                $insertSessionQuery = "INSERT INTO active_sessions (user_id, session_id, login_time, logout_time) 
                                       VALUES ({$row['id']}, '$sessionId', '$loginTime', NULL)";
                mysqli_query($conn, $insertSessionQuery);

                // Redirect based on role
                switch ($row['role']) {
                    case 'admin':
                        redirect('admin/index2', 'Welcome Stockman!', 'success');
                        break;
                    case 'superadmin':
                        redirect('admin/index', 'Welcome System Admin!', 'success');
                        break;
                    case 'hoa':
                        redirect('Hoa/index', 'Welcome HOA!', 'success');
                        break;
                    default:
                        redirect('index', 'Invalid Role!', 'error');
                        break;
                }
            } else {
                redirect('login', 'Invalid Input!', 'error');
            }
        } else {
            redirect('index', 'Something Went Wrong!', 'error');
        }
    } else {
        redirect('index', 'All fields should be mandatory!', 'error');
    }
}
?>
