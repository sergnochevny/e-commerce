<?php if (isset($cart_items) && count($cart_items) > 0): ?>
  <div class="col-sm-12" id="coupon_section">

    <div class="row">
      <div class="col-sm-12">
        <div class="col-md-3 inner-offset-top">Coupon code:</div>
        <div id="coupon" class="col-md-4 inner-offset-top form-row">
          <div class="row">
            <div class="col-sm-8">
              <input type="text"
                     placeholder="Coupon code"
                     value="<?= isset($coupon_code) ? $coupon_code : '' ?>"
                     id="coupon_code"
                     class="input-text" name="coupon_code">
            </div>
            <div class="col-sm-4">
              <input type="button"
                     value="Apply Coupon"
                     id="apply_coupon"
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
          <div id="coupon_discount"><b>$<?= number_format($coupon_discount, 2); ?> USD</b></div>
        </div>
      </div>
    </div>

  </div>
<?php endif; ?>

<?php if (isset($taxes) && ($taxes > 0)) { ?>
  <div class="col-sm-12">
    <div class="col-md-3 col-sm-3 col-xs-6 inner-offset-top">TAXES</div>
    <div class="col-md-9 col-sm-9 col-xs-6 inner-offset-top">
      <div><b>$<? number_format($taxes, 2); ?> USD</b></div>
    </div>
  </div>
<?php } ?>
<div class="col-sm-12">
  <div class="col-md-3 col-sm-3 col-xs-6 inner-offset-top">TOTAL:</div>
  <div class="col-md-9 col-sm-9 col-xs-6 inner-offset-top">
    <div id="cart_total"><b>$<?= number_format($total, 2); ?> USD</b></div>
  </div>
</div>

<!--
<?php if (isset($cart_items) && count($cart_items) > 0) { ?>
  <div id="coupon_section">
    <div class="row">
      <div class="col-md-3">Coupon code:</div>
      <div class="col-md-9">
        <div id="coupon">
          <input type="text" placeholder="Coupon code"
                 value="<? isset($coupon_code) ? $coupon_code : '' ?>"
                 id="coupon_code"
                 class="input-text" name="coupon_code">
          <input type="button" value="Apply Coupon"
                 id="apply_coupon" class="">
        </div>
      </div>
    </div>
    <hr/>
    <div class="row">
      <div class="col-md-3 col-sm-3 col-xs-6">COUPON REDEMPTION:</div>
      <div class="col-md-9 col-sm-9 col-xs-6">
        <div id="coupon_discount"><b>$<? number_format($coupon_discount, 2); ?> USD</b></div>
      </div>
    </div>
    <hr/>
  </div>
<?php } ?>
<?php if (isset($taxes) && ($taxes > 0)) { ?>
  <div class="row" style="margin:0;">
    <div class="col-md-3 col-sm-3 col-xs-6">TAXES</div>
    <div class="col-md-9 col-sm-9 col-xs-6">
      <div><b>$<? number_format($taxes, 2); ?> USD</b></div>
    </div>
  </div>
  <hr/>
<?php } ?>

<div class="row" style="margin:0">
  <div class="col-md-3 col-sm-3 col-xs-6 alert-danger" style="padding-top: 15px; padding-bottom: 15px">TOTAL:</div>
  <div class="col-md-9 col-sm-9 col-xs-6 alert-danger" style="padding-top: 15px; padding-bottom: 15px">
    <div id="cart_total"><b>$<? number_format($total, 2); ?> USD</b></div>
  </div>
</div>
<hr/>
-->