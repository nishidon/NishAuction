<?php
  include "../classes/item.php";

  if(empty($_SESSION)){
    header('Location: ../login.php?error=login');
    exit;
  }

  $bid_pr = $_POST['bid'];
  $item_id = $_POST['item_id'];
  $user_id = $_SESSION['user_id'];
  
  $new_bid = new Item();
  $new_bid->newBid($bid_pr, $item_id, $user_id);
  
?>