<?php
  include "../classes/item.php";
  $item_id = $_POST['item_id'];
  $client_id = $_SESSION['user_id'];
  $method = $_POST['method'];
  $discount = $_POST['coupon'];

  $item = new Item;
  $item->setPayment($item_id, $client_id, $method, $discount);
?>