<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Score();
$app->run();
// ログインユーザーの情報...$app->me();
require_once('header.php');
?>

<div class="container">
  <h1>- Score -</h1>
  <article class="score-sammary">
    <p style="margin:0;"><?= $_SESSION['store']->shisyaName;?></p>
    <h1><?= $_SESSION['store']->name;?></h1>
    <ul>
      <li id="total_point">
        総失点<strong><?= !isset($app->getValues()->total) ? 'ー' : $app->getValues()->total->totalPoint; ?></strong>
      </li>
      <li id="total_count">
        指摘総数<strong><?= !isset($app->getValues()->total) ? 'ー' : $app->getValues()->total->totalCount; ?></strong>
      </li>
    </ul>
    <form action="#" method="post" id="form_category_select">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      <select name="cateId" id="cateId" onChange="getElementById('form_category_select').submit();">
      <?php foreach($app->getValues()->categories as $category):?>
        <option value="<?= $category->id; ?>" id="<?= $category->name; ?>"<?= $app->selectedCateId($category->id); ?>>
          <?= $category->name; ?>
        </option>
      <?php endforeach; ?>
      </select>
      <p class="categoryicon"><?= $_SESSION['category']->img; ?></p>
    </form>
    <div class="clear"></div>
    <?php
    if(isset($app->getValues()->total)){
      $date = new \DateTime($app->getValues()->total->date);
    }
    ?>
    <p>検査日：<?= !isset($app->getValues()->total) ? 'ーーー' : $date->format('Y年m月d日') ; ?>
    <br>検査者：<?= !isset($app->getValues()->total) ? 'ーーー' : $app->getValues()->total->userName; ?></p>
  </article>
  <p style="text-align:right; margin:0;" id="rule">△ = 指摘あり(改善済み)　× = 指摘あり(未改善)</p>
  <table>
    <?php
      if(!isset($app->getValues()->total)){
        echo '<p class="warning">スコアはまだありません</p>';
      }else{
        $app->totalView();
      }
    ?>
  </table>
  <form method="post" action="">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    <div><input type="submit" name="back" class="btn back" value="指摘内容一覧"></div>
  </form>

<?php require_once('footer.php'); ?>
