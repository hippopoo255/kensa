<?php
$FileMakerLink = '<a href="https://www.filemaker.com/jp/products/" target="blank">FileMakerPro</a>';
define('SITE_URL','http://' . $_SERVER['HTTP_HOST'] . '/kensa/public_html');

 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<title>ポートフォリオ</title>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
</head>

<body>
  <header>
  <div class="container">
      <h1>プログラミング学習の進捗状況</h1>
  </div>
  </header>
<hr />
<div class="container">
  <section class="other-content">
    <h2>ー　ポートフォリオ　－</h2>
    <p style="margin:0 auto">
      　前職では商業施設の抜き打ちコンプライアンス検査と、部署のバックオフィスを兼任。iPadで入力した違反箇所の画像や文言がレコードとして蓄積されるよう、
        データベースアプリの<strong><?= $FileMakerLink; ?></strong>を使って、業務システムをカスタマイズしておりました。<br />
      　そんな業務システムを、もしPHPで作ったら...と仮定し、プログラミング学習の題材にしました。<br>
        <br>
        <em style="color:red;">※ブラウザ環境：Google Chrome（必須）</em><br>
        <em style="color:red;">※iPhoneは非対応</em>
    </p>
    <div class="btn kensa">
      <a href="<?= SITE_URL ;?>" style="color:#fff;" target="blank">検査サイトはこちら</a>
    </div>
  </section>


  <section class="learning-content">
    <h2>ー　学習内容　ー</h2>
    <div class="module">
    <h3><i class="fas fa-edit"></i> 実装機能</h3>
    <table>
      <tr><th>機能名</th><th>操作方法</th></tr>
      <tr><td>ログイン機能</td><td>ID:2222222/password:2222222</td></tr>
      <tr><td>メニュー選択</td><td>①検査　②集計（準備中）　③マスター　※上記IDではマスター非表示</td></tr>
      <tr><td>店舗選択</td><td>テキストフォームに店番を直接入力 or StoreListの店舗番号をクリック</td></tr>
      <tr><td>検査選択</td><td>ドロップダウンリストから「防災」「食品」「販売期限」を選択</td></tr>
      <tr><td>指摘内容の入力</td><td>①写真アップ　②大項目選択（「最重要項目」など）　③指摘コメント選択(「非常扉前物品」など)</td></tr>
      <tr><td>指摘の追加</td><td>「追加」ボタンをクリック</td></tr>
      <tr><td>指摘の修正・削除</td><td>Resultsから対象レコードの「修正」または「削除」をクリック</td></tr>
      <tr><td>検査完了</td><td>Resultsの下にある「検査完了」ボタンをクリック（レコード確定）</td></tr>
    </table>
    </div>

    <div class="module">
      <h3><i class="fas fa-edit"></i> 環境</h3>
      <table>
        <tr><th>使用言語</th></tr>
        <tr><td>PHP/JavaScript/HTML/CSS</td></tr>
        <tr><th>フレームワーク/CMS</th></tr>
        <tr><td>使用なし</td></tr>
        <tr><th>データベース</th></tr>
        <tr><td>MariaDB</td></tr>
        <tr><th>サーバ</th></tr>
        <tr><td>ソフト：Apache<br />OS：CentOS<br />SSH：TeraTerm<br />ファイル転送：WinSCP</td></tr>
      </table>
    </div>

    <div class="module">
    <h3><i class="fas fa-edit"></i> 学習テーマ</h3>
      <table>
        <tr><th>PHP</th><td>MVCモデルによるファイルの区分／PDOクラスによるデータベースとの接続／画像のアップロードやページング機能等</td></tr>
        <tr><th>JavaScript,マークアップ</th><td>jQueryによるsubmit前のconfirm等クリックイベント／スマートフォンとPCのレイアウト変更</td></tr>
        <tr><th>MySQL</th><td>SQL文によるdatabase、user、table作成／tableやレコードの編集、操作／2つ以内のテーブル結合、クロス集計／mysqldumpによるsqlデータのバックアップと別DBサーバへの移行</td></tr>
        <tr><th>サーバ学習</th><td>touch,less,vi等によるファイルの操作／epil,remi等リポジトリの設定、yumコマンドによるインストール、PDO等のドライバ確認／firewallのサービス設定／
          その他パーミッションやuser,group操作、.htaccessファイルの記述等を独学中</td></tr>
      </table>
    </div>
  </section>

  <section class="owner-content">
    <h2>ー　ページ作成者　ー</h2>
    <div class="ownImage">
      <img src="own.jpg" alt="owner">
    </div>
    <h3 style="margin-top:0;">木村良太</h3>
    <ul style="padding:0;">
      <li><address>080-7791-3937</address></li>
      <li>2009年11月 司法書士取得</li>
      <li>2018年11月 ITパスポート取得</li>
    </ul>
    </section>

</div>
</body>
</html>
