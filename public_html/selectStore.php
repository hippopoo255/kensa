<?php
// ユーザーの一覧

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\SelectStore();
$app->run();
// ログインユーザーの情報...$app->me();
// ユーザー一覧...$app->getValues()->users;
  require_once('header.php');
?>

<div class="container">
  <h1>- Select Store -</h1>
  <form action="#" method="post" class="selectStore" id="start">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    <p class="err"><?= $app->getErrors('storeId'); ?></p>
    <p class="err"><?= $app->getErrors('selectStore'); ?></p>
    <input type="text" name="storeId" placeholder="店舗番号" value="<?= isset($app->getValues()->storeId) ? $app->getValues()->storeId : ''; ?>">
    <p style="margin:0 0 10px;">店舗名：<?= isset($_SESSION['store']->name) ? $_SESSION['store']->name : '' ; ?></p>
    <input id="date" type="date" name="date" value="<?= isset($app->getValues()->date) ? $app->getValues()->date : ''; ?>">
    <div><input class="btn checkStart" type="submit" name="checkStart" value="ＳＴＡＲＴ"></div>
  <h1>- Store List -</h1>
    <p class="err"><?= $app->getErrors('searchStore'); ?></p>
    <input type="text" name="searchWord" placeholder="検索（店番、店名）" value="<?= isset($app->getValues()->searchWord) ? $app->getValues()->searchWord : ''; ?>">
    <input class="btn storeSearch" type="submit" name="storeSearch" value="検索">

    <table class="storelist">
      <tr>
        <th>店番</th><th>店名</th>
      </tr>
      <?php foreach($app->getValues()->stores as $store): ?>
      <tr>
        <td><input type="submit" name="storeId" value="<?= $store->id; ?>"></td><td><?= $store->name; ?></td>
      </tr>
      <?php endforeach; ?>
    </table>
  </form>
</div>
    <?php require_once("footer.php"); ?>
