<?php
    session_start();
    include 'functions/functions.php';
    include 'topbar.php';
  ?>
  <div class="container">
    <div class="card my-5 mx-auto w-50 p-3" style="margin: 100px 0z;">
      <div class="card-head text-center">
        <h1>REGISTER</h1>
      </div>
      <form action="actions/register.php" method="post">
        <label for="fname" class="form-label">FIRST NAME</label>
        <input type="text" class="form-control" name="fname">
        <label for="lname" class="form-label">LAST NAME</label>
        <input type="text" class="form-control" name="lname">
        <label for="uname" class="form-label">Username</label>
        <input type="text" class="form-control" name="uname">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" name="address">
        <label for="pass" class="form-label">Password</label>
        <input type="password" class="form-control" name="pass">
        <input type="submit" name="submit" value="REGISTER" class="btn btn-success mt-3 w-100">
      </form>
        <p class="text-center mt-3 small">Registered already? <a href="login.php">Log in</a></p>
    </div>
    <?php
    if(!empty($_GET['result']) && $_GET['result'] == 'deleted'){
      success('You account has been successfully deleted.');
    }
    ?>
  </div>
</body>
</html>