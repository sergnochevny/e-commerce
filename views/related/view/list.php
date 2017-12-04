<?php if(!empty($list)): ?>
  <div class="col-xs-12 box outer-offset-bottom half-inner-offset-vertical">
    <h3 class="section-title">Related Fabrics</h3>
    <div class="col-xs-12">
      <div class="row">
        <div data-carousel class="products owl-carousel">
          <?= $list; ?>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

