<?php
namespace MyApp\Model;

class Total Extends \MyApp\Model {

  public function getTotal($values){
    $stmt = $this->db->prepare("select * from ".$values['tableName']." where ytom = ? and storeId = ?");
    $stmt->bindValue(1,$values['ytom']);
    $stmt->bindValue(2,$values['storeId']);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS,'stdClass');
    $result = $stmt->fetch();
    if(empty($result)){
      throw new \Exception('total none!');
    }
    return $result;
  }
  private function getHeads($cateName){
    $stmt = $this->db->prepare("select * from m_c_head inner join m_c_cate on m_c_cate.id = m_c_head.cateId where m_c_cate.name = ?");
    $stmt->bindValue(1,$cateName);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS,'stdClass');
    $result = $stmt->fetchAll();
    return $result;
  }

  private function getGroupedResults($values){
    switch($values['cateName']){
      case '販売期限':
        $stmt = $this->db->prepare("select status,count(id),sum(count) from t_results_dc where storeId = ? and ytom = ? group by status");
        $stmt->bindValue(1,$values['storeId']);
        $stmt->bindValue(2,$values['ytom']);
        $stmt->execute();
      break;
      default:
        $stmt = $this->db->prepare("select hNum,sum(point),count(id),sum(mikaizenflag) from (select id,hNum,point,case when fname3 = '' then 1 else 0 end as mikaizenflag from t_results where category = ? and storeId = ? and ytom = ?) as addflag group by hNum");
        $stmt->bindValue(1,$values['cateName']);
        $stmt->bindValue(2,$values['storeId']);
        $stmt->bindValue(3,$values['ytom']);
        $stmt->execute();
      break;
    }
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
  }

  public function insertTotal($values){
    // 新規レコードの追加(失点、指摘数、判定以外)
    $stmt = $this->db->prepare("insert into ".$values['tableName']." (ytom,cateName,storeId,storeName,shisyaId,shisyaName,date,userName) values(?,?,?,?,?,?,?,?)");
    $stmt->bindValue(1,$values['ytom']);
    $stmt->bindValue(2,$values['cateName']);
    $stmt->bindValue(3,$values['storeId']);
    $stmt->bindValue(4,$values['storeName']);
    $stmt->bindValue(5,$values['shisyaId']);
    $stmt->bindValue(6,$values['shisyaName']);
    $stmt->bindValue(7,$values['date']);
    $stmt->bindValue(8,$values['userName']);
    $stmt->execute();
  }
    // 上記レコードの指摘数、点数を更新($values=tableName,cateName,storeId,ytom)
  public function updateTotal($values){
    $total = $this->getGroupedResults([
      'storeId'=>$values['storeId'],
      'ytom'=>$values['ytom'],
      'cateName'=>$values['cateName']
      ]);
    switch($values['cateName']){
    case '販売期限':
      //合計アイテム数、個数を更新
      for($i = 0;$i < count($total);$i++){
        $totalItem += $total[$i]["count(id)"];
        $totalCount += $total[$i]["sum(count)"];
      }
        $stmt = $this->db->prepare("update ".$values['tableName']." set totalItem = ?,totalCount = ?,date = ? where ytom = ? and storeId = ?");
        $stmt->bindValue(1,$totalItem);
        $stmt->bindValue(2,$totalCount);
        $stmt->bindValue(3,$values['date']);
        $stmt->bindValue(4,$values['ytom']);
        $stmt->bindValue(5,$values['storeId']);
        $stmt->execute();

      // 各カラム名、各カラムごとの値を更新
        $statusFromTotal = [];
        $columnNames = ['item_nebiki','count_nebiki','item_kire','count_kire','item_tekkyo','count_tekkyo','item_kyoyasu','count_kyoyasu'];
        $columnValues = [];
        $allstatus = ['値引期間','期限切れ','要撤去','驚安期間'];
        for($i = 0;$i < count($total);$i++){
          $statusFromTotal[] =  empty($total) ? '0' : $total[$i]["status"];
        }
        foreach($allstatus as $column=>$value){
          for($i = 0;$i < count($total);$i++){
            if($value == $total[$i]["status"]){
            $columnValues[] = $total[$i]["count(id)"];
            $columnValues[] = $total[$i]["sum(count)"];
            break;
            }
          }
          if(!in_array($value,$statusFromTotal)){
              $columnValues[] = "0";
              $columnValues[] = "0";
          }
        }
        /*------上記配列を繰り返し処理で該当のカラムにセット------*/
        for($i = 0;$i < count($columnNames);$i++){
          $stmt = $this->db->prepare("update ".$values['tableName']." set ".$columnNames[$i]." = ? where ytom = ? and storeId = ?");
          $stmt->bindValue(1,$columnValues[$i]);
          $stmt->bindValue(2,$values['ytom']);
          $stmt->bindValue(3,$values['storeId']);
          $stmt->execute();
        }
    break;
    default:
    $totalPoint = '';
    $totalCount = '';
      // 合計点、総指摘数を更新
      if(empty($total)){
        for($i = 0;$i < count($total);$i++){
          $totalPoint += $total[$i]["sum(point)"];
          $totalCount += $total[$i]["count(id)"];
        }
      }else{
        $totalPoint = 0;
        $totalCount = 0;
      }

        $stmt = $this->db->prepare("update ".$values['tableName']." set totalPoint = ?,totalCount = ?, date = ? where ytom = ? and storeId = ?");
        $stmt->bindValue(1,$totalPoint,\PDO::PARAM_INT);
        $stmt->bindValue(2,$totalCount,\PDO::PARAM_INT);
        $stmt->bindValue(3,$values['date']);
        $stmt->bindValue(4,$values['ytom']);
        $stmt->bindValue(5,$values['storeId']);
        $stmt->execute();

    // 各判定、各指摘数を更新
      /*------検査の判定と指摘数を設問数だけ配列化------*/
      $numFromTotal = [];
      $judgeColumn = [];
      $countColumn = [];
      $judge = [];
      $counts = [];
      for($i = 0;$i < count($total);$i++){
        $numFromTotal[] = empty($total) ? '0' : $total[$i]["hNum"];
      }
      $heads = $this->getHeads($values['cateName']);
      foreach($heads as $head){
        $countColumn[] = "count".$head->num;
        $judgeColumn[] = "judge".$head->num;
        for($i = 0;$i < count($total);$i++){
          if($head->num==$total[$i]["hNum"]){
            if($total[$i]["sum(mikaizenflag)"] > 0){
              $counts[] = $total[$i]["count(id)"];
              $judge[] = "×";
              break;
            }
            else{
              $counts[] = $total[$i]["count(id)"];
              $judge[] = "△";
              break;
            }
          }
        }
        if(!in_array($head->num,$numFromTotal)){
            $counts[] = "0";
            $judge[] = "○";
        }
      }
      /*------上記配列を繰り返し処理で該当のカラムにセット------*/
      for($i = 0;$i < count($judge);$i++){
        $stmt = $this->db->prepare("update ".$values['tableName']." set ".$countColumn[$i]." = ?,".$judgeColumn[$i]." = ? where ytom = ? and storeId = ?");
        $stmt->bindValue(1,$counts[$i]);
        $stmt->bindValue(2,$judge[$i]);
        $stmt->bindValue(3,$values['ytom']);
        $stmt->bindValue(4,$values['storeId']);
        $stmt->execute();
      }
    break;
    }
  }
