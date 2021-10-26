<?php
//PATH include 'functions/functions.php';
//GENERAL

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

function title($color, $icon, $title){
  echo "
  <div class='bg-$color'>
    <h1 class='p-5 fw-light display-5 text-white'>
      <i class='$icon'></i>
      $title
    </h1>
  </div>
  ";
}

function alert($alert){
  echo "<h6 class='alert alert-danger role-alert text-center w-50 mx-auto my-3'>$alert</h6>";
}

function success($success){
  echo "<h5 class='alert alert-success role-alert text-center w-50 mx-auto my-3'>$success</h5>";
}
//put those codes in index.php
// $photo = $items['item_photo'];
                    // $itemId = $items['item_id'];
                    // $cat = $items['category_name'];
                    // $itemName = $items['item_name'];
                    // $close_dt = $items['close_datetime'];
                    // $bid_num = $items['bid_num'];
                    // $curr_pr = $items['current_price'];
function oneItem($photo, $itemId, $cat, $itemName, $close_dt, $bid_num, $curr_pr){
  echo"
  <div class='col-lg-3 col-md-6 col-12'>
    <div class='single-product'>
        <div class='product-image'>
            <img src='assets/images/item_images/<?=" .$photo." ?>' alt='#' height='200px'>
            <div class='button'>
                <a href='bid.php?id=<?=" .$itemId." ?>' class='btn'><i class='fas fa-gavel'></i></i> Start bidding</a>
            </div>
        </div>
        <div class='product-info'>
            <h5 class='mb-2'>
                <a href='product-grids.html'><?=" . $itemName." ?></a>
            </h5>
            <span class='category'>
                <i class='lni lni-tag'></i> 
                <?=" . $cat ."?>
            </span>
            <div>
                <span class='text-danger mb-2'>Close at <br><?=" . $close_dt ." ?></span>
            </div>
            <div>
                <p><i class='fas fa-hand-paper'></i> Bid:  <?=" . $bid_num ."?></p>
            </div>
            <div class='price'>
                <span class='text-dark fs-6'>Current Bid Price: <br><span class='text-primary fs-5'>¥<?=" . $curr_pr ."?></span></span>
            </div>
        </div>
    </div>
</div>

  ";
}


?>