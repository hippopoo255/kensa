<?php
namespace MyApp\Model;

class Store Extends \MyApp\Model {
  public function create($values){
    global $AES_KEY;
    $stmt = $this->db->prepare("insert into m_user (id,name,duRank,depId,area,block,post,pass) values (:id,:name,:duRank,:depId,:area,:block,:post,HEX(AES_ENCRYPT(:password,'{$AES_KEY}')))");
    $stmt->bindValue(':id',$values['id']);
    $stmt->bindValue(':name',$values['name']);
    $stmt->bindValue(':duRank',$values['duRank']);
    $stmt->bindValue(':depId',$values['depId']);
    $stmt->bindValue(':area',$values['area']);
    $stmt->bindValue(':block',$values['block']);
    $stmt->bindValue(':post',$values['post']);
    $stmt->bindValue(':password',$values['password']);
    $stmt->execute();

    if($res === false){
      throw new \MyApp\Exception\DuplicateId();
    }
  }

  public function selectStore($storeId){
    $stmt = $this->db->prepare("select * from m_store join (select id as shisyaId,name as shisyaName from m_shisya) as m_shisya on m_store.shisyaId = m_shisya.shisyaId where id = :id");
    $stmt->bindValue(':id',$storeId);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS,'stdClass');
    $store = $stmt->fetch();

    if(empty($store)){
      throw new \MyApp\Exception\UnmatchStoreId();
    }
    return $store;
  }

  function searchStore($searchWord){
    $stmt = $this->db->prepare("select * from m_store where id like ? or name like ?");
    $stmt->bindValue(1,$searchWord);
    $stmt->bindValue(2,$searchWord);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS,'stdClass');
    $stores = $stmt->fetchAll();
    if(empty($stores)){
      throw new \Exception('検索結果がありませんでした');
    }
    return $stores;
  }

  public function findAll(){
    $stmt = $this->db->query("select * from m_store order by id");
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }
}
?>
