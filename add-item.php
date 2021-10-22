<?php
  include "classes/category.php";
  $catList = new Category();
  $cats = $catList->getCat();
  include "topbar.php";
?>
  <div class="container">
    <div class="row">
      <div class="col-8 mx-auto mt-5">
        <div class="card p-3">
          <h1 class="text-center">Put Up an Item</h1>
          <form action="actions/add-item.php" method="post" enctype="multipart/form-data">
          <label for="photo">Photo<span class="text-danger">*</span></label>
          <input type="file" name="photo" class="form-control mb-2" required>
            <label for="name" class="form-label">Name of an item<span class="text-danger">* </span>  <span class="text-muted">(Under 20 letters)</span></label>
            <input type="text" name="name" class="form-control mb-2" maxlength="20" required>
            <label for="category">Category<span class="text-danger">*</span></label>
            <select class="form-control" name="category" id="" required>
              <option value hidden>-Select-</option>
              <?php
                foreach($cats as $cat){
              ?>
              <option value="<?= $cat['category_id'] ?>"><?= $cat['category_name'] ?></option>
              <?php
                }
              ?>
            </select><br>
            <label for="Condition">Condition<span class="text-danger">*</span></label>
            <select class="form-control" name="condition" id=""  required>
              <option value hidden>-Select-</option>
              <option value="unused">Unused</option>
              <option value="As good as new">As good as new</option>
              <option value="Used">Used</option>
              <option value="Good">Good</option>
              <option value="Got some scratches">Got some scratches</option>
              <option value="Broken">Broken</option>
            </select><br>
            <label for="description">Description of an item<span class="text-danger">*</span></label><br>
            <textarea class="form-control" name="description" id="" cols="30" rows="10" required></textarea>
            <label for="Close" class="form-label">Close at<span class="text-danger">*</span></label>
            <input type="datetime-local" name="close_datetime" class="form-control mb-2" required>
            <!-- <input type="date" name="close_date" class="form-control mb-2" required>
            <input type="time" name="close_time" class="form-control mb-2" required> -->
            <label for="price" class="form-label">Opening Price<span class="text-danger">*</span></label>
            <input type="number" name="price" class="form-control mb-2" required>
            <input type="submit" name="submit" class="btn btn-success w-100 mt-3">
          </form>
        </div>
      </div>
    </div>
  </div>