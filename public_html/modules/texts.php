<form action="" method="post" id="form_insert">
<?php if( strpos( getFileName(),'modify') ): ?>
  <input type="hidden" name="re_id" value="<?= $app->getValues()->result->id; ?>">
<?php endif; ?>
<input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">

<!-- 販売期限の時 -->
<?php if($_SESSION['category']->name === '販売期限'):?>
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
      <li class="quarter"><input type="text" name="count"  value="<?= isset($app->getValues()->count) ? $app->getValues()->count: '' ; ?>" placeholder="個数"></li>
      <div class="clear"></div>
      <li class="half itemlabel">商品日付</li>
      <li class="half tekkyolabel">撤去日</li>
      <li class="half"><input type="date" name="itemDate" placeholder="商品日付" value="<?= isset($app->getValues()->itemDate) ? $app->getValues()->itemDate : null; ?>" onChange="getElementById('form_insert').submit();" id="itemDate"></li>
      <li class="half"><input type="date" name="tekkyoDate" placeholder="撤去日" value="<?= isset($app->getValues()->tekkyoDate) ? $app->getValues()->tekkyoDate : ''; ?>"></li>
      <li class="half kyoyasulabel">驚安開始日</li>
      <li class="half nebikilabel">値引開始日</li>
      <li class="half"><input type="date" name="kyoyasuDate" placeholder="驚安開始日" value="<?= isset($app->getValues()->kyoyasuDate) ? $app->getValues()->kyoyasuDate : ''; ?>"></li>
      <li class="half"><input type="date" name="nebikiDate" placeholder="値引開始日" value="<?= isset($app->getValues()->nebikiDate) ? $app->getValues()->nebikiDate : ''; ?>"></li>
      <li class="full"><input type="textarea" name="memo" placeholder="memo" id="memo" value="<?= isset($app->getValues()->memo) ? $app->getValues()->memo : ''; ?>"></li>
    </ul>

<!-- 販売期限以外 -->
<?php else: ?>
<div class="texts">
  <ul>
    <li>
      <select name="headNum" onChange="getElementById('form_insert').submit();" id="headNum">
        <?php foreach($app->getValues()->heads as $head):?>
        <option value="<?= $head->num; ?>"<?= $app->selectedHeadNum($head->num); ?>><?= $head->hline; ?></option>
        <?php endforeach; ?>
      </select>
    </li>
    <li>
      <select name="comment" id="comment">
        <?php foreach($app->getValues()->comments as $comment):?>
        <option value="<?= $comment->comment; ?>"<?= $app->selectedComment($comment->comment); ?>><?= $comment->comment; ?></option>
      <?php endforeach; ?>
      </select>
    </li>
    <li><p>MEMO</p><input type="textarea" name="memo" placeholder="memo" id="memo" value="<?= isset($app->getValues()->memo) ? $app->getValues()->memo : '' ; ?>"></li>
  </ul>
<?php endif; ?>

<!--  共通　-->
  <?= $app->modify(
    '<input type="submit" name="modify" value="修正" class="btn modify">
    <input type="submit" name="cancel" value="キャンセル" class="btn cancel">
    ',
    '<input type="submit" name="insert" value="追加" class="btn insert" id="insert_btn">'
  );?>
</div>
</form>
