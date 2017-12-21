<?php

use app\core\App;

?>
<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <?php $prms['cat'] = $row['cid']; ?>
    <div class="col-xs-6 col-sm-3 list-item">
      <div class="list-inner">
        <a title="<?=$row['cname']?>" data-waitloader data-sb href="<?= App::$app->router()->UrlTo('shop', $prms, $row['cname']); ?>">
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