<?php
require 'config/function.php';

if (isset($_POST['rloginBtn'])) {
    $remail = validate($_POST['remail']);
    $rpassword = validate($_POST['rpassword']);

    if ($remail != '' && $rpassword != '') {
        $query = "SELECT * FROM residents WHERE remail='$remail' LIMIT 1";
        $rresult = mysqli_query($conn, $query);
        if ($rresult) {
           
            if (mysqli_num_rows($rresult) == 1) {
                $rrow = mysqli_fetch_assoc($rresult);
                $rhashedPassword = $rrow['rpassword'];

            
                if (!password_verify($rpassword, $rhashedPassword)) {
                    redirect('resident-login', 'Invalid Password!', 'error');
                }

                if ($rrow['ban_resident'] == 1) {
                    redirect('resident-login', 'The user is currently Inactive', 'error');
                }

                $_SESSION['rloggedIn'] = true;
                $_SESSION['rloggedInUser'] = [
                    'ruser_id' => $rrow['id'],
                    'rname' => $rrow['rname'],
                    'address' => $rrow['address'],
                    'remail' => $rrow['remail'],
                    'rphone' => $rrow['rphone'],
                ];

                redirect('resident/resident-view-payment', 'Logged In Successfully', 'success'); 


            }else {
                redirect('resident-login', 'Invalid Email Address!', 'error'); 
            }
        }
        else {
         redirect('resident-login', 'Something Went Wrong!', 'error'); 
        }
    }
    else {
        redirect('resident-login', 'All fields should be mandatory!', 'error');
    }
}

?>