<?php if(!empty($list)): ?>
  <div class="col-xs-12">
    <div class="row">
      <h3 class="section-title">Related Fabrics</h3>
    </div>
  </div>
  <div class="col-xs-12">
    <div class="row">
      <div data-carousel class="products">
        <?= $list; ?>
      </div>
    </div>
  </div>
<?php endif; ?>

