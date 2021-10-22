<?php
  include 'classes/item.php';
  $row = new Item();
  //In order to check if the item is already displayed.
  $bidItemIds = $row->biddingItems();//outputs are item_id collumn.
  include 'functions/functions.php';
  include 'topbar.php';
  title('dark', 'fas fa-hand-point-up', 'Bidding Items');
?>
<div class="container">
  <div class="row">
      <?php
        if(!empty($bidItemIds)){
          foreach($bidItemIds as $bidItemId){
            $bidItems = $row->getOneItem($bidItemId['item_id']);
            $bidNum = $row->getOneBid($bidItemId['item_id']);
            $endsIn = $row->getOneEnd($bidItemId['item_id']);
            if($bidItems['item_status'] == 'A'){
      ?> 
        <div class="col-lg-3 col-md-6 col-12">
          <!-- Start Single Product -->
          <div class="single-product">
              <div class="product-image">
                  <img src="assets/images/item_images/<?= $bidItems['item_photo'] ?>" alt="#" height="200px">
                  <div class="button">
                      <a href="bid.php?id=<?= $bidItems['item_id'] ?>" class="btn"><i class="fas fa-gavel"></i> Details</a>
                  </div>

              </div>
              <div class="product-info">
                  <h5 class="mb-2">
                      <a href="product-grids.html"><?= $bidItems['item_name'] ?></a>
                  </h5>
                  <span class="category">
                      <i class="lni lni-tag"></i> 
                      <?= $bidItems['category_name'];?>
                  </span><br>
                  <div>
                      <span class="mb-2">Ends In: <br><span class="text-danger"><?= $endsIn ?></span></span>
                  </div>
                  <div>
                      <p><i class="fas fa-hand-paper"></i> Bid: <?= $bidNum['bid_num'] ?></p>
                  </div>
                  <div class="price">
                      <span class="text-dark fs-6">Current Bid Price: <br><span class="text-primary fs-5">¥<?= $bidItems['current_price'] ?></span></span>
                  </div>
              </div>
          </div>
          <!-- End Single Product -->
      </div>
      <?php
            }
        }
      }else{
        echo "<h3 class='text-center text-muted mt-5'>You have no bidding items.</h3>";
      }
      ?>
    </div>
  </div>
</div>