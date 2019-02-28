<?php

namespace MyApp\Controller;

class Check extends \MyApp\Controller{
  protected $c_categoryModel;
  protected $c_headModel;
  protected $c_commentModel;
  protected $imageModel;
  protected $resultsModel;
  protected $totalModel;
/*--------販売期限専用---------*/
  protected $itemModel;
  protected $i_categoryModel;
  protected $dateruleModel;
/*---------------------------*/
  public function __construct()
  {
    $this->c_categoryModel = new \MyApp\Model\C_category();
    $_SESSION['category'] = !isset($_SESSION['category']) ? $this->c_categoryModel->selectCategory(1) : $_SESSION['category'];
    $this->c_headModel = new \MyApp\Model\C_head();
    $this->c_commentModel = new \MyApp\Model\C_comment();
    $this->imageModel = new \MyApp\Controller\FileUpload();
    $this->resultsModel = $_SESSION['category']->name === '販売期限' ? new \MyApp\Model\Results_dc() : new \MyApp\Model\Results();
    $this->totalModel = new \MyApp\Model\Total();
    $this->itemModel = new \MyApp\Model\Item();
    $this->i_categoryModel = new \MyApp\Model\I_category();
    $this->dateruleModel = new \MyApp\Model\Daterule();
  }

  public function run()
  {

    if(!$this->isLoggedIn()){
      header('location: ' . SITE_URL . '/login.php');
      exit;
    }
    // get category info
    $_SESSION['category'] = !isset($_SESSION['category']) ? $this->c_categoryModel->selectCategory(1) : $_SESSION['category'];
    $this->setMonth();
    $this->setValues('categories',$this->c_categoryModel->findAll());
    $this->setValues('image1',$this->imageModel->getImages(1));
    $this->setValues('image2',$this->imageModel->getImages(2));
    $this->setValues('image3',$this->imageModel->getImages(3));
    if($_SESSION['category']->name === '販売期限'){
      $this->setValues('dateRules',$this->dateruleModel->findAll());
      $this->setValues('items',$this->itemModel->findAll());
    }
    else{
      $this->setValues('heads',$this->c_headModel->findByCategory($_SESSION['category']->id));
      $this->setValues('head',$this->c_headModel->selectHead([
        'headNum'=>1,
        'cateId'=>$_SESSION['category']->id
      ]));
      $this->setValues('comments',$this->c_commentModel->findByHead([
        'headNum'=>$this->getValues()->head->num,
        'cateId'=>$_SESSION['category']->id
      ]));
    }
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
    if(isset($this->getValues()->total)){
      $_SESSION['datetime'] = new \DateTime($this->getValues()->total->date);
    }

    if($_SERVER['REQUEST_METHOD']==='POST'){
      $this->postProcess();
    }
  }
  /*-------------------------------postProcess--------------------------------*/
    protected function postProcess()
    {
      // check.php/checkmodify.php共通
      $this->postCommonProcess();

      // 検査日修正時
      if(isset($_POST['date'])){
          $_SESSION['datetime'] = new \DateTime(h($_POST['date']));
          if(isset($this->getValues()->total)){
            $this->updateTotal();
          }
      }
      // 検査項目を選択した場合
      if(isset($_POST['cateId'])){
        $_SESSION['category'] = $this->c_categoryModel->selectCategory(h($_POST['cateId']));
        header('location: ' . SITE_URL . '/check.php');
        exit;
      }
      // 削除ボタンを押した場合
      if(isset($this->getValues()->results)){
        foreach($this->getValues()->results as $result){
          if(isset($_POST["delete-{$result->id}"])){
            try{
              $this->resultsModel->delete($result->id);
              unlink($result->fname);
              unlink($result->fname2);
              unlink($result->fname3);
            }catch(\Exeption $e){
              $this->setErrors('results',$e->getMessage());
            }
            $this->updateTotal();
          }
        }
      }
      // 修正ボタンを押した場合
      if(isset($this->getValues()->results)){
        foreach($this->getValues()->results as $result){
          if(isset($_POST["modify-{$result->id}"])){
            $_SESSION['re_id'] = $result->id;
            header('location: ' . SITE_URL . '/checkmodify.php');
            exit;
          }
        }
      }
      // 検査完了ボタンを押したとき
      if(isset($_POST['compbtn'])){
        if(!isset($this->getValues()->total)){
          $this->insertTotal();
          $this->updateTotal();
          $this->lockTotal();
        }
        elseif($this->getValues()->total->compFlag == 1){
          $this->unlockTotal();
        }
        else{
          $this->updateTotal();
          $this->lockTotal();
        }
        header('location: ' .SITE_URL.'/check.php');
        exit;
      }
      /*-------------------販売期限専用-------------------------*/
      if($_SESSION['category']->name==='販売期限'){
        // 追加ボタンを押した場合
        if(isset($_POST['insert'])){
          $this->postInsertDcProcess();
        }
        // JANを入力した場合
        if(isset($_POST['jan'])){
          $this->postItemTextProcess();
          return;
        }
      }
      /*-------------------販売期限以外-----------------------*/
      else{
        // 追加ボタンを押した場合
        if(isset($_POST['insert'])){
            $this->postInsertProcess();
        }
        // 設問番号を選択した場合
        if(isset($_POST['headNum'])){
          $this->postHeadProcess();
          return;
        }
      }
      /*--------------------------------------------------*/
      if($this->hasError()){
        return;
      }
      header('location: ' .SITE_URL.'/check.php');
      exit;
    }

