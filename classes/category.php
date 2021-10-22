<?php
  require_once "database.php";
  class Category extends Database{
    public function CreateCat($category_name){

      $sql = "SELECT * FROM categories WHERE category_name = '$category_name'";
      $result = $this->conn->query($sql);

      if ($result->num_rows < 1) {
        $sql = "INSERT INTO categories(category_name) VALUES('$category_name')";
        $result = $this->conn->query($sql);
        if($result){
          header('Location: ../categories.php');
          exit;
          // success("The new category, $category_name, is now available");
        }else{
          header('Location: ../categories.php');
          exit;
        }
      }else{
        header('Location: ../categories.php?error=duplicate?name='.$category_name);
        exit;
      }
    }

    public function getCat(){
      $sql = "SELECT * FROM categories";
      $result = $this->conn->query($sql);
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          $catList[] = $row;
        }
        return $catList;
      }else{
        die($this->conn->error);
      }
    }

    public function getOneCat($id){
      $sql = "SELECT * FROM categories WHERE category_id = '$id'";
      $result = $this->conn->query($sql);
      if($result->num_rows == 1){
        $row = $result->fetch_assoc();
      }
      return $row;
    }

    public function deleteCat($id){
      $sql = "DELETE FROM categories WHERE category_id = '$id'";
      $result = $this->conn->query($sql);
      if($result){
        header('Location: ../categories.php');
        exit;
      }else{
        header('Location: ../categories.php?error=fail');
        exit;
      }
    }

    public function editCat($catName, $catId){
      $sql = "UPDATE categories
              SET category_name = '$catName'
              WHERE category_id = '$catId'
            ";
      $result = $this->conn->query($sql);

      if($result){
        header("Location: ../categories.php");
        exit;
      }else{
        header('Location: ../categories.php?error=fail');
        exit;
      }
    }

    
  }

?>