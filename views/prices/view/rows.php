<?php

use app\core\App;

?>
<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $key => $row): ?>
    <?php
    $prm = 'a.priceyard';
    $data_filter_item_active = false;
    if(!empty($filter[$prm])) {
      $data_filter_item_active = in_array($row['id'], array_keys($filter[$prm]));
    }
    ?>
    <div class="col-xs-6 col-sm-3 list-item" <?= $data_filter_item_active ? 'data-filter-item-active' : ''; ?>>
      <div class="list-inner">
        <a data-filter data-filter-from_to data-filter-prm="<?= $prm; ?>" data-filter-val=<?= $row['id']; ?>
        <?= $data_filter_item_active ? 'data-filter-item-active' : ''; ?>
        href="<?= App::$app->router()->UrlTo('shop/filter'); ?>"
           data-from="<?= isset($row['min_price']) ? $row['min_price'] : ''; ?>"
           data-to="<?= isset($row['max_price']) ? $row['max_price'] : ''; ?>">
          <div class="item-name">
            <?= isset($row['title']) ? $row['title'] : ('$' . number_format($row['min_price'], 2) . ' - $' . number_format($row['max_price'], 2)); ?>
          </div>
        </a>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-xs-12 text-center inner-offset-vertical">
    <span class="h3">No results found</span>
  </div>
<?php endif; ?>