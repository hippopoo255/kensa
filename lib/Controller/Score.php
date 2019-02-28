<?php

namespace MyApp\Controller;

class Score extends \MyApp\Controller{
  protected $c_categoryModel;
  protected $c_headModel;
  protected $c_commentModel;
  protected $imageModel;
  protected $resultsModel;
  protected $totalModel;

  public function __construct(){
    $this->c_categoryModel = new \MyApp\Model\C_category();
    $this->c_headModel = new \MyApp\Model\C_head();
    $this->c_commentModel = new \MyApp\Model\C_comment();
    $this->imageModel = new \MyApp\Controller\FileUpload();
    $this->resultsModel = new \MyApp\Model\Results();
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
    $this->setValues('heads',$this->c_headModel->findByCategory($_SESSION['category']->id));

    try{
      $this->setValues('total',$this->totalModel->getTotal([
        'tableName'=>$_SESSION['category']->tableName,
        'ytom'=>$_SESSION['datetime']->format('Y-m'),
        'storeId'=>$_SESSION['store']->id
      ]));

      foreach($this->getValues()->total as $key=>$value){
        if($_SESSION['category']->name !== '販売期限'){
          if(strpos($key,'judge') === 0){
            $judge[] = $value;
          }
          if(strpos($key,'count') === 0){
            $count[] = $value;
          }
        }else{
          if(strpos($key,'item') === 0){
            $item[] = $value;
          }
          if(strpos($key,'count') === 0){
            $count[] = $value;
          }
        }
      }

      $this->setValues('count',$count);
      if($_SESSION['category']->name !== '販売期限'){
        $this->setValues('judge',$judge);
      }else{
        $this->setValues('item',$item);
        $this->setValues('status',['期限切れ','未撤去','驚安期間','値引期間']);
      }

    }catch(\Exception $e){
      $this->setErrors('total',$e->getMessage());
    }

    if($_SERVER['REQUEST_METHOD']==='POST'){
      $this->postProcess();
    }
  }

/*---------------------------------------------------------------------------*/

/*-------------------------------postProcess--------------------------------*/
  protected function postProcess(){
    if(!isset($_POST['token']) || $_POST['token']!==$_SESSION['token']){
      echo 'InvalidToken!';
      exit;
    }
    // 検査項目を選択した場合
    if(isset($_POST['cateId'])){
      $_SESSION['category'] = $this->c_categoryModel->selectCategory(h($_POST['cateId']));
      header('location: ' .SITE_URL.'/score.php');
      exit;
    }
    // Backを押した場合
    if(isset($_POST['back'])){
      header('location: ' .SITE_URL.'/check.php');
      exit;
    }
    header('location: ' .SITE_URL.'/score.php');
    exit;
  }

  public function selectedCateId($cateId){
    if($cateId == $_SESSION['category']->id){
      $value = ' selected';
    }
    else{
      $value = '';
    }
    return $value;
  }

  public function selectedHeadNum($headNum){
    if($headNum == $this->getValues()->head->num){
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
  public function totalView()
  {
    if($_SESSION['category']->name !== '販売期限'){
      echo '<tr><th>No</th><th>項目</th><th>判定</th><th>指摘数</th></tr>';
      for($i = 0; $i < count($this->getValues()->judge); $i++ ){
        $no = $i + 1;
        echo '<tr><td>' . $no . '</td><td>' . $this->getValues()->heads[$i]->hline .
        '</td><td class="judge">' . $this->getValues()->judge[$i] . '</td><td>' .
        $this->getValues()->count[$i] .
        '</td></tr>';
      }
    }else{
      echo '<tr><th>No</th><th>状態</th><th>アイテム数</th><th>個数</th></tr>';
      for($i = 0; $i < count($this->getValues()->status); $i++ ){
        $no = $i + 1;
        echo '<tr><td>' . $no . '</td><td>' . $this->getValues()->status[$i] .
        '</td><td>' . $this->getValues()->item[$i] . '</td><td>' .
        $this->getValues()->count[$i] .
        '</td></tr>';
      }
    }
  }

}
 ?>
