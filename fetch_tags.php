<?php
include 'config.php';

// Database connection
$conn = new mysqli('localhost:3307', 'root', '', 'petpals');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch tags from the database
$sql = "SELECT id, name FROM tag";
$result = $conn->query($sql);

$options = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
    }
} else {
    $options = "<option value=''>No tags available</option>";
}

$conn->close();
echo $options;
?>


