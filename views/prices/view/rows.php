<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <?php
    $prms = ['prc' => 1];
    if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
    ?>
    <div class="col-xs-6 col-sm-3 list-item">
      <div class="list-inner">
        <a data-waitloader data-prices
           href="<?= _A_::$app->router()->UrlTo('shop', $prms, 'prices-'.$row['min_price'].'-'.$row['min_price']); ?>"
           data-prices_from="$row['min_price']" data-prices_to="$row['max_price']">
          <div class="item-name"><?= '$' . $row['min_price'] . ' - $' . $row['max_price']; ?></div>
        </a>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>