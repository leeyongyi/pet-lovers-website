<?php
$host = "localhost";
$port = 3307;
$user = "root";
$pass = "";
$dbname = "petpals";

// Open database connection
$connection = new mysqli($host, $user, $pass, $dbname, $port);

// Check if connection is successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Retrieve form data
$UserName = $_POST['name'];
$UserEmail = $_POST['email'];
$UserPhoneNum = $_POST['phoneNum'];
$UserUsername = $_POST['username'];
$UserPassword = $_POST['password'];
$UserConfirmPassword = $_POST['confirmPass'];

// Validate password match
if ($UserPassword !== $UserConfirmPassword) {
    echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
    exit;
}

// OPTIONAL: Hash password before storing
$hashedPassword = password_hash($UserPassword, PASSWORD_DEFAULT);

// Prepare SQL statement to prevent SQL injection
$stmt = $connection->prepare("INSERT INTO user (name, email, phoneNum, username, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $UserName, $UserEmail, $UserPhoneNum, $UserUsername, $hashedPassword);

if ($stmt->execute()) {
    // Success: Redirect to another page
    echo "<script>alert('Sign up successful'); window.location.href='read_post.php';</script>";
} else {
    // Error message
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$connection->close();
?>
