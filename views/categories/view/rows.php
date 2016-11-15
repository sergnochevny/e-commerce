<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <?php
    $prms['mnf'] = $row['id'];
    if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
    ?>
    <div class="col-xs-6 col-sm-3 list-item">
      <div class="list-inner">
        <a data-waitloader href="<?= _A_::$app->router()->UrlTo('shop', $prms, $row['manufacturer']); ?>">
          <div class="item-name"><?= $row['manufacturer']; ?></div>
        </a>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>