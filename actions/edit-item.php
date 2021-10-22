<?php
  include "../classes/item.php";
  include "../functions/functions.php";
  $user_id = $_SESSION['user_id'];
  $item_id = $_GET['item_id'];
  $name = $_POST['name'];
  $cat_id = $_POST['category'];
  $con = $_POST['condition'];
  $desc = $_POST['description'];
  $cd = $_POST['close_datetime'];
  $pr = $_POST['price'];
  $photo_name = $_FILES['photo']['name'];
  $tmp_name = $_FILES['photo']['tmp_name'];

  $item = new Item();
  $item->editItem($name, $cat_id, $con, $desc, $cd, $pr, $photo_name, $tmp_name, $user_id, $item_id);
?>