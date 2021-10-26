<?php
  date_default_timezone_set('Asia/Tokyo');
  require_once "database.php";
  class User extends Database{
    public function createUser($first_name, $last_name, $address, $uname, $pass){
      $pass = password_hash($pass, PASSWORD_DEFAULT);

      $sql = "INSERT INTO users(first_name, last_name, address, username, password) 
              VALUES ('$first_name','$last_name','$address', '$uname','$pass')";

      //execute the SQL statement
      if($this->conn->query($sql)){
        header("Location: ../login.php");
      }else{
        die("Error in creating the user:".$this->conn->error);
      }
    }

    public function login($uname, $pass){
      $sql = "SELECT * FROM users WHERE username = '$uname'";
      $result = $this->conn->query($sql);

      if($result){
        //check if the username exists
        if($result->num_rows == 1){
          $user_details = $result->fetch_assoc();

          if(password_verify($pass, $user_details['password'])){
            $_SESSION['user_id'] = $user_details['user_id'];
            $_SESSION['username'] = $user_details['username'];
            $_SESSION['address'] = $user_details['address'];
            $_SESSION['first_name'] = $user_details['first_name'];
            $_SESSION['last_name'] = $user_details['last_name'];
            $_SESSION['status'] = $user_details['status'];

            if($_SESSION['status'] != 'B'){
              header('Location: ../index.php');
              exit;
            }else{
              header("Location: ../login.php?error=banned");
              exit;
             }

          }
        }else{
          header('Location: ../login.php?error=error');
          exit;
        }
      }else{
        die("Error in logging in: " .$this->conn->error);
      }
    }

    public function getUsers(){
      $sql = "SELECT * FROM users";
      $result = $this->conn->query($sql);
      if($result->num_rows > 0){
        while($rows = $result->fetch_assoc()){
          $ulist[] = $rows;
        }
      }
      return $ulist;
    }

    public function getOneUser($id){
      $sql = "SELECT * FROM users WHERE user_id = '$id'";
      $result = $this->conn->query($sql);
      if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        return $row;

      }else{
        die('Failed to get user info: '.$this->conn->error);
      }
    }

    public function updateUser($user_id, $first_name, $last_name, $uname, $address, $photo_name, $tmp_name){
      
      if(empty($photo_name)){
        $sql = "SELECT photo FROM users WHERE user_id = '$user_id'";
        $result = $this->conn->query($sql);
        if ($result->num_rows == 1){
          $row = $result->fetch_assoc();
          $photo_name = $row['photo'];
        }
      }
      $target_dir = "../assets/images/user_images/";
      $target_file = $target_dir .basename($photo_name);

      $sql = "SELECT * FROM users WHERE username = '$uname'";
      $result = $this->conn->query($sql);
      if($result->num_rows < 1 || $uname == $_SESSION['username']){
        $_SESSION['username'] = $uname;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['address'] = $address;

        echo $_SESSION['username'];
        echo $_SESSION['first_name'];
        echo $_SESSION['last_name'];
        echo $_SESSION['address'];
        $sql = "UPDATE users
                SET first_name = '$first_name',
                    last_name = '$last_name',
                    username = '$uname',
                    address = '$address',
                    photo = '$photo_name'
                WHERE user_id = '$user_id'";
        $result = $this->conn->query($sql);

        if ($result){
          move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
          header("Location: ../edit-profile.php?error=NoErrors");
          exit;
        }else{
          header("Location: ../edit-profile.php?error=duplicate");
          exit;
        }
      }else{
        die($this->conn->error);
      }
    }

    public function deleteUser($user_id){
      $sql = "DELETE FROM users WHERE user_id = '$user_id'";
      $result = $this->conn->query($sql);
      if($result){
        session_destroy();
        header('Location: ../register.php?result=deleted');
        exit;
      }
    }

    public function changePass($curPass, $newPass, $newPassCon){
      $user_id = $_SESSION['user_id'];
      $sql = "SELECT password FROM users WHERE user_id = '$user_id'";
      $result = $this->conn->query($sql);

      if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        if(password_verify($curPass, $row['password'])){
          if($newPass == $newPassCon){
            $newPass = password_hash($newPass, PASSWORD_DEFAULT);
            $sql = "UPDATE users
                    SET password = '$newPass'
                    WHERE user_id = '$user_id'";
            $result = $this->conn->query($sql);
            if ($result){
              $passResult = 'success';
            }else{
              $passResult = 'error';
            }
          }else{
            $passResult = 'nomatch';
          }
        }else{
          $passResult = 'wrongPass';
        }
      }else{
        die($this->conn->error);
      }
      header('Location: ../edit-profile.php?passResult='.$passResult);
      exit;
    }

    public function getClientInfo($item_id){
      $sql = "SELECT * 
              FROM users 
              INNER JOIN items
              ON users.user_id = items.highest_bidder_id
              WHERE items.item_id = '$item_id'
              ";
     $result = $this->conn->query($sql); 
     if($result->num_rows == 1){
       $row = $result->fetch_assoc();
       return $row;
      }
    }

    public function banUsers($user_id, $time, $reasons){
      
      if($time == '1'){
        $day = strtotime('+1day');
      }elseif($time == '3'){
        $day = strtotime('+3day');
      }elseif($time == 'w'){
        $day = strtotime('+1week');
      }

      $until = date('Y/m/d H:i', $day);
      

      $sql1 = "UPDATE users
              SET status = 'B'
              WHERE user_id = '$user_id'
              ";

      $sql2 = "INSERT INTO bans(user_id, reasons, until) VALUES('$user_id', '$reasons', '$until')";

      $result2 = $this->conn->query($sql2); 
      $result1 = $this->conn->query($sql1);
      
      if($result1 && $result2){
        header('Location: ../users.php');
        exit;
      }else{
        die($this->conn->error);
      }
    }

    public function AutoCancelBans(){
      $dateTime = date('Y/m/d H:i:s');
      $sql = "SELECT * FROM bans WHERE until < '$dateTime'";
      $result = $this->conn->query($sql);
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          $unban_user = $row['user_id'];
          
          // $unban_user = $expired['user_id'];
          $sql1 = "DELETE FROM bans 
                    WHERE user_id = '$unban_user'";

          $sql2 = "UPDATE users
                    SET status = 'U'
                    WHERE user_id = '$unban_user'
                    ";

          $result1 = $this->conn->query($sql1);
          $result2 = $this->conn->query($sql2);
        }
      }
    }

      public function ManualCancelBans($user_id){
        $sql1 = "DELETE FROM bans 
                  WHERE user_id = '$user_id'
                  ";

        $sql2 = "UPDATE users
                  SET status = 'U'
                  WHERE user_id = '$user_id'
                  ";
        $result1 = $this->conn->query($sql1);
        $result2 = $this->conn->query($sql2);

        if($result1 && $result2){
          header('Location: ../users.php');
          exit;
        }else{
          die($this->conn->error);
        }
      }
    
      public function getBanInfo($user_id){
        $sql = "SELECT * FROM bans WHERE user_id = '$user_id'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row;
      }
    
  }