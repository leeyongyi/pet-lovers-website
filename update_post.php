<?php
include 'config.php'; 

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

// Initialize variables
$post = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Database connection
    $conn = new mysqli('localhost:3307', 'root', '', 'petpals');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch post data
    $sql = "SELECT * FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    }

    $stmt->close();
    $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize variables from POST data
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content']; 
    $formattedContent = formatContentWithParagraphs($content);
    $tag_id = $_POST['tag_id'];
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $date_posted = date('Y-m-d H:i:s');
    $current_image_path = isset($_POST['current_image_path']) ? $_POST['current_image_path'] : '';
    $image_path = $current_image_path;

    // Handling file upload
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);

        // Check if uploaded file is an image
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check === false) {
            echo '<script>alert("File is not an image."); window.location.href="update_post.php?id=' . $id . '";</script>';
            exit;
        }

        // Allow certain file formats
        $allowedFormats = array("jpg", "png", "jpeg", "gif");
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, $allowedFormats)) {
            echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed."); window.location.href="update_post.php?id=' . $id . '";</script>';
            exit;
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            echo '<script>alert("Sorry, there was an error uploading your file."); window.location.href="update_post.php?id=' . $id . '";</script>';
            exit;
        }
    } elseif ($_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Handle other upload errors if needed
        echo "<script>alert('File upload error: " . $_FILES['file']['error'] . "'); window.location.href='update_post.php?id=' . $id . ';</script>";
        exit;
    }

    // Database connection and update
    $conn = new mysqli('localhost:3307', 'root', '', 'petpals');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement using prepared statements to prevent SQL injection
    $sql = "UPDATE posts SET title=?, content=?, image_path=?, tag_id=?, date_posted=?, author=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $title, $formattedContent, $image_path, $tag_id, $date_posted, $author, $id);

    // Execute the update
    if ($stmt->execute()) {
        if ($_FILES['file']['error'] === UPLOAD_ERR_OK && $check !== false && in_array($imageFileType, $allowedFormats)) {
            echo '<script>alert("Post updated successfully"); window.location.href="read_post.php";</script>';
        } else {
            echo '<script>alert("Post updated successfully, but the uploaded file was not an image."); window.location.href="read_post.php";</script>';
        }
    } else {
        echo '<script>alert("Error: ' . $stmt->error . '"); window.location.href="update_post.php?id=' . $id . '";</script>';
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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

    <!-- Header Area Start -->
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
    <!-- Header Area End -->

    <!-- Update Post Form Start -->
    <div class="create-post">
        <h2 class="post-headline">Update Post</h2>
        <form action="update_post.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo isset($post['id']) ? $post['id'] : ''; ?>">
                <input type="text" name="title" placeholder="Title" value="<?php echo isset($post['title']) ? htmlspecialchars($post['title']) : ''; ?>" required>
                <textarea name="content" placeholder="Content" required><?php echo isset($post['content']) ? htmlspecialchars(str_replace('</p>', "\n", str_replace('<p>', '', $post['content']))) : ''; ?></textarea>
                <input type="file" name="file">
                <select name="tag_id" required>
                        <?php include 'fetch_tags.php'; ?>
                </select>
                <input type="text" name="author" placeholder="Author" value="<?php echo isset($post['author']) ? htmlspecialchars($post['author']) : ''; ?>" required>
                <input type="hidden" name="current_image_path" value="<?php echo isset($post['image_path']) ? htmlspecialchars($post['image_path']) : ''; ?>">
                <input type="submit" value="Update Post">
        </form>
    </div>
    <!-- Update Post Form End -->

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
