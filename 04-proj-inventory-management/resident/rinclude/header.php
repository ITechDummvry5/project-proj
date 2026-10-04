<?php require '../config/function.php'; ?>
<?php require 'resident-authen.php'; ?>
<!-- Hoa header -->
 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="shortcut icon" href="../assets/image/icon.png" type="image/x-icon">
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Resident</title>
<!-- style -->
        <link href="assets/css/styles.css" rel="stylesheet" /> 
        <link href="assets/css/custom-resident.css" rel="stylesheet" /> 
        <link href="assets/css/main.min.css" rel="stylesheet" />
        <link href="../assets/css/select.min.css" rel="stylesheet" />
        
        <script src="../assets/js/jquery.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js" ></script>
        <script src="../assets/js/sidebar.min.js" ></script>
        <script src="../assets/js/font-awesome.min.js" ></script>
    
        <script src="../assets/js/data-table-library.js" ></script>
        <script src="../assets/js/data-table-start-demo.js" ></script>
        <script src="../assets/js/sweetalert2.min.js"></script>
        <script src="../assets/js/select.min.js"></script>

        <script src="assets/js/main.min.js"></script>
        <script src="assets/js/jspdf.min.js"></script>
        <script src="assets/js/html2canvas.min.js"></script>

    </head>
    <script>
    function confirmDeletereject(url) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Deleted!',
                text: 'Your request has been deleted.',
                icon: 'success'
            }).then(() => {
                // Redirect to the delete URL
                window.location.href = url;
            });
        }
    });
}
</script>
   
    <body class="sb-nav-fixed">

    <?php include('rinclude/navbar.php'); ?>

    <div id="layoutSidenav">
    <?php include('rinclude/sidebar.php'); ?>
    
    <div id="layoutSidenav_content">
                <main>

   


