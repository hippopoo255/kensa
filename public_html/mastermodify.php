<?php
// ユーザーの一覧

require_once(__DIR__ . '/../config/config.php');
// fileupload

// $app = new MyApp\Controller\Checkmodify();
// $app->run();
// ログインユーザーの情報...$app->me();
// ユーザー一覧...$app->getValues()->users;
  require_once('header.php');
?>

<div class="container">
  <h1>- Modify（準備中） -</h1>

  <div class="images">
    <p class="err"><?= null!==$app->getErrors('image') ? $app->getErrors('image'): ''; ?></p>
    <ul class="tab">
      <li class="tab_name1 active">Before1</li>
      <li class="tab_name2">Before2</li>
      <li class="tab_name3">After</li>
    </ul>
    <div class="clear"></div>
    <div class="img1 active">
      <form action="#" method="post" enctype="multipart/form-data" id="form_file_insert">
      <input type="file" name="image" id="my_file">
      <input type="hidden" name="MAX_FILE_SIZE">
      </form>
      <img src="<?= $app->getValues()->image;?>">
      <p><i class="fas fa-camera"></i></p>
    </div>
    <div class="img2">
      <form action="#" method="post" enctype="multipart/form-data" id="form_file_insert2">
      <input type="file" name="image2" id="my_file2">
      <input type="hidden" name="MAX_FILE_SIZE">
      </form>
      <img src="<?= $app->getValues()->image2;?>">
      <p><i class="fas fa-camera"></i></p>
    </div>
    <div class="img3">
      <form action="#" method="post" enctype="multipart/form-data" id="form_file_insert3">
      <input type="file" name="image3" id="my_file3">
      <input type="hidden" name="MAX_FILE_SIZE">
      </form>
      <img src="<?= $app->getValues()->image3;?>">
      <p><i class="fas fa-camera"></i></p>
    </div>
  </div>

  <form action="" method="post" id="form_modify">
  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  <input type="hidden" name="re_id" value="<?= $app->getValues()->result->id; ?>">
  <div class="texts">
    <ul>
      <li>
        <select name="headNum" onChange="getElementById('form_modify').submit();">
          <?php foreach($app->getValues()->heads as $head):?>
          <option value="<?= $head->num; ?>"<?= $app->selectedHeadNum($head->num); ?>><?= $head->hline; ?></option>
          <?php endforeach; ?>
        </select>
      </li>
      <li>
        <select name="comment">
        <?php foreach($app->getValues()->comments as $comment):?>
          <option value="<?= $comment->comment; ?>"<?= $app->selectedComment($comment->comment); ?>><?= $comment->comment; ?></option>
        <?php endforeach; ?>
        </select>
      </li>
      <li><p>MEMO</p><input type="textarea" name="memo" placeholder="memo" id="memo" value="<?=$app->getValues()->memo; ?>"></li>
    </ul>
    <input type="submit" name="modify" value="修正" class="btn modify">
    <input type="submit" name="cancel" value="キャンセル" class="btn cancel">
  </div>
  </form>
</div>
<div class="clear"></div>

<?php require_once('../config/footer.php'); ?>
