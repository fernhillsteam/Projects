<?php

include 'lib/Database.php';



class Website{


  // Db Property
  private $db;
  // Db __construct Method
  public function __construct(){
    $this->db = new Database();
  }

  
  // Select All Slider Images Method
  public function selectAllSliderImg(){
    $sql = "SELECT * FROM slider_images ORDER BY sl_no DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
  




}

