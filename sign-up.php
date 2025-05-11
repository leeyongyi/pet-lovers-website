<?php
$host = "localhost";
$port = 3307; // Port number
$user = "root"; // Database username
$pass = ""; // Database password
$dbname = "petpals"; // Database name

// Open database connection
$connection = new mysqli("$host", "$user", "$pass", "$dbname", "$port");

# Check if connection is successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

# Retrieve form data
$UserName = $_POST['name'];
$UserEmail = $_POST['email'];
$UserPhoneNum = $_POST['phoneNum'];
$UserUsername = $_POST['username'];
$UserPassword = $_POST['password'];
$UserConfirmPassword = $_POST['confirmPass'];

# Insert data into table
$sql = "INSERT INTO user (name, email, phoneNum, username, password, confirmPass) 
        VALUES ('$UserName', '$UserEmail', '$UserPhoneNum', '$UserUsername', '$UserPassword', '$UserConfirmPassword')";

if (mysqli_query($connection, $sql)) {
    echo '<script>alert("Sign up successful"); window.location.href="read_post.php";</script>';
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($connection);
}

# Close database connection
mysqli_close($connection);
?>