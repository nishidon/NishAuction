<?php
include "../classes/evaluation.php";
$evaluation = new Evaluate;

$item_id = $_POST['item_id'];
$star = $_POST['star'];
$comment = $_POST['comment'];

$evaluation->addEvaluate($item_id, $star, $comment);
?>