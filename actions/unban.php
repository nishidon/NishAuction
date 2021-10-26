<?php
include "../classes/user.php";
$user_id = $_GET['user_id'];
$user = new User;
$user->ManualCancelBans($user_id);
?>