<?php
include 'classes/user.php';
include 'classes/item.php';
include 'classes/evaluation.php';
$item_id = $_GET['id'];
$user = new User();
$dealInfo = $user->getClientInfo($item_id);
$item = new Item;
$itemList = $item->getOneItem($item_id);
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
    <div class="row mt-5">
      <div class="col-6 mx-auto">
        <h3>Seller:</h3>
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
                          <li><span><?=str_repeat('&nbsp;', 5). $reviewNum; ?>reviews</span></li>
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