// $tableName,$storeId,$ytom
  public function lockTotal($values){
    $stmt = $this->db->prepare("update ".$values['tableName']." set compFlag = 1 where ytom = ? and storeId = ?");
    $stmt->bindValue(1,$values['ytom']);
    $stmt->bindValue(2,$values['storeId']);
    $stmt->execute();
  }
// $tableName,$storeId,$ytom
  public function unlockTotal($values){
    $stmt = $this->db->prepare("update ".$values['tableName']." set compFlag = 0 where ytom = ? and storeId = ?");
    $stmt->bindValue(1,$values['ytom']);
    $stmt->bindValue(2,$values['storeId']);
    $stmt->execute();
  }

  public function setDashboard($values){
    $now = new \DateTime();
    if($values['tableName'] === 't_total_hanbaikigen'){
      $stmt = $this->db->prepare("select ytom,cateName,storeId,storeName,count_kire as count_kire from {$values['tableName']} where ytom = :thisMonth order by count_kire desc limit 3");
      $stmt->execute([':thisMonth'=>$values['ytom']]);
      $dashboard = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      if(empty($dashboard)){
        throw new \MyApp\Exception\DashboardNone();
      }
    }
    else{
      $stmt = $this->db->prepare("select ytom,cateName,storeId,storeName,totalPoint from {$values['tableName']} where ytom = :thisMonth order by totalPoint limit 3");
      $stmt->execute([':thisMonth'=>$values['ytom']]);
      $dashboard = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      if(empty($dashboard)){
        throw new \MyApp\Exception\DashboardNone();
      }
    }
    return $dashboard;
  }
}
?>
