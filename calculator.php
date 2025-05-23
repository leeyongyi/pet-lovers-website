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
        <div class="col-12">
            <article class="single-post">
                <h2>How old is Your Pet in Human Years</h2>

                <!-- Post Image -->
                <img src="img/blog-img/7.jpg" alt="Blog Image" class="post-image">
                
                <p class="post-content"><br>
                    Did you know that understanding your pet's age in human terms can provide valuable insights into their development and care needs? Just as humans have different life stages, so do our beloved pets. By referring to your pet's age in human years, you can better understand their maturity level, health requirements, and overall well-being. For example, a one-year-old dog may be equivalent to a teenager in human years, while a seven-year-old dog might be considered a senior citizen. Knowing your pet's age in human terms allows you to tailor their care, diet, and exercise routines accordingly, ensuring they lead a healthy and fulfilling life at every stage.
                </p>
            </article>

            <!-- Pet Age Calculator -->
            <h2>Pet Age Calculator</h2>
            <p class="info-text">Note: These age calculations are approximate and may vary depending on the breed and health of your pet.</p>

            <input type="number" id="petAge" min="0" value="0" placeholder="Enter Age">
            <select id="ageOption">
                <option value="years">Years</option>
                <option value="months">Months</option>
            </select>
            <select id="petType">
                <option value="smallDog">Small Dog</option>
                <option value="averageDog">Average Dog</option>
                <option value="bigDog">Big Dog</option>
                <option value="cat">Cat</option>
                <option value="horse">Horse</option>
                <option value="pig">Pig</option>
                <option value="snake">Snake</option>
                <option value="goldfish">Goldfish</option>
                <option value="rat">Rat</option>
                <option value="rabbit">Rabbit</option>
                <option value="hamster">Hamster</option>
            </select>
            <button class="calculate-btn" onclick="calculateAge()">Calculate</button>
            <div id="result"></div>
        </div>
    </div>
</div>

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

    <script>
      function calculateAge() {
        var petAge = parseInt(document.getElementById("petAge").value);
        var ageOption = document.getElementById("ageOption").value;
        var petType = document.getElementById("petType").value;
        var humanAge = 0;

        if (isNaN(petAge) || petAge < 0 || petAge > 50) {
            document.getElementById("result").innerHTML = "Please enter a valid age (0-50 years).";
            return;
        }

        if (!petAge || !ageOption || !petType) {
            document.getElementById("result").innerHTML = "Please fill in all the fields.";
            return;
        }

        if (ageOption === "months") {
            if (petType === "hamster" || petType === "rat") {
                // Keep age in months for small pets
                petAge = petAge;
            } else {
                petAge = petAge / 12; // Convert months to years for other pets
            }
        }

        switch (petType) {
            case "smallDog":
                humanAge = calculateDogAge(petAge, 4);
                break;
            case "averageDog":
                humanAge = calculateDogAge(petAge, 5);
                break;
            case "bigDog":
                humanAge = calculateDogAge(petAge, 6);
                break;
            case "cat":
                humanAge = calculateCatAge(petAge);
                break;
            case "horse":
                humanAge = calculateHorseAge(petAge);
                break;
            case "pig":
                humanAge = calculatePigAge(petAge);
                break;
            case "snake":
                humanAge = calculateSnakeAge(petAge);
                break;
            case "goldfish":
                humanAge = calculateGoldfishAge(petAge);
                break;
            case "rat":
                humanAge = calculateRatAge(petAge);
                break;
            case "rabbit":
                humanAge = calculateRabbitAge(petAge);
                break;
            case "hamster":
                humanAge = calculateHamsterAge(petAge);
                break;
            default:
                humanAge = "Unknown";
                break;
        }

        document.getElementById("result").innerHTML = "Your pet is approximately " + humanAge + " years (" + (petAge * 12) + " months) old in human years.";
    }

    function calculateDogAge(age, multiplier) {
        if (age <= 2) {
            return age * 12;
        } else {
            return 24 + (age - 2) * multiplier;
        }
    }

    function calculateCatAge(age) {
        if (age <= 2) {
            return age * 12;
        } else {
            return 24 + (age - 2) * 4;
        }
    }

    function calculateHorseAge(age) {
        return age * 6;
    }

    function calculatePigAge(age) {
        return age * 7;
    }

    function calculateSnakeAge(age) {
        return age * 3; // Adjusted for snake species
    }

    function calculateGoldfishAge(age) {
        return age * 4; // Adjusted for goldfish
    }

    function calculateRatAge(age) {
        return age * 6;
    }

    function calculateRabbitAge(age) {
        return age * 7;
    }

    function calculateHamsterAge(age) {
        return age * 8;
    }
    </script>
    
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