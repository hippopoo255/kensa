<?php
namespace MyApp\Model;

class C_head Extends \MyApp\Model {
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

  public function selectHead($value){
    $stmt = $this->db->prepare("select * from m_c_head join (select rank as rankfrompoint,point from m_c_point) as m_c_point on m_c_point.rankfrompoint = m_c_head.rank where num = :num and cateId = :cateId");
    $stmt->bindValue(':num',$value['headNum']);
    $stmt->bindValue(':cateId',$value['cateId']);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS,'stdClass');
    $head = $stmt->fetch();
    return $head;
  }

  public function findByCategory($value){
    $stmt = $this->db->prepare("select * from m_c_head where cateId = :id order by num");
    $stmt->bindValue(':id',$value);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS,'stdClass');
    $heads = $stmt->fetchAll();
    return $heads;
  }

  public function findAll(){
    $stmt = $this->db->prepare("select * from m_c_head order by id");
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }


}

?>
