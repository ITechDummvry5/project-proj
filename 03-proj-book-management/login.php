<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - E-Library</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-container h2 {
            margin-bottom: 20px;
        }
        .alert {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="form-container text-center">
    <h2>Login</h2>

    <?php
    if(isset($_GET['login_error'])) {
        $error_message = '';
        switch($_GET['login_error']) {
            case 'invalid_password':
                $error_message = "Invalid password!";
                break;
            case 'no_user':
                $error_message = "No user found with this email!";
                break;
            case 'missing_fields':
                $error_message = "Please enter email and password!";
                break;
        }
        echo "<div id='loginError' class='alert alert-danger'>$error_message</div>";
    }
    ?>

    <form action="custom/userLogin.php" method="POST">
        <div class="mb-3 text-start">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3 text-start">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <p class="mt-2">Don't have an account? <a href="register.php">Register</a></p>
    </form>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const alertBox = document.getElementById('loginError');
        if(alertBox) {
            setTimeout(() => alertBox.style.display = 'none', 3000);
        }
    });
</script>
</body>
</html>
