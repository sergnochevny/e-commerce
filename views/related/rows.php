<?php if(count($data) > 0): ?>
  <?php foreach($data as $row): ?>
    <?php $prms['pid'] = $row['pid']; ?>
    <div class="col-xs-12 col-sm-6  product-item">
      <label class="product-block" style="font-weight: normal; margin-left: 0; height: auto">
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