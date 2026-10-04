<?php

// Database connection settings
$host = "localhost";
$username = "root";
$password = "";
$database = "bookstore"; // change this to your DB name

// Connect
$con = mysqli_connect($host, $username, $password, $database);

// Check connection
if(!$con){
    die("Connection Failed: " . mysqli_connect_error());
}
?>
