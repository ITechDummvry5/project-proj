<?php
require 'config/function.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['loggedIn'])) {

    $userId = $_SESSION['loggedInUser']['user_id'];
    $sessionId = session_id();
    $logoutTime = date('Y-m-d H:i:s');

    // Update logout time for the current session
    $updateSessionQuery = "UPDATE sessions SET logout_time = '$logoutTime' WHERE user_id = $userId AND session_id = '$sessionId'";
    if (mysqli_query($conn, $updateSessionQuery)) {
        error_log("Session updated successfully: user_id=$userId, session_id=$sessionId, logout_time=$logoutTime");
    } else {
        error_log("Failed to update session: " . mysqli_error($conn));
    }

    // Destroy the session
    logoutSession();
    redirect('login.php', 'You’ve been logged out...');
}
?>
