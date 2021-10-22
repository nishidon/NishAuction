<?php
  $item_id = $_GET['item_id'];
  include 'classes/item.php';
  include "classes/category.php";
  $catList = new Category();
  $cats = $catList->getCat();
  $itemList = new Item();
  $itemData = $itemList->getOneItem($item_id);
  $bidNum = $itemList->getOneBid($item_id);
  include 'topbar.php';
  include 'functions/functions.php';
  title('dark', 'far fa-edit', 'Edit Item');
  // print_r($itemData);
?>
<div class="container">
  <div class="row mt-5">
    <div class="col-6 mx-auto">
      <div class="card p-3">
      <img src="assets/images/item_images/<?= $itemData['item_photo']; ?>" alt="image of an item">
        <form action="actions/edit-item.php?item_id=<?= $itemData['item_id'] ?>" method="post" enctype="multipart/form-data">
          <label for="photo">Photo<span class="text-danger"></span></label>
          <input type="file" name="photo" class="form-control mb-2">
          <label for="name" class="form-label">Name of an item<span class="text-danger">* </span>  <span class="text-muted">(Under 20 letters)</span></label>
          <input type="text" name="name" class="form-control mb-2" maxlength="20" value="<?= $itemData['item_name']; ?>" required>
          <label for="category">Category<span class="text-danger">*</span></label>
          <select class="form-control" name="category" id="" value="<?= $itemData['category_name']; ?>" required>
            <option value hidden>-Select-</option>
            <?php
              foreach($cats as $cat){
            ?>
            <option value="<?= $cat['category_id'] ?>" <?php if($cat['category_id'] == $itemData['category_id']){echo 'selected';} ?>><?= $cat['category_name'] ?></option>
            <?php
              }
            ?>
          </select><br>
          <label for="Condition">Condition<span class="text-danger">*</span></label>
          <?php 
          ?>
          <select class="form-control" name="condition" id="" required>
            <option value="<?= $itemData['item_condition'] ?>" hidden><?= $itemData['item_condition'] ?></option>
            <option value="Unused">Unused</option>
            <option value="As good as new">As good as new</option>
            <option value="Used">Used</option>
            <option value="Good">Good</option>
            <option value="Got some scratches">Got some scratches</option>
            <option value="Broken">Broken</option>
          </select><br>
          <label for="description">Description of an item<span class="text-danger">*</span></label><br>
          <textarea class="form-control" name="description" id="" cols="30" rows="10" required><?= h($itemData['description']) ?></textarea>
          <label for="Close" class="form-label">Close at<span class="text-danger">*</span></label>
           <?php $datetime = date('Y-m-d'.'\T'.'H:i:s',strtotime($itemData['close_datetime'])); ?>
          <input type="datetime-local" name="close_datetime" class="form-control mb-2" 
          value="<?= $datetime ?>" required>
          <label for="price" class="form-label">
            Opening Price
            <span class="text-danger">
            <?php if($bidNum['bid_num'] == 0){ 
            echo "*"
;            }else{
            echo "(No modification of open price allowed after being bidden.)";
            }
            ?>
            </span>
          </label>
          <?php
            if($bidNum['bid_num'] > 0){
              echo "<h4>
                      ¥ ".$itemData['item_price']." ->  ¥ ".$itemData['current_price']."</h4>
                      <input type='hidden' name='price' value='".NULL."'>";
              
            }else{
              echo "<div class='row'>
                      <div class='col-1 text-end mt-1 me-0'>
                        <h4>¥</h4>
                      </div>
                      <div class='col-11 ps-0 ms-0'>
                        <input type='number' name='price' class='form-control mb-2' value=".$itemData['current_price']." required>
                      </div>
                    </div>
              ";
            }
          ?>
          <input type="submit" name="submit" value="Update" class="btn btn-success w-100 mt-3">
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>