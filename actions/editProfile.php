<?php
  include "../classes/user.php";

  $user_id = $_SESSION['user_id'];
  $first_name = $_POST['fname'];
  $last_name = $_POST['lname'];
  $uname = $_POST['uname'];
  $address = $_POST['address'];
  $photo_name = $_FILES['photo']['name'];
  $tmp_name = $_FILES['photo']['tmp_name'];


  $user = new User;
  $user->updateUser($user_id, $first_name, $last_name, $uname, $address, $photo_name, $tmp_name);
?>