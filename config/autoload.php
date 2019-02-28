<?php

/*-----------------------------

MyApp
ex)
V=>index.php
Cname = MyApp\Controller\Index;
classFilePath = lib/Controller/Index.php
Mname = MyApp\Model\User;

-----------------------------*/


/*-----------------------------------
関数名：spl_autoload_register(spl = standard php library)
内　容：
=> $class = MyApp\Controller\Index;
もし$class ===  MyApp\で始まっていたら、↑のclassFilePathを読み込む
----------------------------------*/
spl_autoload_register(function($class){
  $prefix = 'MyApp\\';  //バックスラッシュはエスケープしなければならないので、'MyApp\'ではなく'MyApp\\'

  if(strpos($class,$prefix)===0){
    $className = substr($class,strlen($prefix));
    $classFilePath = __DIR__ . '/../lib/' . str_replace('\\','/',$className) . '.php';
    if(file_exists($classFilePath)){
    require $classFilePath;
    }
  }
});

 ?>
