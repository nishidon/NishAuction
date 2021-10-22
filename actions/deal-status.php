<?php
$action = $_GET['action'];
$item_id = $_GET['item_id'];
include '../classes/item.php';
$item = new Item();
$item->dealStatus($item_id, $action);
?>