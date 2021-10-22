<?php
  include '../classes/category.php';

  $cat = new Category();
  $cat->deleteCat($_GET['id']);
?>