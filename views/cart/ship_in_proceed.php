<?php if ((count($cart_items) > 0) && isset($shipping) && ($shipping > 0)) { ?>

  <div class="row">
    <div class="col-sm-12 half-inner-offset-top">
      <div class="col-sm-4 text-right"><?= ($shipping == 1) ? 'Express Post' : '' ?>
        <?= ($shipping == 3) ? 'Ground Ship' : '' ?></div>
      <div class="col-sm-2 col-sm-offset-2">$<?= number_format($shipcost, 2); ?></div>
      <div class="col-sm-2">N/A</div>
      <div class="col-sm-2">$<?= number_format($shipcost, 2); ?></div>
    </div>
  </div>

<?php } ?>
<?php if ((count($cart_items) > 0) && isset($bShipRoll) && $bShipRoll) { ?>

  <div class="row">
    <div class="col-sm-12 half-inner-offset-top">
      <div class="col-sm-4 text-right">Ship fabric on a roll</div>
      <div class="col-sm-2 col-sm-offset-2">$<?= number_format($rollcost, 2); ?></div>
      <div class="col-sm-2"><span class="quantity">N/A</span></div>
      <div class="col-sm-2">$<?= number_format($rollcost, 2); ?></div>
    </div>
  </div>

<?php } ?>
<?php if ((count($cart_samples_items) > 0) && ($bExpressSamples) && !(count($cart_items) > 0)) { ?>

  <div class="row">
    <div class="col-sm-12 half-inner-offset-top">
      <div class="col-sm-4 text-right">Deliver by overnight courier</div>
      <div class="col-sm-2 col-sm-offset-2">$<?= number_format($express_samples_cost, 2); ?></div>
      <div class="col-sm-2"><span class="quantity">N/A</span></div>
      <div class="col-sm-2">$<?= number_format($express_samples_cost, 2); ?></div>
    </div>
  </div>

<?php } ?>

<div class="row">
  <div class="col-sm-12 half-inner-offset-top">
    <div class="col-sm-10 text-right">Sub Total:</div>
    <div class="col-sm-2">$<?= number_format($total, 2); ?></div>
  </div>
</div>