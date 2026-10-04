<?php require_once '../config/function.php';
        require 'authen.php';
        date_default_timezone_set('Asia/Manila');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
     
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="capstone" />
        <meta name="author" content="Charles" />
        <link rel="shortcut icon" href="../assets/image/icon.png" type="image/x-icon">
        <title>Dashboard</title>
        
        <!-- sbadmin -->
        <link href="assets/css/sbadmin.min.css" rel="stylesheet" />     
        <!-- alertify -->
        <link rel="stylesheet" href="assets/css/alertify-default.min.css"/> <!--For showing quantity update notification for the text color white-->
        <link rel="stylesheet" href="assets/css/alertify.min.css"/> <!--For showing quantity update notification-->
        <!-- select -->
        <link href="../assets/css/select.min.css" rel="stylesheet" />
        <!-- custom -->
         <link href="assets/css/scratch.min.css" rel="stylesheet" />
         
    </head>
    <body class="sb-nav-fixed">

    <?php include('includes/navbar.php'); ?>

<div id="layoutSidenav">

    <?php include('includes/sidebar.php'); ?>

    <div id="layoutSidenav_content">  <main>
                    <!--Date 4/24/2024-->