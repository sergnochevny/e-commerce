<?php if (isset($cart_items) && count($cart_items) > 0): ?>
  <div class="col-sm-12" data-block="coupon_section">

    <div class="row">
      <div class="col-sm-12">
        <div class="col-md-3 inner-offset-top">Coupon code:</div>
        <div data-block="coupon" class="col-md-4 inner-offset-top form-row">
          <div class="row">
            <div class="col-sm-8">
              <input type="text"
                     placeholder="Coupon code"
                     value="<?= isset($coupon_code) ? $coupon_code : '' ?>"
                     data-block="coupon_code"
                     class="input-text" name="coupon_code">
            </div>
            <div class="col-sm-4">
              <input type="button"
                     value="Apply Coupon"
                     data-block="apply_coupon"
                     class="btn button">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="col-md-3 col-sm-3 col-xs-6 inner-offset-top">COUPON REDEMPTION:</div>
        <div class="col-md-9 col-sm-9 col-xs-6 inner-offset-top">
          <div data-block="coupon_discount"><b>$<?= number_format($coupon_discount, 2); ?> USD</b></div>
        </div>
      </div>
    </div>

  </div>
<?php endif; ?>

<?php if (isset($taxes) && ($taxes > 0)) { ?>
  <div class="col-sm-12">
    <div class="col-md-3 col-sm-3 col-xs-6 inner-offset-top">TAXES</div>
    <div class="col-md-9 col-sm-9 col-xs-6 inner-offset-top">
      <div><b>$<?= number_format($taxes, 2); ?> USD</b></div>
    </div>
  </div>
<?php } ?>
<div class="col-sm-12">
  <div class="col-md-3 col-sm-3 col-xs-6 inner-offset-top">TOTAL:</div>
  <div class="col-md-9 col-sm-9 col-xs-6 inner-offset-top">
    <div data-block="cart_total"><b>$<?= number_format($total, 2); ?> USD</b></div>
  </div>
</div>
