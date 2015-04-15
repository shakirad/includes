<?php
//CONNECT TO THE DATABASE ALSO INCLUDES A SCRIPT TO DISPLAY ERRORS

$host = "localhost"; 
$user = "shakirad"; 
$password = "Rp505Neumn5"; 
$database = "shakirad_CTproject"; 

/*$host = 'localhost';
$user = 'root';
$password = 'root';
$database = 'CTproject';
$port = 8889;*/

 
//create a connection 
$conn = mysqli_connect($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//debugging

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

?>