<?php
  session_start();
  class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "root";
    private $database = "Nish Auction";
    public $conn;

    public function __construct(){
      $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
      if($this->conn->error){
        die("Unable to connect to database".$this->database.":".$this->conn->connect_error);
      }
    }
  }
?>