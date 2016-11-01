<?php if ((isset($cart_items) && count($cart_items) > 0) || (isset($cart_samples_items) && count($cart_samples_items) > 0)) { ?>
  <div class="div_subtotal_table">
    <div class="col-xs-12 table-list-row">
      <?php if (isset($handlingcost) && ($handlingcost > 0)) { ?>
        <div class="row">
          <div class="col-sm-12 table-list-row-item">
            <div class="row">
              <div class="col-sm-10 text-right">Handling</div>
              <div class="col-sm-2">$<?= number_format($handlingcost, 2); ?></div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if (isset($shipDiscount) && ($shipDiscount > 0)) { ?>
        <div class="row">
          <div class="col-sm-12 table-list-row-item">
            <div class="row">
              <div class="col-sm-10 text-right">Shipping Discount</div>
              <div class="col-sm-2">$<?= number_format($shipDiscount, 2); ?></div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if (isset($couponDiscount) && ($couponDiscount > 0)) { ?>
        <div class="row">
          <div class="col-sm-12 table-list-row-item">
            <div class="row">
              <div class="col-sm-10 text-right">Coupon Redemption</div>
              <div class="col-sm-2">$<?= number_format($couponDiscount, 2); ?></div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if (isset($taxes) && ($taxes > 0)) { ?>
        <div class="row">
          <div class="col-sm-12 table-list-row-item">
            <div class="row">
              <div class="col-sm-10 text-right">Taxes</div>
              <div class="col-sm-2">$<?= number_format($taxes, 2); ?></div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if (isset($total) && ($total > 0)) { ?>
        <div class="row">
          <div class="col-sm-12 table-list-row-item">
            <div class="row">
              <div class="col-sm-10 text-right">Total</div>
              <div class="col-sm-2">$<?= number_format($total, 2); ?></div>
            </div>
          </div>
        </div>
      <?php } ?>

    <?php if (isset($discount) && ($discount > 0)) { ?>
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-2">You Saved</div>
          <div class="col-sm-8">$<?= number_format($discount, 2); ?></div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
