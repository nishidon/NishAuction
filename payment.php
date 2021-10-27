<?php
include 'classes/item.php';
include 'classes/user.php';
include 'classes/category.php';
include 'classes/evaluation.php';
unset($_SESSION['item_id']);
$item_id = $_GET['id'];
$row = new Item;
$users = new User;
$clientInfo = $users->getOneUser($_SESSION['user_id']);
$itemList = $row->getOneItem($item_id);
$evaluate = new Evaluate;
$starAvg = $evaluate->getEvaluateAvg($itemList['user_id']);
$reviewNum = $evaluate->getEvaluateNum($itemList['user_id']);
include 'functions/functions.php';
include 'topbar.php';
title('dark', 'fas fa-coins', 'Payment');
?>
<section class="item-details section">
  <div class="container">
    <div class="row mb-5">
      <div class="col-6 mx-auto">
        <div class="card mb-5">
          <div class="card-header">
            <a class="card-link text-muted w-100" href="edit-profile.php?action=shipping&id=<?=$item_id?>">
              <div class="row">
                <div class="col-11">
                  <p>shipping to: <span class="text-dark fs-5"><?=$clientInfo['first_name']." ".$clientInfo['last_name']?></span><br>
                    <span class="text-dark"><?=$clientInfo['address']?></span>
                  </p>
                </div>
                <div class="col-1">
                  <i class="fas fa-chevron-right pt-2 fs-3"></i>
                </div>
            </div>
            </a>
          </div>
          <div class="card-body">
            <p>Item Price: ¥<?=$itemList['current_price']?></p>
            <p>Discount Coupon: no</p>
            <h4>Total Price: <span class="text-danger">¥<?=$itemList['current_price']?></span></h4>
          </div>
        </div>
        <form action="actions/payment.php" method="post">
          <h4>Payment Infomation</h4>
          <div class="card my-3">
            <div class="card-body">
              <p class="text-dark">Use Coupons</p>
              <select class="form-control" name="coupon" id="">
                <option value hidden>-select-</option>
              </select>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <p class="text-dark">Payment Method</p>
              <select class="form-control" name="method" id="">
                <option value hidden>-select-</option>
                <option value="1">Option1</option>
                <option value="2">Option2</option>
                <option value="3">Option3</option>
                <option value="4">Option4</option>
              </select>
            </div>
          </div>
          <input type="hidden" name="item_id" value="<?=$item_id?>">
          <input class="btn btn-warning w-100 mt-4" type="submit" name="submit" value="Pay">
        </form>
      </div>
    </div>
      
          <h3>Item Infomation</h3>
            <div class="top-area">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-images">
                            <main id="gallery">
                                <div class="main-img">
                                    <img src="assets/images/item_images/<?= $itemList['item_photo'] ?>" id="current" alt="#">
                                </div>
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
                                    <p class="mb-5">
                                        <i class="lni lni-tag"></i> 
                                        <?= $itemList['category_name'] ?>
                                    </p>
                                </label>
                            </form>
                            <h3 class="mb-5"><span class="text-muted">Price:</span> ¥<?=$itemList['current_price']?></h3>
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
                                    <li><span class="text-danger mb-2">CLOSED AT:</span> <?= $itemList['close_datetime'] ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Item Details -->
    </body>
    </html>