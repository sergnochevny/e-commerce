<div class="col-xs-12 table-list-row" data-block="cart_item" data-pid="<?= $pid; ?>" data-row="items">
  <div class="col-xs-12 col-sm-6 table-list-row-item">
    <div class="row">
      <?= $item['pname']; ?>
    </div>
  </div>
  <div class="col-xs-12 col-sm-2 table-list-row-item">
    <div class="row">
      <div class="col-xs-4 visible-xs">
        <div class="row"><b>Sale Price:</b></div>
      </div>
      <div class="col-xs-8 col-sm-12">
        <div class="row">
          <span class="amount"><?= $item['format_sale_price']; ?></span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-2 table-list-row-item">
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
  <div class="col-xs-12 col-sm-2 table-list-row-item">
    <div class="row">
      <div class="col-xs-4 visible-xs">
        <div class="row"><b>Total:</b></div>
      </div>
      <div class="col-xs-8 col-sm-12">
        <div class="row"><span class="amount"><?= $t_pr; ?></span></div>
      </div>
    </div>
  </div>
</div>