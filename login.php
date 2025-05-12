<?php
session_start(); 

$host = "localhost";
$port = 3307;
$user = "root";
$pass = "";
$dbname = "petpals";

// Open database connection
$connection = new mysqli($host, $user, $pass, $dbname, $port);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if form data exists
if (isset($_POST['username']) && isset($_POST['password'])) {
    $UserUsername = trim($_POST['username']);
    $UserPassword = trim($_POST['password']);

    // Prepare and bind
    $stmt = $connection->prepare("SELECT password FROM user WHERE username = ?");
    $stmt->bind_param("s", $UserUsername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Bind result
        $stmt->bind_result($hashedPasswordFromDB_raw);
        $stmt->fetch();
        $hashedPasswordFromDB = trim($hashedPasswordFromDB_raw);

        if (password_verify($UserPassword, $hashedPasswordFromDB)) {
            $_SESSION['username'] = $UserUsername; 
            echo '<script>alert("Login successful"); window.location.href="read_post.php";</script>';
        } else {
            echo '<script>alert("Invalid username or password."); window.history.back();</script>';
        }
    } else {
        echo '<script>alert("Invalid username or password."); window.history.back();</script>';
    }

    $stmt->close();
} else {
    echo "Form submission error. Please try again.";
}

$connection->close();
?>
