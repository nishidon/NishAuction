<?php
  include 'classes/item.php';
  $user_id = $_SESSION['user_id'];
  $row = new Item();
  $myItems = $row->getItems('myItems');
  $salesArray = $row->getSales($user_id);
  if(!empty($salesArray)){
    $totalSales = 0;
    foreach($salesArray as $sales){
      $totalSales += ($sales - $sales * 0.1);
    }
  }
  if(empty($_SESSION)){
    header('Location: index.php');
    exit;
  }
  include 'topbar.php';
  include 'functions/functions.php';
  title('dark', 'fas fa-user', 'My Page');
?>

  <div class="container">
    <div class="row mt-5 p-3 border">
      <div class="row mb-3 w-100">
        <div class="col">
          <a class="btn btn-secondary" href="edit-profile.php">
            <i class="fas fa-user-cog"></i>
            Edit Profile
          </a>
        </div>
      </div>
      <div class="row mb-3 w-100 mx-auto">
        <div class="col">
          <a class="btn btn-primary w-100" href="add-item.php"><i class="fas fa-arrow-alt-circle-up"></i> Newly put up for sale</a>
        </div>
        <div class="col">
          <a class="btn btn-primary w-100" href="my-items.php"><i class="fas fa-store"></i> My Items</a>
        </div>
      </div>
      <div class="row mb-3 w-100 mx-auto">
        <div class="col">
        <a class="btn btn-primary w-100" href="winning-bids.php"><i class="fas fa-gavel"></i>  Winning bids</a>
        </div>
        <div class="col">
          <a class="btn btn-primary w-100" href="bidding-items.php"><i class="fas fa-hand-point-up"></i>   Bidding Now</a>
        </div>
      </div>
      <div class="row w-100 mx-auto">
        <div class="col">
          <a class="btn btn-primary w-100" href="wish-list.php"><i class="fas fa-heart"></i> Wish List</a>
        </div>
        <div class="col">
          <!-- <a class="btn btn-primary w-100" href="view-item.php">Winning bids</a> -->
        </div>
      </div>
    </div>
      <?php
        if(!empty($salesArray)){
      ?>
      <div class='row'>
        <div class='col-8 mx-auto mt-5'>
          <table class="table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Sales</th>
              </tr>
            </thead>
              <?php
              foreach( $myItems as $myItem){
                if($myItem['item_status'] == 'RECEIVED'){
                $payment = $row->getPayment($myItem['item_id']);
              ?>
              <tr>
                <td><?=$myItem['close_datetime']?></td>
                <td><?=$myItem['item_name']?></td>
                <td>¥<?=$payment['price']?></td>
                <td>¥<?=$payment['price'] - $payment['price'] * 0.1?></td>
              </tr>
            <?php
                }
              }
            ?>
            <tr class="table-secondary">
              <th>Total: </th>
              <td></td>
              <td></td>
              <td><h5><span class="text-danger">¥<?=$totalSales?></span></h5></td>
            </tr>
          </table>
<!-- 
          <h1>Your sales: ¥ <?=$totalSales?></h1> -->

        </div>
      </div>

      <?php
      }
    ?>
      </div>
    </div>
  </div>
</body>
</html>
  

