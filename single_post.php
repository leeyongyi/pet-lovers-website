<?php
include 'config.php';
?>
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
                                    <li><a href="profile.php?username=<?php echo urlencode($username); ?>">Profile</a></li>
                                    <li><a href="create_post.php">Add Post</a></li>
                                    <li><a href="calculator.php">Pet Age Calculator</a></li>
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
	<!-- ##### Single Post Area Start ##### -->
        <div class="container">
            <div class="row">
                <div class="col">
                    <?php
                    // Check if ID parameter is set in the URL
                        if (isset($_GET['id'])) {
                            // Database connection 
                            $conn = new mysqli('localhost:3307', 'root', '', 'petpals'); 

                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Escape the ID to prevent SQL injection
                            $post_id = $conn->real_escape_string($_GET['id']);

                            // SQL query to fetch the post details
                            $sql = "SELECT p.title, p.content, p.image_path, t.name as tag_name, p.date_posted, p.author 
                                    FROM posts p 
                                    JOIN tag t ON p.tag_id = t.id
                                    WHERE p.id = $post_id";
                            $result = $conn->query($sql);

                            // Check if query executed successfully
                            if ($result) {
                                // Check if post exists
                                if ($result->num_rows > 0) {
                                    $post = $result->fetch_assoc();
                    ?>
                            <!-- Display post details -->
                            <style>
                                .single-post .post-image {
                                    max-width: 100%;
                                    height: auto;
                                    margin-bottom: 30px;
                                }

                                .single-post .post-content {
                                    font-size: 15px;
                                    line-height: 1.8;
                                    margin-bottom: 30px;
                                }

                                .single-post .post-tag {
                                    display: inline-block;
                                    background-color: #ffffff;
                                    padding: 5px 10px;
                                    border: 1px solid #30336b;
                                    color: #30336b;
                                    text-decoration: none;
                                    transition: background-color 0.3s ease;
                                    margin-bottom: 20px;
                                }

                                .single-post .post-tag:hover {
                                    background-color: #f0f0f0;
                                }

                                .single-post .post-meta {
                                    font-size: 12px;
                                    color: #787878;
                                    margin-bottom: 20px;
                                }

                                .single-post .post-meta p {
                                    display: inline-block;
                                    margin-right: 10px;
                                }
                            </style>

                            <article class="single-post">
                                <h2><?php echo $post['title']; ?></h2>
                                <?php if (!empty($post['image_path'])) : ?>
                                    <img src="<?php echo $post['image_path']; ?>" alt="Post Image" class="post-image">
                                <?php endif; ?>
                                <p class="post-content"><?php echo $post['content']; ?></p>
                                <div class="tag-box">
                                    <a href="tag_posts.php?tag=<?php echo urlencode($post['tag_name']); ?>" class="post-tag"><?php echo htmlspecialchars($post['tag_name']); ?></a>
                                </div>
                                <div class="post-meta">
                                    <p>Date Posted: <?php echo date('M d, Y', strtotime($post['date_posted'])); ?></p>
                                    <p>By <a href="profile.php?username=<?php echo urlencode($post['author']); ?>"><?php echo htmlspecialchars($post['author']); ?></a></p>
                                </div>
                            </article>

                    <?php
                            } else {
                                echo '<script>alert("Post not found..");</script>';
                            }
                        } else {
                            echo '<script>alert("Error: ' . $conn->error . '");</script>';
                        }

                        // Close database connection
                        $conn->close();
                    } else {
                        echo '<script>alert("Post ID not specified.");</script>';
                    }
                    ?>
                </div>
            </div>
        </div>
    <!-- ##### Single Post Area End ##### -->
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
    <script src="login.js"></script>
</body>

</html>
