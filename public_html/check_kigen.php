<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Check_kigen();
$app->run();
// ログインユーザーの情報...$app->me();
// var_dump(isset($_POST['jan']));
  require_once('header.php');
?>
<div class="container">
  <section class="session-wrapper">
    <?php require_once('modules/session.php'); ?>
  </section>

  <section class="daterule-wrapper">
    <?php require_once('modules/daterule_table.php'); ?>
  </section>
</div>
<div class="clear"></div>
<div class="container">
  <h1>- Insert -</h1>
  <?php require_once('modules/images.php');?>

  <form action="" method="post" id="form_insert">
  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  <p class="err"><?= $app->getErrors('item'); ?></p>
  <p class="err"><?= $app->getErrors('dateRule'); ?></p>
  <p class="err"><?= $app->getErrors('insert'); ?></p>
  <div class="texts">
    <ul>
      <li class="half"><input type="text" name="jan" placeholder="JAN" value="<?= isset($app->getValues()->jan) ? $app->getValues()->jan : ''; ?>" onChange="getElementById('form_insert').submit();" id="jan"></li>
      <li class="half"><input type="text" name="name" placeholder="商品名" value="<?= isset($app->getValues()->name) ? $app->getValues()->name : ''; ?>" id="name"></li>
      <li class="quarter"><input type="text" name="categoryCode" placeholder="分類コード" value="<?= isset($app->getValues()->categoryCode) ? $app->getValues()->categoryCode : ''; ?>"></li>
      <li class="quarter"><input type="text" name="categoryName" placeholder="分類名" value="<?= isset($app->getValues()->categoryName) ? $app->getValues()->categoryName : ''; ?>"></li>
      <li class="quarter"><input type="text" name="status" placeholder="状態" value="<?= isset($app->getValues()->status) ? $app->getValues()->status : ''; ?>" id="status"></li>
      <li class="quarter"><input type="text" name="count" placeholder="個数"></li>
      <div class="clear"></div>
      <li class="half itemlabel">商品日付</li>
      <li class="half tekkyolabel">撤去日</li>
      <li class="half"><input type="date" name="itemDate" placeholder="商品日付" value="<?= isset($app->getValues()->itemDate) ? $app->getValues()->itemDate : null; ?>" onChange="getElementById('form_insert').submit();" id="itemDate"></li>
      <li class="half"><input type="date" name="tekkyoDate" placeholder="撤去日" value="<?= isset($app->getValues()->tekkyoDate) ? $app->getValues()->tekkyoDate : ''; ?>"></li>
      <li class="half kyoyasulabel">驚安開始日</li>
      <li class="half nebikilabel">値引開始日</li>
      <li class="half"><input type="date" name="kyoyasuDate" placeholder="驚安開始日" value="<?= isset($app->getValues()->kyoyasuDate) ? $app->getValues()->kyoyasuDate : ''; ?>"></li>
      <li class="half"><input type="date" name="nebikiDate" placeholder="値引開始日" value="<?= isset($app->getValues()->nebikiDate) ? $app->getValues()->nebikiDate : ''; ?>"></li>
      <li class="full"><input type="textarea" name="memo" placeholder="memo" id="memo"></li>
    </ul>
    <input type="submit" name="insert" value="追加" class="btn insert" id="insert_btn">
  </div>
  </form>
</div>
<div class="clear"></div>

<div class="container">
  <h1>- Results -</h1>
  <h2>（<?= $_SESSION['datetime']->format('Y年n月'); ?>）</h2>
  <form action="" method="post" id="form_modify">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    <section class="monthes">
      <input type="submit" name="prev" class="btn month" value="前月">
      <input type="submit" name="this" class="btn month" value="当月">
      <input type="submit" name="next" class="btn month<?= $app->hiddenByMonthOver(); ?>" value="翌月">
    </section>
    <p><?= $app->getErrors('results');?></p>
    <?php if(isset($app->getValues()->results)): ?>
    <?php foreach($app->getValues()->results as $result):?>
      <input type="hidden" name="re_id" value="<?= $result->id; ?>">
    <div class="result">
      <ul class="tab">
        <li class="tab_name1 active">Before1</li>
        <li class="tab_name2">Before2</li>
        <li class="tab_name3">After</li>
      </ul>
      <div class="clear"></div>
      <div class="img1 active">
        <img src="<?= $result->fname; ?>">
      </div>
      <div class="img2">
        <img src="<?= $result->fname2; ?>">
      </div>
      <div class="img3">
        <img src="<?= $result->fname3; ?>">
      </div>
      <p><?= $result->itemName; ?></p>
      <table class="kigentable">
        <tr><th>商品日付</th><td><?= date('Y年n月j日',strtotime($result->itemDate)); ?></td></tr>
        <tr><th>状態</th><td><?= $result->status; ?></td></tr>
        <tr><th>個数</th><td><?= $result->count; ?></td></tr>
      </table>
      <input type="submit" name="delete-<?= $result->id; ?>" value="削除" class="btn delete">
      <input type="submit" name="modify-<?= $result->id; ?>" value="修正" class="btn modify">
    </div>
  <?php endforeach;?>
<?php endif; ?>
<div class="clear"></div>

<script src="js/modules/images.js"></script>
<?php require_once('footer.php'); ?>
