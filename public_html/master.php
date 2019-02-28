<?php
// ユーザーの一覧

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Master();
$app->run();
$uniqueKey = $app->getUniqueKey();
// ログインユーザーの情報...$app->me();
// ユーザー一覧...$app->getValues()->users;
  require_once('header.php');
?>


<div class="container">
    <h1>- Master Controll-</h1>
    <form action="" method="post" class="mastermanager" id="form_master">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      <input type="hidden" name="currentPage" value="<?= $app->getValues()->page; ?>" id="currentPage">
      <!-- select master -->
      <select name="masterName" onChange="getElementById('form_master').submit();">
        <?php foreach($app->getValues()->masterNames as $key=>$value): ?>
        <option value="<?= $value; ?>"<?= $app->selectedMaster($value); ?>>
          <?= $key; ?>
        </option>
        <?php endforeach; ?>
      </select>

      <!-- master list -->
      <table class="masterlist">
        <!-- loop $app->getValues()->columns -->
        <tr>
          <th>
            DEL
          </th>
          <?php foreach($app->getValues()->columns as $column): ?>
          <th>
            <?= $column->Field; ?>
          </th>
          <?php endforeach; ?>
          <th>
            modify
          </th>
        </tr>
        <!-- loop $app->getValues()->master -->
        <?php foreach($app->getValues()->master as $record): ?>
        <tr>
          <td>
            <input type="checkbox" name="del-<? $record->$uniqueKey; ?>">
          </td>
          <?php foreach($record as $key=>$value): ?>
          <td>
            <?= h($value); ?>
          </td>
          <?php endforeach; ?>
          <td>
            <input type="submit" name="modify-<?= $record->$uniqueKey; ?>" value="修正">
          </td>
        </tr>
      <?php endforeach; ?>
      </table>
      <input type="submit" name="delete" class="btn delete-checked" value="チェックした項目を削除">
    </form>

    <a href="?p=<?= $app->getValues()->page - 1; ?>" class="<?= $app->getPrevHidden(); ?>">&lt;</a>
    <?php for($i = 1; $i <= $app->getValues()->totalPages; $i++):?>
      <a href="?p=<?= $i; ?>" class="pages<?= $app->getCurrent($i); ?>"><?= $i;?></a>
    <?php endfor; ?>
    <a href="?p=<?= $app->getValues()->page + 1; ?>" class="<?= $app->getNextHidden(); ?>">&gt;</a>
    <p><?= $app->getValues()->from; ?>～<?= $app->getValues()->to; ?>件を表示（全<?= $app->getValues()->totalArticles; ?>件）</p>
</div>
    <?php require_once("../config/footer.php"); ?>
