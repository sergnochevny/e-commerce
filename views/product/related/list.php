<?php if(!empty($list)): ?>
  <div class="col-xs-12">
    <div class="row">
      <h3 class="section-title">Related Fabrics</h3>
    </div>
  </div>
  <div class="row related-selected">
    <div class="col-xs-12">
      <div class="col-xs-12">
        <div class="row" data-carousel data-related>
          <?= $list; ?>
        </div>
      </div>
      <div class="text-center">
        <a data-related-add class="button" style="width: 150px;">Add new</a>
      </div>
    </div>
  </div>
  <div class="col-xs-12">
    <hr>
  </div>
<?php endif; ?>

