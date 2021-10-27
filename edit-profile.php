<?php
  include 'classes/user.php';
  include 'classes/item.php';
  include 'topbar.php';
  include 'functions/functions.php';
  title('dark', 'fas fa-user-cog', 'Edit Profile');
  $user_id = $_SESSION['user_id'];
  $user = new User();
  $userInfo = $user->getOneUser($user_id);
  $item = new Item();
  $myItems = $item->getItems('myItems');
  $bidding = $item->checkBid($user_id);
  if(!empty($myItems)){
    foreach($myItems as $myItem){
      if($myItem['item_status'] == 'A' || $myItem['item_status'] == 'S'){
        $selling = 'yes';
      }else{
        $selling = 'no';
      }
    }
  }else{
    $selling = 'no';
  }
  if(!empty($_GET['action']) && $_GET['action'] == 'shipping'){
    $_SESSION['item_id'] = $_GET['id'];
  }
?>

<div class="container my-5">
  <div class="row">
    <div class="col">
      <?php
      if(!empty($_GET['passResult'])){
        if($_GET['passResult'] == 'success'){
          success('Your password has been successfully updated.');
        }elseif($_GET['passResult'] == 'error'){
          alert('Failed to update your password.');
        }elseif($_GET['passResult'] == 'nomatch'){
          alert('Please make sure to match the confirmation password with the new password.');
        }elseif($_GET['passResult'] == 'wrongPass'){
          alert('Please enter the correct passoword.');
        }
      }
        
      ?>
    </div>
  </div>
  <div class="row mx-auto">
    <div class="col">
      <div class="card w-75 float-end">
        <img src="assets/images/user_images/<?= $userInfo['photo'] ?>" alt="<?= $userInfo['photo'] ?>" class="card-img">
        <div class="card-body">
          <h2><?= $userInfo['first_name'] ." ". $userInfo['last_name'] ?></h2>
          <p class="text-muted fst-italic">@<?= $userInfo['username'] ?></p>
        </div>
      </div>
    </div>
    <div class="col">
      <form action="actions/editProfile.php" method="post" enctype="multipart/form-data">
        <label for="fname" class="form-label">FIRST NAME</label>
        <input type="text" class="form-control" name="fname" value="<?= $userInfo['first_name'] ?>" required>
        <label for="lname" class="form-label">LAST NAME</label>
        <input type="text" class="form-control" name="lname" value="<?= $userInfo['last_name'] ?>" required>
        <label for="uname" class="form-label">Username</label>
        <input type="text" class="form-control" name="uname" value="<?= $userInfo['username'] ?>" required>
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" name="address" value="<?= $userInfo['address'] ?>" required>
        <label for="image" class="form-label">User Image</label>
        <input type="file" name="photo" class="form-control">
        <input type="submit" name="submit" value="Update" class="btn btn-success mt-3 w-100">
      </form>
      <div class="col">
        <!-- Button trigger modal --> 
        <button type="button" class="btn float-start" data-bs-toggle="modal" data-bs-target="#changePassword"> 
          <span class="float-start text-decoration-none text-muted">
            <i class="fas fa-lock"></i>
            Change Password
          </span>
        </button>
      </div>
      <div class="col">
        <button type="button" class="btn float-end" data-bs-toggle="modal" data-bs-target="#deleteAccount"> 
            <span class="float-start text-decoration-none text-muted">
              <i class="fas fa-trash"></i>
              Delete Account
            </span>
          </button>
      </div>
    </div>
  </div>
</div>
     <!--Modal1 --> 
     <div class="modal fade" id="changePassword" data-bs-backdrop="static" tabindex="-1" aria-labelledby="changePassword" aria-hidden="true"> 
  <div class="modal-dialog modal-dialog-centered"> 
    <div class="modal-content"> 
      <form action="actions/changePass.php" method="post">
        <div class="modal-header"> 
          <h5 class="modal-title" id="changePassword"><i class="fas fa-lock"></i> Change Password</h5> 
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" required></button> 
        </div> 
        <div class="modal-body">
            <label for="Current Password" class="form-label">Current Password</label>
            <input type="password" name="curPass" class="form-control" required>
            <label for="New Password" class="form-label">New Password</label>
            <input type="password" name="newPass" id="password" class="form-control" required>
            <label for="Confirm New Password" class="form-label">Comfirm New Password</label>
            <input type="password" name="newPassCon" id="passwordConfirm" class="form-control" required>
        </div> 
        <div class="modal-footer"> 
          <!-- <button type="button" class="btn btn-primary" data-bs-dismiss="modal" name="passUpdate">Update</button>  -->
          <input type="submit" class="btn btn-primary" name="passUpdate" value="Update"> 
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div> 
  </div> 
</div>
    <!--Modal2 --> 
    <div class="modal fade" id="deleteAccount" tabindex="-1" aria-labelledby="deleteAccount" aria-hidden="true"> 
      <div class="modal-dialog modal-dialog-centered"> 
        <div class="modal-content"> 
          <div class="modal-header"> 
            <h5 class="modal-title" id="deleteAccount"><i class="fas fa-trash"></i> Delete Account</h5> 
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
          </div> 
          <div class="modal-body text-center">
            <?php
              if($userInfo['status'] == 'A'){
                $delete = 'no';
                echo " <p>You are the administrator of this application.<br> You are not allowed to delete your account.</p>";
              }elseif($selling == 'yes'){
                $delete = 'no';
                echo " <p>You are currently selling items.<br> Please come back after taking off your items.</p>";
              }elseif($bidding == 'yes'){
                $delete = 'no';
                echo " <p>You have bidding items.<br> Please come back after finishing the process</p>";
              }else{
                $delete = 'permitted';
                echo " <p>Are you sure you want to delete your account?</p>";
              }
            ?>
           
            
          </div> 
          <div class="modal-footer"> 
          <?php
          if($delete == 'permitted'){
          ?>
            <a href="actions/deleteUser.php?user_id=<?php echo $user_id ?>" class="btn btn-danger">Yes</a>
          <?php
          }
          ?>

            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div> 
      </div> 
    </div>
    <?php
      include 'footer.php';
    ?>
</body>
</html>