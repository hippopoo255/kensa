<?php

namespace MyApp\Controller;

class Check_kigen extends \MyApp\Controller{
  protected $c_categoryModel;
  protected $itemModel;
  protected $i_categoryModel;
  protected $dateruleModel;
  protected $imageModel;
  protected $resultsModel;
  protected $totalModel;

  public function __construct(){
    $this->c_categoryModel = new \MyApp\Model\C_category();
    $this->itemModel = new \MyApp\Model\Item();
    $this->i_categoryModel = new \MyApp\Model\I_category();
    $this->dateruleModel = new \MyApp\Model\Daterule();
    $this->imageModel = new \MyApp\Controller\FileUpload();
    $this->resultsModel = new \MyApp\Model\Results_dc();
    $this->totalModel = new \MyApp\Model\Total();
  }

  public function run(){
    if(!$this->isLoggedIn()){
      header('location: ' . SITE_URL . '/login.php');
      exit;
    }
    // get category info
    $_SESSION['category'] = !isset($_SESSION['category']) ? $this->c_categoryModel->selectCategory(1) : $_SESSION['category'];
    $this->setMonth();
    $this->setValues('categories',$this->c_categoryModel->findAll());
    $this->setValues('dateRules',$this->dateruleModel->findAll());
    $this->setValues('items',$this->itemModel->findAll());
    $this->setValues('image1',$this->imageModel->getImages(1));
    $this->setValues('image2',$this->imageModel->getImages(2));
    $this->setValues('image3',$this->imageModel->getImages(3));

    try{
      $this->setValues('results',$this->resultsModel->getResults([
        'cateId'=>$_SESSION['category']->id,
        'storeId'=>$_SESSION['store']->id,
        'ytom'=>$_SESSION['datetime']->format('Y-m')
      ]));
    }catch(\Exception $e){
      $this->setErrors('results',$e->getMessage());
    }

    try{
      $this->setValues('total',$this->totalModel->getTotal([
        'tableName'=>$_SESSION['category']->tableName,
        'ytom'=>$_SESSION['datetime']->format('Y-m'),
        'storeId'=>$_SESSION['store']->id
      ]));
    }catch(\Exception $e){
      $this->setErrors('total',$e->getMessage());
    }
    if(isset($this->getValues()->total) ){
      $_SESSION['datetime'] = new \DateTime($this->getValues()->total->date);
    }
    if($_SERVER['REQUEST_METHOD']==='POST'){
      $this->postProcess();
      // ファイルをアップロードした場合
      if(isset($_FILES['image1']) || isset($_FILES['image2']) || isset($_FILES['image3'])){
        $this->postImageUploadProcess();
        if($this->hasError()){
          return;
        }
      }
      // Before1-3のゴミ箱を押した場合
      for($i = 1; $i < 4;$i++){
        if(isset($_POST['del-image'.$i])){
          $this->postImageDeleteProcess('image'.$i);
        }
      }

      // 追加ボタンを押した場合
      if(isset($_POST['insert'])){
          $this->postInsertProcess();
      }
      // JANを入力した場合
      if(isset($_POST['jan'])){
        $this->setValues('jan',h($_POST['jan']));
        try{
          $this->setValues('item',$this->itemModel->selectItem(h($_POST['jan'])));
        }catch(\Exception $e){
          $this->setErrors('item',$e->getMessage());
        }
        $name = isset($this->getValues()->item) ? $this->getValues()->item->name : $_POST['name'];
        $categoryCode = isset($this->getValues()->item) ? $this->getValues()->item->categoryCode : $_POST['categoryCode'];
        $categoryName = isset($this->getValues()->item) ? $this->getValues()->item->categoryName : $_POST['categoryName'];
        $this->setValues('name',$name);
        $this->setValues('categoryCode',$categoryCode);
        $this->setValues('categoryName',$categoryName);
        // 商品日付を入力した場合
        if(!empty($_POST['itemDate'])){
          if(!empty($this->getValues()->categoryCode)){
            $this->setValues('itemDate',h($_POST['itemDate']));
            try{
              $datePoints = $this->dateruleModel->getPoints($this->getValues()->categoryCode);
              $itemDateTime = strtotime(h($_POST['itemDate']));
              $this->setValues('tekkyoDate',date('Y-m-d',strtotime($datePoints->tekkyoPoint,$itemDateTime)));
              $this->setValues('kyoyasuDate',date('Y-m-d',strtotime($datePoints->kyoyasuPoint,$itemDateTime)));
              $this->setValues('nebikiDate',date('Y-m-d',strtotime($datePoints->nebikiPoint,$itemDateTime)));
              $dateTimes = [
              '要撤去'=>$this->getValues()->tekkyoDate,
              '驚安期間'=>$this->getValues()->kyoyasuDate,
              '値引期間'=>$this->getValues()->nebikiDate
              ];
              foreach($dateTimes as $key => $value){
                if($_SESSION['datetime']->format('Y-m-d') > $this->getValues()->itemDate){
                  $status = '期限切れ';
                  break;
                }
                if($value === '1970-01-01'){
                  continue;
                }
                // 検査日 > 各ルールに基づく起算日だったら
                if($_SESSION['datetime']->format('Y-m-d') > $value){
                  $status = $key;
                  break;
                }
              }
              $this->setValues('status',$status);
            }catch(\Exception $e){
              $this->setValues('dateRule',$e->getMessage());
            }
        }
        else{
          $this->setValues('itemDate',h($_POST['itemDate']));
        }
      }
      return;
    }
      // 検査項目を選択した場合
      if(isset($_POST['cateId'])){
        $_SESSION['category'] = $this->c_categoryModel->selectCategory($_POST['cateId']);
        $_SESSION['category']->name === '販売期限' ? header('location: ' . SITE_URL . '/check_kigen.php') : header('location: ' . SITE_URL . '/check.php') ;
        exit;
      }

      // 削除ボタンを押した場合
      if(isset($this->getValues()->results)){
        foreach($this->getValues()->results as $result){
          if(isset($_POST["delete-{$result->id}"])){
            if(!isset($_POST['token']) || $_POST['token']!==$_SESSION['token']){
              echo 'InvalidToken!';
              exit;
            }
            try{
              $this->resultsModel->delete($result->id);
              unlink($result->fname);
              unlink($result->fname2);
              unlink($result->fname3);
            }catch(\Exeption $e){
              $this->setErrors('results',$e->getMessage());
            }
          }
        }
        $this->updateTotal();
      }
      // 修正ボタンを押した場合
      if(isset($this->getValues()->results)){
        foreach($this->getValues()->results as $result){
          if(isset($_POST["modify-{$result->id}"])){
            if(!isset($_POST['token']) || $_POST['token']!==$_SESSION['token']){
              echo 'InvalidToken!';
              exit;
            }
            $_SESSION['re_id'] = $result->id;
            header('location: ' . SITE_URL . '/checkmodify_kigen.php');
            exit;
          }
        }
      }
      // 検査完了ボタンを押した場合
      if(isset($_POST['compbtn'])){
        if($this->getValues()->total->compFlag == 1){
          $this->unlockTotal();
        }
        elseif(empty(get_object_vars($this->getValues()->total))){
          $this->insertTotal();
          $this->updateTotal();
          $this->lockTotal();
        }
        else{
          $this->updateTotal();
          $this->lockTotal();
        }
      }

      // 検査日修正時
      if(isset($_POST['date'])){
          $_SESSION['datetime'] = new \DateTime(h($_POST['date']));
          if(isset($this->getValues()->total)){
            $this->updateTotal();
          }
      }
      header('location: ' . SITE_URL . '/check_kigen.php');
      exit;
    }
  }
  /*-----------------------------postProcess--------------------------------*/
  protected function postProcess(){
    if(!isset($_POST['token']) || $_POST['token']!==$_SESSION['token']){
      echo 'InvalidToken!';
      exit;
    }

  }
  /*--------------------------postImageUploadProcess()--------------------------------*/
  protected function postImageUploadProcess(){
    try{
        $this->imageModel->upload();
    }catch(\Exception $e){
        $this->setErrors('image',$e->getMessage());
    }
  }
  /*--------------------------postImageDeleteProcess()--------------------------------*/
  protected function postImageDeleteProcess($image){
    unlink($this->getValues()->$image);
    $this->setValues($image,'');
    header('location:' . SITE_URL .'/check_kigen.php');
    exit;
  }
  /*--------------------------postInsertProcess()--------------------------------*/
  //


