<?php

namespace MyApp\Controller;

class Master extends \MyApp\Controller{
  protected $limit;
  protected $offset;
  protected $masterModel;
  protected $masterNames = [
    '検査カテゴリーマスター'=>'',
    '指摘内容マスター'=>'',
    '設問番号マスター'=>'',
    '失点マスター'=>'',
    '期限ルールマスター'=>'',
    '部署マスター'=>'',
    '本部マスター'=>'',
    '分類マスター'=>'',
    '商品マスター'=>'',
    '支社マスター'=>'',
    '店舗マスター'=>'',
    'ユーザーマスター'=>'',
  ];

  public function __construct(){
    $this->limit = 30;
    $this->masterModel = new \MyApp\Model\Masters();
    $tableList = $this->masterModel->getTableList();
    $i = 0;
    foreach($this->masterNames as $key=>$value){
      if(strpos($tableList[$i]->Tables_in_sample,'m_') !== 0){
        continue;
      }
      $this->masterNames[$key] = $tableList[$i]->Tables_in_sample;
      $i++;
      if($i > count($tableList)){
        break;
      }
    }
    $this->setValues('masterNames',$this->masterNames);
  }

  public function run(){
    if(!$this->isLoggedIn()){
      header('location: ' . SITE_URL . '/login.php');
      exit;
    }

    if($_SERVER['REQUEST_METHOD']==='POST'){
      $this->postProcess();
    }

    $_SESSION['masterName'] = !isset($_SESSION['masterName']) ? $this->getValues()->masterNames['検査カテゴリーマスター'] : $_SESSION['masterName'];
    $page = isset($_GET['p']) && preg_match('/^[1-9][0-9]*$/', $_GET['p']) && $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['p'] : 1 ;
    $this->setValues('page',$page);
    $this->offset = ($page - 1) * $this->limit;
    $this->setValues('master',$this->masterModel->findAll($_SESSION['masterName'],$this->limit,$this->offset));
    $this->setValues('columns',$this->masterModel->findColumns($_SESSION['masterName']));
    $this->setValues('totalArticles',$this->masterModel->CountRecords($_SESSION['masterName']));
    $this->setValues('totalPages',ceil($this->getValues()->totalArticles / $this->limit));
    $this->setValues('from',$this->offset + 1);
    $to = $this->offset + $this->limit ;
    if($to > $this->getValues()->totalArticles){
      $to = $this->getValues()->totalArticles;
    }
    $this->setValues('to',$to);
  }

/*-------------------------------postProcess--------------------------------*/
  protected function postProcess(){
    if(!isset($_POST['token']) || $_POST['token']!==$_SESSION['token']){
      echo 'InvalidToken!';
      exit;
    }
    $_SESSION['masterName'] = h($_POST['masterName']);
    $this->setValues('page',1);
    $this->setValues('columns',$this->masterModel->findColumns($_SESSION['masterName']));
    $this->setValues('master',$this->masterModel->findAll($_SESSION['masterName'],$this->limit,$this->offset));
    $uniqueKey = $this->getUniqueKey();
    // 修正ボタンを押した場合
    foreach($this->getValues()->master as $record){
      if(isset($_POST["modify-{$record->$uniqueKey}"])){
        $_SESSION['re_id'] = $record->$uniqueKey;
        header('location: ' . SITE_URL . '/mastermodify.php');
        exit;
      }
    }
    // 削除ボタンを押した場合
    if(isset($_POST['delete'])){
      foreach($this->getValues()->master as $record){
        if(isset($_POST["del-{$record->$uniqueKey}"])){
          $id = $record->$uniqueKey;
          $this->masterModel->delete($_SESSION['masterName'],$uniqueKey,$id);
        }
      }
      header('location: ' . SITE_URL . '/master.php');
      exit;
    }
  }

  public function selectedMaster($value){
    return $value === $_SESSION['masterName'] ? ' selected' : '' ;
  }
  public function getUniqueKey(){
    return $this->getValues()->columns[0]->Field;
  }
  public function getPrevHidden(){
    return $this->getValues()->page == 1 ? 'hidden' : '';
  }
  public function getNextHidden(){
    return $this->getValues()->totalPages == $this->getValues()->page ? 'hidden' : '';
  }
  public function getCurrent($value){
    return $value == $this->getValues()->page ? ' current' : '';
  }

}
 ?>
