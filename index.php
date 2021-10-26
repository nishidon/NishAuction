<?php
    date_default_timezone_set('Asia/Tokyo');
    include 'classes/item.php';
    include 'classes/category.php';
    include 'classes/favorite.php';
    $row = new Item();
    $itemList = $row->getItems('index');
    $allItems = $row->getItems('all');
    $rows = new Category();
    $catList = $rows->getCat();
    if(isset($_POST['submit'])){
        $item_name = $_POST['search'];
        $search_result = $row->searchItems($item_name);
    }
    if(!empty($_SESSION)){
        $user_id = $_SESSION['user_id'];
        $fav = new Favorite();
        $checkFavNum = $fav->checkFavoriteNum($user_id);
        $fav->removeClosedFav();
    }
    include 'topbar.php';
?>
    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->

    <!-- Start Header Area -->
    <div class="header navbar-area">
        <!-- Start Header Middle -->
        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-7">
                        <!-- Start Header Logo -->
                        <!-- <a class="navbar-brand" href="index.php">
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
                                <form action="" method="post" class="w-100">
                                    <div class="row">
                                <div class="col-10" style="padding-right: 0">
                                    <input class="form-control w-100 me-0 h-100" name="search" type="text" placeholder="Search" value="<?php if(isset($_POST['search'])){ echo $_POST['search'];} ?>">
                                </div>
                                <div class="col-2" style="padding-left: 0">
                                    <span class="bg-dark p-1 border rounded">
                                        <input type="submit" name="submit" value="Search" class="btn btn-dark">
                                    </span> 
                                </div>
                                    <!-- <div class="search-input">
                                        <input name="search" type="text" placeholder="Search">
                                    </div>
                                    <div class="search-btn">
                                        <button type="submit" name="submit">
                                            <i class="lni lni-search-alt"></i>
                                        </button>
                                    </div> -->
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
                                <!-- <div class="wishlist">
                                    <a href="javascript:void(0)">
                                        <i class="lni lni-heart"></i>
                                        <span class="total-items"><?= $checkFavNum ?></span>
                                    </a>
                                </div> -->
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
                                                <a href="actions/favorite.php?page=index&id=<?= $items['item_id'] ?>" class="remove" title="Remove this item"><i
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
                                            <!-- <li>
                                                <a href="javascript:void(0)" class="remove" title="Remove this item"><i
                                                        class="lni lni-close"></i></a>
                                                <div class="cart-img-head">
                                                    <a class="cart-img" href="product-details.html"><img
                                                            src="assets/images/header/cart-items/item2.jpg" alt="#"></a>
                                                </div>
                                                <div class="content">
                                                    <h4><a href="product-details.html">Wi-Fi Smart Camera</a></h4>
                                                    <p class="quantity">1x - <span class="amount">$35.00</span></p>
                                                </div>
                                            </li> -->
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
                                        <a href="index.html" class="active" aria-label="Toggle navigation">Home</a>
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
                                        <a class="dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse"
                                            data-bs-target="#submenu-1-3" aria-controls="navbarSupportedContent"
                                            aria-expanded="false" aria-label="Toggle navigation">Shop</a>
                                        <ul class="sub-menu collapse" id="submenu-1-3">
                                            <li class="nav-item"><a href="product-grids.html">Shop Grid</a></li>
                                            <li class="nav-item"><a href="product-list.html">Shop List</a></li>
                                            <li class="nav-item"><a href="product-details.html">shop Single</a></li>
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
        <!-- End Header Bottom -->
    </div>
    <!-- End Header Area -->

    <!-- Start Trending Product Area -->
    <section class="trending-product section" style="margin-top: 12px;">
        <div class="container">
            <?php
            if(!isset($_POST['submit']) && empty($_GET['category_id'])){
            ?>
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Trending Items</h2>
                    </div>
                </div>
            </div>
            <div class="row">
            <?php
                if(!empty($itemList)){
                    foreach($itemList as $items){
                        $row->updateItemStatus($items['item_id']);
                        $bidNum = $row->getOneBid($items['item_id']);
                        $endsIn = $row->getOneEnd($items['item_id']);
                        // if(strtotime($items['close_datetime']) > strtotime(date('Y-m-d H:i:s'))){
                        if($items['item_status'] == 'A'){
            ?>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Product -->
                    <div class="single-product">
                        <div class="product-image">
                            <img src="assets/images/item_images/<?= $items['item_photo'] ?>" alt="#" height="200px">
                            <div class="button">
                                <a href="bid.php?id=<?= $items['item_id'] ?>" class="btn"><i class="fas fa-gavel"></i>Start bidding</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="mb-2">
                                <a href="product-grids.html"><?= $items['item_name'] ?></a>
                            </h5>
                            <span class="category">
                                <i class="lni lni-tag"></i> 
                                <?= $items['category_name'];?>
                            </span><br>
                            <div>
                                <span class="mb-2">Ends In: <br><span class="text-danger"><?= $endsIn ?></span></span>
                            </div>
                            <div>
                                <p><i class="fas fa-hand-paper"></i> Bid: <?= $bidNum['bid_num'] ?></p>
                            </div>
                            <div class="price">
                                <span class="text-dark fs-6">Current Bid Price: <br><span class="text-primary fs-5">¥<?= $items['current_price'] ?></span></span>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                </div>
                <?php
                        }
                    }
                }else{
                    echo "<h3 class='text-muted text-center'>Sorry...No trending items...</h3>";
                }
            }elseif(isset($_GET['category_id'])){
            ?>
            <div class="row">
            <?php
            $count = 0;
            if(!empty($allItems)){
                foreach($allItems as $items){
                    if($items['category_id'] == $_GET['category_id']){
                    $row->updateItemStatus($items['item_id']);
                    $bidNum = $row->getOneBid($items['item_id']);
                    $endsIn = $row->getOneEnd($items['item_id']);
                    $count++;
                ?>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Product -->
                    <div class="single-product">
                        <div class="product-image">
                            <img src="assets/images/item_images/<?= $items['item_photo'] ?>" alt="#" height="200px">
                            <div class="button">
                                <a href="bid.php?id=<?= $items['item_id'] ?>" class="btn"><i class="fas fa-gavel"></i></i> Start bidding</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="mb-2">
                                <a href="product-grids.html"><?= $items['item_name'] ?></a>
                            </h5>
                            <span class="category">
                                <i class="lni lni-tag"></i> 
                                <?= $items['category_name'];?>
                            </span><br>
                            <div>
                            <span class="mb-2">Ends In: <br><span class="text-danger"><?= $endsIn ?></span></span>
                            </div>
                            <div>
                                <p><i class="fas fa-hand-paper"></i> Bid:  <?= $bidNum['bid_num'] ?></p>
                            </div>
                            <div class="price">
                                <span class="text-dark fs-6">Current Bid Price: <br><span class="text-primary fs-5">¥<?= $items['current_price'] ?></span></span>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                </div>

                <?php
                        }
                    }
                }
                if($count < 1){
                    echo "<h3 class='text-muted text-center'>No items were found in the category.</h3>";
                }
            }elseif($search_result != 'error'){
                ?>
                <div class="row">
                <?php
                foreach($search_result as $search){
                    $row->updateItemStatus($search['item_id']);
                    // if(strtotime($items['close_datetime']) > strtotime(date('Y-m-d H:i:s'))){
                    if($search['item_status'] == 'A'){
                    $bidNum = $row->getOneBid($items['item_id']);
                    $endsIn = $row->getOneEnd($items['item_id']);
                ?>
             <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Product -->
                    <div class="single-product">
                        <div class="product-image">
                            <img src="assets/images/item_images/<?= $search['item_photo'] ?>" alt="#" height="200px">
                            <div class="button">
                                <a href="bid.php?id=<?= $search['item_id'] ?>" class="btn"><i class="fas fa-gavel"></i></i> Start bidding</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <span>
                                <i class="lni lni-tag"></i> 
                                <?= $search['category_name'];?>
                            </span>
                            <h5 class="mb-2">
                                <a href="product-grids.html"><?= $search['item_name'] ?></a>
                            </h5>
                            <div>
                               <span class="mb-2">Ends In: <br><span class="text-danger"><?= $endsIn ?></span></span>
                            </div>
                            <div>
                            <p><i class="fas fa-hand-paper"></i> Bid:  <?= $bidNum['bid_num'] ?></p>
                            </div>
                            <div class="price">
                                <span class="text-dark fs-6">Current Bid Price: <br><span class="text-primary fs-5">¥<?= $search['current_price'] ?></span></span>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                </div>
                <?php
                    }
                }
            }else{
                echo "
                <div class='row'>
                    <div class='col-3 mx-auto'>
                        <p>
                        Your search - $item_name - did not match any items.<br>
                        <br>
                        Suggestions:<br>
                        <br>
                        Make sure that all words are spelled correctly.<br>
                        Try different keywords.<br>
                        Try more general keywords.<br>
                    </div>
                </div>
                ";
        }
                ?>
                

                    
                <!-- <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-product">
                        <div class="product-image">
                            <img src="assets/images/products/product-2.jpg" alt="#">
                            <span class="sale-tag">-25%</span>
                            <div class="button">
                                <a href="product-details.html" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <span class="category">Speaker</span>
                            <h4 class="title">
                                <a href="product-grids.html">Big Power Sound Speaker</a>
                            </h4>
                            <ul class="review">
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><span>5.0 Review(s)</span></li>
                            </ul>
                            <div class="price">
                                <span>$275.00</span>
                                <span class="discount-price">$300.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-product">
                        <div class="product-image">
                            <img src="assets/images/products/product-3.jpg" alt="#">
                            <div class="button">
                                <a href="product-details.html" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <span class="category">Camera</span>
                            <h4 class="title">
                                <a href="product-grids.html">WiFi Security Camera</a>
                            </h4>
                            <ul class="review">
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><span>5.0 Review(s)</span></li>
                            </ul>
                            <div class="price">
                                <span>$399.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-product">
                        <div class="product-image">
                            <img src="assets/images/products/product-4.jpg" alt="#">
                            <span class="new-tag">New</span>
                            <div class="button">
                                <a href="product-details.html" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <span class="category">Phones</span>
                            <h4 class="title">
                                <a href="product-grids.html">iphone 6x plus</a>
                            </h4>
                            <ul class="review">
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><span>5.0 Review(s)</span></li>
                            </ul>
                            <div class="price">
                                <span>$400.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-product">
                        <div class="product-image">
                            <img src="assets/images/products/product-5.jpg" alt="#">
                            <div class="button">
                                <a href="product-details.html" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <span class="category">Headphones</span>
                            <h4 class="title">
                                <a href="product-grids.html">Wireless Headphones</a>
                            </h4>
                            <ul class="review">
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><span>5.0 Review(s)</span></li>
                            </ul>
                            <div class="price">
                                <span>$350.00</span>
                            </div>
                        </div>
                    </div> -->
                    <!-- End Single Product -->
                <!-- </div>
                <div class="col-lg-3 col-md-6 col-12"> -->
                    <!-- Start Single Product -->
                    <!-- <div class="single-product">
                        <div class="product-image">
                            <img src="assets/images/products/product-6.jpg" alt="#">
                            <div class="button">
                                <a href="product-details.html" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <span class="category">Speaker</span>
                            <h4 class="title">
                                <a href="product-grids.html">Mini Bluetooth Speaker</a>
                            </h4>
                            <ul class="review">
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star"></i></li>
                                <li><span>4.0 Review(s)</span></li>
                            </ul>
                            <div class="price">
                                <span>$70.00</span>
                            </div>
                        </div>
                    </div> -->
                    <!-- End Single Product -->
                <!-- </div>
                <div class="col-lg-3 col-md-6 col-12"> -->
                    <!-- Start Single Product -->
                    <!-- <div class="single-product">
                        <div class="product-image">
                            <img src="assets/images/products/product-7.jpg" alt="#">
                            <span class="sale-tag">-50%</span>
                            <div class="button">
                                <a href="product-details.html" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <span class="category">Headphones</span>
                            <h4 class="title">
                                <a href="product-grids.html">PX7 Wireless Headphones</a>
                            </h4>
                            <ul class="review">
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star"></i></li>
                                <li><span>4.0 Review(s)</span></li>
                            </ul>
                            <div class="price">
                                <span>$100.00</span>
                                <span class="discount-price">$200.00</span>
                            </div>
                        </div>
                    </div> -->
                    <!-- End Single Product -->
                <!-- </div>
                <div class="col-lg-3 col-md-6 col-12"> -->
                    <!-- Start Single Product -->
                    <!-- <div class="single-product">
                        <div class="product-image">
                            <img src="assets/images/products/product-8.jpg" alt="#">
                            <div class="button">
                                <a href="product-details.html" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <span class="category">Laptop</span>
                            <h4 class="title">
                                <a href="product-grids.html">Apple MacBook Air</a>
                            </h4>
                            <ul class="review">
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><span>5.0 Review(s)</span></li>
                            </ul>
                            <div class="price">
                                <span>$899.00</span>
                            </div>
                        </div>
                    </div> -->
                    <!-- End Single Product -->
                <!-- </div> -->
            </div>
        </div>
    </section>
    <!-- End Trending Product Area -->

    <!-- Start Call Action Area -->
    <!-- <section class="call-action section">
        <div class="container">
            <div class="row ">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="inner">
                        <div class="content">
                            <h2 class="wow fadeInUp" data-wow-delay=".4s">Currently You are using free<br>
                                Lite version of ShopGrids</h2>
                            <p class="wow fadeInUp" data-wow-delay=".6s">Please, purchase full version of the template
                                to get all pages,<br> features and commercial license.</p>
                            <div class="button wow fadeInUp" data-wow-delay=".8s">
                                <a href="javascript:void(0)" class="btn">Purchase Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- End Call Action Area -->

    <!-- Start Banner Area -->
    <!-- <section class="banner section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="single-banner" style="background-image:url('assets/images/banner/banner-1-bg.jpg')">
                        <div class="content">
                            <h2>Smart Watch 2.0</h2>
                            <p>Space Gray Aluminum Case with <br>Black/Volt Real Sport Band </p>
                            <div class="button">
                                <a href="product-grids.html" class="btn">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="single-banner custom-responsive-margin"
                        style="background-image:url('assets/images/banner/banner-2-bg.jpg')">
                        <div class="content">
                            <h2>Smart Headphone</h2>
                            <p>Lorem ipsum dolor sit amet, <br>eiusmod tempor
                                incididunt ut labore.</p>
                            <div class="button">
                                <a href="product-grids.html" class="btn">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- End Banner Area -->

    <!-- Start Shipping Info -->
    <!-- <section class="shipping-info">
        <div class="container">
            <ul>
                <li>
                    <div class="media-icon">
                        <i class="lni lni-delivery"></i>
                    </div>
                    <div class="media-body">
                        <h5>Free Shipping</h5>
                        <span>On order over $99</span>
                    </div>
                </li>
                <li>
                    <div class="media-icon">
                        <i class="lni lni-support"></i>
                    </div>
                    <div class="media-body">
                        <h5>24/7 Support.</h5>
                        <span>Live Chat Or Call.</span>
                    </div>
                </li>
                <li>
                    <div class="media-icon">
                        <i class="lni lni-credit-cards"></i>
                    </div>
                    <div class="media-body">
                        <h5>Online Payment.</h5>
                        <span>Secure Payment Services.</span>
                    </div>
                </li>
                <li>
                    <div class="media-icon">
                        <i class="lni lni-reload"></i>
                    </div>
                    <div class="media-body">
                        <h5>Easy Return.</h5>
                        <span>Hassle Free Shopping.</span>
                    </div>
                </li>
            </ul>
        </div>
    </section> -->
    <!-- End Shipping Info -->

  <?php
    include 'footer.php';
  ?>
</body>

</html>