<?php
namespace MyApp\Model;

class Item Extends \MyApp\Model {
  // public function create($values){
  //   global $AES_KEY;
  //   $stmt = $this->db->prepare("insert into m_user (id,name,duRank,depId,area,block,post,pass) values (:id,:name,:duRank,:depId,:area,:block,:post,HEX(AES_ENCRYPT(:password,'{$AES_KEY}')))");
  //   $stmt->bindValue(':id',$values['id']);
  //   $stmt->bindValue(':name',$values['name']);
  //   $stmt->bindValue(':duRank',$values['duRank']);
  //   $stmt->bindValue(':depId',$values['depId']);
  //   $stmt->bindValue(':area',$values['area']);
  //   $stmt->bindValue(':block',$values['block']);
  //   $stmt->bindValue(':post',$values['post']);
  //   $stmt->bindValue(':password',$values['password']);
  //   $stmt->execute();
  //
  //   if($res === false){
  //     throw new \MyApp\Exception\DuplicateId();
  //   }
  // }

  public function selectItem($value){
    $stmt = $this->db->prepare("select janCode,m_item.name,categoryCode,m_i_cate.name as categoryName from m_item join m_i_cate on m_item.categoryCode = m_i_cate.code where janCode = :jan");
    $stmt->execute([':jan'=>$value]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS,'stdClass');
    $item = $stmt->fetch();
    if(empty($item)){
      throw new \Exception('Not Entried Itemlist...');
    }
    return $item;
  }

  public function findAll(){
    $stmt = $this->db->prepare("select * from m_item order by janCode");
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }


}

?>
