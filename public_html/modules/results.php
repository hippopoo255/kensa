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
    <?php if($_SESSION['category']->name === '販売期限'):?>
      <p><?= $result->itemName; ?></p>
      <table class="kigentable">
        <tr><th>商品日付</th><td><?= date('Y年n月j日',strtotime($result->itemDate)); ?></td></tr>
        <tr><th>状態</th><td><?= $result->status; ?></td></tr>
        <tr><th>個数</th><td><?= $result->count; ?></td></tr>
      </table>
    <?php else: ?>
      <p><?= $result->hNum; ?><?= $result->hline; ?></p>
      <p class="comment"><?= $result->comment; ?></p>
      <p class="memo"><?= empty($result->memo) ? '　' : $result->memo; ?></p>
    <?php endif;?>
    <input type="submit" name="delete-<?= $result->id; ?>" value="削除" class="btn delete">
    <input type="submit" name="modify-<?= $result->id; ?>" value="修正" class="btn modify">
  </div>
<?php endforeach;?>
<?php endif; ?>
</form>
