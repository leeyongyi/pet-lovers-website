<?php
if (session_id() == '') {
    session_start();
} 

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit(); 
}

$username = $_SESSION['username'];

// Database connection settings
$host = 'localhost:3307'; 
$dbname = 'petpals'; 
$user = 'root'; 
$pass = ''; 

// Create a connection
$connection = new mysqli($host, $user, $pass, $dbname);

// Check the connection
if ($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}
?>