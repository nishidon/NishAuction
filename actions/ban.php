<?php
  include "../classes/user.php";
  $user_id = $_POST['user_id'];
  $time = $_POST['time'];
  $reasons = $_POST['reasons'];
  $user = new User;
  $user->banUsers($user_id, $time, $reasons);
?>