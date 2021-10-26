<?php
    include 'classes/user.php';
    $user = new User;
    if(!empty($_GET) && $_GET['error'] == 'banned'){
      $user_id = $_SESSION['user_id'];
      $banInfo = $user->getBanInfo($user_id);
      session_destroy();
    }
    include 'topbar.php';
    include 'functions/functions.php';
  ?>
  <div class="container">
    <div class="card w-50 mx-auto p-3" style="margin-top: 200px">
      <div class="text-center">
        <h1>LOGIN</h1>
      </div>
      <div class="card-body">
        <form action="actions/login.php" method="post">
          <input class="form-control mb-3" type="text" name="uname" placeholder="USERNAME">
          <input class="form-control mb-3" type="password" name="pass" placeholder="PASSWORD">
          <input class="btn btn-primary w-100 my-4" type="submit" name="submit" value="LOG IN">
        </form>
          <p class="text-center"><a href="register.php">Create Account</a></p>
      </div>
    </div>
    <?php
    if(!empty($_GET) && $_GET['error'] == 'banned'){
      alert(
        "You are banned until <span class='text-danger'>".$banInfo['until']."</span> for the following reasons:<br><br><span class='text-danger'>".$banInfo['reasons']."</span><br><br>
        For the duration of the suspention, you are not allowed to sell/bid any items.
      ");
    }
    if(empty($_SESSION) && !empty($_GET['error']) && $_GET['error'] == 'login'){
      alert('Please login to bid.');
    }
    if(!empty($_GET['error']) && $_GET['error'] == 'error'){
      alert('The password or the username you entered is incorrect.');
    }
    ?>
  </div>
</body>
</html>