<?php
namespace MyApp\Model;

class Daterule Extends \MyApp\Model {

  public function getPoints($code){
    $stmt = $this->db->prepare("select nebikiPoint,kyoyasuPoint,tekkyoPoint from m_daterule where categoryCode = :categoryCode");
    $stmt->execute([':categoryCode'=>$code]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS,'stdClass');
    $points = $stmt->fetch();
    if(empty($points)){
      throw new \Exception('値引きルールに登録されていない分類コードです');
    }
    return $points;
  }

  public function findAll(){
    $stmt = $this->db->prepare("select * from m_daterule join (select code,name as categoryName from m_i_cate) as m_i_cate on m_i_cate.code = m_daterule.categoryCode order by id");
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }


}

?>
