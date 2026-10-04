<?php
session_start();
include('../config/function.php'); // adjust path

if(isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Query to get the user
    $stmt = $con->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows === 1){
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])) {
            // Login successful: set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            header("Location: ../index.php");
            exit;
        } else {
            // Invalid password
            header("Location: ../login.php?login_error=invalid_password");
            exit;
        }
    } else {
        // No user found
        header("Location: ../login.php?login_error=no_user");
        exit;
    }
} else {
    // Missing email or password
    header("Location: ../login.php?login_error=missing_fields");
    exit;
}
?>
