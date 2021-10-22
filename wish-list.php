<?php
  include 'classes/item.php';
  include 'classes/favorite.php';
  $user_id = $_SESSION['user_id'];
  include 'topbar.php';
  include 'functions/functions.php';
  title('dark', 'fas fa-heart', 'Wish List');
  $itemList = new Item();
  $items = $itemList->getItems('all');//get all items that are open
  $fav = new Favorite();
  $fav->removeClosedFav();
?>
<div class="container">
  <div class="row">
  <?php
  if(!empty($items)){
  foreach($items as $item){
    $favCheck = $fav->checkFavorite($user_id, $item['item_id']);
    $endsIn = $itemList->getOneEnd($item['item_id']);
    $bidNum = $itemList->getOneBid($item['item_id']);
    if($favCheck == 'yes'){
  ?>
    <div class="col-lg-3 col-md-6 col-12">
      <!-- Start Single Product -->
      <div class="single-product">
          <div class="product-image">
              <img src="assets/images/item_images/<?= $item['item_photo'] ?>" alt="#" height="200px">
              <div class="button">
                  <a href="bid.php?id=<?= $item['item_id'] ?>" class="btn"><i class="fas fa-gavel"></i></i> Start bidding</a>
              </div>
          </div>
          <div class="product-info">
              <h5 class="mb-2">
                  <a href="product-grids.html"><?= $item['item_name'] ?></a>
              </h5>
              <span class="category">
                  <i class="lni lni-tag"></i> 
                  <?= $item['category_name'];?>
              </span><br>
              <div>
              <span class="mb-2">Ends In: <br><span class="text-danger"><?= $endsIn ?></span></span>
              </div>
              <div>
                  <p><i class="fas fa-hand-paper"></i> Bid:  <?= $bidNum['bid_num'] ?></p>
              </div>
              <div class="price">
                  <span class="text-dark fs-6">Current Bid Price: <br><span class="text-primary fs-5">¥<?= $item['current_price'] ?></span></span>
              </div>
          </div>
      </div>
      <!-- End Single Product -->
    </div>
    <?php
    }
  }
}
  ?>
  </div>
</div>