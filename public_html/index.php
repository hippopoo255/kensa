<?php
require_once(__DIR__ . '/../config/config.php');
$app = new MyApp\Controller\Index();
$app->run();
// ログインユーザーの情報...$app->me();
// ユーザー一覧...$app->getValues()->users;
require_once('header.php');
?>


<div class="container">

    <h1>- Dash Board -</h1>
    <ul class="dashboards">
      <?php foreach($app->getDashboards() as $dashboard): ?>
      <li class="dashboard">
        <p class="title"><?= $app->getNow()->modify('-3 day')->format('Y年n月'); ?>ワーストランキング(<?= $dashboard[0]['cateName']; ?>)</p>
        <table>
          <tr><th>店番</th><th>店名</th><th class="lavel">得点</th></tr>
          <?php for($i = 0;$i<count($dashboard);$i++): ?>
          <tr>
            <td><?= $dashboard[$i]['storeId']; ?></td>
            <td><?= $dashboard[$i]['storeName']; ?></td>
            <td><?= $dashboard[$i]['cateName'] !== '販売期限' ? $dashboard[$i]['totalPoint'] . '点' : $dashboard[$i]['count_kire'] . '個' ; ?></td>
          </tr>
        <?php endfor; ?>
        </table>
      </li>
      <?php endforeach; ?>
    </ul>
    <div class="clear"></div>
</div>
<div class="container">
  <h1>- Menu -</h1>
  <ul class="menus">
    <li class="menu">
      <a href="selectStore.php"><img src="img/menu1.png"></a>
      <p>検査</p>
    </li>
    <li class="menu">
      <a href=""><img src="img/menu2.png"></a>
      <p>集計<br>(準備中)</p>
    </li>
    <li class="menu" id="admin_only">
      <a href="master.php"><img src="img/menu3.png"></a>
      <p>マスター管理<br>(準備中)</p>
    </li>
  </ul>
</div>
    <?php require_once("footer.php"); ?>
