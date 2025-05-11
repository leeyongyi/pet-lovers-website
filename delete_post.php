<?php
include 'config.php';

$id = $_GET['id'];

// Validate ID
if (!filter_var($id, FILTER_VALIDATE_INT)) {
    echo '<script>alert("Invalid post ID"); window.location.href="read_post.php";</script>';
    exit;
}

// Database connection
$conn = new mysqli('localhost:3307', 'root', '', 'petpals');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute() === TRUE) {
    echo '<script>alert("Post deleted successfully"); window.location.href="read_post.php";</script>';
} else {
    echo '<script>alert("Error: Could not delete post"); window.location.href="read_post.php";</script>';
}

$stmt->close();
$conn->close();
?>
