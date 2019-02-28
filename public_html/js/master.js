(function() {
  'use strict';
  // submit trigger
  var form_btn = document.getElementById('form_btn');
  form_btn.addEventListener('click',function(){
    document.getElementById('form').submit();
  });

  var currentPage = document.getElementById('currentPage');
  var pages = document.getElementsByClassName('pages');

})();
