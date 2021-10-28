<?php
include 'functions/functions.php';
include 'classes/item.php';
$row = new Item();
$itemList = $row->getItems('myItems');

include 'topbar.php';
title('dark', 'fas fa-user', 'My Items');
?>
<div class="container">
  <div class="row">
  <?php
  if(!empty($itemList)){

      foreach(array_reverse($itemList) as $items){
        $row->updateItemStatus($items['item_id']);
        $bidNum = $row->getOneBid($items['item_id']);
        $endsIn = $row->getOneEnd($items['item_id']);
  ?>
  <?php
    if($items['item_status'] == 'RECEIVED' OR $items['item_status'] == 'B'){
      $color = '#E3E8E9';
    }else{
      $color = NULL;
    }
  ?>
      <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Product -->
                    <div class="single-product">
                        <div class="product-image">
                            <img src="assets/images/item_images/<?= $items['item_photo'] ?>" alt="#" height="200px">
                            <?php
                            if($items['item_status'] == 'B'){
                              echo "<span class='sale-tag'>CLOSED</span>";
                              }elseif($items['item_status'] == 'P'){
                                echo "<span class='new-tag bg-warning'>SOLD</span>";
                              }elseif($items['item_status'] == 'RECEIVED'){
                                echo "<span class='new-tag bg-success'>OVER</span>";
                              }elseif($items['item_status'] != 'A'){
                                echo "<span class='new-tag'>SOLD</span>";
                              }
                            ?>
                            <?php
                            if($items['item_status'] == 'A'){
                              $page = 'bid';
                              $btnName = 'Details';
                              $icon = 'fas fa-cog';
                            }elseif($items['item_status'] == 'S' || $items['item_status'] == 'SENT' || $items['item_status'] == 'RECEIVED' || $items['item_status'] == 'P' ){
                              $page = 'seller';
                              $btnName = 'Deal';
                              $icon = 'fas fa-handshake';
                            }elseif($items['item_status'] == 'B'){
                              $page = 'resell';
                              $btnName = 'Resell';
                              $icon = 'fas fa-arrow-alt-circle-up';
                            }
                            ?>
                            <div class="button">
                                <a href="<?= $page ?>.php?id=<?= $items['item_id'] ?>" class="btn"><i class="<?= $icon ?>"></i><?= $btnName ?></a>
                            </div>
                        </div>
                        <div class="product-info" style="background-color: <?= $color ?>;">
                            <h5 class="mb-2">
                                <a href="product-grids.html"><?= $items['item_name'] ?></a>
                            </h5>
                            <span class="category">
                                <i class="lni lni-tag"></i> 
                                <?= $items['category_name'];?>
                            </span><br>
                            <div>
                              <?php if($items['item_status'] == 'A'){ ?>
                                <span class="mb-2">Ends In: <br><span class="text-danger"><?= $endsIn ?></span></span>
                              <?php }else{?>
                                <span class="text-danger mb-2">CLOSED AT: <br><?= $items['close_datetime'] ?></span>
                              <?php }?>
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
    }else{
      echo "<h3 class='text-center text-muted mt-5'>You have no selling items.</h3>";
    }
      ?>
  </div>
</div>
<?php
  // include 'footer.php';
?>
</body>
</html>