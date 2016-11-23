<?php if((count($cart_items) > 0) && isset($shipping) && ($shipping > 0)) { ?>
  <div class="col-xs-12 table-list-row">
    <div class="col-xs-12 col-sm-6 table-list-row-item">
      <div class="row">
        <?= ($shipping == 1) ? 'Express Post' : '' ?>
        <?= ($shipping == 3) ? 'Ground Ship' : '' ?>
      </div>
    </div>
    <div class="col-xs-12 col-sm-2 col-sm-offset-4 table-list-row-item">
      <div class="row">
        <div class="col-xs-4 visible-xs">
          <div class="row"><b>Total:</b></div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><span class="amount">$<?= number_format($shipcost, 2); ?></span></div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<?php if((count($cart_items) > 0) && isset($bShipRoll) && $bShipRoll) { ?>
  <div class="col-xs-12 table-list-row">
    <div class="col-xs-12 col-sm-6 table-list-row-item">
      <div class="row">
        Ship fabric on a roll
      </div>
    </div>
    <div class="col-xs-12 col-sm-2 col-sm-offset-4 table-list-row-item">
      <div class="row">
        <div class="col-xs-4 visible-xs">
          <div class="row"><b>Total:</b></div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><span class="amount">$<?= number_format($rollcost, 2); ?></span></div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<?php if((count($cart_samples_items) > 0) && ($bExpressSamples) && !(count($cart_items) > 0)) { ?>
  <div class="col-xs-12 table-list-row">
    <div class="col-xs-12 col-sm-6 table-list-row-item">
      <div class="row">
        Deliver by overnight courier
      </div>
    </div>
    <div class="col-xs-12 col-sm-2 col-sm-offset-4 table-list-row-item">
      <div class="row">
        <div class="col-xs-4 visible-xs">
          <div class="row"><b>Total:</b></div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><span class="amount">$<?= number_format($express_samples_cost, 2); ?></span></div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<div class="col-xs-12 table-list-row">
  <div class="col-xs-6 col-sm-10 table-list-row-item text-right">
      <b>Subtotal:</b>
  </div>
  <div class="col-xs-6 col-sm-2 coltable-list-row-item">
    <div class="row">
      <span class="amount"><b>$<?= number_format($total, 2); ?></b></span>
    </div>
  </div>
</div>
