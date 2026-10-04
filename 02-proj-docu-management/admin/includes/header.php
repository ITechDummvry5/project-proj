<?php require_once '../config/function.php';
        require 'authentication.php';
        date_default_timezone_set('Asia/Manila');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <style>
    ::-webkit-scrollbar {
    display: none;
}

html {
    scrollbar-width: none; /* For Firefox */
}

  </style>

    <title>Assisting Management System</title>
    <link href="assets/img/favicon.png" rel="icon">

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <!-- <link href="assets/css/font.css" rel="stylesheet"> -->
    <!-- Custom styles for this page -->
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
     <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/select.min.css" rel="stylesheet">
        <!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="assets/css/sweetalert2.min.css">


</head>
<main>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
    <?php include 'sidebar.php'?>
  
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                
  <?php include 'navbar.php'?>

