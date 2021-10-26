<?php
  include 'classes/user.php';
  $user = new User;
  $userInfo = $user->getOneUser($_GET['user_id']);
  include 'topbar.php';
  include 'functions/functions.php';
  title('dark', 'fas fa-user-slash', 'Ban Users');
?>
<div class="container">
  <div class="row">
    <div class="col-6 mx-auto mt-5">
      <table class="table">
        <tr class="bg-dark text-white">
          <th>Name</th>
          <th>Address</th>
          <th>Username</th>
        </tr>
        <tr>
          <td><?=  $userInfo['first_name']." ".$userInfo['last_name'] ?></td>
          <td><?=  $userInfo['address'] ?></td>
          <td><?=  $userInfo['username'] ?></td>
        </tr>
      </table>

      <form action="actions/ban.php" method="post">
        <label for="suspensionTime">Suspend for:</label>
        <select class="form-control" name="time" id="">
          <option value hidden>-select-</option>
          <option value="1">1 day</option>
          <option value="3">3 days</option>
          <option value="w">1 week</option>
        </select>
        <label for="reasons">Reasons</label>
        <textarea class="form-control" name="reasons" id="" cols="30" rows="10" required></textarea>
        <input type="hidden" name="user_id" value="<?=$_GET['user_id']?>">
        <input class="btn btn-danger w-100 mt-3" type="submit" value="BAN">
      </form>
    </div>
  </div>
</div>