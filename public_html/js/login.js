(function() {
  'use strict';

  // submit送信trigger
  var form_btn = document.getElementById('form_btn');
  form_btn.addEventListener('click',function(){
    document.getElementById('form').submit();
  });
  
})();
