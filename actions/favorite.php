<?php
  include '../classes/favorite.php';
  $item_id = $_GET['id'];
  $page = $_GET['page'];
  $user_id = $_SESSION['user_id'];
  $row = new Favorite();
  $row->modifyFavorite($user_id, $item_id, $page);
?>