<?php
    if(!empty($_SESSION)){
        $fullName = $_SESSION['first_name']." ".$_SESSION['last_name'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nish Auction</title>
  <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />

  <!-- ========================= CSS here ========================= -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/LineIcons.3.0.css" />
  <link rel="stylesheet" href="assets/css/tiny-slider.css" />
  <link rel="stylesheet" href="assets/css/glightbox.min.css" />
  <link rel="stylesheet" href="assets/css/main.css" />
 
  <!-- font-awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
  input[type="number"]::-webkit-outer-spin-button, 
  input[type="number"]::-webkit-inner-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
  } 
  </style>
</head>
<body>
<!-- Start Header Area -->
    <header class="header navbar-area">
        <!-- Start Topbar -->
        <div class="topbar"  style="padding:5px 0;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-left">
                            <h1 style="line-height: 40px;font-size: 30px; margin:0">
                                <a href="index.php" class="navbar-brand text-white">
                                    Nish Auction
                                </a>
                            </h1>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-middle">
                            <ul class="useful-links m-0">
                                <li><a href="index.php">Home</a></li>
                                <!-- <li><a href="#">About Us</a></li> -->
                                <li><a href="#">Contact Us</a></li>
                                <?php
                                if(!empty($_SESSION) && $_SESSION['status'] == 'A'){
                                  echo "<li><a href='dashboard.php'>Dashboard</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-end">
                            <a href="my-page.php">
                                <div class="user">
                                    

                                    <?php
                                    if(!empty($_SESSION)){
                                        echo "<i class='lni lni-user'></i>";
                                        echo $fullName;
                                    }
                                     ?>
                                </div>
                            </a>
                            
                            <ul class="user-login m-0">
                            <?php if(!empty($_SESSION)){ ?>
                                <li>
                                    <a href="logout.php">Logout</a>
                                </li>
                            <?php
                            }else{
                            ?>
                                <li>
                                    <a href="login.php">Sign In</a>
                                </li>
                                <li>
                                    <a href="register.php">Register</a>
                                </li>
                            <?php
                            }
                            ?>
                            </ul>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
        <!-- End Topbar -->
