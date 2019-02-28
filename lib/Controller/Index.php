<?php

namespace MyApp\Controller;

class Index extends \MyApp\Controller {
  private $dashboards = [];

  public function run(){
    // loginしていなければ
    if(!$this->isLoggedIn()){
      // login処理
      header('location: ' . SITE_URL . '/login.php');
      exit;
    }

    // get users info
    $userModel = new \MyApp\Model\User();
    $this->setValues('users',$userModel->findAll());

    // get dashboards
    $c_categoryModel = new \MyApp\Model\C_category();
    $this->setValues('categories',$c_categoryModel->findAll());
    $totalModel = new \MyApp\Model\Total();
    foreach($this->getValues()->categories as $category){
      try{
        $this->dashboards[] = $totalModel->setDashboard([
          'tableName'=>$category->tableName,
          'ytom'=>$this->now->modify('-3 day')->format('Y-m')
        ]);
      }catch(\MyApp\Exception\DashboardNone $e){
         $this->seterrors('dashboard',$e->getMessage());
         return;
      }
    }
  }

  public function getDashboards(){
    return $this->dashboards;
  }
}
