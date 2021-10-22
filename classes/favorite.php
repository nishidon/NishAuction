<?php
date_default_timezone_set('Asia/Tokyo');
require_once "database.php";
class Favorite extends Database{
  public function modifyFavorite($user_id, $item_id, $page){

    $sql= "SELECT * FROM favorite 
          WHERE user_id = '$user_id'
          AND item_id = '$item_id'
          ";
    $result = $this->conn->query($sql);
    if($result->num_rows < 1){

      $sql = "INSERT INTO favorite(user_id, item_id)
              VALUES('$user_id', '$item_id')";

      if($this->conn->query($sql)){
        header('Location: ../bid.php?id='.$item_id);
        exit;
      }else{
        die("Error in adding favorites:".$this->conn->error."<a href='../bid.php'>Back</a>");
      }

    }else{
      $sql = "DELETE FROM favorite
              WHERE user_id = '$user_id'
              AND item_id = '$item_id'
              ";
      $result = $this->conn->query($sql);
      if($this->conn->query($sql)){
        if($page == 'index'){
          header('Location: ../index.php');
          exit;
        }else{
          header('Location: ../bid.php?id='.$item_id);
          exit;
        }
      }else{
        die("Error in adding favorites:".$this->conn->error."<a href='../bid.php'>Back</a>");
      }
    }
  }

  //remove closed items from wish list
  public function removeClosedFav(){
    $sql = "SELECT item_id
            FROM items
            WHERE item_status != 'A'";
    $result = $this->conn->query($sql);
    while($row = $result->fetch_assoc()){
      $item_ids[] = $row;
    }
    if(!empty($item_ids)){
      foreach($item_ids as $item_id){
        $id = $item_id['item_id'];
        $sql = "DELETE FROM favorite
                WHERE item_id = '$id'
                ";
        $result = $this->conn->query($sql);
      }
    }
  }

  public function checkFavorite($user_id, $item_id){
    $sql = "SELECT * FROM favorite 
            WHERE user_id = '$user_id'
            AND item_id = '$item_id'
            ";
    $result = $this->conn->query($sql);
    if($result->num_rows > 0){
     return 'yes';
    }else{
      return 'no';
    }
  }

  public function checkFavoriteNum($user_id){
    $sql = "SELECT * FROM favorite 
            WHERE user_id = '$user_id'
            ";
    $result = $this->conn->query($sql);
     return $result->num_rows;
  }
}

?>