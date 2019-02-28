(function() {
  'use strict';

//images submit trigger
var my_file1 = document.getElementById('my_file1');
my_file1.addEventListener('change',function(){
  document.getElementById('form_file_insert1').submit();
});
var my_file2 = document.getElementById('my_file2');
my_file2.addEventListener('change',function(){
  document.getElementById('form_file_insert2').submit();
});
var my_file3 = document.getElementById('my_file3');
my_file3.addEventListener('change',function(){
  document.getElementById('form_file_insert3').submit();
});

/*------------------image_tabs_clickevent----------------------*/
  var tabs1 = document.getElementsByClassName('tab_name1');
  var tabs2 = document.getElementsByClassName('tab_name2');
  var tabs3 = document.getElementsByClassName('tab_name3');
  var images1 = document.getElementsByClassName('img1');
  var images2 = document.getElementsByClassName('img2');
  var images3 = document.getElementsByClassName('img3');
  var del_image1_form = document.getElementsByClassName('del_image1_form');
  var del_image2_form = document.getElementsByClassName('del_image2_form');
  var del_image3_form = document.getElementsByClassName('del_image3_form');
  var i;

  for(i = 0; i < tabs1.length; i++){
    tabs1[i].addEventListener('click',function(){
      for(i=0;i<tabs1.length;i++){
        tabs1[i].className = 'tab_name1 active';
      }
      for(i=0;i<tabs2.length;i++){
        tabs2[i].className = 'tab_name2';
      }
      for(i=0;i<tabs3.length;i++){
        tabs3[i].className = 'tab_name3';
      }
      for(i=0;i<images1.length;i++){
        images1[i].className = 'img1 active';
      }
      for(i=0;i<images2.length;i++){
        images2[i].className = 'img2';
      }
      for(i=0;i<images3.length;i++){
        images3[i].className = 'img3';
      }
      for(i=0;i<del_image1_form.length;i++){
        del_image1_form[i].className = 'del_image1_form active';
      }
      for(i=0;i<del_image2_form.length;i++){
        del_image2_form[i].className = 'del_image2_form';
      }
      for(i=0;i<del_image3_form.length;i++){
        del_image3_form[i].className = 'del_image3_form';
      }

    });
  }

  for(i = 0; i < tabs2.length; i++){
    tabs2[i].addEventListener('click',function(){
      for(i=0;i<tabs1.length;i++){
        tabs1[i].className = 'tab_name1';
      }
      for(i=0;i<tabs2.length;i++){
        tabs2[i].className = 'tab_name2 active';
      }
      for(i=0;i<tabs3.length;i++){
        tabs3[i].className = 'tab_name3';
      }
      for(i=0;i<images1.length;i++){
        images1[i].className = 'img1';
      }
      for(i=0;i<images2.length;i++){
        images2[i].className = 'img2 active';
      }
      for(i=0;i<images3.length;i++){
        images3[i].className = 'img3';
      }
      for(i=0;i<del_image1_form.length;i++){
        del_image1_form[i].className = 'del_image1_form';
      }
      for(i=0;i<del_image2_form.length;i++){
        del_image2_form[i].className = 'del_image2_form active';
      }
      for(i=0;i<del_image3_form.length;i++){
        del_image3_form[i].className = 'del_image3_form';
      }
    });
  }

  for(i = 0; i < tabs3.length; i++){
    tabs3[i].addEventListener('click',function(){
      for(i=0;i<tabs1.length;i++){
        tabs1[i].className = 'tab_name1';
      }
      for(i=0;i<tabs2.length;i++){
        tabs2[i].className = 'tab_name2';
      }
      for(i=0;i<tabs3.length;i++){
        tabs3[i].className = 'tab_name3 active';
      }
      for(i=0;i<images1.length;i++){
        images1[i].className = 'img1';
      }
      for(i=0;i<images2.length;i++){
        images2[i].className = 'img2';
      }
      for(i=0;i<images3.length;i++){
        images3[i].className = 'img3 active';
      }
      for(i=0;i<del_image1_form.length;i++){
        del_image1_form[i].className = 'del_image1_form';
      }
      for(i=0;i<del_image2_form.length;i++){
        del_image2_form[i].className = 'del_image2_form';
      }
      for(i=0;i<del_image3_form.length;i++){
        del_image3_form[i].className = 'del_image3_form active';
      }
    });
  }


})();
