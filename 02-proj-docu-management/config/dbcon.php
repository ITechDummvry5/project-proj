<?php


// // Database connection using environment variables
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME','root');
// define('DB_PASSWORD','');
// define('DB_DATABASE','banadero');
// $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Date 4/24/2024
require __DIR__ . '/../vendor/autoload.php';


// Enable error reporting   
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

if (!defined('DB_SERVER')) define('DB_SERVER', $_ENV['DB_SERVER']);
if (!defined('DB_USERNAME')) define('DB_USERNAME', $_ENV['DB_USERNAME']);
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
if (!defined('DB_DATABASE')) define('DB_DATABASE', $_ENV['DB_DATABASE']);


$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>



