<?php

use app\core\App;

?>
<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <?php $prms['ptrn'] = $row['id']; ?>
    <div class="col-xs-6 col-sm-3 list-item">
      <div class="list-inner">
        <a data-filter href="<?= App::$app->router()->UrlTo('shop/filter', $prms); ?>">
          <div class="item-name"><?= $row['pattern']; ?></div>
        </a>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-xs-12 text-center inner-offset-vertical">
    <span class="h3">No results found</span>
  </div>
<?php endif; ?>