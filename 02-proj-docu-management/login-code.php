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
        $query = "SELECT * FROM account WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $query);

        // Check if query executed successfully
        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                // Fetch user data
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password'];

                // Check if the user is banned
                if ($row['is_ban'] == 1) {
                    redirect('login.php', 'This User Is Currently Inactive', 'error');
                }

                // Verify password
                if (!password_verify($password, $hashedPassword)) {
                    redirect('login.php', 'Invalid Password', 'error');
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

                // Insert into sessions table
                $sessionId = session_id();
                $loginTime = date('Y-m-d H:i:s');
                $insertSessionQuery = "INSERT INTO sessions (user_id, session_id, login_time, logout_time) 
                                       VALUES ({$row['id']}, '$sessionId', '$loginTime', NULL)";
                mysqli_query($conn, $insertSessionQuery);

                // Redirect based on role
                switch ($row['role']) {
                    case 'staff':
                        redirect('admin/index2.php', 'Welcome Staff', 'success');
                        break;
                    case 'secretary':
                        redirect('admin/index2.php', 'Welcome Secretary', 'success');
                        break;
                    default:
                        redirect('index.php', 'Invalid Role!', 'error');
                        break;
                }
            } else {
                redirect('login.php', "Account doesn't Exist", 'error');
            }
        } else {
            redirect('index.php', 'Failed to Fetch', 'error');
        }
    } else {
        redirect('index.php', 'All Fields Should Be Filled', 'error');
    }
}
?>
