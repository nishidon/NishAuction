<?php
  include "../classes/user.php";

  $uname = $_POST['uname'];
  $pass = $_POST['pass'];

  $user = new User;
  $user->login($uname, $pass);
?>