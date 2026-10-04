<?php 

require '../config/function.php';

$paraResultId = checkParamId('id');
if(is_numeric($paraResultId)){ 
    $adminId = validate($paraResultId);

    $admin = getById('admins', $adminId);
    if($admin['status'] == 200){ 
        // Delete related active sessions first
        $deleteSessionsQuery = "DELETE FROM active_sessions WHERE user_id = $adminId";
        mysqli_query($conn, $deleteSessionsQuery);

        // Now delete the admin
        $adminDeleteRes = delete('admins', $adminId);
        if ($adminDeleteRes) {
            redirect('admins.php', 'Admin successfully Delete!','success');
        } else {
            redirect('admins.php', 'Something went wrong during deletion.','error');
        }
    } else {
        redirect('admins.php', $admin['message'],'error');
    }
} else {
    redirect('admins.php', 'Invalid ID provided.','error');
}
?>
