<?php
include 'classes/item.php';
include 'classes/category.php';
$row1 = new Item();
$winningBids = $row1->getWinningItems();
$cat = new Category();
include 'functions/functions.php';
include 'topbar.php';
title('dark', 'fas fa-gavel', 'Winning Items');
//This is for updating the status of items.
$itemList = $row1->getItems('all');
if(!empty($itemList)){
    foreach($itemList as $items){
    $row1->updateItemStatus($items['item_id']);
    }
}
?>
<div class="container">
  <div class="row">
    <?php
    if(!empty($winningBids)){
      foreach($winningBids as $winningBid){
        // $row1->updateItemStatus($winningBid['item_id']);
        $endsIn = $row1->getOneEnd($winningBid['item_id']);
        $category = $cat->getOneCat($winningBid['category_id']);
    ?>
  <div class="col-lg-3 col-md-6 col-12">
          <!-- Start Single Product -->
          <div class="single-product">
              <div class="product-image">
                  <img src="assets/images/item_images/<?= $winningBid['item_photo'] ?>" alt="#" height="200px">
                  <div class="button">
                      <a href="auction-winner.php?id=<?= $winningBid['item_id'] ?>" class="btn"><i class="fas fa-handshake"></i>Deal</a>
                  </div>
              </div>
              <div class="product-info">
                  <h5 class="mb-2">
                      <a href="product-grids.html"><?= $winningBid['item_name'] ?></a>
                  </h5>
                  <span class="category">
                      <i class="lni lni-tag"></i> 
                      <?= $category['category_name'];?>
                  </span><br>
                  <div>
                  <span class="text-danger mb-2">CLOSED AT: <br><?= $winningBid['close_datetime'] ?></span>
                  </div>
                  <div class="price">
                      <span class="text-dark fs-6">Max Bid Price: <br><span class="text-primary fs-5">¥<?= $winningBid['current_price'] ?></span></span>
                  </div>
              </div>
          </div>
          <!-- End Single Product -->
      </div>
      <?php
      }
    }
      ?>
  </div>
</div>