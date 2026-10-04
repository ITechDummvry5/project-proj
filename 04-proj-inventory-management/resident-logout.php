<?php 
require 'config/function.php';

if (isset($_SESSION['rloggedIn'])) {
    rlogoutSession();
    redirect('resident-login', 'Logout successfully');
}

?>