<?php
  include '../classes/category.php';
  
  $catName = $_POST['category_name'];
  $catId = $_POST['category_id'];
  $cat = new Category();
  $cat->editCat($catName, $catId);
?>