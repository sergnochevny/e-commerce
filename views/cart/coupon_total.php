<?php if(isset($cart_items) && count($cart_items) > 0): ?>
  <div class="col-sm-12 inner-offset-top" data-block="coupon_section">
    <div class="row">
      <div class="col-sm-12" data-block="coupon">
        <div class="row">
          <div class="col-xs-8">
            <div id="coupon_code_init" class="row">
              <label for="coupon_code">Coupon code:</label>
              <input id="coupon_code" type="text"
                     placeholder="Coupon code"
                     value="<?= isset($coupon_code) ? $coupon_code : '' ?>"
                     data-block="coupon_code"
                     class="input-text" name="coupon_code"/>
            </div>
          </div>
          <div class="col-xs-4">
            <input type="button"
                   value="Apply Coupon"
                   data-block="apply_coupon"
                   class="btn button"/>
          </div>
        </div>
      </div>

      <div class="col-sm-12 inner-offset-top">
        <div class="row">
          <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="row">
              COUPON REDEMPTION:
            </div>
          </div>
          <div class="col-md-9 col-sm-9 col-xs-6">
            <div data-block="coupon_discount" class="row">
              <b>$<?= number_format($coupon_discount, 2); ?> USD</b>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php if(isset($taxes) && ($taxes > 0)) { ?>
  <div class="col-sm-12 inner-offset-top">
    <div class="row">
      <div class="col-md-3 col-sm-3 col-xs-6">
        <div class="row">
          TAXES
        </div>
      </div>
      <div class="col-md-9 col-sm-9 col-xs-6">
        <div class="row">
          <b>$<?= number_format($taxes, 2); ?> USD</b>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<div class="col-sm-12">
  <div class="row">
    <div class="col-md-3 col-sm-3 col-xs-6 inner-offset-top">
      <div class="row">
        TOTAL:
      </div>
    </div>
    <div class="col-md-9 col-sm-9 col-xs-6 inner-offset-top">
      <div data-block="cart_total" class="row">
        <b>$<?= number_format($total, 2); ?> USD</b>
      </div>
    </div>
  </div>
</div>
<script src='<?= /** @noinspection PhpUndefinedMethodInspection */
  _A_::$app->router()->UrlTo('views/js/cart/code.min.js'); ?>' type="text/javascript"></script>
