<div class="images">
  <p class="err"><?= null!==$app->getErrors('image') ? $app->getErrors('image'): ''; ?></p>
  <ul class="tab">
    <li class="tab_name1 active">Before1</li>
    <li class="tab_name2">Before2</li>
    <li class="tab_name3">After</li>
  </ul>
  <div class="clear"></div>
  <div class="img1 active">
    <p><i class="fas fa-camera"></i></p>
    <img src="<?= $app->getValues()->image1;?>" id="img1">
    <form action="#" method="post" enctype="multipart/form-data" id="form_file_insert1">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      <input type="file" name="image1" id="my_file1">
      <input type="hidden" name="MAX_FILE_SIZE">
    </form>
  </div>
  <div class="img2">
    <p><i class="fas fa-camera"></i></p>
    <img src="<?= $app->getValues()->image2;?>" id="img2">
    <form action="#" method="post" enctype="multipart/form-data" id="form_file_insert2">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      <input type="file" name="image2" id="my_file2">
      <input type="hidden" name="MAX_FILE_SIZE">
    </form>
  </div>
  <div class="img3">
    <p><i class="fas fa-camera"></i></p>
    <img src="<?= $app->getValues()->image3;?>" id="img3">
    <form action="#" method="post" enctype="multipart/form-data" id="form_file_insert3">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      <input type="file" name="image3" id="my_file3">
      <input type="hidden" name="MAX_FILE_SIZE">
    </form>
  </div>
  <form  action="" method="post" id="del-image1_form" class="del_image1_form active">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    <input type="hidden" name="del-image1" value="del-image1">
    <i class="fas fa-trash-alt" id="del-image1"></i>
  </form>
  <form  action="" method="post" id="del-image2_form" class="del_image2_form">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    <input type="hidden" name="del-image2" value="del-image2">
    <i class="fas fa-trash-alt" id="del-image2"></i>
  </form>
  <form  action="" method="post" id="del-image3_form" class="del_image3_form">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    <input type="hidden" name="del-image3" value="del-image3">
    <i class="fas fa-trash-alt" id="del-image3"></i>
  </form>
</div>
