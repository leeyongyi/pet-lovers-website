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
    <!-- ##### Tag Posts Start ##### -->
    <style>
        .tag-list {
            background-color: white;
            padding: 20px 0;
            margin-bottom: 30px;
            border-top: 1px solid #dcdcdc;
        }

        .tag-list h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }
        .tag {
            display: inline-block;
            padding: 0 35px;
            border: 1px solid #c5c5c5;
            font-size: 12px;
            color: #000000;
            height: 45px;
            line-height: 43px;
            margin: 5px;
        }

        .tag:hover {
            border: 1px solid #30336b;
            color: #ffffff;
            background-color: #30336b;
        }
    </style>
    <div class="tag-list">
        <div class="container">
            <h2>Posts by Tag: <?php echo htmlspecialchars($_GET['tag']); ?></h2>
            <div class="tags">
                <?php
                include 'config.php';
                // Displaying tags dynamically
                $tags = array("petpals", "adoption", "care", "fun", "pets", "training", "toys");
                foreach ($tags as $tag) {
                    echo '<a href="tag_posts.php?tag=' . urlencode($tag) . '" class="tag">' . htmlspecialchars($tag) . '</a>';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php
                // Database connection
                $conn = new mysqli('localhost:3307', 'root', '', 'petpals');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Get tag name from query parameter
                if (isset($_GET['tag'])) {
                    $tag = $_GET['tag'];

                    // SQL query to fetch posts with the specified tag
                    $sql = "SELECT p.id, p.title, p.content, p.image_path, t.name as tag_name, p.date_posted, p.author 
                            FROM posts p 
                            JOIN tag t ON p.tag_id = t.id
                            WHERE t.name = '$tag'";
                    $result = $conn->query($sql);

                    // Error handling for query execution
                    if (!$result) {
                        die("Query failed: " . $conn->error);
                    }

                    // Display posts
                    if ($result->num_rows > 0) {
                        while ($post = $result->fetch_assoc()) {
                            ?>
                            <!-- Single Blog Post -->
                            <div class="single-blog-area blog-style-2 mb-50 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1000ms">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-6">
                                        <div class="single-blog-thumbnail">
                                            <?php if (!empty($post['image_path'])) : ?>
                                                <img src="<?php echo $post['image_path']; ?>" alt="">
                                            <?php endif; ?>
                                            <div class="post-date">
                                                <a href="#"><?php echo date('d M', strtotime($post['date_posted'])); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="single-blog-content">
                                            <div class="line"></div>
                                            <a href="#" class="post-tag"><?php echo $post['tag_name']; ?></a>
                                            <h4><a href="single_post.php?id=<?php echo $post['id']; ?>" class="post-headline"><?php echo $post['title']; ?></a></h4>
                                            <p><?php echo substr($post['content'], 0, 200); ?><?php if (strlen($post['content']) > 200) echo '...'; ?></p>
                                            <div class="post-meta">
                                                <p>By <a href="#"><?php echo $post['author']; ?></a></p>
                                            </div>
                                            <a href='update_post.php?id=<?php echo $post['id']; ?>'>Edit</a> |
                                            <a href='delete_post.php?id=<?php echo $post['id']; ?>' onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>No posts found for tag: $tag.</p>";
                    }
                } else {
                    echo "<p>Tag parameter not provided.</p>";
                }

                // Close database connection
                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <!-- ##### Tag Posts End ##### -->
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
