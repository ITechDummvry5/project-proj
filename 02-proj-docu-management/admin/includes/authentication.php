<?php 
// require 'config/function.php';

if(isset($_SESSION['loggedIn'])){ 

    if($_SESSION['loggedInUser']['role'] != 'staff' && $_SESSION['loggedInUser']['role'] != 'secretary') {
        alertMessage();
        redirect('index.php','Your account is not authorized!','error');
    }
    
    $email = validate($_SESSION['loggedInUser']['email']);
   
    $query = "SELECT * FROM account WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 0){
        logoutSession();
        redirect('../login.php','Access  Denied!','error');
    }else{ 
        $row = mysqli_fetch_assoc($result);
        if($row['is_ban'] == 1) { 
            logoutSession();
    redirect('../login.php','This account are currently Inactive','error');
            
        }
    }
}
else{
    redirect('../login.php','Please Login to continue...','error'); //this for copy the link already login then logout mo then mag shoshow to kasi nawala na yung session
}

?>