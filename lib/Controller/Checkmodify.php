<?php

namespace MyApp\Controller;

class Checkmodify extends \MyApp\Controller\Check {

  public function run(){
    // loginしていなければ
    if(!$this->isLoggedIn()){
      // login処理
      header('location: ' . SITE_URL . '/login.php');
      exit;
    }
    // get result info
    $this->setValues('result',$this->resultsModel->findById($_SESSION['re_id']));
    if($_SESSION['category']->name === '販売期限'){
      // set texts
      $this->setValues('jan',$this->getValues()->result->janCode);
      $this->setValues('name',$this->getValues()->result->itemName);
      $this->setValues('categoryCode',$this->getValues()->result->categoryCode);
      $this->setValues('categoryName',$this->getValues()->result->categoryName);
      $this->setValues('itemDate',$this->getValues()->result->itemDate);
      $this->setValues('tekkyoDate',$this->getValues()->result->tekkyoDate);
      $this->setValues('kyoyasuDate',$this->getValues()->result->kyoyasuDate);
      $this->setValues('nebikiDate',$this->getValues()->result->nebikiDate);
      $this->setValues('status',$this->getValues()->result->status);
      $this->setValues('count',$this->getValues()->result->count);
    }else{
      // set dropdownlist heads
      $this->setValues('heads',$this->c_headModel->findByCategory($this->getValues()->result->cateId));
      // set dropdownlist comments
      $this->setValues('head',$this->c_headModel->selectHead([
        'headNum'=>$this->getValues()->result->hNum,
        'cateId'=>$this->getValues()->result->cateId
      ]));
      $this->setValues('comments',$this->c_commentModel->findByHead([
        'headNum'=>$this->getValues()->head->num,
        'cateId'=>$_SESSION['category']->id
      ]));
    }
    $this->setValues('memo',$this->getValues()->result->memo);
    // set images
    if(basename($_SERVER['HTTP_REFERER']) !== "checkmodify.php" ){
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
      $this->postProcessOfChild($image1,$image2,$image3);
    }
  }

        private function postProcessOfChild($image1,$image2,$image3)
        {
            $this->postCommonProcess();

            // cancel_btn pushed
            if(isset($_POST['cancel'])){
              if(strpos($image1,'images') === 0){unlink($image1);}
              if(strpos($image2,'images') === 0){unlink($image2);}
              if(strpos($image3,'images') === 0){unlink($image3);}
              header('location: ' . SITE_URL . '/check.php');
              exit;
            }
      /*------------------販売期限専用---------------------*/
                if($_SESSION['category']->name === '販売期限'){
                  // modify_btn pushed
                  if(isset($_POST['modify'])){
                    $this->postDcModifyProcess($image1,$image2,$image3);
                  }
                  // input jan
                  if(isset($_POST['jan'])){
                    $this->postItemTextProcess();
                    return;
                  }
                }
      /*------------------販売期限以外---------------------*/
                else{
                  // modify_btn pushed
                  if(isset($_POST['modify'])){
                    $this->postModifyProcess($image1,$image2,$image3);
                  }
                  // select head
                  if(isset($_POST['headNum'])){
                    $this->postHeadProcess();
                    return;
                  }
                }
      /*---------------------------------------------------*/
          if($this->hasError()){
            return;
          }
          header('location:' . SITE_URL .'/checkmodify.php');
          exit;
        }

                /*--------------------------postDcModifyProcess()--------------------------------*/
                private function postDcModifyProcess($image1,$image2,$image3){
                  unlink($this->getValues()->result->fname);
                  $fname = $this->imageModel->_move($image1);
                  unlink($this->getValues()->result->fname2);
                  $fname2 = $this->imageModel->_move($image2);
                  unlink($this->getValues()->result->fname3);
                  $fname3 = $this->imageModel->_move($image3);
                  $this->resultsModel->update([
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
                    'userId'=>$_SESSION['me']->id,
                    'userName'=>$_SESSION['me']->name,
                    'fname'=>$fname,
                    'fname2'=>$fname2,
                    'fname3'=>$fname3,
                    'ytom'=>$_SESSION['datetime']->format('Y-m'),
                    'id'=>h($_POST['re_id'])
                  ]);
                  $this->updateTotal();
                  header('location: ' . SITE_URL .'/check.php');
                  exit;
                }

                /*--------------------------postModifyProcess()--------------------------------*/
                private function postModifyProcess($image1,$image2,$image3){
                  $this->setValues('head',$this->c_headModel->selectHead([
                    'headNum'=>$_POST['headNum'],
                    'cateId'=>$_SESSION['category']->id
                  ]));

                  unlink($this->getValues()->result->fname);
                  $fname = $this->imageModel->_move($image1);
                  unlink($this->getValues()->result->fname2);
                  $fname2 = $this->imageModel->_move($image2);
                  unlink($this->getValues()->result->fname3);
                  $fname3 = $this->imageModel->_move($image3);
                  $this->resultsModel->update([
                    'hNum'=>$this->getValues()->head->num,
                    'hline'=>$this->getValues()->head->hline,
                    'comment'=>h($_POST['comment']),
                    'memo'=>h($_POST['memo']),
                    'point'=>$this->getValues()->head->point,
                    'userId'=>$_SESSION['me']->id,
                    'userName'=>$_SESSION['me']->name,
                    'fname'=>$fname,
                    'fname2'=>$fname2,
                    'fname3'=>$fname3,
                    'ytom'=>$_SESSION['datetime']->format('Y-m'),
                    'id'=>h($_POST['re_id'])
                  ]);
                  $this->updateTotal();
                  header('location: ' . SITE_URL .'/check.php');
                  exit;
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

                  $this->setValues('memo',h($_POST['memo']));
                  return;
                }




}
