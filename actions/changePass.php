<?php
include '../classes/user.php';

$curPass = $_POST['curPass'];
$newPass = $_POST['newPass'];
$newPassCon = $_POST['newPassCon'];

$pass = new User();
$pass->changePass($curPass, $newPass, $newPassCon);

?>