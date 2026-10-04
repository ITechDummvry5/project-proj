<?php
require 'config/function.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function send_password_reset($get_name, $get_email, $token) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USERNAME'];
        $mail->Password   = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $_ENV['SMTP_PORT'];

        // Recipients
        $mail->setFrom($_ENV['SMTP_USERNAME'], $_ENV['SMTP_FROM_NAME']);
        $mail->addAddress($get_email);

        // Content
        $resetLink = "http://localhost/new/password-change.php?token=$token&email=$get_email";
        // $resetLink = "https://casaverde.website/ims/password-change.php?token=$token&email=$get_email";
        $mail->isHTML(true);
        $mail->Subject = 'IMS Reset Password';
        $mail->Body = "Hi $get_name,<br>Click on this link <a href='$resetLink'>here</a> to reset your password.";
        $mail->AltBody = "Hi $get_name, click on this link to reset your password: $resetLink";

        $mail->send();
        $_SESSION['status'] = "Reset link has been sent to your email!";
    } catch (Exception $e) {
        $_SESSION['status'] = "Mail could not be sent. Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['pass_reset_link'])) {
    $email = validate($_POST['email']);
    $token = md5(rand());
    $expiration_time = date("Y-m-d H:i:s", strtotime("+1 hour"));

    $check_email = "SELECT email, name FROM admins WHERE email='$email' LIMIT 1";
    $check_email_run = mysqli_query($conn, $check_email);
    
    if (mysqli_num_rows($check_email_run) > 0) {
        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['name'];
        $get_email = $row['email'];

        $update_token = "UPDATE admins SET verify_token='$token', token_expiration='$expiration_time' WHERE email='$get_email' LIMIT 1";
        $update_token_run = mysqli_query($conn, $update_token);

        if ($update_token_run) {
            send_password_reset($get_name, $get_email, $token);
            redirect('password-reset.php', 'Email has been sent to your email','success');
        } else {
            redirect('password-reset.php', 'Something went wrong', 'error');
        }
    } else {
        redirect('password-reset.php', 'Email not found!', 'error');
    }
}

if (isset($_POST['password_update'])) {
    $email = validate($_POST['email']);
    $new_password = validate($_POST['new_password']);
    $confirm_password = validate($_POST['confirm_password']);
    $token = validate($_POST['password_token']);

    if (!empty($token)) {
        if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {
            $check_token = "SELECT verify_token, token_expiration FROM admins WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($conn, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {
                $token_data = mysqli_fetch_assoc($check_token_run);
                $expiration = $token_data['token_expiration'];

                if (strtotime($expiration) > time()) {
                    if ($new_password == $confirm_password) {
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                        $update_passwords = "UPDATE admins SET password ='$hashed_password' WHERE verify_token='$token' LIMIT 1"; 
                        $update_passwords_run = mysqli_query($conn, $update_passwords);

                        if ($update_passwords_run) {
                            $new_token = md5(rand())."imscasa.website";
                            $new_expiration_time = date("Y-m-d H:i:s", strtotime("+1 hour"));
                            $update_new_token = "UPDATE admins SET verify_token ='$new_token', token_expiration='$new_expiration_time' WHERE verify_token='$token' LIMIT 1"; 
                            $update_new_token_run = mysqli_query($conn, $update_new_token);

                            redirect("login.php", 'New Password Successfully Updated', 'success');
                        } else {
                            redirect("password-change.php?token=$token&email=$email", 'Password did not update. Something went wrong.', 'error');
                        }
                    } else {
                        redirect("password-change.php?token=$token&email=$email", 'Passwords do not match.', 'error');
                    }
                } else {
                    redirect("password-change.php?token=$token&email=$email", 'Token has expired. Please request a new password reset.', 'error');
                }
            } else {
                redirect("password-change.php?token=$token&email=$email", 'Invalid token.', 'error');
            }
        } else {
            redirect("password-change.php?token=$token&email=$email", 'All fields are required.', 'error');
        }
    } else {
        redirect('password-change.php', 'No token provided.', 'error');
    }
}
?>
