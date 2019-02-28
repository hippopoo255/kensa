<div>
  <h2>販売期限ルール</h2>
  <table>
    <tr><th>分類コード</th><th>分類名</th><th>値引開始起算点</th><th>驚安開始起算点</th><th>撤去起算点</th></tr>
    <?php foreach($app->getValues()->dateRules as $dateRule): ?>
    <tr><td><?= $dateRule->categoryCode; ?></td><td><?= $dateRule->categoryName; ?></td><td><?= $dateRule->nebikiPoint; ?></td><td><?= $dateRule->kyoyasuPoint; ?></td><td><?= $dateRule->tekkyoPoint; ?></td></tr>
    <?php endforeach; ?>
  </table>
</div>
<div>
  <h2>商品一覧</h2>
  <table>
    <tr><th>JANコード</th><th>商品名</th><th>分類コード</th></tr>
    <?php foreach($app->getValues()->items as $item): ?>
    <tr><td><?= $item->janCode; ?></td><td><?= $item->name; ?></td><td><?= $item->categoryCode; ?></td></tr>
    <?php endforeach; ?>
  </table>
</div>
<div style="background:#eee;">
  <h2>入力方法</h2>
  <p style="margin:0;">1.JAN→商品日付→個数の順で入力<br>2.商品一覧に無いものはその他の箇所も入力</p>
</div>
