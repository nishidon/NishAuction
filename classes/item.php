<?php
  date_default_timezone_set('Asia/Tokyo');
  require_once "database.php";
  class Item extends Database{
    public function addItem($name, $cat_id, $con, $desc, $cd, $ct, $pr, $photo_name, $tmp_name, $user_id){

      $curr_pr = $pr;

      $sql = "INSERT INTO items(item_name, item_price, current_price, item_condition, close_datetime, item_photo, description, user_id, category_id)
              VALUES('$name', '$pr', '$curr_pr', '$con', '$cd', '$photo_name', '$desc', '$user_id', '$cat_id')";

      if($this->conn->query($sql)){
        $target_file = "../assets/images/item_images/$photo_name";
        if(move_uploaded_file($tmp_name, $target_file)){
          header("location: ../my-page.php");
        }else{
          die("Error moving the photo.");
        }
      }else{
        die("Error in creating the user:".$this->conn->error."<a href='../my-page.php'>Back</a>");
      }
    }

    public function editItem($name, $cat_id, $con, $desc, $cd, $pr, $photo_name, $tmp_name, $user_id, $item_id){

      if($photo_name == NULL){
        $photo = $this->getOneItem($item_id);
        $photo_name = $photo['item_photo'];
      }

      if($pr == NULL){
        $price = $this->getOneItem($item_id);
        $pr = $price['item_price'];
        $curr_pr = $price['current_price'];
      }else{
        $curr_pr = $pr;
      }

   

      $sql = "UPDATE items
              SET item_name = '$name',
                  item_price = '$pr',
                  current_price = '$curr_pr',
                  item_condition = '$con',
                  close_datetime = '$cd',
                  item_photo = '$photo_name',
                  description = '$desc',
                  user_id = '$user_id',
                  category_id = '$cat_id'
              WHERE item_id = '$item_id'
              ";


      if($this->conn->query($sql)){

        if(!empty($tmp_name)){
            $target_file = "../assets/images/item_images/$photo_name";
          if(move_uploaded_file($tmp_name, $target_file)){
            header("location: ../edit-item.php?item_id=".$item_id);
            exit;
          }else{
            header("location: ../edit-item.php?result=error&item_id=".$item_id);
            exit;
          }
        }

        header("location: ../edit-item.php?item_id=".$item_id);
        exit;

      }else{
        die("Error in updating the item:".$this->conn->error."<a href='../edit-item.php?result=error&item_id=".$item_id."'>Back</a>");
      }
    }

    public function getItems($operation){

      if($operation == 'index'){
        //For trending items in Home
        $sql = "SELECT * FROM items 
                INNER JOIN categories 
                ON items.category_id = categories.category_id
                WHERE item_status = 'A'
                ORDER BY close_datetime  
                LIMIT 8";
      }elseif($operation == 'myItems'){
        //For my page
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM items
                INNER JOIN categories 
                ON items.category_id = categories.category_id
                WHERE user_id = '$user_id'
                ORDER BY close_datetime  
                ";
      }else{
        //For All
        $sql = "SELECT * FROM items
                INNER JOIN categories
                ON items.category_id = categories.category_id
                WHERE item_status = 'A'
                ORDER BY close_datetime
                ";
      }

        $result = $this->conn->query($sql);
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          $itemList[] = $row;
        }
      return $itemList;
      }
    }

    public function getOneItem($id){

      $sql = "SELECT * FROM items 
              INNER JOIN categories 
              ON items.category_id = categories.category_id
              INNER JOIN users
              ON items.user_id = users.user_id
              WHERE items.item_id = '$id'
              ";

      $result = $this->conn->query($sql);
      if($result->num_rows == 1){
        $row = $result->fetch_assoc();
      }
      return $row;
    }

    //assign $item_id using foreach
    public function updateItemStatus($item_id){
      $sql = "SELECT * FROM items WHERE item_id = '$item_id'";
      $result = $this->conn->query($sql);
      $row = $result->fetch_assoc();
      if(strtotime($row['close_datetime']) < strtotime(date('Y-m-d H:i:s'))){
        if($row['item_price'] < $row['current_price']){
          $sql = "UPDATE items
          SET item_status = 'S'
          WHERE item_id = '$item_id'
          AND item_status = 'A'
          ";
          $this->conn->query($sql);
        }else{
          $sql = "UPDATE items
          SET item_status = 'B'
          WHERE item_id = '$item_id'
          AND item_status = 'A'
          ";
          $this->conn->query($sql);
        }

       
      }
    }

    public function getOneEnd($id){
      $sql = "SELECT close_datetime FROM items WHERE item_id = '$id'";
      $result = $this->conn->query($sql);
      if($result->num_rows == 1){
        $ends = $result->fetch_assoc();
      }
      foreach($ends as $end){
        $endTs = strtotime($end);
        $currTs = strtotime(date('Y-m-d H:i:s'));
        $diff = $endTs - $currTs;

          $remDays = floor($diff / 60 / 60 / 24);
          $diff = $diff - ($remDays * 60 * 60 * 24);
          $remHours = floor($diff / 60 / 60);
          $diff = $diff - ($remHours * 60 * 60);
          $remMins = floor($diff / 60 );
          $diff = $diff - ($remMins * 60);
          $remSecs = floor($diff);
          return $remDays."d ".$remHours."h ".$remMins."m ".$remSecs."s";
      }
    }

    //replace with this
    public function newBid($bid_pr, $item_id, $user_id){

      $datetime = date('Y-m-d H:i:s');

      //check if the bid price is valid
      // $sql = "SELECT bids.bid_price 
      //         FROM bids
      //         INNER JOIN items
      //         ON bids.item_id and items.item_id
      //         WHERE bids.item_id = '$item_id'";
      $sql = "SELECT current_price FROM items WHERE item_id = '$item_id'";

      $result = $this->conn->query($sql);
      $row = $result->fetch_assoc();

      if($row['current_price'] >= $bid_pr){

        header('Location: ../bid.php?result=fail&id='.$item_id);
        exit;

      }else{
        $sql = "INSERT INTO bids(bidder_id, item_id, bid_price, bid_datetime)
                VALUES ('$user_id','$item_id','$bid_pr','$datetime')
                ";
        $result1 = $this->conn->query($sql);

        $sql2 = "UPDATE items
                SET current_price = '$bid_pr',
                    highest_bidder_id = '$user_id'
                WHERE item_id = '$item_id'
                ";
        $result2 = $this->conn->query($sql2);
        if(($result1 && $result2) == TRUE){
          header('Location: ../bid.php?result=success&id='.$item_id);
          exit;
        }else{
          die('Error(Class newBid): '.$this->conn->error);
        }
      }
    }

    public function getOneBid($item_id){
      $sql = "SELECT COUNT(*) as bid_num
              FROM bids
              WHERE item_id = $item_id
              ";
      $result = $this->conn->query($sql);
      if($result){
        $bid_num = $result->fetch_assoc();
        return $bid_num;
      }
    }

    public function getBidders($item_id){
      $sql = "SELECT * 
              FROM bids
              INNER JOIN users
              ON users.user_id = bids.bidder_id
              INNER JOIN items
              ON items.item_id = bids.item_id
              WHERE bids.item_id = $item_id
              ";
      $result = $this->conn->query($sql);
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          $bidders[] = $row;
        }
        return $bidders;
      }else{
        return 'NoBids';
      }
    }

    public function checkBid($user_id){
      $sql = "SELECT * 
              FROM bids 
              INNER JOIN items
              ON items.item_id = bids.item_id
              WHERE bids.bidder_id ='$user_id' 
              AND items.item_status = ('A' OR 'S')
              ";
      $result = $this->conn->query($sql);

      if($result->num_rows > 0){
        $bidding = 'yes';
      }else{
        $bidding = 'no';
      }
      return $bidding;
    }



    public function getSales(){
      $user_id = $_SESSION['user_id'];
      $sales = 0;

      $sql = "SELECT current_price 
              FROM items 
              WHERE item_status = 'S'
              AND user_id = '$user_id'";
      $result = $this->conn->query($sql);
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          $sales += $row['current_price'];
        }
      }else{
        $sales = 0;
      }
      return $sales;
    }

    public function searchItems($item_name){
      $sql="SELECT * FROM items 
            INNER JOIN categories 
            ON items.category_id = categories.category_id
            WHERE item_name 
            LIKE '%$item_name%'";
      $result = $this->conn->query($sql);
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          $search[] = $row;
        }
      }else{
        return 'error';
      }
      return $search;
    }

    public function biddingItems(){
      $user_id = $_SESSION['user_id'];
      $sql = "SELECT DISTINCT item_id
              FROM bids
              WHERE bidder_id = '$user_id'
              ";
      $result = $this->conn->query($sql);
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          $bidding[] = $row;
        }
        return $bidding;
      }
      
    }

    public function getWinningItems(){
      $user_id = $_SESSION['user_id'];
      $sql = "SELECT * 
              FROM bids
              INNER JOIN items
              ON bids.item_id = items.item_id
              WHERE (bids.bid_price = items.current_price) 
              AND (items.item_status = 'S' OR items.item_status = 'SENT' OR items.item_status = 'RECEIVED') 
              AND (bids.bidder_id = '$user_id')
              ";
      $result = $this->conn->query($sql);
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          $winningBids[] = $row;
        }
        return $winningBids;
      }
    }

    public function dealStatus($item_id, $action){
      if($action == 'sent'){
        $operation = 'SENT';
      }elseif($action == 'received'){
        $operation = 'RECEIVED';
      }

      $sql = "UPDATE items
              SET item_status = '$operation'
              WHERE item_id = '$item_id'
              ";
      $result = $this->conn->query($sql);
      if($result){
        if($action == 'sent'){
          header('Location: ../seller.php?id='.$item_id);
          exit;
        }elseif($action == 'received'){
          header('Location: ../auction-winner.php?id='.$item_id);
          exit;
        }
      }else{
        if($action == 'sent'){
          header('Location: ../seller.php?result=error&id='.$item_id);
          exit;
        }elseif($action == 'received'){
          header('Location: ../auction-winner.php?result=error&id='.$item_id);
          exit;
        }
      }
    }

  }