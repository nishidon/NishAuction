<?php
include 'classes/user.php';
$item_id = $_GET['id'];
$user = new User();
$dealInfo = $user->getClientInfo($item_id);
include 'topbar.php';
include 'functions/functions.php';
title('dark', 'fas fa-handshake', 'Deal');
?>
<div class="container">
  <div class="row">
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
</div>