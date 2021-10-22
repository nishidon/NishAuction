<?php
require "../classes/user.php";

$first_name = $_POST['fname'];
$last_name = $_POST['lname'];
$uname = $_POST['uname'];
$address = $_POST['address'];
$pass = $_POST['pass'];


$user = new User;
$user->createUser($first_name, $last_name, $address, $uname, $pass);
?>