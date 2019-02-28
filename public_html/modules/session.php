<p><?=$_SESSION['store']->id; ?>：<?=$_SESSION['store']->name; ?></p>

<?php if( !strpos( getFileName(),'modify' ) ):?>
<form action="#" method="post" id="form_date_select">
  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  <p>検査日：<input type="date" name="date" value="<?=$_SESSION['datetime']->format('Y-m-d'); ?>" id="date"  onChange="getElementById('form_date_select').submit();"></p>
</form>
<form action="#" method="post" id="form_category_select">
  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    <select name="cateId" id="cateId" onChange="getElementById('form_category_select').submit();">
    <?php foreach($app->getValues()->categories as $category):?>
      <option value="<?= $category->id; ?>"<?= $app->selectedCateId($category->id); ?>>
        <?= $category->name; ?>
      </option>
    <?php endforeach; ?>
    </select>
</form>
<form action="#" method="post" id="form_comp">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      <input type="hidden" name="userPost" value="<?= $app->me()->post; ?>" id="userPost" >
      <input type="hidden" name="compFlag" value="<?= !isset($app->getValues()->total) ? 0 : $app->getValues()->total->compFlag ; ?>" id="compFlag">
      <input type="submit" name="compbtn" class="btn comp" id="comp_btn" value="検査完了">
</form>
<?php endif; ?>

<p class="categoryicon"><?= $_SESSION['category']->img; ?></p>
