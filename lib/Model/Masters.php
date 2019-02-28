<?php
namespace MyApp\Model;

class Masters Extends \MyApp\Model {
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

  public function login($values){
    global $AES_KEY;
    $stmt = $this->db->prepare("select `id`,`name`,`duRank`,`depId`,`area`,`block`,`post`,CONVERT(AES_DECRYPT(UNHEX(`pass`),'{$AES_KEY}') using utf8) as password from m_user where id = :id");
    $stmt->bindValue(':id',$values['id']);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS,'stdClass');
    $user = $stmt->fetch();

    if(empty($user)){
      throw new \MyApp\Exception\UnmatchId();
    }
    if($values['password'] !== $user->password){
      throw new \MyApp\Exception\UnmatchPassword();
    }
    return $user;
  }

  public function getTableList(){
    $stmt = $this->db->query("show tables");
    // $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll(\PDO::FETCH_CLASS, 'stdClass');
  }

  public function findAll($masterName,$limit,$offset){
    $stmt = $this->db->prepare("select * from $masterName limit ? offset ?");
    $stmt->bindValue(1,$limit,\PDO::PARAM_INT);
    $stmt->bindValue(2,$offset,\PDO::PARAM_INT);
    $stmt->execute();
    // $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll(\PDO::FETCH_CLASS);
  }

  public function findColumns($masterName){
    $stmt = $this->db->prepare("show columns from $masterName");
    $stmt->execute();
    // $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll(\PDO::FETCH_CLASS);
  }

  public function CountRecords($masterName){
    $stmt = $this->db->query("select * from $masterName");
    return $stmt->rowCount();
  }

  public function delete($masterName,$uniqueKey,$id){
    $stmt = $this->db->prepare("delete from $masterName where $uniqueKey = ?");
    $stmt->execute([$id]);
  }
}
?>
