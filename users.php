<?php
include "classes/user.php";
$rows = new User();
$users = $rows->getUsers();
include "topbar.php";
require_once "functions/functions.php";
title('dark', 'fas fa-user-cog', 'Users');
$rows->AutoCancelBans();
?>
<div class="container">
  <div class="row">
    <div class="col-8 mx-auto mt-5">
      <table class="table table-hover">
        <thead class="table-dark">
          <tr>
            <th>User ID</th>
            <th>Full Name</th>
            <th>Username</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($users as $user){
              if($user['status'] != 'A'){
                if($user['status'] == 'B'){
                  $btn = 'UNBAN';
                  $color = 'warning';
                  $href = 'actions/unban';
                }else{
                  $btn = 'BAN';
                  $color = 'danger';
                  $href = 'ban';
                }
              $fullname = $user['first_name']." ".$user['last_name']
          ?>
          <tr>
            <td><?= $user['user_id'] ?></td>
            <td><?= $fullname ?></td>
            <td><?= $user['username'] ?></td>
            <td>
              <a class="btn btn-outline-<?=$color?>" href="<?=$href?>.php?user_id=<?= $user['user_id'] ?>"><?=$btn?></a>
            </td>
          </tr>
          <?php
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
