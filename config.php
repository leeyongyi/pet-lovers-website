<?php
// Database connection settings
$host = 'localhost:3307'; // Database host and port (e.g., 'localhost')
$dbname = 'petpals'; // Database name
$user = 'root'; // Database username
$pass = ''; // Database password

// Create a connection
$connection = new mysqli($host, $user, $pass, $dbname);

// Check the connection
if ($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}
?>