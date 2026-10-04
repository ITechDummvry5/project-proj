<?php 

if(isset($_SESSION['rloggedIn'])){
    
    $remail = validate($_SESSION['rloggedInUser']['remail']);
   
    $query = "SELECT * FROM residents WHERE remail='$remail' LIMIT 1";
    $rresult = mysqli_query($conn, $query);

    
    if(mysqli_num_rows($rresult) == 0){
        rlogoutSession();
        redirect('../resident-login.php','Login to continue...!','error');
    }else{ 
        $rrow = mysqli_fetch_assoc($rresult);
        if($rrow['ban_resident'] == 1) { 
            rlogoutSession();
    redirect('../resident-login.php',' Your account are currently Inactive!','error');
            
        }
    }
 }else {
    redirect('../resident-login.php', 'Login to Continue...','error');
 }

?>


