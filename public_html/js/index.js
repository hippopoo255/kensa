(function() {
  'use strict';

  // submit送信trigger
  var form_btn = document.getElementById('form_btn');
  form_btn.addEventListener('click',function(){
    document.getElementById('form').submit();
  });

  // menu画面で開発者以外マスター管理を非表示にする
  var post = document.getElementById('post');
  if(post.value !== '開発者'){
    document.getElementById('admin_only').className = 'hidden';
  }
  
  // dashboardのlavelを販売期限だけ「失点」ではなく「期限切れ」に変える
  var title = document.getElementsByClassName('title');
  var lavel = document.getElementsByClassName('lavel');
  for(var i = 0;i < title.length;i++){
	   if(title[i].textContent.indexOf('販売期限') != -1){
       lavel[i].textContent = '期限切れ';
     }
  }


})();
