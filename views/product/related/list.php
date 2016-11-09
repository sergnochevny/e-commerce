<div class="col-xs-12">
  <h3 class="section-title">Related Fabrics</h3>
</div>
<div class="row related-selected">
  <div class="col-xs-12">
    <div class="col-xs-12" style="margin-bottom: 30px">
      <div class="owl-carousel" data-carousel data-related>
        <?php if(!empty($list)): ?>
          <?= $list; ?>
        <?php endif; ?>
      </div>
    </div>
    <div class="text-center">
      <a data-related-add class="button" style="width: 250px;">Add Related Fabrics</a>
    </div>
  </div>
</div>
