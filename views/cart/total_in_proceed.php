<div class="div_subtotal_table">
  <div class="col-xs-12 table-list-row">
    <?php if(isset($handlingcost) && ($handlingcost > 0)) { ?>
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-2">Handling</div>
          <div class="col-sm-8">$<?= number_format($handlingcost, 2); ?></div>
        </div>
      </div>
    <?php } ?>
    <?php if(isset($shipDiscount) && ($shipDiscount > 0)) { ?>
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-2">Shipping Discount</div>
          <div class="col-sm-8">$<?= number_format($shipDiscount, 2); ?></div>
        </div>
      </div>
    <?php } ?>
    <?php if(isset($couponDiscount) && ($couponDiscount > 0)) { ?>
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-2">Coupon Redemption</div>
          <div class="col-sm-8">$<?= number_format($couponDiscount, 2); ?></div>
        </div>
      </div>
    <?php } ?>
    <?php if(isset($taxes) && ($taxes > 0)) { ?>
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-2">Taxes</div>
          <div class="col-sm-8">$<?= number_format($taxes, 2); ?></div>
        </div>
      </div>
    <?php } ?>
    <?php if(isset($total) && ($total > 0)) { ?>
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-2">Total</div>
          <div class="col-sm-8">$<?= number_format($total, 2); ?></div>
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
