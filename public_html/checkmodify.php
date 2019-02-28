<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Checkmodify();
$app->run();
// ログインユーザーの情報...$app->me();
// ユーザー一覧...$app->getValues()->users;
  require_once('header.php');
?>

<div class="container">
  <?php require_once('modules/session.php');?>
</div>

<div class="container">
<h1>- Modify -</h1>
<!-- 指摘内容の修正フォーム -->
  <?php require_once('modules/images.php');?>
  <?php require_once('modules/texts.php'); ?>
</div>
<div class="clear"></div>

<script src="js/modules/images.js"></script>
<?php require_once('footer.php'); ?>
