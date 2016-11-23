<div class="col-xs-12 table-list-row" data-block="sample_item" data-pid="<?= $pid; ?>" data-row="samples">
  <div class="col-xs-12 col-sm-6 table-list-row-item">
    <div class="row">
      SAMPLE - <?= $item['Product_name']; ?>
    </div>
  </div>
  <div class="col-xs-12 col-sm-2 col-sm-offset-2 table-list-row-item">
    <div class="row">
      <div class="col-xs-4 visible-xs">
        <div class="row"><b>Quantity:</b></div>
      </div>
      <div class="col-xs-8 col-sm-12">
        <div class="row">
          <?= $item['quantity']; ?>
        </div>
      </div>
    </div>
  </div>
</div>