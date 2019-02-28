<?php
namespace MyApp\Controller;

class FileUpload {

  private $_imageFileName;
  private $_imageType;

  public function upload() {
      // 1.error check
      $this->_validateUpload();

      // 2.type check
      $ext = $this->_validateImageType();

      // 3.save
      $savePath = $this->_save($ext);

      // 4.createThumbnail
      $this->_createThumbnail($savePath);

      header('Location: '.SITE_URL.'/'.pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME).'.php');
      exit;


  }

    /*------------ １．エラー検証------------------
    ・$_FILESの送信結果に基づき条件別に例外処理
      ・!isset($_FILES['image'])||!isset($_FILES['image']['error'])
          ⇒\Exception('Upload Error!');
      ・$_FILES['image']['error'] == 'UPLOAD_ERR_OK'
          ⇒return true;
      ・$_FILES['image']['error'] == 'UPLOAD_ERR_INI_SIZE'
          ⇒throw new \Exception('File too large!');
      ・$_FILES['image']['error'] == 'UPLOAD_ERR_FORM_SIZE'
          ⇒throw new \Exception('File too large!');
      ・default:
          ⇒throw new \Exception('Err: ' . $_FILES['image']['error']);
    --------------------------------------------*/
    private function _validateUpload() {
      if(isset($_FILES['image1'])){
        if (!isset($_FILES['image1']) || !isset($_FILES['image1']['error'])) {
          throw new \Exception('Upload Error!');
        }
        switch($_FILES['image1']['error']) {
          case UPLOAD_ERR_OK:
            return true;
          case UPLOAD_ERR_INI_SIZE:
          case UPLOAD_ERR_FORM_SIZE:
            throw new \Exception('File too large!');
          default:
            throw new \Exception('Err: ' . $_FILES['image1']['error']);
        }
      }
      elseif(isset($_FILES['image2'])){
        if (!isset($_FILES['image2']) || !isset($_FILES['image2']['error'])) {
          throw new \Exception('Upload Error!');
        }
        switch($_FILES['image2']['error']) {
          case UPLOAD_ERR_OK:
            return true;
          case UPLOAD_ERR_INI_SIZE:
          case UPLOAD_ERR_FORM_SIZE:
            throw new \Exception('File too large!');
          default:
            throw new \Exception('Err: ' . $_FILES['image2']['error']);
        }
      }
      elseif(isset($_FILES['image3'])){
        if (!isset($_FILES['image3']) || !isset($_FILES['image3']['error'])) {
          throw new \Exception('Upload Error!');
        }
        switch($_FILES['image3']['error']) {
          case UPLOAD_ERR_OK:
            return true;
          case UPLOAD_ERR_INI_SIZE:
          case UPLOAD_ERR_FORM_SIZE:
            throw new \Exception('File too large!');
          default:
            throw new \Exception('Err: ' . $_FILES['image3']['error']);
        }
      }
    }
    /*------------ ２．ファイル形式検証------------------
    ・upload()関数内の$extにファイルの拡張子を返す
      ※exif_imagetype($_FILES['image']['tmp_name'])
          'IMAGETYPE_GIF'⇒'gif';
          'IMAGETYPE_JPEG'⇒'jpg';
          'IMAGETYPE_PNG'⇒'png';
          default⇒throw new \Exception('PNG/JPEG/GIF only!');
    --------------------------------------------*/
    private function _validateImageType() {
      if(isset($_FILES['image1'])){
        $this->_imageType = exif_imagetype($_FILES['image1']['tmp_name']);
      }
      elseif(isset($_FILES['image2'])){
        $this->_imageType = exif_imagetype($_FILES['image2']['tmp_name']);
      }
      elseif(isset($_FILES['image3'])){
        $this->_imageType = exif_imagetype($_FILES['image3']['tmp_name']);
      }
      switch($this->_imageType) {
        case IMAGETYPE_GIF:
          return 'gif';
        case IMAGETYPE_JPEG:
          return 'jpg';
        case IMAGETYPE_PNG:
          return 'png';
        default:
          throw new \Exception('PNG/JPEG/GIF only!');
        }
    }
    /*------------ ３．ファイル保存------------------
    引数：$ext(= 'gif' or 'jpg' or 'png')
    ・グローバル変数$imageFileNameに保存時のファイル名を代入
    ・$savePathに画像の保存先ディレクトリを代入(定数IMAGES_DIRと$imageFileNameを結合)
    ・move_uploaded_file（成功すればtrueを返す）を実行
    ・失敗(=false)の時は例外処理(=throw new \Exception('Could not upload!'))を実行
    --------------------------------------------*/
    private function _save($ext) {
      if(isset($_FILES['image1'])){
        $this->_imageFileName = sprintf(
          '%05d-%02d-%07d-%d-%s.%s',
          $_SESSION['store']->id,
          $_SESSION['category']->id,
          $_SESSION['me']->id,
          1,
          date("YmdHis"),
          $ext
        );
      }
      elseif(isset($_FILES['image2'])){
        $this->_imageFileName = sprintf(
          '%05d-%02d-%07d-%d-%s.%s',
          $_SESSION['store']->id,
          $_SESSION['category']->id,
          $_SESSION['me']->id,
          2,
          date("YmdHis"),
          $ext
        );
      }
      elseif(isset($_FILES['image3'])){
        $this->_imageFileName = sprintf(
          '%05d-%02d-%07d-%d-%s.%s',
          $_SESSION['store']->id,
          $_SESSION['category']->id,
          $_SESSION['me']->id,
          3,
          date("YmdHis"),
          $ext
        );
      }
      $savePath = IMAGES_DIR . '/' . $this->_imageFileName;
      if(isset($_FILES['image1'])){$res = move_uploaded_file($_FILES['image1']['tmp_name'], $savePath);}
      elseif(isset($_FILES['image2'])){$res = move_uploaded_file($_FILES['image2']['tmp_name'], $savePath);}
      elseif(isset($_FILES['image3'])){$res = move_uploaded_file($_FILES['image3']['tmp_name'], $savePath);}
      if ($res === false) {
        throw new \Exception('Could not upload!');
      }
      return $savePath;
    }
    /*------------ 4．サムネイル作成------------------
    引数：$ext(= 'gif' or 'jpg' or 'png')
    ・グローバル変数$_imageFileNameに保存時のファイル名を代入
    ・$savePathに画像の保存先ディレクトリを代入(定数IMAGES_DIRと$imageFileNameを結合)
    ・move_uploaded_file（成功すればtrueを返す）を実行
    ・失敗(=false)の時は例外処理(=throw new \Exception('Could not upload!'))を実行
    --------------------------------------------*/
    private function _createThumbnail($savePath) {
      $imageSize = getimagesize($savePath);
      $width = $imageSize[0];
      $height = $imageSize[1];
      $this->_createThumbnailMain($savePath, $width, $height);
    }

    private function _createThumbnailMain($savePath, $width, $height) {
      switch($this->_imageType) {
        case IMAGETYPE_GIF:
          $srcImage = imagecreatefromgif($savePath);
          break;
        case IMAGETYPE_JPEG:
          $srcImage = imagecreatefromjpeg($savePath);
          break;
        case IMAGETYPE_PNG:
          $srcImage = imagecreatefrompng($savePath);
          break;
      }
      $thumbHeight = round($height * THUMBNAIL_WIDTH / $width);
      $thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumbHeight);
      imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, THUMBNAIL_WIDTH, $thumbHeight, $width, $height);

      switch($this->_imageType) {
        case IMAGETYPE_GIF:
          imagegif($thumbImage, IMAGES_DIR . '/' . $this->_imageFileName);
          break;
        case IMAGETYPE_JPEG:
          imagejpeg($thumbImage, IMAGES_DIR . '/' . $this->_imageFileName);
          break;
        case IMAGETYPE_PNG:
          imagepng($thumbImage, IMAGES_DIR . '/' . $this->_imageFileName);
          break;
      }

    }


  public function getImages($num){
    $images = [];
    $files = [];
    $imageDir = opendir(IMAGES_DIR);
    while(false !== ($file = readdir($imageDir))){
      if($file === '.' || $file === '..'){
        continue;
      }
      elseif(strpos($file,sprintf(
        '%05d-%02d-%07d-%d-%s',
        $_SESSION['store']->id,
        $_SESSION['category']->id,
        $_SESSION['me']->id,
        $num,
        date("Ym")
        )
        ) === false){
       continue;
      }
      $files[] = $file;
      $images[] = basename(IMAGES_DIR).'/'.$file;
    }
    array_multisort($files,SORT_DESC,$images);
    if(count($images)>1){
      for($i = 1;$i<count($images);$i++){
        unlink($images[$i]);
        unset($images[$i]);
      }
    }
    return $images ? $images[0] : '';
  }

  public function _move($image) {
    if($image){
      $movePath = basename(MOVED_DIR) . '/' . basename($image);
      $res = rename($image, $movePath);
    }
    else{
      $movePath = '';
    }
    return $movePath;
  }
}
?>
