<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/modules/nav.js"></script>
<script src="js/<?= getFileName(); ?>.js"></script>
<script>
$(function(){
  $('#start').submit(function(){
    if($('#date').val() == ""){
        window.alert("検査日を入力してください")
        return false;
    }
  });
});
// 検査完了ボタンクリック時
$(function(){
  $('#form_comp').submit(function(){
    if($('#compFlag').val() == "1"){
      if($('#userPost').val() !== /*'ブロック長' && $('#userPost').val() !== 'エリア長' && $('#userPost').val() !==*/ '開発者' ){
        window.alert("解除権限がありません。開発者に依頼してください")
        return false;
      }
      else if(!window.confirm("解除しますか？")){
        return false;
      }
    }
    else if(!window.confirm("一度完了すると元に戻せません。検査を完了しますか？")){
        return false;
    }
  });
});


/* ---------検査完了後のロック処理---------*/
// 検査日変更時
$(function(){
  $('#date').on('click',function(){
    if($('#compFlag').val()=="1"){
      window.alert('検査完了済みです');
      return false;
    }
  });
});
// ファイルアップロード時
$(function(){
  $('#my_file1').on('click',function(){
    if($('#compFlag').val()=="1"){
      window.alert('検査完了済みです');
      return false;
    }
  });
});
// ファイル2アップロード時
$(function(){
  $('#my_file2').on('click',function(){
    if($('#compFlag').val()=="1"){
      window.alert('検査完了済みです');
      return false;
    }
  });
});
// ファイル3アップロード時
$(function(){
  $('#my_file3').on('click',function(){
    if($('#compFlag').val()=="1"){
      window.alert('検査完了済みです');
      return false;
    }
  });
});

// 設問番号入力時
$(function(){
  $('#headNum').on('click',function(){
    if($('#compFlag').val()=="1"){
      window.alert('検査完了済みです');
      return false;
    }
  });
});
// コメント入力時
$(function(){
  $('#comment').on('click',function(){
    if($('#compFlag').val()=="1"){
      window.alert('検査完了済みです');
      return false;
    }
  });
});
// 備考欄入力時
$(function(){
  $('#memo').on('click',function(){
    if($('#compFlag').val()=="1"){
      window.alert('検査完了済みです');
      return false;
    }
  });
});
// 修正ボタン
$(function(){
  $('.modify').on('click',function(){
    if($('#compFlag').val()=="1"){
      window.alert('検査完了済みです');
      return false;
    }
  });
});
// 追加ボタン全般
$(function(){
  $('#insert_btn').on('click',function(){
    // 検査完了済みなら追加実行しない
    if($('#compFlag').val() == "1"){
      window.alert("検査完了済みです");
      return false;
    }
    // 未入力の検証(jan/name/itemDate/status/count('期限切れ''要撤去'))
    if($('#jan').val() == "" || $('#name').val() == "" || $('#itemDate').val() == "" || $('#status').val() == ""){
      window.alert("jan/商品名/商品日付/状態を未入力とすることはできません");
      return false;
    }
    // 検査未完了で、「はい」を選択したら削除処理実行
    else if($('#status').val() == "期限切れ" && $('#count').val() == ""){
      window.alert("期限切れ/要撤去の場合は個数の入力が必須です");
      return false;
    }else if($('#status').val() == "要撤去" && $('#count').val() == ""){
      window.alert("期限切れ/要撤去の場合は個数の入力が必須です");
      return false;
    }
    // 検査未完了で、「いいえ」なら追加実行しない
    else if(!window.confirm("指摘を追加します。よろしいですか？")){
      return false;
    }
    else{
      $('#form_insert').submit();
    }
  });
});
// 削除ボタン全般
$(function(){
  $('.delete').on('click',function(){
    // 検査完了済みなら削除実行しない
    if($('#compFlag').val() == "1"){
      window.alert("検査完了済みです");
      return false;
    }
    // 検査未完了で、「はい」を選択したら削除処理実行
    else if(window.confirm("削除してよろしいですか？")){
      $('#form_modify').submit();
    // 「いいえ」なら削除実行しない
    }else  {
      return false;
    }
  });
});
$(function(){
  $('.delete-checked').on('click',function(){
    // 「はい」を選択したら削除処理実行
    if(window.confirm("削除してよろしいですか？")){
      $('#form_master').submit();
    // 「いいえ」なら削除実行しない
    }else  {
      return false;
    }
  });
});
// ゴミ箱1
$(function(){
  $('#del-image1').on('click',function(){
    if(window.confirm("before1を削除してよろしいですか？")){
      $('#del-image1_form').submit();
    // 「いいえ」なら削除実行しない
    }else  {
      return false;
    }
  });
});
// ゴミ箱2
$(function(){
  $('#del-image2').on('click',function(){
    if(window.confirm("before2を削除してよろしいですか？")){
      $('#del-image2_form').submit();
    // 「いいえ」なら削除実行しない
    }else  {
      return false;
    }
  });
});
// ゴミ箱3
$(function(){
  $('#del-image3').on('click',function(){
    if(window.confirm("afterを削除してよろしいですか？")){
      $('#del-image3_form').submit();
    // 「いいえ」なら削除実行しない
    }else  {
      return false;
    }
  });
});
/* ------------------------------------*/

/* ---------販売期限レコード追加前のアラート-----------*/
$(function(){
  $('#insert_btn').on('click',function(){

  });
});
/* -------------------------------------------------*/
</script>
</body>
</html>
