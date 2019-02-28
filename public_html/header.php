<!DOCTYPE html>

<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width-device-width,initial-scale=1">
  <title><?= getTitle(); ?></title>
  <link rel="icon" href="img/favicon.ico">
  <!-- <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css"> -->
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
  <!-- <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script> -->
</head>
<body>
<?php if(getFileName() !== 'login'):?>
  <div class="top_line">
  <ul class="top_nav">
    <li id="me"><?= h($app->me()->name); ?>さん、ようこそ▼</li>
    <li class="nav hidden"><a href="index.php">ＴＯＰ</a></li>
  <!--  check　or scoreページだったら-->
  <?php if(strpos(getFileName(),'check') !== false || strpos(getFileName(),'score') !== false): ?>
    <li class="nav hidden"><a href="selectStore.php">店舗を選択する</a></li>
  <?php endif; ?>
  <!--  checkページだったら-->
  <?php if(strpos(getFileName(),'check') !== false): ?>
    <li class="nav hidden" id="score_btn" onclick="document.getElementById('form_score').submit()">
    <form action="score.php" method="post" id="form_score">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    スコアを見る
    </li>
  <?php endif; ?>
  <!--  scoreページだったら-->
  <?php if(strpos(getFileName(),'score') !== false): ?>
    <li class="nav hidden">
      <a href="<?= $app->getRecordScreen();?>">指摘一覧を見る</a>
    </li>
  <?php endif; ?>

    <li id="form_btn" class="nav hidden">
      <form action="logout.php" method="post" id="form">
         <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
         <input type="hidden" name="post" value="<?= h($app->me()->post); ?>" id="post">
      </form>
       ログアウト
    </li>
  </ul>
  <div class="clear"></div>
<?php endif;?>
</div>
<header>
  <h1>施設検査サイト</h1>
</header>
