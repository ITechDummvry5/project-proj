<?php  
require 'config/function.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Barangay Bañadero</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <style>
    ::-webkit-scrollbar {
    display: none;
}

html {
    scrollbar-width: none; /* For Firefox */
}

  </style>
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">

  <!-- Fonts
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="assets/css/font.css" rel="stylesheet"> -->

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Bootslander
  * Template URL: https://bootstrapmade.com/bootslander-free-bootstrap-landing-page-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <?php
if (in_array(basename($_SERVER['PHP_SELF']), ['login.php', 'forgot-password.php'])): ?>
    <img src="assets/img/favicon.png" alt="icon">
<?php endif; ?>


        <h1 class="sitename">Assistance Management</h1>
      </a>

      <?php 
  include('navbar.php')
  ?>
    </div>
  </header>
  <main class="main">
