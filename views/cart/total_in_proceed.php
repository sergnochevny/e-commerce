<?php if((isset($cart_items) && count($cart_items) > 0) || (isset($cart_samples_items) && count($cart_samples_items) > 0)) : ?>
  <div class="div_subtotal_table">
    <div class="col-xs-12 table-list-row">
      <?php if(isset($handlingcost) && ($handlingcost > 0)) { ?>
        <div class="row">
          <div class="col-sm-12 table-list-row-item">
            <div class="row">
              <div class="col-sm-10 text-right"><b>Handling:</b></div>
              <div class="col-sm-2"><b>$<?= number_format($handlingcost, 2); ?></b></div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if(isset($shipDiscount) && ($shipDiscount > 0)) { ?>
        <div class="row">
          <div class="col-sm-12 table-list-row-item">
            <div class="row">
              <div class="col-sm-10 text-right"><b>Shipping Discount:</b></div>
              <div class="col-sm-2"><b>$<?= number_format($shipDiscount, 2); ?></b></div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(isset($couponDiscount) && ($couponDiscount > 0)) { ?>
        <div class="row">
          <div class="col-sm-12 table-list-row-item">
            <div class="row">
              <div class="col-sm-10 text-right"><b>Coupon Redemption:</b></div>
              <div class="col-sm-2"><b>$<?= number_format($couponDiscount, 2); ?></b></div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(isset($taxes) && ($taxes > 0)) { ?>
        <div class="row">
          <div class="col-sm-12 table-list-row-item">
            <div class="row">
              <div class="col-sm-10 text-right"><b>Taxes:</b></div>
              <div class="col-sm-2"><b>$<?= number_format($taxes, 2); ?></b></div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(isset($total) && ($total > 0)) { ?>
        <div class="row">
          <div class="col-sm-12 table-list-row-item">
            <div class="row">
              <div class="col-sm-10 text-right"><b>Total:</b></div>
              <div class="col-sm-2"><b>$<?= number_format($total, 2); ?></b></div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(isset($discount) && ($discount > 0)) { ?>
        <div class="row">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-10 text-right"><b style="color: red;">You Saved:</b></div>
              <div class="col-sm-2"><b style="color: red;">$<?= number_format($discount, 2); ?></b></div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
<?php endif; ?>