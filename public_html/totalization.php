<?php
// ユーザーの一覧

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Index();
$app->run();
// ログインユーザーの情報...$app->me();
// ユーザー一覧...$app->getValues()->users;
  require_once('header.php');
?>


<div class="container">
    <h1>- 準備中 -</h1>

</div>
    <?php require_once("../config/footer.php"); ?>
