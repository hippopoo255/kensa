(function() {
  'use strict';

  // submit trigger
  var form_btn = document.getElementById('form_btn');
  form_btn.addEventListener('click',function(){
    document.getElementById('form').submit();
  });

  var judge = document.getElementsByClassName('judge');

  for(var i = 0; i < judge.length; i++){
    if(judge[i].innerHTML === '×'){
      judge[i].className = 'judge warning';
    }else if(judge[i].innerHTML === '△'){
      judge[i].className = 'judge notice';
    }
  }

  var totalPoint = document.getElementById('total_point');
  var totalCount = document.getElementById('total_count');
  var hanbaikigen = document.getElementById('販売期限');
  if(hanbaikigen.selected){
    totalPoint.classList.add('hidden');
    totalCount.classList.add('hidden');
    document.getElementById('rule').className = 'hidden';
  }

})();
