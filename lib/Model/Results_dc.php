<?php
namespace MyApp\Model;

class Results_dc Extends \MyApp\Model {
  public function insert($values){
    $stmt = $this->db->prepare("insert into t_results_dc (cateId,category,janCode,itemName,categoryCode,categoryName,itemDate,nebikiDate,kyoyasuDate,tekkyoDate,status,count,memo,storeId,storeName,shisyaId,shisyaName,userId,userName,fname,fname2,fname3,ytom) values (:cateId,:category,:janCode,:itemName,:categoryCode,:categoryName,:itemDate,:nebikiDate,:kyoyasuDate,:tekkyoDate,:status,:count,:memo,:storeId,:storeName,:shisyaId,:shisyaName,:userId,:userName,:fname,:fname2,:fname3,:ytom)");
    $stmt->bindValue(':cateId',$values['cateId']);
    $stmt->bindValue(':category',$values['category']);
    $stmt->bindValue(':janCode',$values['janCode']);
    $stmt->bindValue(':itemName',$values['itemName']);
    $stmt->bindValue(':categoryCode',$values['categoryCode']);
    $stmt->bindValue(':categoryName',$values['categoryName']);
    $stmt->bindValue(':itemDate',$values['itemDate']);
    $stmt->bindValue(':nebikiDate',$values['nebikiDate']);
    $stmt->bindValue(':kyoyasuDate',$values['kyoyasuDate']);
    $stmt->bindValue(':tekkyoDate',$values['tekkyoDate']);
    $stmt->bindValue(':status',$values['status']);
    $stmt->bindValue(':count',$values['count']);
    $stmt->bindValue(':memo',$values['memo']);
    $stmt->bindValue(':storeId',$values['storeId']);
    $stmt->bindValue(':storeName',$values['storeName']);
    $stmt->bindValue(':shisyaId',$values['shisyaId']);
    $stmt->bindValue(':shisyaName',$values['shisyaName']);
    $stmt->bindValue(':userId',$values['userId']);
    $stmt->bindValue(':userName',$values['userName']);
    $stmt->bindValue(':fname',$values['fname']);
    $stmt->bindValue(':fname2',$values['fname2']);
    $stmt->bindValue(':fname3',$values['fname3']);
    $stmt->bindValue(':ytom',$values['ytom']);
    $stmt->execute();
  }

  public function update($values){
    $stmt = $this->db->prepare("update t_results_dc set janCode = :janCode, itemName = :itemName, categoryCode = :categoryCode, categoryName = :categoryName, itemDate = :itemDate, nebikiDate = :nebikiDate, kyoyasuDate = :kyoyasuDate, tekkyoDate = :tekkyoDate, status = :status, count = :count, memo = :memo, userId = :userId, userName = :userName,fname = :fname, fname2 = :fname2, fname3 = :fname3, ytom = :ytom where id = :id");
    $stmt->bindValue(':janCode',$values['janCode']);
    $stmt->bindValue(':itemName',$values['itemName']);
    $stmt->bindValue(':categoryCode',$values['categoryCode']);
    $stmt->bindValue(':categoryName',$values['categoryName']);
    $stmt->bindValue(':itemDate',$values['itemDate']);
    $stmt->bindValue(':nebikiDate',$values['nebikiDate']);
    $stmt->bindValue(':kyoyasuDate',$values['kyoyasuDate']);
    $stmt->bindValue(':tekkyoDate',$values['tekkyoDate']);
    $stmt->bindValue(':status',$values['status']);
    $stmt->bindValue(':count',$values['count']);
    $stmt->bindValue(':memo',$values['memo']);
    $stmt->bindValue(':userId',$values['userId']);
    $stmt->bindValue(':userName',$values['userName']);
    $stmt->bindValue(':fname',$values['fname']);
    $stmt->bindValue(':fname2',$values['fname2']);
    $stmt->bindValue(':fname3',$values['fname3']);
    $stmt->bindValue(':ytom',$values['ytom']);
    $stmt->bindValue(':id',$values['id']);
    $stmt->execute();
  }

  function getResults($values){
    $stmt = $this->db->prepare("select * from t_results_dc where cateId = :cateId and storeId = :storeId and ytom = :ytom");
    $stmt->bindValue(':cateId',$values['cateId']);
    $stmt->bindValue(':storeId',$values['storeId']);
    $stmt->bindValue(':ytom',$values['ytom']);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS,'stdClass');
    $results = $stmt->fetchAll();
    if(empty($results)){
      throw new \Exception('指摘事項はありません');
    }
    return $results;
  }
  function getSortResults($values,$desc){
    $stmt = $this->db->prepare("select * from t_results where cateId = :cateId and storeId = :storeId and date_format(`datetime`,'%Y-%m') = :ytom order by :key{$desc}");
    $stmt->bindValue(':cateId',$values['cateId']);
    $stmt->bindValue(':storeId',$values['storeId']);
    $stmt->bindValue(':ytom',$values['ytom']);
    $stmt->bindValue(':key',$values['key']);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS,'stdClass');
    $results = $stmt->fetchAll();
    if(empty($results)){
      throw new \Exception('指摘事項はありません');
    }
    return $results;
  }

  public function findAll(){
    $stmt = $this->db->query("select * from t_results_dc order by id");
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }

  public function delete($id){
    $stmt = $this->db->prepare("delete from t_results_dc where id = :id");
    $res = $stmt->execute([':id'=>$id]);
    if($res === false){
      throw new \Exception('削除がうまくいきませんでした');
    }
  }

  public function findById($id){
    $stmt = $this->db->prepare("select * from t_results_dc where id = :id");
    $stmt->execute([':id'=>$id]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS,'stdClass');
    $result = $stmt->fetch();
    return $result;
  }
}

?>
