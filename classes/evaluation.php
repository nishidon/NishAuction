<?php
date_default_timezone_set('Asia/Tokyo');
require_once "database.php";
class Evaluate extends Database{
  public function addEvaluate($item_id, $star, $comment){
      $client_id = $_SESSION['user_id'];
      $date = date('Y/m/d H:i');

      $sql = "SELECT user_id FROM items WHERE item_id = '$item_id'";
      $result = $this->conn->query($sql);
      if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $seller_id = $row['user_id'];
      }

      $sql = "INSERT INTO evaluation(seller_id, client_id, item_id, star, comment, evaluate_date)
              VALUES('$seller_id', '$client_id', '$item_id', '$star', '$comment', '$date')";


      if($this->conn->query($sql)){
        $sql = "UPDATE items 
                SET deal_status = 'OVER'
                WHERE item_id = '$item_id'
                ";
        $result = $this->conn->query($sql);
        if($result){
          header('Location: ../auction-winner.php?id='.$item_id.'&result=added');
          exit;
        }else{
          die($this->conn->error);
        }
      }else{
        die("Error in adding evaluation:".$this->conn->error."<a href='../auction-winner.php?id=".$item_id.">Back</a>");
      }
  }

  public function getEvaluate($user_id){
    $sql = "SELECT * FROM evaluation WHERE seller_id = '$user_id'";
    $result = $this->conn->query($sql);
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $evaluation[] = $row;
      }
      return $evaluation;
    }
  }
}