  private function insertTotal(){
    $this->totalModel->insertTotal([
      'tableName'=>$_SESSION['category']->tableName,
      'ytom'=>$_SESSION['datetime']->format('Y-m'),
      'cateName'=>$_SESSION['category']->name,
      'storeId'=>$_SESSION['store']->id,
      'storeName'=>$_SESSION['store']->name,
      'shisyaId'=>$_SESSION['store']->shisyaId,
      'shisyaId'=>$_SESSION['store']->shisyaId,
      'shisyaName'=>$_SESSION['store']->shisyaName,
      'date'=>$_SESSION['datetime']->format('Y-m-d'),
      'userName'=>$_SESSION['me']->name
      ]);
  }

  private function updateTotal(){
    $this->totalModel->updateTotal([
      'tableName'=>$_SESSION['category']->tableName,
      'cateName'=>$_SESSION['category']->name,
      'storeId'=>$_SESSION['store']->id,
      'ytom'=>$_SESSION['datetime']->format('Y-m'),
      'date'=>$_SESSION['datetime']->format('Y-m-d')
    ]);
  }
  private function lockTotal(){
    $this->totalModel->lockTotal([
      'tableName'=>$_SESSION['category']->tableName,
      'storeId'=>$_SESSION['store']->id,
      'ytom'=>$_SESSION['datetime']->format('Y-m')
    ]);
  }
  private function unlockTotal(){
    $this->totalModel->unlockTotal([
      'tableName'=>$_SESSION['category']->tableName,
      'storeId'=>$_SESSION['store']->id,
      'ytom'=>$_SESSION['datetime']->format('Y-m')
    ]);
  }


/*---------------------------------------------------------------------------*/
  public function selectedCateId($cateId){
    if($cateId == $_SESSION['category']->id){
      $value = ' selected';
    }
    else{
      $value = '';
    }
    return $value;
  }

  public function hiddenByMonthOver(){
    $value = $_SESSION['datetime']->format('Y-m') == $this->getNow()->format('Y-m') ? ' hidden' : '' ;
    return $value;
  }
}
 ?>
