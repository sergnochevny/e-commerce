<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <?php $prms['clr'] = $row['id'];?>
    <div class="col-xs-6 col-sm-3 list-item">
      <div class="list-inner">
        <a  title="<?=$row['color']?>" data-sb data-waitloader href="<?= _A_::$app->router()->UrlTo('shop', $prms, $row['color']); ?>">
          <div class="item-name"><?= $row['color']; ?></div>
        </a>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-xs-12 text-center inner-offset-vertical">
    <span class="h3">No results found</span>
  </div>
<?php endif; ?>