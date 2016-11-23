<?php if((isset($cart_items) && count($cart_items) > 0) || (isset($cart_samples_items) && count($cart_samples_items) > 0)) : ?>
  <div class="div_subtotal_table col-xs-12 cart-data-view">
    <div class="row">
      <?php if(isset($handlingcost) && ($handlingcost > 0)) { ?>
        <div class="col-xs-12 table-list-row">
          <div class="col-xs-6 col-sm-10 text-right table-list-row-item">
            <b>Handling:</b>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="row">
              <b>$<?= number_format($handlingcost, 2); ?></b>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if(isset($shipDiscount) && ($shipDiscount > 0)) { ?>
        <div class="col-xs-12 table-list-row">
          <div class="col-xs-6 col-sm-10 text-right table-list-row-item">
            <b>Shipping Discount:</b>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="row">
              <b>$<?= number_format($shipDiscount, 2); ?></b>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(isset($couponDiscount) && ($couponDiscount > 0)) { ?>
        <div class="col-xs-12 table-list-row">
          <div class="col-xs-6 col-sm-10 text-right table-list-row-item">
            <b>Coupon Redemption:</b>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="row">
              <b>$<?= number_format($couponDiscount, 2); ?></b>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(isset($taxes) && ($taxes > 0)) { ?>
        <div class="col-xs-12 table-list-row">
          <div class="col-xs-6 col-sm-10 text-right table-list-row-item">
            <b>Taxes:</b>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="row">
              <b>$<?= number_format($taxes, 2); ?></b>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(isset($total) && ($total > 0)) { ?>
        <div class="col-xs-12 table-list-row">
          <div class="col-xs-6 col-sm-10 text-right table-list-row-item">
            <b>Total:</b>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="row">
              <b>$<?= number_format($total, 2); ?></b>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(isset($discount) && ($discount > 0)) { ?>
        <div class="col-xs-12  table-list-row">
          <div class="col-xs-6 col-sm-10 text-right table-list-row-item">
            <b style="color: red;">You Saved:</b>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="row">
              <b style="color: red;">$<?= number_format($discount, 2); ?></b>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
<?php endif; ?>