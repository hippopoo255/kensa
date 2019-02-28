(function() {
  'use strict';


var me = document.getElementById('me');
var form_btn = document.getElementById('form_btn');
var nav = document.getElementsByClassName('nav');

// top_line event
me.addEventListener('click',function(){
  for(var i = 0;i < nav.length;i++){
    if(nav[i].className === 'nav hidden'){
      nav[i].classList.remove('hidden');
    }else{
      nav[i].classList.add('hidden');
    }
  }
});

// submit logout
form_btn.addEventListener('click',function(){
  document.getElementById('form').submit();
});


})();
