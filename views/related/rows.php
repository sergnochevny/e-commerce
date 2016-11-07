<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <?php $prms['pid'] = $row['pid'];
    if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>
    <div class="col-xs-6 col-sm-3 col-md-2 product-item for-related">
      <div class="product-inner">
        <figure class="product-image-box" style="background-image: url(<?= $row['filename']; ?>)"></figure>
        <span class="product-category"><?= $row['pname']; ?></span>
        <div class="form-row" style="margin-left: 0">
          <label class="inline" style="font-weight: normal"><input type="checkbox" name="related-select"> Add</label>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-sm-12 text-center offset-top">
    <h2 class="offset-top page-title">No results found</h2>
  </div>
<?php endif; ?>