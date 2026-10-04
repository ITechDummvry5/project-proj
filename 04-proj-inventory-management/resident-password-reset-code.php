<?php
require 'config/function.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Function to send password reset email
function send_password_resident_reset($get_rname, $get_remail, $rtoken) {
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
        $mail->setFrom($_ENV['SMTP_USERNAME'], 'Support');
        $mail->addAddress($get_remail);

        // Content
        $resident_resetLink = "http://localhost/new/resident-password-change.php?rtoken=$rtoken&remail=$get_remail";
        // $resident_resetLink = "https://casaverde.website/ims/resident-password-change.php?rtoken=$rtoken&remail=$get_remail";

        $mail->isHTML(true);
        $mail->Subject = 'Resident Password Reset';
        $mail->Body = "Hello $get_rname,<br>Click <a href='$resident_resetLink'>here</a> to reset your password.";
        $mail->AltBody = "Hello $get_rname, click this link to reset your password: $resident_resetLink";

        $mail->send();
        $_SESSION['status'] = "Reset link has been sent to your email!";
    } catch (Exception $e) {
        $_SESSION['status'] = "Error sending email: {$mail->ErrorInfo}";
    }
}

// Handling password reset link request
if (isset($_POST['resident_reset_link'])) {
    $remail = validate($_POST['remail']);
    $rtoken = md5(rand());
    $rexpiration_time = date("Y-m-d H:i:s", strtotime("+1 hour"));

    $check_email = "SELECT remail, rname FROM residents WHERE remail='$remail' LIMIT 1";
    $check_email_run = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($check_email_run) > 0) {
        $row = mysqli_fetch_array($check_email_run);
        $get_rname = $row['rname'];
        $get_remail = $row['remail'];

        // Update token in the database
        $update_token = "UPDATE residents SET verify_token='$rtoken', token_expiration='$rexpiration_time' WHERE remail='$remail' LIMIT 1";
        $update_token_run = mysqli_query($conn, $update_token);
        
        if ($update_token_run) {
            send_password_resident_reset($get_rname, $get_remail, $rtoken);
            redirect('resident-password-reset.php', 'Reset link sent to your email', 'success');
        } else {
            redirect('resident-password-reset.php', 'Something went wrong', 'eror');
        }
    } else {
        redirect('resident-password-reset.php', 'Email not found', 'eror');
    }
}

// Handling password update request

if (isset($_POST['update_password'])) {
    $rtoken = validate($_POST['token_password']);
    $remail = validate($_POST['remail']);
    $new_password = validate($_POST['new_password']);
    $confirm_password = validate($_POST['confirm_password']);

    if (!empty($rtoken)) {
        if (!empty($remail) && !empty($new_password) && !empty($confirm_password)) {
            $check_token = "SELECT verify_token, token_expiration FROM residents WHERE verify_token='$rtoken' LIMIT 1";
            $check_token_run = mysqli_query($conn, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {
                $rtoken_data = mysqli_fetch_assoc($check_token_run);
                $expiration = $rtoken_data['token_expiration'];

                if (strtotime($expiration) > time()) {
                    if ($new_password == $confirm_password) {
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                        $update_passwords = "UPDATE residents SET rpassword ='$hashed_password' WHERE verify_token='$rtoken' LIMIT 1"; 
                        $update_passwords_run = mysqli_query($conn, $update_passwords);

                        if ($update_passwords_run) {
                            $new_token = md5(rand())."imscasa.website";
                            $new_expiration_time = date("Y-m-d H:i:s", strtotime("+1 hour"));
                            $update_new_token = "UPDATE residents SET verify_token ='$new_token', token_expiration='$new_expiration_time' WHERE verify_token='$rtoken' LIMIT 1"; 
                            $update_new_token_run = mysqli_query($conn, $update_new_token);

                            redirect("resident-login.php", 'New Password Successfully Updated', 'success');
                        } else {
                            redirect("resident-password-change.php?rtoken=$rtoken&remail=$remail", 'Password did not update. Something went wrong.', 'error');
                        }
                    } else {
                        redirect("resident-password-change.php?rtoken=$rtoken&remail=$remail", 'Passwords do not match.', 'error');
                    }
                } else {
                    redirect("resident-password-change.php?rtoken=$rtoken&remail=$remail", 'Token has expired. Please request a new password reset.', 'error');
                }
            } else {
                redirect("resident-password-change.php?rtoken=$rtoken&remail=$remail", 'Invalid token.', 'error');
            }
        } else {
            redirect("resident-password-change.php?rtoken=$rtoken&remail=$remail", 'All fields are required.', 'error');
        }
    } else {
        redirect('resident-password-change.php', 'No token provided.', 'error');
    }
}


?>
