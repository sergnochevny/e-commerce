<?php

use app\core\App;

?>

<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <?php
    $prm = 'b.cid';
    $data_filter_item_active = false;
    if(!empty($filter_form[$prm])) {
      $data_filter_item_active = in_array($row['cid'], $filter_form[$prm]);
    }
    ?>
    <div class="col-xs-6 col-sm-3 list-item" <?= $data_filter_item_active ? 'data-filter-item-active' : ''; ?>>
      <div class="list-inner">
        <a data-filter data-filter-prm="<?= $prm; ?>" data-filter-val=<?= $row['cid']; ?>
          <?= $data_filter_item_active ? 'data-filter-item-active' : ''; ?>
           href="<?= App::$app->router()->UrlTo('shop/filter'); ?>">
          <div class="item-name"><?= $row['cname']; ?></div>
        </a>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-xs-12 text-center inner-offset-vertical">
    <span class="h3">No results found</span>
  </div>
<?php endif; ?>