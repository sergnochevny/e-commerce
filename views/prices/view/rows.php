<?php

use app\core\App;

?>
<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $key => $row): ?>
    <?php $prms = ['prc' => $key]; ?>
    <div class="col-xs-6 col-sm-3 list-item">
      <div class="list-inner">
        <a data-waitloader data-sb_prices
           href="<?= App::$app->router()->UrlTo('shop', $prms, isset($row['title']) ? $row['title'] : ('price-' . $row['min_price'] . '-' . $row['max_price'])); ?>"
           data-prices_from="<?= isset($row['min_price']) ? $row['min_price'] : ''; ?>"
           data-prices_to="<?= isset($row['max_price']) ? $row['max_price'] : ''; ?>">
          <div class="item-name">
            <?= isset($row['title']) ? $row['title'] : ('$' . number_format($row['min_price'], 2) . ' - $' . number_format($row['max_price'], 2)); ?>
          </div>
        </a>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>