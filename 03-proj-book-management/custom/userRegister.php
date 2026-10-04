<?php
session_start();
include('../config/function.php'); // Your DB connection and helper functions

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check for empty fields
    if (empty($name) || empty($email) || empty($password)) {
        header("Location: ../register.php?register_error=missing_fields");
        exit;
    }

    // Check if email already exists
    $stmt = $con->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        header("Location: ../register.php?register_error=email_exists");
        exit;
    }

    // Hash the password and insert user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $con->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['name'] = $name; // Save username in session
        header("Location: ../index.php");
        exit;
    } else {
        header("Location: ../register.php?register_error=failed");
        exit;
    }

    $stmt->close();
}
?>
