<?php
  require_once 'classes/category.php';
  $cats = new Category();
  $catList = $cats->getOneCat($_GET['id']);
  include 'topbar.php';
?>
<div class="container">
  <div class="row">
    <div class="col-8 mx-auto text-center mt-5">
      <form action='actions/editCat.php' method='post'>
        <label class='form-label' for='category_name'>Category Name</label>
        <input class='form-control' type='text' name='category_name' value='<?= $catList['category_name'] ?>'>
        <input type='hidden' name='category_id' value='<?= $_GET['id'] ?>'><br>
        <input type='submit' value='Update' name='update' class='btn btn-warning btn-block w-100'>
      </form>
    </div>
  </div>
</div>