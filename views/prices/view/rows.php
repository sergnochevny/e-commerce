<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $key => $row): ?>
    <?php
    $prms = ['prc' => $key];
    if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
    ?>
    <div class="col-xs-6 col-sm-3 list-item">
      <div class="list-inner">
        <a data-waitloader data-sb_prices
           href="<?= _A_::$app->router()->UrlTo('shop', $prms, 'price-' . $row['min_price'] . '-' . $row['max_price']); ?>"
           data-prices_from="<?= $row['min_price']; ?>" data-prices_to="<?= $row['max_price']; ?>">
          <div class="item-name"><?= '$' . number_format($row['min_price'],2) . ' - $' . number_format($row['max_price'],2); ?></div>
        </a>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>