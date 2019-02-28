<?php

namespace MyApp;

class Model{
  protected $db;

  public function __construct(){
    try{
      $this->db = new \PDO(DSN,DBUSER,DBPASS);
      // $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      $this->db->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    }catch(\PDOException $e){
      echo $e->getMessage();
      exit;
    }
  }
}




?>
