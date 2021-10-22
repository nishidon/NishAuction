<?php
session_start();
include 'topbar.php';
require_once 'functions/functions.php';
title('dark', 'fas fa-user-cog', 'Dashboard');
?>
<div class="container">
  <div class="row mt-5">
    <div class="col">
      <a class="btn btn-primary w-100" href="categories.php">Add Categories</a>
    </div>
    <div class="col">
      <a class="btn btn-primary w-100" href="users.php">Users</a>
    </div>
  </div>
</div>