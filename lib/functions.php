<?php
function h($s){
    return htmlspecialchars($s,ENT_QUOTES,'UTF-8');
}

function transfer($fileName){
  $url = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
  $url .= $_SERVER["HTTP_HOST"] . dirname($_SERVER["SCRIPT_NAME"]);
  $url .= "/" . $filename;     //認証OKの場合
  header("Location:".$url );  //ページに遷移
  exit;
}

function getFileName(){
  return pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
}
function getTitle(){
  switch(getFileName()){
    case 'login': $title = 'log in'; break;
    case 'logout': $title = 'log out'; break;
    case 'selectStore': $title = '店舗選択'; break;
    case 'check': $title = '検査画面'; break;
    default: $title = '施設検査サイト'; break;
  }
  return $title;
}


 ?>
