<?php
// ユーザーの一覧

require_once(__DIR__ . '/../config/config.php');
// fileupload

$app = new MyApp\Controller\Checkmodify_kigen();
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
  <?php require_once('modules/images.php');?>

  <form action="" method="post" id="form_modify">
  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  <input type="hidden" name="re_id" value="<?= $app->getValues()->result->id; ?>">
  <div class="texts">
    <ul>
      <li class="half"><input type="text" name="janCode" placeholder="JAN" value="<?= $app->getValues()->janCode; ?>" onChange="getElementById('form_modify').submit();" id="jan"></li>
      <li class="half"><input type="text" name="itemName" placeholder="商品名" value="<?= $app->getValues()->itemName; ?>" id="name"></li>
      <li class="quarter"><input type="text" name="categoryCode" placeholder="分類コード" value="<?= $app->getValues()->categoryCode; ?>"></li>
      <li class="quarter"><input type="text" name="categoryName" placeholder="分類名" value="<?= $app->getValues()->categoryName; ?>"></li>
      <li class="quarter"><input type="text" name="status" placeholder="状態" value="<?= $app->getValues()->status; ?>" id="status"></li>
      <li class="quarter"><input type="text" name="count" value="<?= $app->getValues()->count; ?>" placeholder="個数"></li>
      <div class="clear"></div>
      <li class="half itemlabel">商品日付</li>
      <li class="half tekkyolabel">撤去日</li>
      <li class="half"><input type="date" name="itemDate" placeholder="商品日付" value="<?= $app->getValues()->itemDate; ?>" onChange="getElementById('form_modify').submit();" id="itemDate"></li>
      <li class="half"><input type="date" name="tekkyoDate" placeholder="撤去日" value="<?= $app->getValues()->tekkyoDate; ?>"></li>
      <li class="half kyoyasulabel">驚安開始日</li>
      <li class="half nebikilabel">値引開始日</li>
      <li class="half"><input type="date" name="kyoyasuDate" placeholder="驚安開始日" value="<?= $app->getValues()->kyoyasuDate; ?>"></li>
      <li class="half"><input type="date" name="nebikiDate" placeholder="値引開始日" value="<?= $app->getValues()->nebikiDate; ?>"></li>
      <li class="full"><input type="textarea" name="memo" placeholder="memo" id="memo" value="<?=$app->getValues()->memo; ?>"></li>
    </ul>
    <input type="submit" name="modify" value="修正" class="btn modify">
    <input type="submit" name="cancel" value="キャンセル" class="btn cancel">
  </div>
  </form>
</div>
<div class="clear"></div>

<script src="js/modules/images.js"></script>
<?php require_once('footer.php'); ?>
