<?php
$host = "localhost";
$port = 3307; // Port number
$user = "root"; // Database username
$pass = ""; // Database password
$dbname = "petpals"; // Database name

// Open database connection
$connection = new mysqli($host, $user, $pass, $dbname, $port);

// Check if connection is successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if form data exists before accessing it
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Retrieve form data
    $UserUsername = $_POST['username'];
    $UserPassword = $_POST['password'];

    // SQL query to fetch user with the given username/email
    $sql = "SELECT * FROM user WHERE username = '$UserUsername'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if ($UserPassword === $row['password']) {
            // Passwords match, login successful
            echo '<script>alert("Login successful"); window.location.href="read_post.php";</script>';
        } else {
            // Passwords do not match
            echo "Login failed. Invalid username or password.";
        }
    } else {
        // No user found with the given username/email
        echo "Login failed. Invalid username or password.";
    }
} else {
    // Form data not received
    echo "Form submission error. Please try again.";
}

// Close database connection
$connection->close();
?>
