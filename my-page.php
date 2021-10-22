<?php
  include 'classes/item.php';
  $row = new Item();
  // $myItems = $row->getItems('myItems');
  $sales = $row->getSales();
  if(empty($_SESSION)){
    header('Location: index.php');
    exit;
  }
  include 'topbar.php';
  include 'functions/functions.php';
  title('dark', 'fas fa-user', 'My Page');
?>

  <div class="container">
    <div class="row">
      <div class="col mt-4 text-center alert alert-dark">
        <h1>Your sales: ¥<?= $sales ?></h1>
      </div>
    </div>
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
  </div>
</body>
</html>
  

