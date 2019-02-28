<?php

namespace MyApp\Controller;

class Checkmodify_kigen extends \MyApp\Controller {
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
    // loginしていなければ
    if(!$this->isLoggedIn()){
      // login処理
      header('location: ' . SITE_URL . '/login.php');
      exit;
    }
    // get result info
    $this->setValues('result',$this->resultsModel->findById($_SESSION['re_id']));
    // set texts
    $this->setValues('janCode',$this->getValues()->result->janCode);
    $this->setValues('itemName',$this->getValues()->result->itemName);
    $this->setValues('categoryCode',$this->getValues()->result->categoryCode);
    $this->setValues('categoryName',$this->getValues()->result->categoryName);
    $this->setValues('itemDate',$this->getValues()->result->itemDate);
    $this->setValues('tekkyoDate',$this->getValues()->result->tekkyoDate);
    $this->setValues('kyoyasuDate',$this->getValues()->result->kyoyasuDate);
    $this->setValues('nebikiDate',$this->getValues()->result->nebikiDate);
    $this->setValues('status',$this->getValues()->result->status);
    $this->setValues('count',$this->getValues()->result->count);
    $this->setValues('memo',$this->getValues()->result->memo);
    // set images
    if(basename($_SERVER['HTTP_REFERER']) !== "checkmodify_kigen.php" ){
      if( $this->getValues()->result->fname !== ''){
        copy( $this->getValues()->result->fname, basename(IMAGES_DIR) . '/' . basename($this->getValues()->result->fname) );
      }
      if( $this->getValues()->result->fname2 !== ''){
        copy( $this->getValues()->result->fname2, basename(IMAGES_DIR) . '/' . basename($this->getValues()->result->fname2) );
      }
      if( $this->getValues()->result->fname3 !== ''){
        copy( $this->getValues()->result->fname3, basename(IMAGES_DIR) . '/' . basename($this->getValues()->result->fname3) );
      }
    }
    $image1 = $this->imageModel->getImages(1);
    $image2 = $this->imageModel->getImages(2);
    $image3 = $this->imageModel->getImages(3);
    $this->setValues('image1',$image1);
    $this->setValues('image2',$image2);
    $this->setValues('image3',$image3);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      // file upload
      if(isset($_FILES['image1']) || isset($_FILES['image2']) || isset($_FILES['image3'])){
        $this->postImageUploadProcess();
      }
      // modify_btn pushed
      if(isset($_POST['modify'])){
        $this->postModifyProcess($image1,$image2,$image3);
      }
      // cancel_btn pushed
      if(isset($_POST['cancel'])){
        if(strpos($image1,'images') === 0){unlink($image1);}
        if(strpos($image2,'images') === 0){unlink($image2);}
        if(strpos($image3,'images') === 0){unlink($image3);}
        header('location: ' . SITE_URL . '/check_kigen.php');
        exit;
      }
      // Before1-3のゴミ箱を押した場合
      for($i = 1; $i < 4;$i++){
        if(isset($_POST['del-image'.$i])){
          $this->postImageDeleteProcess('image'.$i);
        }
      }
      // input janCode
      if(isset($_POST['janCode'])){
        $this->postTextProcess();
      }
    }
  }

  /*--------------------------postImageUploadProcess()--------------------------------*/
  private function postImageUploadProcess(){
    try{
      $this->imageModel->upload();
    }catch(\Exception $e){
      $this->setErrors('image',$e->getMessage());
    }
    if($this->hasError()){
      return;
    }
    header('location: ' . SITE_URL .'/checkmodify_kigen.php');
    exit;
  }
  /*--------------------------postImageDeleteProcess--------------------------------*/
  protected function postImageDeleteProcess($image){
    unlink($this->getValues()->$image);
    $this->setValues($image,'');
    header('location:' . SITE_URL .'/checkmodify_kigen.php');
    exit;
  }
  /*--------------------------postModifyProcess()--------------------------------*/
  private function postModifyProcess($fname,$fname2,$fname3){
    unlink($this->getValues()->result->fname);
    $fname = $this->imageModel->_move($fname);
    unlink($this->getValues()->result->fname2);
    $fname2 = $this->imageModel->_move($fname2);
    unlink($this->getValues()->result->fname3);
    $fname3 = $this->imageModel->_move($fname3);
    $this->resultsModel->update([
      'janCode'=>h($_POST['janCode']),
      'itemName'=>h($_POST['itemName']),
      'categoryCode'=>h($_POST['categoryCode']),
      'categoryName'=>h($_POST['categoryName']),
      'itemDate'=>h($_POST['itemDate']),
      'nebikiDate'=>h($_POST['nebikiDate']),
      'kyoyasuDate'=>h($_POST['kyoyasuDate']),
      'tekkyoDate'=>h($_POST['tekkyoDate']),
      'status'=>h($_POST['status']),
      'count'=>h($_POST['count']),
      'memo'=>h($_POST['memo']),
      'userId'=>$_SESSION['me']->id,
      'userName'=>$_SESSION['me']->name,
      'fname'=>$fname,
      'fname2'=>$fname2,
      'fname3'=>$fname3,
      'ytom'=>$_SESSION['datetime']->format('Y-m'),
      'id'=>h($_POST['re_id'])
    ]);
    $this->updateTotal();
    header('location: ' . SITE_URL .'/check_kigen.php');
    exit;
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
  /*--------------------------postTextProcess()--------------------------------*/
  private function postTextProcess(){
    $this->setValues('janCode',h($_POST['janCode']));
    try{
      $this->setValues('item',$this->itemModel->selectItem(h($_POST['janCode'])));
    }catch(\Exception $e){
      $this->setErrors('item',$e->getMessage());
    }
    $name = isset($this->getValues()->item) ? $this->getValues()->item->name : $_POST['itemName'];
    $categoryCode = isset($this->getValues()->item) ? $this->getValues()->item->categoryCode : $_POST['categoryCode'];
    $categoryName = isset($this->getValues()->item) ? $this->getValues()->item->categoryName : $_POST['categoryName'];
    $this->setValues('itemName',$name);
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
}
