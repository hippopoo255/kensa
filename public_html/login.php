<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Login();
$app->run();
require_once('header.php');
?>

  <div class="container">
    <form action="" method="post" id="form">
      <p class="err"><?= $app->getErrors('login'); ?></p>
      <div><input type="text" name="id" placeholder="ID(半角数字)" value="<?= isset($app->getValues()->id) ? h($app->getValues()->id) : ''; ?>"></div>
      <div><input type="password" name="password" placeholder="password(半角英数字)"></div>
      <div class="btn login" id="form_btn">ログイン</div>
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
  </div>

  <?php require_once("footer.php"); ?>
