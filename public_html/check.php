<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Check();
$app->run();
// ログインユーザーの情報...$app->me();
  require_once('header.php');
  // var_dump($_SERVER['REQUEST_METHOD']);
?>

<div class="container">
  <?php
  if($_SESSION['category']->name === '販売期限'){
    echo '<section class="session-wrapper">';
    require_once('modules/session.php');
    echo '</section>';
    echo '<section class="daterule-wrapper">';
    require_once('modules/daterule_table.php');
    echo '</section>';
  }else{
    require_once('modules/session.php');
  }
  ?>
</div>

<div class="container">
<h1>- Insert -</h1>
<!-- 指摘内容の新規追加フォーム -->
  <?php require_once('modules/images.php');?>
  <?php require_once('modules/texts.php'); ?>
</div>
<div class="clear"></div>

<!-- 指摘内容一覧のフォーム -->
<div class="container">
  <?php require_once('modules/results.php'); ?>
</div>
<div class="clear"></div>

<script src="js/modules/images.js"></script>
<?php require_once('footer.php'); ?>
