<?php

    if(!empty($_SESSION)){
        require_once "classes/item.php";
        $user = new Item;
        $sellerToDos = $user->SellerToDo();
        $winnerToDos = $user->WinnerToDo();
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
                                        <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-transparent" data-bs-toggle="modal" data-bs-target="#notifications">
                                        <i class="fas fa-bell text-warning"></i>
                                    </button>
                                </li>
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
    <!-- Modal -->
    <div class="modal fade" id="notifications" tabindex="-1" aria-labelledby="notificationsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="notificationsLabel">What To Do</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?php
            if(!empty($sellerToDos) || !empty($winnerToDos)){
                if(!empty($sellerToDos)){
                    echo "<span class='text-danger'>Send the following Items:</span><br>";
                    foreach($sellerToDos as $sellerToDo){
            ?>
            <li>
                <div>
                    <a class="" href="bid.php?id=<?= $sellerToDo['item_id'] ?>"><img height="80px" width="80px" src="assets/images/item_images/<?= $sellerToDo['item_photo'] ?>" alt="#"></a>
                </div>

                <div class="content">
                    <h4><a href="bid.php?id=<?= $sellerToDo['item_id'] ?>">
                            <?= $sellerToDo['item_name'] ?></a></h4>
                    <p class="quantity">Currently: <span class="text-primary">¥<?= $sellerToDo['current_price'] ?></span></p>
                </div>
            </li>
            <?php
                    }
                }

                if(!empty($winnerToDos)){
                    echo "<span class='text-danger'>Receive the following Items:</span><br>";
                    foreach($winnerToDos as $winnerToDo){
            ?>
            <div class="row">
                <hr>
                <div class="col-3">
                    <a class="" href="auction-winner.php?id=<?= $winnerToDo['item_id'] ?>">
                        <img height="80px" width="80px" src="assets/images/item_images/<?= $winnerToDo['item_photo'] ?>" alt="#">
                    </a>
                </div>

                <div class="col-9">
                    <h4>
                        <a href="auction-winner.php?id=<?= $winnerToDo['item_id'] ?>">
                            <?= $winnerToDo['item_name'] ?>
                        </a>
                    </h4>
                </div>
            </div>
            <?php
                    }
                }
            }else{
                echo "No notifications";
            }
                
               
            ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