        protected function postCommonProcess()
        {
          // CSRF対策
          if(!isset($_POST['token']) || $_POST['token']!==$_SESSION['token']){
            echo 'InvalidToken!';
            exit;
          }

          // ファイルをアップロードした場合
          if(isset($_FILES['image1']) || isset($_FILES['image2']) || isset($_FILES['image3'])){
            $this->postImageUploadProcess();
          }
          // Before1-afterのゴミ箱を押した場合
          for($i = 1; $i < 4;$i++){
            if(isset($_POST['del-image'.$i])){
              $this->postImageDeleteProcess('image'.$i);
            }
          }
        }

  /*--------------------------postImageUploadProcess()--------------------------------*/
  protected function postImageUploadProcess()
  {
    try{
        $this->imageModel->upload();
    }catch(\Exception $e){
        $this->setErrors('image',$e->getMessage());
    }
  }
  /*--------------------------postImageDeleteProcess()--------------------------------*/
  protected function postImageDeleteProcess($image)
  {
    unlink($this->getValues()->$image);
  }

/*--------------------------postInsertDcProcess()--------------------------------*/
  protected function postInsertDcProcess(){
      $fname = $this->imageModel->_move($this->getValues()->image1);
      $fname2 = $this->imageModel->_move($this->getValues()->image2);
      $fname3 = $this->imageModel->_move($this->getValues()->image3);
      $this->resultsModel->insert([
        'cateId'=>$_SESSION['category']->id,
        'category'=>$_SESSION['category']->name,
        'janCode'=>h($_POST['jan']),
        'itemName'=>h($_POST['name']),
        'categoryCode'=>h($_POST['categoryCode']),
        'categoryName'=>h($_POST['categoryName']),
        'itemDate'=>h($_POST['itemDate']),
        'nebikiDate'=>h($_POST['nebikiDate']),
        'kyoyasuDate'=>h($_POST['kyoyasuDate']),
        'tekkyoDate'=>h($_POST['tekkyoDate']),
        'status'=>h($_POST['status']),
        'count'=>h($_POST['count']),
        'memo'=>h($_POST['memo']),
        'storeId'=>$_SESSION['store']->id,
        'storeName'=>$_SESSION['store']->name,
        'shisyaId'=>$_SESSION['store']->shisyaId,
        'shisyaName'=>$_SESSION['store']->shisyaName,
        'userId'=>$_SESSION['me']->id,
        'userName'=>$_SESSION['me']->name,
        'fname'=>$fname,
        'fname2'=>$fname2,
        'fname3'=>$fname3,
        'ytom'=>$_SESSION['datetime']->format('Y-m')
      ]);
    if(empty(get_object_vars($this->getValues()->total))){
      $this->insertTotal();
    }
    $this->updateTotal();
    header('location: ' . SITE_URL .'/check.php');
    exit;
  }

