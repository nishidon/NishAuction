<?php
    include 'classes/item.php';
    include 'classes/user.php';
    include 'functions/functions.php';
    include 'classes/category.php';
    include 'classes/favorite.php';
    include 'classes/evaluation.php';
    $item_id = $_GET['id'];
    $row = new Item();
    $itemList = $row->getOneItem($item_id);
    $allItems = $row->getItems('all');
    $endsIn = $row->getOneEnd($item_id);
    $bidNum = $row->getOneBid($item_id);
    $bidders = $row->getBidders($item_id);
    $rows = new Category();
    $catList = $rows->getCat();
    $evaluate = new Evaluate;
    $starAvg = $evaluate->getEvaluateAvg($itemList['user_id']);
    $reviewNum = $evaluate->getEvaluateNum($itemList['user_id']);
    if(!empty($_SESSION)){
        $fav = new Favorite();
        $user_id = $_SESSION['user_id'];
        $checkFavNum = $fav->checkFavoriteNum($user_id);
        $fav->removeClosedFav();
    }
    include 'topbar.php';
?>

    <div class="header navbar-area">
        <!-- Start Header Middle -->
        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-7">
                        <!-- Start Header Logo -->
                        <!-- <a class="navbar-brand" href="index.html">
                            <img src="assets/images/logo/logo.svg" alt="Logo">
                        </a> -->
                        <!-- End Header Logo -->
                    </div>
                    <div class="col-lg-5 col-md-7 d-xs-none">
                        <!-- Start Main Menu Search -->
                        <div class="main-menu-search">
                            <!-- navbar search start -->
                            <div class="navbar-search search-style-5">
                                <!-- <div class="search-select">
                                    <div class="select-position">
                                        <select id="select1">
                                            <option selected>All</option>
                                            <option value="1">option 01</option>
                                            <option value="2">option 02</option>
                                            <option value="3">option 03</option>
                                            <option value="4">option 04</option>
                                            <option value="5">option 05</option>
                                        </select>
                                    </div>
                                </div> -->
                                <form action="index.php" method="post" class="w-100">
                                    <div class="row">
                                        <div class="col-10" style="padding-right: 0">
                                            <input class="form-control w-100 me-0 h-100" name="search" type="text" placeholder="Search">
                                        </div>
                                        <div class="col-2" style="padding-left: 0">
                                            <span class="bg-dark p-1 border rounded">
                                                <input type="submit" name="submit" value="Search" class="btn btn-dark">
                                            </span> 
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- navbar search Ends -->
                        </div>
                        <!-- End Main Menu Search -->
                    </div>
                    <div class="col-lg-4 col-md-2 col-5 ps-5">
                        <div class="middle-right-area">
                            <!-- <div class="nav-hotline">
                                <i class="lni lni-phone"></i>
                                <h3>Hotline:
                                    <span>(+100) 123 456 7890</span>
                                </h3>
                            </div> -->
                            <?php
                             if(!empty($_SESSION)){
                            ?>
                            <div class="navbar-cart">
                                <div class="cart-items">
                                    <a href="javascript:void(0)" class="main-btn">
                                        <i class="lni lni-heart"></i>
                                        <span class="total-items"><?= $checkFavNum ?></span>
                                    </a>
                                    <!-- Shopping Item -->
                                    <div class="shopping-item">
                                        <div class="dropdown-cart-header">
                                            <span><?= $checkFavNum ?> Item<?php if($checkFavNum>1){echo 's';} ?></span>
                                            <a href="wish-list.php">>>Details</a>
                                        </div>
                                        <ul class="shopping-list">
                                            <?php
                                                foreach($allItems as $items){
                                                   $checkFav = $fav->checkFavorite($user_id, $items['item_id']);
                                                    if($checkFav == 'yes'){
                                            ?>
                                            <li>
                                                <a href="actions/favorite.php?page=bid&id=<?= $items['item_id'] ?>" class="remove" title="Remove this item"><i
                                                        class="lni lni-close"></i></a>
                                                <div class="cart-img-head">
                                                    <a class="" href="bid.php?id=<?= $items['item_id'] ?>"><img height="80px" width="80px" src="assets/images/item_images/<?= $items['item_photo'] ?>" alt="#"></a>
                                                </div>

                                                <div class="content">
                                                    <h4><a href="bid.php?id=<?= $items['item_id'] ?>">
                                                            <?= $items['item_name'] ?></a></h4>
                                                    <p class="quantity">Currently: <span class="text-primary">¥<?= $items['current_price'] ?></span></p>
                                                </div>
                                            </li>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php
                             }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Middle -->
        <!-- Start Header Bottom -->
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="nav-inner">
                        <!-- Start Mega Category Menu -->
                        <div class="mega-category-menu">
                            <span class="cat-button"><i class="lni lni-menu"></i>All Categories</span>
                            <ul class="sub-category">
                                <?php
                                    foreach($catList as $cat){
                                ?>
                                <li>
                                    <a href="index.php?category_id=<?= $cat['category_id'] ?>"><?= $cat['category_name'] ?></a>
                                </li>
                                <?php
                                    }
                                ?>
                                <!-- <li><a href="product-grids.html">Electronics <i class="lni lni-chevron-right"></i></a>
                                    <ul class="inner-sub-category">
                                        <li><a href="product-grids.html">Digital Cameras</a></li>
                                        <li><a href="product-grids.html">Camcorders</a></li>
                                        <li><a href="product-grids.html">Camera Drones</a></li>
                                        <li><a href="product-grids.html">Smart Watches</a></li>
                                        <li><a href="product-grids.html">Headphones</a></li>
                                        <li><a href="product-grids.html">MP3 Players</a></li>
                                        <li><a href="product-grids.html">Microphones</a></li>
                                        <li><a href="product-grids.html">Chargers</a></li>
                                        <li><a href="product-grids.html">Batteries</a></li>
                                        <li><a href="product-grids.html">Cables & Adapters</a></li>
                                    </ul>
                                </li>
                                <li><a href="product-grids.html">accessories</a></li>
                                <li><a href="product-grids.html">Televisions</a></li>
                                <li><a href="product-grids.html">best selling</a></li>
                                <li><a href="product-grids.html">top 100 offer</a></li>
                                <li><a href="product-grids.html">sunglass</a></li>
                                <li><a href="product-grids.html">watch</a></li>
                                <li><a href="product-grids.html">man’s product</a></li>
                                <li><a href="product-grids.html">Home Audio & Theater</a></li>
                                <li><a href="product-grids.html">Computers & Tablets </a></li>
                                <li><a href="product-grids.html">Video Games </a></li>
                                <li><a href="product-grids.html">Home Appliances </a></li> -->
                            </ul>
                        </div>
                        <!-- End Mega Category Menu -->
                        <!-- Start Navbar -->
                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a href="index.html" aria-label="Toggle navigation">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse"
                                            data-bs-target="#submenu-1-2" aria-controls="navbarSupportedContent"
                                            aria-expanded="false" aria-label="Toggle navigation">Pages</a>
                                        <ul class="sub-menu collapse" id="submenu-1-2">
                                            <li class="nav-item"><a href="about-us.html">About Us</a></li>
                                            <li class="nav-item"><a href="faq.html">Faq</a></li>
                                            <li class="nav-item"><a href="login.html">Login</a></li>
                                            <li class="nav-item"><a href="register.html">Register</a></li>
                                            <li class="nav-item"><a href="mail-success.html">Mail Success</a></li>
                                            <li class="nav-item"><a href="404.html">404 Error</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dd-menu active collapsed" href="javascript:void(0)"
                                            data-bs-toggle="collapse" data-bs-target="#submenu-1-3"
                                            aria-controls="navbarSupportedContent" aria-expanded="false"
                                            aria-label="Toggle navigation">Shop</a>
                                        <ul class="sub-menu collapse" id="submenu-1-3">
                                            <li class="nav-item"><a href="product-grids.html">Shop Grid</a></li>
                                            <li class="nav-item"><a href="product-list.html">Shop List</a></li>
                                            <li class="nav-item active"><a href="product-details.html">shop Single</a>
                                            </li>
                                            <li class="nav-item"><a href="cart.html">Cart</a></li>
                                            <li class="nav-item"><a href="checkout.html">Checkout</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse"
                                            data-bs-target="#submenu-1-4" aria-controls="navbarSupportedContent"
                                            aria-expanded="false" aria-label="Toggle navigation">Blog</a>
                                        <ul class="sub-menu collapse" id="submenu-1-4">
                                            <li class="nav-item"><a href="blog-grid-sidebar.html">Blog Grid Sidebar</a>
                                            </li>
                                            <li class="nav-item"><a href="blog-single.html">Blog Single</a></li>
                                            <li class="nav-item"><a href="blog-single-sidebar.html">Blog Single
                                                    Sibebar</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="contact.html" aria-label="Toggle navigation">Contact Us</a>
                                    </li>
                                </ul>
                            </div> <!-- navbar collapse -->
                        </nav>
                        <!-- End Navbar -->
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Nav Social -->
                    <div class="nav-social">
                        <h5 class="title">Follow Us:</h5>
                        <ul>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-instagram"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-skype"></i></a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Nav Social -->
                </div>
            </div>
        </div>
        <!-- Start Header Bottom -->
    </div>
    <!-- End Header Area -->

    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Bid an Item</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="index.php"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="index.php">Shop</a></li>
                        <li>Bid</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Bid alert -->
    
    <!-- Start Item Details -->
    <section class="item-details section">
        <div class="container">
        <?php
        if(!empty($_SESSION) && !empty($_GET['result'])){
            if($_GET['result'] == 'fail'){
            alert('Please enter a higher price than the current one.');
            }elseif($_GET['result'] == 'success'){
            success('Bidding Successful.');
            }
        }
    ?>
            <div class="top-area">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-images">
                            <main id="gallery">
                                <div class="main-img">
                                    <img src="assets/images/item_images/<?= $itemList['item_photo'] ?>" id="current" alt="#">
                                </div>
                                <!-- <div class="images">
                                    <img src="assets/images/product-details/01.jpg" class="img" alt="#">
                                    <img src="assets/images/product-details/02.jpg" class="img" alt="#">
                                    <img src="assets/images/product-details/03.jpg" class="img" alt="#">
                                    <img src="assets/images/product-details/04.jpg" class="img" alt="#">
                                    <img src="assets/images/product-details/05.jpg" class="img" alt="#">
                                </div> -->
                            </main>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-info mt-5">
                            <h2 class=""><?= $itemList['item_name'] ?></h2>
                            <form action="index.php" method="post">
                                <label>
                                    <input type="hidden" value="<?=$itemList['category_name']?>" name="search">
                                    <input type="submit" name="submit" style="display: none;">
                                    <p>
                                        <i class="lni lni-tag"></i> 
                                        <?= $itemList['category_name'] ?>
                                    </p>
                                </label>
                            </form>
                            <?php
                                if($bidNum['bid_num'] > 0){
                            ?>
                            <button class="btn btn-outline-success border border-white" data-bs-toggle="modal" data-bs-target="#bid">
                                <i class="fas fa-hand-paper"></i> 
                                Bid: <?= $bidNum['bid_num']; ?>
                            </button>
                            <?php 
                            }else{ 
                            ?>
                            <button class="btn btn-transparent text-muted">
                                <i class="fas fa-hand-paper"></i> 
                                Bid: <?= $bidNum['bid_num']; ?>
                            </button>
                            <?php
                                }
                            ?>
                            <h3 class="mt-3 text-danger">
                                <span class="text-dark fs-5 ">
                                <?php
                                if($itemList['item_status'] == 'A'){
                                    echo "Currently:";
                                }else{
                                    echo "Max Bid:";
                                }
                                ?> 
                                </span>  ¥ <?= $itemList['current_price'] ?>
                            </h3>
                            
                            
                            <div class="bottom-content mb-5">
                                <div class="row align-items-end">
                                    <?php
                                     if($itemList['item_status'] == 'A'){
                                        if((empty($_SESSION)) OR ($itemList['user_id'] != $_SESSION['user_id'])){
                                        
                                    ?>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        
                                        <div class="button cart-button">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#exampleModal">Bid</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                    <?php
                                        if(!empty($_SESSION)){
                                    ?>
                                        <div class="wish-button">
                                            <a href="actions/favorite.php?id=<?= $item_id ?>" class="btn fs-6">
                                            <?php
                                                
                                                    $checkFav = $fav->checkFavorite($user_id, $item_id);
                                                    if($checkFav != 'no'){
                                                        echo "<i class='fas fa-heart text-danger'></i> ";
                                                    }else{
                                                        echo "<i class='far fa-heart'></i> ";
                                                    }
                                                
                                                ?>
                                                To Wishlist
                                            </a>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    </div>
                                    <?php
                                    }else{
                                    ?>
                                        <a href="edit-item.php?item_id=<?= $itemList['item_id'] ?>" class="btn btn-outline-warning w-50 mt-5 fs-4">Edit</a>
                                    <?php
                                    }
                                }
                                    ?>
                                </div>
                            </div>
                            <?php
                                if(empty($_SESSION) OR $itemList['user_id'] != $_SESSION['user_id']){
                            ?>
                            <!-- user info -->
                            <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                                <a href="evaluation.php?seller_id=<?= $itemList['user_id'] ?>">
                                    <div class="row">
                                        <div class="col-2">
                                        <img src="assets/images/user_images/<?= $itemList['photo'] ?>" alt="profile image" class="rounded-circle" style="object-fit: cover;" width="60px" height="60px">
                                        </div>
                                        <div class="col-10 p-2">
                                            <div class="row">
                                                <h5 class="m-0 p-0">
                                                    <?php
                                                    echo $itemList['username'];
                                                    ?>
                                                </h5>
                                                <ul class="ms-0 ps-0 mt-1 mb-0 text-muted">
                                                    <?php
                                                    for($i=1; $i<=$starAvg; $i++){
                                                    echo "<li><i class='lni lni-star-filled float-start text-warning pt-1'></i></li>";
                                                    }
                                                    for($i=1; $i<=(5-$starAvg); $i++){
                                                    echo "<li><i class='lni lni-star float-start pt-1'></i></li>";
                                                    }
                                            
                                                    ?>
                                                    <li><span><?=str_repeat('&nbsp;', 5). $reviewNum; ?> reviews</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="product-details-info">
                <div class="single-block">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="info-body custom-responsive-margin">
                                <h4>Description</h4>
                                <p>
                                    <?= nl2br($itemList['description']) ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="info-body">
                                <h4>Lot Details</h4>
                                <ul class="normal-list">
                                    <li><span>Opening Price: </span> ¥<?= $itemList['item_price'] ?></li>
                                    <li><span>Condition: </span> <?= $itemList['item_condition'] ?></li>
                                    <?php
                                    if($itemList['item_status'] == 'A'){
                                    ?>
                                    <li><span>Close time: </span> <?= $itemList['close_datetime'] ?></li>
                                    <?php
                                    }else{
                                    ?>
                                    <li><span class="text-danger mb-2">CLOSED AT:</span> <?= $itemList['close_datetime'] ?></li>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if($itemList['item_status'] == 'A'){
                                    ?>
                                        <li><span>Ends in: </span> <span class="text-danger"><?= $endsIn ?></span></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Item Details -->

        <!--Bidding Modal-->
        <div class="modal fade" id="exampleModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="actions/bid.php" method="post">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalToggleLabel">
                                <i class="fas fa-gavel"></i>
                                Bid
                            </h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-1 text-center">
                                    <label class="form-label" for="bid">
                                        <h3 style="line-height: 50px;">¥</h3>
                                    </label>
                                </div>
                                <div class="col-11">
                                    <input type="number" name="bid" class="form-control fs-4 required">
                                    <input type="hidden" name="item_id" value="<?= $item_id ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="submit" value="Bid" class="btn btn-outline-danger w-100 fs-4">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="bid" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $bidNum['bid_num']; ?> bid<?php if($bidNum['bid_num']>1){echo 's';} ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <h6 class="text-center"><span class="text-danger">Opening Price:</span> <span class="text-primary fs-5"> ¥<?= $itemList['item_price'] ?></span></h6>
                    <hr>
                    <?php
                    if($bidders != 'NoBids'){
                        foreach($bidders as $bidder){
                    ?>
                    <div class="row">
                        <div class="col-2">
                            <img style="object-fit: cover;" width="60px" height="60px" src="assets/images/user_images/<?= $bidder['photo'] ?>" alt="" class="rounded-circle">
                        </div>
                        <div class="col-10">
                            <h5><?= $bidder['username'] ?></h5>
                            <h6>Bid: <span class="text-primary"> ¥<?= $bidder['bid_price'] ?></span></h6>
                            <?= $bidder['bid_datetime'] ?><br><br>
                        </div>
                    </div>
                    <?php
                    }
                }
                    ?>
                </div>
            </div>
        </div>
        </div>

    <!-- Review Modal -->
    <!-- <div class="modal fade review-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Leave a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="review-name">Your Name</label>
                                <input class="form-control" type="text" id="review-name" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="review-email">Your Email</label>
                                <input class="form-control" type="email" id="review-email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="review-subject">Subject</label>
                                <input class="form-control" type="text" id="review-subject" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="review-rating">Rating</label>
                                <select class="form-control" id="review-rating">
                                    <option>5 Stars</option>
                                    <option>4 Stars</option>
                                    <option>3 Stars</option>
                                    <option>2 Stars</option>
                                    <option>1 Star</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="review-message">Review</label>
                        <textarea class="form-control" id="review-message" rows="8" required></textarea>
                    </div>
                </div>
                <div class="modal-footer button">
                    <button type="button" class="btn">Submit Review</button>
                </div>
            </div>
        </div>
    </div> -->
    <!-- End Review Modal -->

    <!-- Footer Start -->
    <?php
        include 'footer.php';
    ?>
    <!-- Footer End -->
    
    
</body>
</html>