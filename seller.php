<?php
include 'classes/item.php';
include 'classes/user.php';
include 'classes/category.php';
include 'classes/evaluation.php';
$item_id = $_GET['id'];
$row = new Item;
$user = new User;
$dealInfo = $user->getClientInfo($item_id);
$evaluate = new Evaluate;
$starAvg = $evaluate->getEvaluateAvg($dealInfo['user_id']);
$reviewNum = $evaluate->getEvaluateNum($dealInfo['user_id']);
include 'topbar.php';
include 'functions/functions.php';
title('dark', 'fas fa-handshake', 'Deal');
?>
<div class="container">
  <div class="row">
    <?php
      if($dealInfo['item_status'] == 'P'){
    ?>
      <div class="container">
        <div class="row">
          <div class="col mt-5">
            <h4 class="text-center text-success mb-5">Please wait until your client completes the payment process.</h4>
          </div>  
        </div>
      </div>
    <?php
      }
    ?>
    <?php
      if($dealInfo['item_status'] == 'S'){
    ?>
    <div class="col text-center my-5">
      <a class="btn btn-outline-danger w-75" href="actions/deal-status.php?action=sent&item_id=<?= $item_id ?>">Item Sent</a>
    </div>
    <div class="row">
      <div class="col-6 mx-auto">
        <h4 class="border-bottom text-center">Client's information</h4>
        <table class="table">
          <tr>
            <th>Full Name</th>
            <td><?= $dealInfo['first_name']." ".$dealInfo['last_name']  ?></td>
          </tr>
          <tr>
            <th>Address</th>
            <td><?= $dealInfo['address'] ?></td>
          </tr>
        </table>
      </div>
    </div>
    <?php
      }elseif($dealInfo['item_status'] == 'SENT'){
    ?>
    <div class="col mt-5">
      <h4 class="text-center text-success">Please wait until your client receives the item.</h4>
    </div>
    <?php
      }elseif($dealInfo['item_status'] == 'RECEIVED'){
    ?>
    <div class="col mt-5">
      <h4 class="text-center text-success">Deal is over. Your sales has been payed.</h4>
    </div>
    <?php
      }
    ?>
  </div>

  <h3 style="margin-top: 200px;">Item Infomation</h3>
    <div class="card top-area">
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
                  <h5 class="mb-3"><span class="text-muted">Price:</span></h5>
                </div>
                <div class="col">
                  <h5> ¥<?=$dealInfo['current_price']?></h5>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <h5 class="mb-3"><span class="text-muted">Sales Fee</span></h5>
                </div>
                <div class="col">
                  <h5><span class=""> - ¥<?=$dealInfo['current_price'] * 0.1?></span></h5>
                </div>
              </div>
            <div class="row">
              <div class="col">
                <h3 class="mb-3"><span class="text-muted">Total Sales</span></h3>
              </div>
              <div class="col">
                <h3><span class="text-danger">¥<?=$dealInfo['current_price'] - $dealInfo['current_price'] * 0.1?></span></h3>
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