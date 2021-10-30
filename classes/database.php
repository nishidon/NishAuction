<?php
  session_start();
  class Database {
    private $servername = "us-cdbr-east-04.cleardb.com";
    private $username = "b8f3e0a37ee93a";
    private $password = "af3a4c8d";
    private $database = "heroku_6498cd5b2e1898a";
    public $conn;

    public function __construct(){
      $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
      if($this->conn->error){
        die("Unable to connect to database".$this->database.":".$this->conn->connect_error);
      }
    }
  }
?>