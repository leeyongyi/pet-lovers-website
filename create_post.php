<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tag_id = $_POST['tag_id'];
    $author = $_POST['author'];
    $date_posted = date('Y-m-d H:i:s'); 

    // Function to format content with paragraphs
    function formatContentWithParagraphs($content) {
        $paragraphs = explode("\n", $content);
        $formattedContent = '';
        foreach ($paragraphs as $paragraph) {
            if (trim($paragraph) !== '') {
                $formattedContent .= '<p>' . htmlspecialchars(trim($paragraph)) . '</p>';
            }
        }
        return $formattedContent;
    }

    // Format the content with paragraphs
    $formattedContent = formatContentWithParagraphs($content);

    // Handling file upload
    $uploadOk = true;
    $image_path = '';

    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);

        // Check if uploaded file is an image
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check === false) {
            echo '<script>alert("File is not an image."); window.location.href="create_post.php";</script>';
            exit;
        }

        // Allow certain file formats
        $allowedFormats = array("jpg", "jpeg", "png", "gif");
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, $allowedFormats)) {
            echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed."); window.location.href="create_post.php";</script>';
            exit;
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            echo '<script>alert("Sorry, there was an error uploading your file."); window.location.href="create_post.php";</script>';
            exit;
        }
    } elseif ($_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Handle other upload errors if needed
        echo "<script>alert('File upload error: " . $_FILES['file']['error'] . "'); window.location.href='create_post.php';</script>";
        exit;
    }

    // Database connection
    $conn = new mysqli('localhost:3307', 'root', '', 'petpals');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind parameters for insertion
    $stmt = $conn->prepare("INSERT INTO posts (title, content, image_path, tag_id, date_posted, author) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $title, $formattedContent, $image_path, $tag_id, $date_posted, $author);

    // Execute the statement
    if ($stmt->execute()) {
        echo '<script>alert("Post created successfully."); window.location.href="read_post.php";</script>';
    } else {
        echo '<script>alert("Error: ' . $stmt->error . '"); window.location.href="create_post.php";</script>';
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>



<script>
function validateForm() {
    let title = document.forms["createPostForm"]["title"].value;
    let content = document.forms["createPostForm"]["content"].value;
    let tag_id = document.forms["createPostForm"]["tag_id"].value;
    let author = document.forms["createPostForm"]["author"].value;

    if (title.trim() == "") {
        alert("Title must be filled out");
        return false;
    }
    if (content.trim() == "") {
        alert("Content must be filled out");
        return false;
    }
    if (tag_id.trim() == "") {
        alert("Tag must be selected");
        return false;
    }
    if (author.trim() == "") {
        alert("Author must be filled out");
        return false;
    }
    return true; 
}
</script>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>PetPals: Connect with Pet Lovers Worldwide</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Style CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="preload-content">
            <div id="original-load"></div>
        </div>
    </div>

    <!-- ##### Header Area Start ##### -->
    <header class="header-area">
        <!-- Top Header Area -->
        <div class="top-header">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <!-- Breaking News Area -->
                    <div class="col-12 col-sm-8">
                        <div class="breaking-news-area">
                            <div id="breakingNewsTicker" class="ticker">
                                <ul>
                                    <li><a href="#">Share, Connect, Love Pets</a></li>
                                    <li><a href="#">Connecting Pet Lovers Everywhere</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logo Area -->
        <div class="logo-area text-center">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <a href="index.html" class="original-logo"><img src="img/core-img/logo.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nav Area -->
        <div class="original-nav-area" id="stickyNav">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Classy Menu -->
                    <nav class="classy-navbar justify-content-between">
                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu" id="originalNav">
                            <!-- close btn -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul>
                                    <li><a href="read_post.php">Home</a></li>
                                    <li><a href="profile.html">Profile</a></li>
                                    <li><a href="create_post.php">Add Post</a></li>
                                    <li><a href="Pet-Age-Calculater.html">Pet Age Calculater</a></li>
                                    <li><a href="index.html">Sign Out</a></li>
                                </ul>
                            </div>
                            <!-- Nav End -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->
    <!-- ##### Create Post Form Start ##### -->
    <div class="create-post">
        <h2 class="post-headline">Create Post</h2>
        <form name="createPostForm" action="create_post.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <input type="text" name="title" placeholder="Title" required>
                <textarea name="content" placeholder="Content" required></textarea>
                <input type="file" name="file" required>
                <select name="tag_id" required>
                        <?php include 'fetch_tags.php'; ?>
                </select>
                <input type="text" name="author" placeholder="Author" required>
                <input type="submit" value="Submit">
        </form>
    </div>
    <!-- ##### Create Post Form End ##### -->
    <!-- ##### Instagram Feed Area Start ##### -->
    <div class="instagram-feed-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="insta-title">
                        <h5>Follow us @PetPals</h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- Instagram Slides -->
        <div class="instagram-slides owl-carousel">
            <!-- Single Insta Feed -->
            <div class="single-insta-feed">
                <img src="https://i.pinimg.com/236x/7f/0f/5e/7f0f5ea2c81ceddb9678fc6f8489f91b.jpg" alt="">
                <!-- Hover Effects -->
                <div class="hover-effects">
                    <a href="#" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
            <!-- Single Insta Feed -->
            <div class="single-insta-feed">
                <img src="https://i.pinimg.com/474x/7c/48/ad/7c48addaa248ca48a1b76a424a4ff29a.jpg" alt="">
                <!-- Hover Effects -->
                <div class="hover-effects">
                    <a href="#" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
            <!-- Single Insta Feed -->
            <div class="single-insta-feed">
                <img src="https://i.pinimg.com/474x/14/05/0b/14050b85a181301a0833a1204aac57c7.jpg" alt="">
                <!-- Hover Effects -->
                <div class="hover-effects">
                    <a href="#" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
            <!-- Single Insta Feed -->
            <div class="single-insta-feed">
                <img src="https://i.pinimg.com/236x/8d/3c/de/8d3cde41856a7702f480fec88b008310.jpg" alt="">
                <!-- Hover Effects -->
                <div class="hover-effects">
                    <a href="#" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
            <!-- Single Insta Feed -->
            <div class="single-insta-feed">
                <img src="https://i.pinimg.com/236x/ae/4f/01/ae4f01f22f38c6a876d67dc3b5c13a55.jpg" alt="">
                <!-- Hover Effects -->
                <div class="hover-effects">
                    <a href="#" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
            <!-- Single Insta Feed -->
            <div class="single-insta-feed">
                <img src="https://i.pinimg.com/236x/1a/ef/5b/1aef5b1f17f5749f6f2e37d82e96f09f.jpg" alt="">
                <!-- Hover Effects -->
                <div class="hover-effects">
                    <a href="#" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
            <!-- Single Insta Feed -->
            <div class="single-insta-feed">
                <img src="https://i.pinimg.com/236x/9a/3e/a7/9a3ea7ceb2ce0d146d40c84d1f75dad1.jpg" alt="">
                <!-- Hover Effects -->
                <div class="hover-effects">
                    <a href="#" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Instagram Feed Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area text-center">
        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o"
            aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
    </footer>
    <!-- ##### Footer Area End ##### -->

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="js/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>
    <!-- Custom JavaScript -->
    <script src="signin.js"></script>
</body>

</html>

