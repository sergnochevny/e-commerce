<?php if((count($cart_items) > 0) && isset($shipping) && ($shipping > 0)) { ?>

  <div class="row">
    <div class="col-sm-12 inner-offset-top">
      <div class="col-sm-3"><?= ($shipping == 1) ? 'Express Post' : '' ?>
        <?= ($shipping == 3) ? 'Ground Ship' : '' ?></div>
      <div class="col-sm-3">$<?= number_format($shipcost, 2); ?></div>
      <div class="col-sm-3">N/A</div>
      <div class="col-sm-3">$<?= number_format($shipcost, 2); ?></div>
    </div>
  </div>

<?php } ?>
<?php if((count($cart_items) > 0) && isset($bShipRoll) && $bShipRoll) { ?>

  <div class="row">
    <div class="col-sm-12 inner-offset-top">
      <div class="col-sm-3">Ship fabric on a roll</div>
      <div class="col-sm-3">$<?= number_format($rollcost, 2); ?></div>
      <div class="col-sm-3"><span class="quantity">N/A</span></div>
      <div class="col-sm-3">$<?= number_format($rollcost, 2); ?></div>
    </div>
  </div>

<?php } ?>
<?php if((count($cart_samples_items) > 0) && ($bExpressSamples) && !(count($cart_items) > 0)) { ?>

  <div class="row">
    <div class="col-sm-12 inner-offset-top">
      <div class="col-sm-3">Deliver by overnight courier</div>
      <div class="col-sm-3">$<?= number_format($express_samples_cost, 2); ?></div>
      <div class="col-sm-3"><span class="quantity">N/A</span></div>
      <div class="col-sm-3">$<?= number_format($express_samples_cost, 2); ?></div>
    </div>
  </div>

<?php } ?>

<div class="row">
  <div class="col-sm-12 inner-offset-top">
    <div class="col-sm-3">Sub Total:</div>
    <div class="col-sm-9">$<?= number_format($total, 2); ?></div>
  </div>
</div>