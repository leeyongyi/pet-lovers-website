<?php
include 'config.php';
$loggedInUsername = isset($_SESSION['username']) ? $_SESSION['username'] : null;
// Default user information
$user = ['username' => 'Unknown', 'introduction' => 'No introduction available.', 'image_path' => 'img/default-profile.png'];
$userPosts = [];

// Fetch username from the URL query string
if (isset($_GET['username'])) {
    $profileUsername = $_GET['username'];

    // Prepare the SQL query to fetch user data by username
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $connection->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $profileUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists in the database
        if ($result->num_rows > 0) {
            // Fetch user details
            $user = $result->fetch_assoc();
            $sqlPosts = "
                SELECT posts.*, tag.name AS tag_name
                FROM posts
                INNER JOIN tag ON posts.tag_id = tag.id
                WHERE posts.author = ?
            ";
            $stmtPosts = $connection->prepare($sqlPosts);
            if ($stmtPosts) {
                $stmtPosts->bind_param("s", $profileUsername);
                $stmtPosts->execute();
                $postResult = $stmtPosts->get_result();

                // Fetch all posts with their tags
                while ($row = $postResult->fetch_assoc()) {
                    $userPosts[] = $row;
                }
                $stmtPosts->close();
            } else {
                echo "<p style='color:red;'>Error fetching posts.</p>";
            }

        } else {
            // User not found, alert and redirect
            echo "<script type='text/javascript'>
                    alert('User not found');
                    window.location.href = 'read_post.php';
                  </script>";
            exit;
        }
        $stmt->close();
    } else {
        echo "<p style='color:red;'>Error preparing statement.</p>";
    }
} else {
    echo "<p style='color:red;'>Username not specified.</p>";
}

$connection->close();
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
                            </div>
                            <!-- Nav End -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- Breadcumb Area -->
    <div class="breadcumb-area bg-img" style="background-image: url('<?php echo htmlspecialchars($user['image_path']); ?>');">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-content text-center">
                        <h2><?php echo htmlspecialchars($user['username']); ?>'s Profile</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Page Content -->
    <div class="blog-wrapper section-padding-100-0 clearfix">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-12">
                    <div class="single-blog-area clearfix mb-100">
                        <div class="single-blog-content">
                            <!-- Edit Profile Button -->
                            <?php if ($loggedInUsername === $user['username']): ?>
                                <div class="d-flex justify-content-end mb-3">
                                    <a href="edit_profile.php?username=<?php echo urlencode($user['username']); ?>" class="btn original-btn">Edit Profile</a>
                                </div>
                            <?php endif; ?>
                            <!-- Profile Info -->
                            <h4 class="post-headline">Welcome to <?php echo htmlspecialchars($user['username']); ?>'s profile</h4>
                            
                            <!-- Profile Image and Introduction -->
                            <div class="row">
                                <?php if (!empty($user['image_path']) && $user['image_path'] !== 'img/default-profile.png'): ?>
                                    <div class="col-md-4">
                                        <img src="<?php echo htmlspecialchars($user['image_path']); ?>" alt="Profile Image" class="img-fluid">
                                    </div>
                                <?php endif; ?>
                                <div class="col-md-8 d-flex align-items-center justify-content-center">
                                    <p class="mb-3 text-center"><?php echo nl2br(htmlspecialchars($user['introduction'])); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Wrapper for Posts -->
    <div class="blog-wrapper clearfix">
        <div class="container">
            <div class="row">
                <?php if (!empty($userPosts)): ?>
                    <h4 class="mb-4">Posts by <?php echo htmlspecialchars($user['username']); ?></h4>
                    <div class="row">
                        <?php foreach ($userPosts as $post): ?>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="single-blog-area blog-style-2 mb-100">
                                    <div class="single-blog-thumbnail">
                                        <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="">
                                        <div class="post-date">
                                            <a href="#"><?php echo date('d', strtotime($post['date_posted'])); ?> <span><?php echo date('F', strtotime($post['date_posted'])); ?></span></a>
                                        </div>
                                    </div>
                                    <div class="single-blog-content mt-50">
                                        <div class="line"></div>
                                        <a href="tag_posts.php?tag=<?php echo urlencode($post['tag_name'] ?? 'No Tag'); ?>" class="post-tag">
                                            <?php echo htmlspecialchars($post['tag_name'] ?? 'No Tag'); ?>
                                        </a>
                                        <h4><a href="single_post.php?id=<?php echo $post['id']; ?>" class="post-headline"><?php echo htmlspecialchars($post['title']); ?></a></h4>
                                        <p><?php echo strip_tags(substr($post['content'], 0, 100)); ?>...</p>
                                        <div class="post-meta">
                                            <p>By <a href="profile.php?username=<?php echo urlencode($post['author']); ?>"><?php echo htmlspecialchars($post['author']); ?></a></p>
                                        </div>
                                        <?php if ($username === $post['author']): ?>
                                            <a href='update_post.php?id=<?php echo $post['id']; ?>'>Edit</a> |
                                            <a href='delete_post.php?id=<?php echo $post['id']; ?>' onclick="return confirm('Are you sure?');">Delete</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center">No posts found for this user.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- ##### Blog Wrapper End ##### -->
     
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
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <!-- Footer Nav Area -->
                    <div class="classy-nav-container breakpoint-off">
                        <!-- Classy Menu -->
                        <nav class="classy-navbar justify-content-center">

                            <!-- Menu -->
                            <div class="classy-menu">

                                <!-- close btn -->
                                <div class="classycloseIcon">
                                    <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                                </div>
                            </div>
                        </nav>
                    </div>

                    <!-- Footer Social Area -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
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

</body>

</html>