<?php

namespace MyApp\Controller;

class Login extends \MyApp\Controller{

  public function run(){
    
    // loginしていれば
    if($this->isLoggedIn()){
      // login処理
      header('location: ' . SITE_URL);
      exit;

      // get users info
      $userModel = new \MyApp\Model\User();
      $this->setValues('users', $userModel->findAll());
    }

    if($_SERVER['REQUEST_METHOD']==='POST'){
        $this->postProcess();
    }
  }

  protected function postProcess(){

    // validation
    try{
      $this->_validate(); //if(!preg_match){throw new \MyApp\Exception\invalidId() OR invalidPassword();}
    } catch(\MyApp\Exception\EmptyPost $e){
        $this->setErrors('login',$e->getMessage());
    } catch(\MyApp\Exception\InvalidId $e){
        $this->setErrors('login',$e->getMessage());
    }

    $this->setValues('id',h($_POST['id']));

    if($this->hasError()){
      return;
    }
    else{
       try{
         $userModel = new \MyApp\Model\User();
         $user = $userModel->login([
           'id'=>$_POST['id'],
           'password'=>$_POST['password']
         ]);
         }catch(\MyApp\Exception\UnmatchId $e){
            $this->seterrors('login',$e->getMessage());
            return;
         }catch(\MyApp\Exception\UnmatchPassword $e){
            $this->seterrors('login',$e->getMessage());
            return;
         }
        // login処理
        session_regenerate_id(true);
        $_SESSION['me'] = $user;

        // redirection
       header('location: ' . SITE_URL );
       exit;
    }
  }

  private function _validate(){
    if(!isset($_SESSION['token']) || $_POST['token']!==$_SESSION['token']){
      echo 'InvalidToken!';
      exit;
    }
    if(!isset($_POST['id']) || !isset($_POST['password'])){
      echo 'InvalidForm!';
      exit;
    }
    if($_POST['id'] === '' || $_POST['password'] === ''){
      throw new \MyApp\Exception\EmptyPost();
      exit;
    }
    if(!preg_match('/[0-9]{7}/',$_POST['id'])){
      throw new \MyApp\Exception\InvalidId();
      exit;
    }
  }
}
 ?>