  /*--------------------------postInsertProcess()--------------------------------*/
  protected function postInsertProcess()
  {
    $this->setValues('head',$this->c_headModel->selectHead([
      'headNum'=>$_POST['headNum'],
      'cateId'=>$_SESSION['category']->id
    ]));
    $fname = $this->imageModel->_move($this->getValues()->image1);
    $fname2 = $this->imageModel->_move($this->getValues()->image2);
    $fname3 = $this->imageModel->_move($this->getValues()->image3);
    $this->resultsModel->insert([
      'cateId'=>$_SESSION['category']->id,
      'category'=>$_SESSION['category']->name,
      'hNum'=>$this->getValues()->head->num,
      'hline'=>$this->getValues()->head->hline,
      'comment'=>h($_POST['comment']),
      'memo'=>h($_POST['memo']),
      'point'=>$this->getValues()->head->point,
      'storeId'=>$_SESSION['store']->id,
      'storeName'=>$_SESSION['store']->name,
      'shisyaId'=>$_SESSION['store']->shisyaId,
      'shisyaName'=>$_SESSION['store']->shisyaName,
      'userId'=>$_SESSION['me']->id,
      'userName'=>$_SESSION['me']->name,
      'fname'=>$fname,
      'fname2'=>$fname2,
      'fname3'=>$fname3,
      'ytom'=>$_SESSION['datetime']->format('Y-m')
    ]);
    if(empty(get_object_vars($this->getValues()->total))){
      $this->insertTotal();
    }
    $this->updateTotal();
    header('location: ' . SITE_URL .'/check.php');
    exit;
  }


/*---------------------------------------------------------------------------*/
  private function insertTotal()
  {
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
      return;
  }
// checkmodify.phpが継承するメソッド
  protected function updateTotal()
  {
    $this->totalModel->updateTotal([
      'tableName'=>$_SESSION['category']->tableName,
      'cateName'=>$_SESSION['category']->name,
      'storeId'=>$_SESSION['store']->id,
      'ytom'=>$_SESSION['datetime']->format('Y-m'),
      'date'=>$_SESSION['datetime']->format('Y-m-d')
    ]);
  }
  private function lockTotal()
  {
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

  /*--------------------------postItemTextProcess()--------------------------------*/
  protected function postItemTextProcess()
  {
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

  /*--------------------------postHeadProcess()--------------------------------*/
  private function postHeadProcess()
  {
    $this->setValues('head',$this->c_headModel->selectHead([
      'headNum'=>$_POST['headNum'],
      'cateId'=>$_SESSION['category']->id
    ]));
    $this->setValues('comments',$this->c_commentModel->findByHead([
      'headNum'=>$this->getValues()->head->num,
      'cateId'=>$_SESSION['category']->id
    ]));
    return;
  }


  public function selectedCateId($cateId)
  {
    if($cateId == $_SESSION['category']->id){
      $value = ' selected';
    }
    else{
      $value = '';
    }
    return $value;
  }

  public function selectedHeadNum($headNum)
  {
    if($headNum == $this->getValues()->head->num){
      $value = ' selected';
    }
    else{
      $value = '';
    }
    return $value;
  }
  public function hiddenByMonthOver()
  {
    $value = $_SESSION['datetime']->format('Y-m') == $this->getNow()->format('Y-m') ? ' hidden' : '' ;
    return $value;
  }
  public function selectedComment($comment){
    if(isset($this->getValues()->result)){
      if($comment === $this->getValues()->result->comment){
        $value = ' selected';
      }
    }
    else{
      $value = '';
    }
    return $value;
  }
}
 ?>
