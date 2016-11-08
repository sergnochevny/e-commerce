<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <?php $prms['pid'] = $row['pid'];
    if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>
    <div class="col-xs-12 col-sm-6  product-item">
      <label class="product-block <?= (isset($related_selected) && in_array($row['pid'], $related_selected))?'checked':'';?>" style="font-weight: normal; margin-left: 0; height: auto">
        <input data-related_chk data-pid="<?= $row['pid']; ?>" type="checkbox"
               <?= (isset($related_selected) && in_array($row['pid'], $related_selected))?'checked':'';?>
               name="related-select[<?= $row['pid']; ?>]" style="display: none;"/>
        <div class="col-xs-3 col-sm-4 col-md-3 figure">
          <div class="row">
            <figure style="background-image: url(<?= $row['filename']; ?>)"></figure>
          </div>
        </div>
        <div class="col-xs-9 col-sm-8 col-md-9 product-desc">
          <span><?= $row['pname']; ?></span>
        </div>
      </label>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-sm-12 text-center offset-top">
    <h2 class="offset-top page-title">No results found</h2>
  </div>
<?php endif; ?>