<?php
include "classes/evaluation.php";
include "classes/user.php";
include "classes/item.php";
$seller_id = $_GET['seller_id'];
$users = new User;
$items = new Item;
$evaluation = new Evaluate;
$evaluationInfo = $evaluation->getEvaluate($seller_id);
$starAvg = $evaluation->getEvaluateAvg($seller_id);
$reviewNum = $evaluation->getEvaluateNum($seller_id);

include 'topbar.php';
include 'functions/functions.php';
title('dark', 'fas fa-comment-alt', 'Seller Evaluation');
?>
<div class="container mt-5">

  <?php
  //seller information
  $sellerInfo = $users->getOneUser($seller_id);
  ?>
  <!-- user info -->
  <h3 class="w-75 mx-auto">Seller: </h3>
  <div class="card shadow-sm p-3 mb-5 bg-white rounded w-75 mx-auto">
    <a href="evaluation.php?seller_id=<?= $sellerInfo['user_id'] ?>">
      <div class="row">
        <div class="col-2">
          <img src="assets/images/user_images/<?= $sellerInfo['photo'] ?>" alt="profile image" class="rounded-circle" style="object-fit: cover;" width="60px" height="60px">
        </div>
        <div class="col-10 p-2">
          <div class="row">
            <h5 class="m-0 p-0">
                <?php
                echo $sellerInfo['username'];
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
              <li><span><?=str_repeat('&nbsp;', 5). $reviewNum; ?> reviews</span></li>
            </ul>
          </div>
        </div>
      </div>
    </a>
  </div>
  
  
  <?php
  if(!empty($evaluationInfo)){
    foreach($evaluationInfo as $evaluationData){
      $itemInfo = $items->getOneItem($evaluationData['item_id']);
      $clientInfo = $users->getOneUser($evaluationData['client_id']);
  ?>
  <div class="row mb-4">
    <div class="col-6 mx-auto">
      <div class="card p-3 shadow">
        <a class="" href="evaluation.php?seller_id=<?= $clientInfo['user_id'] ?>">
          <div class="row mb-3">
            <div class="col-2">
              <img src="assets/images/user_images/<?= $clientInfo['photo'] ?>" alt="profile image" class="rounded-circle" style="object-fit: cover;" width="60px" height="60px">
            </div>
            <div class="col-10">
              <div class="row">
                <div class="col">
                  <h5 class="m-0 pt-3">
                  <?php
                    echo $clientInfo['username'];
                  ?>
                  </h5>
                </div>
              </div>
            </div>
          </div>
          <div class="row my-2 text-muted">
            <div class="col">
              <div class="">
                <p>
                  <?php
                  echo "Item Bought: ". $itemInfo['item_name'];
                  ?>
                </p>
              </div>  
            </div>
          </div>
          <div class="row mb-2 text-muted">
            <div class="col-2 pe-0">
              Evaluation:
            </div>
            <div class="col-10 ps-0">
              <ul class="pt-1">
                <?php
                for($i=1; $i<=$evaluationData['star']; $i++){
                  echo "<li><i class='lni lni-star-filled float-start text-warning'></i></li>";
                }
                for($i=1; $i<=(5-$evaluationData['star']); $i++){
                  echo "<li><i class='lni lni-star float-start'></i></li>";
                }
          
                ?>
              </ul>
            </div>
          </div>
          <div class="row text-muted">
            <div class="col">
              Comment:
              <p class="p-2" style="background-color: #F5F5F5;">
              <?php
                echo $evaluationData['comment'];
              ?>
              </p>
            </div>
          </div>
          <div class="row text-muted">
            <div class="col">
              <p class="float-end">
              <?php
                echo "<i class='far fa-clock'></i> ". $evaluationData['evaluate_date'];
              ?>
              </p>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
  <?php
      }
  ?>
</div>
<?php

}else{
  echo 'No evaluation';
}
?>
