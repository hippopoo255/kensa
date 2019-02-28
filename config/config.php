<?php
ini_set('display_errors',0);

// DB
define('DBHOST','localhost');
define('DBNAME','sample');/*phppractice_*/
define('DSN','mysql:dbhost='.DBHOST.';dbname='.DBNAME.';charset=utf8');
define('DBUSER','admin');
define('DBPASS','admin');
$AES_KEY = 'H3a5Aa3pCvGm';

// define('SITE_URL','http://' . $_SERVER['HTTP_HOST']); //'http://192.168.33.10:8000'
define('SITE_URL','http://' . $_SERVER['HTTP_HOST'] . '/kensa/public_html'); //'localhost/3.practice/public_html'
// fileUpload
define('MAX_FILE_SIZE', 3 * 1024 * 1024); // 3MB
define('IMAGES_DIR', __DIR__ . '/../public_html/images');
define('THUMBS_DIR', __DIR__ . '/../public_html/thumbs');
define('MOVED_DIR', __DIR__ . '/../public_html/moved');
define('THUMBNAIL_WIDTH', 600);

require_once("../lib/functions.php");
require_once("autoload.php");

session_start();
 ?>
