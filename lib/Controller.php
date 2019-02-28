<?php

namespace MyApp;

class Controller {
/*-------session--------
['me']:object(\MyApp\Model\User)->login($array('id'=>$_POST['id'],'password'=>$_POST['password']));
['token']:string
-----------------------*/
  protected $now;
  private $_errors;
  private $_values;
  public function __construct(){
    if(!isset($_SESSION['token'])){
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
    $this->_errors = new \stdClass();
    $this->_values = new \stdClass();
    $this->now = new \DateTime();
  }

  protected function setErrors($key,$error){
    $this->_errors->$key = $error;
  }

  public function getErrors($key){
    return isset($this->_errors->$key) ? $this->_errors->$key : '' ;
  }

  protected function hasError(){
    return !empty(get_object_vars($this->_errors)) ;
  }

  protected function setMonth(){
    $this->now = new \DateTime();
    $_SESSION['datetime'] = !isset($_SESSION['datetime']) ? $this->now : $_SESSION['datetime'];
    $_SESSION['datetime'] = isset($_POST['prev']) ? $_SESSION['datetime']->modify('-1 month') : $_SESSION['datetime'];
    $_SESSION['datetime'] = isset($_POST['next']) ? $_SESSION['datetime']->modify('+1 month') : $_SESSION['datetime'];
    $_SESSION['datetime'] = isset($_POST['this']) ? $this->now : $_SESSION['datetime'];
  }

  protected function setValues($key,$value){
    $this->_values->$key = $value;
  }

  public function getValues(){
    return $this->_values;
  }

  public function getNow(){
    // $this->now = new \DateTime();
    return $this->now;
  }

  protected function isLoggedIn(){
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
    //↑true OR false(要件: $_SESSION['me']がセットされていて、かつ空でない）
  }

  public function me(){
    return $this->isLoggedIn() ? $_SESSION['me'] : null ;
  }
  public function hiddenByIsLoggedIn(){
    return !$this->isLoggedIn() ? ' hidden' : '' ;
  }
  public function getRecordScreen()
  {
    return $_SESSION['category']->name === '販売期限' ? 'check_kigen.php' : 'check.php';
  }

  public function modify($s,$t)
  {
    if( strpos( getFileName(),'modify' ) ){
      return $s;
    }else{
      return $t;
    }
  }



}

 ?>
