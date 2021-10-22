<?php
  include '../classes/user.php';

  $user_id = $_GET['user_id'];

  $delete = new User();
  $delete->deleteUser($user_id);
?>