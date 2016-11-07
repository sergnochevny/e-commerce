<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <?php $prms['pid'] = $row['pid'];
    if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>
    <div class="col-xs-12">
      <div class="product-inner">
        <label class="inline" style="font-weight: normal; margin-left: 0; height: auto">
          <div class="form-row">
            <input type="checkbox" name="related-select">
            <figure class="product-image-box" style="background-image: url(<?= $row['filename']; ?>)"></figure>
            <span class="product-category"><?= $row['pname']; ?></span>
          </div>
        </label>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-sm-12 text-center offset-top">
    <h2 class="offset-top page-title">No results found</h2>
  </div>
<?php endif; ?>