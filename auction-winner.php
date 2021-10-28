<?php
include 'classes/user.php';
include 'classes/item.php';
include 'classes/evaluation.php';
$item_id = $_GET['id'];
$user = new User();
$dealInfo = $user->getClientInfo($item_id);
$item = new Item;
$itemList = $item->getOneItem($item_id);
$paymentInfo = $item->getPayment($item_id);
$discount = $paymentInfo['discount'];
$evaluate = new Evaluate;
$starAvg = $evaluate->getEvaluateAvg($itemList['user_id']);
$reviewNum = $evaluate->getEvaluateNum($itemList['user_id']);
include 'topbar.php';
include 'functions/functions.php';
title('dark', 'fas fa-handshake', 'Deal');
?>
<div class="container">
  <div class="row">
    <?php
      if(!empty($_GET['payment']) && $_GET['payment'] == 'success'){
    ?>
    <div class="row">
      <div class="col mt-5">
        <h4 class="text-center text-dark">Thank you. The payment has been completed.</h4>
      </div>
    </div>
    <?php
      }
    ?>
    <?php
      if($dealInfo['item_status'] == 'S'){
    ?>
    <div class="row">
      <div class="col mt-5">
        <h4 class="text-center text-success">Please wait until the seller sends the item.</h4>
      </div>
    </div>
    <?php
      }elseif($dealInfo['item_status'] == 'SENT'){
    ?>
    <div class="row">
      <div class="col-6 mx-auto mt-5">
        <a class="btn btn-outline-danger w-100" href="actions/deal-status.php?action=received&item_id=<?= $item_id ?>">Received</a>
      </div>
    </div>
    <div class="row">
      <div class="col mt-5">
        <h4 class="text-center text-success">Please wait until the item you bought arrives.</h4>
      </div>
    </div>
    <?php
      }elseif($dealInfo['deal_status'] == 'OVER'){
        success('Thank you for using our online auction service.');
      }elseif($dealInfo['item_status'] == 'RECEIVED'){
    ?>
    <div class="col-6 mx-auto mt-5">
      <h4 class="mb-5 text-center">Deal is over. Please evaluate the seller.</h4>
      <form action="actions/evaluation.php" method="post">
      <label for="star">Star:</label>
        <select class="form-control" name="star" id="star" required>
          <option value hidden>-select-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
        <label for="comment">Comment:</label>
        <textarea class="form-control" name="comment" id="" cols="30" rows="10" required></textarea><br>
        <input type="hidden" name="item_id" value="<?= $item_id ?>">
        <input class="btn btn-success w-100" type="submit" value="Submit" name="submit">
      </form>
    </div>
    <?php
      }
    ?>

    <!--Item Info-->

    <h3 style="margin-top: 200px;">Item Infomation</h3>
    <div class="card top-area p-0">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-12 col-12">
          <div class="product-images">
            <main id="gallery">
              <div class="main-img">
                <img src="assets/images/item_images/<?= $dealInfo['item_photo'] ?>" id="current" alt="#">
              </div>
            </main>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-12">
          <div class="product-info mt-5">
            <div class="row">
              <div class="col">
                <h2 class="mb-5"><?= $dealInfo['item_name'] ?></h2>
              </div>
              <div class="row">
                <div class="col">
                  <h5 class="mb-3"><span class="text-muted">Item Price:</span></h5>
                </div>
                <div class="col">
                  <h5> ¥<?=$dealInfo['current_price']?></h5>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <h5 class="mb-3"><span class="text-muted">Discount Coupon</span></h5>
                </div>
                <div class="col">
                  <?php
                  if($discount == 0){
                    echo "<h5>No coupons selected</h5>";
                  }else{
                    echo "<h5> - ¥$discunt</h5>";
                  }
                  ?>
                  
                </div>
              </div>
            <div class="row">
              <div class="col">
                <h3 class="mb-3"><span class="text-muted">Total Price</span></h3>
              </div>
              <div class="col">
                <h3><span class="text-danger">¥<?=$paymentInfo['price']?></span></h3>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
            
    <div class="product-details-info mb-5">
      <div class="single-block">
        <div class="row">
          <div class="col-lg-6 col-12">
            <div class="info-body custom-responsive-margin">
              <h4>Description</h4>
                <p>
                  <?= nl2br($dealInfo['description']) ?>
                </p>
              </div>
            </div>
            <div class="col-lg-6 col-12">
              <div class="info-body">
                <h4>Lot Details</h4>
                <ul class="normal-list">
                  <li><span>Opening Price: </span> ¥<?= $dealInfo['item_price'] ?></li>
                  <li><span>Condition: </span> <?= $dealInfo['item_condition'] ?></li>
                  <li><span class="text-danger mb-2">CLOSED AT:</span> <?= $dealInfo['close_datetime'] ?></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="row mt-5">
      <div class="col-6 mx-auto">
        <h3>Seller:</h3>
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
                          <li><span><?=str_repeat('&nbsp;', 5). $reviewNum; ?>reviews</span></li>
                        </ul>
                    </div>
                </div>
            </div>
          </a>
        </div>
      </div>
    </div> -->
  </div>
</div>