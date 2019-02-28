<?php

namespace MyApp\Controller;

class SelectStore extends \MyApp\Controller{

  public function run(){

    if(!$this->isLoggedIn()){
      header('location: ' . SITE_URL . '/login.php');
      exit;
    }
      // get stores info
    $storeModel = new \MyApp\Model\Store();
    $this->setValues('stores', $storeModel->findAll());
    if(isset($_SESSION['datetime'])){$this->setValues('date',$_SESSION['datetime']->format('Y-m-d'));}
    if($_SERVER['REQUEST_METHOD']==='POST'){
      if(isset($_POST['storeSearch'])){
        if(!isset($_POST['token']) || $_POST['token']!==$_SESSION['token']){
          echo 'InvalidToken!';
          exit;
        }
        else{
          try{
            $this->setValues('searchWord', h($_POST['searchWord']));
            $searchWord = '%'.h($_POST['searchWord']).'%';
            $stores = $storeModel->searchStore($searchWord);
            $this->setValues('stores', $stores);
          }catch(\Exception $e){
            $this->setErrors('searchStore',$e->getMessage());
            return;
          }
        }
      }
      else{
        $this->postProcess();
      }
    }
  }

  protected function postProcess(){
    // validation
    try{
      $this->_validate(); //if(!preg_match){throw new \MyApp\Exception\invalidId() OR invalidPassword();}
    } catch(\MyApp\Exception\EmptyPost $e){
        $this->setErrors('storeId',$e->getMessage());
    } catch(\MyApp\Exception\InvalidStoreId $e){
        $this->setErrors('storeId',$e->getMessage());
    }

    $this->setValues('storeId',h($_POST['storeId']));
    $this->setValues('date',h($_POST['date']));

    if($this->hasError()){
      return;
    }
    else{
       try{
         $storeModel = new \MyApp\Model\Store();
         $store = $storeModel->selectStore($_POST['storeId']);
       }catch(\MyApp\Exception\UnmatchStoreId $e){
            $this->seterrors('selectStore',$e->getMessage());
            return;
        }
        // storeのsession処理
        session_regenerate_id(true);
        $_SESSION['store'] = $store;
        $_SESSION['datetime'] = new \DateTime(h($_POST['date']));
        // storeのsession処理
        header('location: ' . SITE_URL .'/check.php');
        exit;
    }
  }

  private function _validate(){
    if(!isset($_POST['token']) || $_POST['token']!==$_POST['token']){
      echo 'InvalidToken!';
      exit;
    }
    if(!isset($_POST['storeId'])){
      echo 'InvalidForm!';
      exit;
    }
    if($_POST['storeId'] === ''){
      throw new \MyApp\Exception\EmptyPost();
      exit;
    }
    if(preg_match('/[^0-9]+/',$_POST['storeId'])){
      throw new \MyApp\Exception\InvalidStoreId();
      exit;
    }
  }
}
 ?>
