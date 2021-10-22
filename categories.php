<?php
  include 'classes/category.php';
  $cats = new Category();
  $catList = $cats->getCat();
  include 'topbar.php';
  include 'functions/functions.php';
  title('dark', 'fas fa-folder', 'Categories');
?>

<div class="container">
  <div class="row">
    <div class="col">
      <form action="actions/categories.php" method="post">
        <div class="text-center m-5">
          <label class="me-3" for="AddCategory">Add Category</label>
          <input class="me-1" type="text" name="category_name" required>
          <input type="submit" value="ADD" name="add" class="btn btn-success text-white">
        </div>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-7 mx-auto">
      <table class="table table-hover">
        <thead class="table-dark">
          <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <td></td>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($catList as $cat){
          ?>
          <tr>
            <td><?= $cat['category_id'] ?></td>
            <td><?= $cat['category_name'] ?></td>
            <td>
              <a class="btn btn-outline-danger" href="actions/deleteCat.php?action=delete&id=<?= $cat['category_id'] ?>">Delete</a>
              <a class="btn btn-outline-warning" href="editCat.php?id=<?= $cat['category_id'] ?>">Edit</a>
            </td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  
</div>