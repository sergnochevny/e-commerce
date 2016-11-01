<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-xs-12 text-center afterhead-row">
        <h3 class="page-title">
          <?php if((isset($cart_samples_items) && strlen($cart_samples_items) > 0) || (isset($cart_items) && strlen($cart_items) > 0)): ?>
            Cart
          <?php else: ?>
            Your cart is empty, yet...
          <?php endif; ?>
        </h3>
      </div>
    </div>

    <?php if(isset($cart_items) && strlen($cart_items) > 0): ?>
      <div class="row" data-block="products-cart-list">
        <div class="col-xs-12 data-view">
          <div class="col-xs-12 table-list-header hidden-xs">
            <div class="row">
              <div class="col-sm-4 col">
                <a href="#">Products</a>
              </div>
              <div class="col-sm-2 col">
                <a href="#">Price</a>
              </div>
              <div class="col-sm-2 col">
                <a href="#">Discount</a>
              </div>
              <div class="col-sm-2 col">
                <a href="#">Quantity</a>
              </div>
              <div class="col-sm-1 col">
                <a href="#">Total</a>
              </div>
            </div>
          </div>
          <div class="col-xs-12 table-list-row" data-block="product_in_cart">
            <div class="row">
              <?= isset($cart_items) ? $cart_items : ''; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 inner-offset-vertical" data-block="row_subtotal_items">
        <div class="row">
          <div class="col-sm-2 col-sm-offset-8"><b>Fabrics Subtotal:</b></div>
          <div class="col-sm-2" data-block="subtotal_items" data-title="Subtotal">
            <?= isset($sum_items) ? $sum_items : ''; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-xs-12 text-center">
        <hr class="half-outer-offset-top"/>
      </div>
    </div>

    <?php if(isset($cart_samples_items) && strlen($cart_samples_items) > 0): ?>
      <div class="col-xs-12 inner-offset-bottom" data-block="samples_legend">
        <div class="row">
          <?= isset($cart_samples_legend) ? $cart_samples_legend : ''; ?>
        </div>
      </div>
      <div class="row" data-block="samples_table">
        <div class="col-xs-12 data-view">
          <div class="col-xs-12 table-list-header hidden-xs">
            <div class="row">
              <div class="col-sm-10 col">
                <a href="#">Product</a>
              </div>
              <div class="col-sm-2 col">
                <a href="#">Quantity</a>
              </div>
            </div>
          </div>
          <div class="col-xs-12 table-list-row">
            <div class="row">
              <?= isset($cart_samples_items) ? $cart_samples_items : ''; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 inner-offset-vertical" data-block="row_subtotal_samples">
        <div class="row">
          <div class="col-sm-2 col-sm-offset-8">Samples Subtotal:</div>
          <div class="col-sm-2" data-block="subtotal_samples_items"><b><?= isset($sum_samples) ? $sum_samples : ''; ?></b></div>
        </div>
      </div>

      <?php if((isset($cart_samples_items) && strlen($cart_samples_items) > 0) && (isset($cart_items) && strlen($cart_items) > 0)): ?>
        <div class="col-xs-12 inner-offset-bottom" data-block="row_subtotal">
          <div class="row">
            <div class="col-xs-12 col-sm-2 col-sm-offset-8">
              Subtotal
            </div>
            <div class="col-xs-12 col-sm-2">
              <b data-block="subtotal"><?= $sum_all_items; ?></b>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <?php if((isset($cart_items) && strlen($cart_items) > 0) || (isset($cart_samples_items) && strlen($cart_samples_items) > 0)): ?>
      <div data-block="div_subtotal_table">
        <div class="row">
          <div class="col-xs-12 data-view">
            <div class="col-xs-12 table-list-row" data-block="subtotal_table">
              <div class="row">
                <div class="" data-block="shipping">
                  <?= isset($shipping) ? $shipping : ''; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-12 inner-offset-top">
          <div class="row">
            <div class="col-xs-12 col-sm-3">
              Subtotal
            </div>
            <div class="col-xs-12 col-sm-4" data-block="subtotal_ship">
              $<?= number_format($subtotal_ship, 2); ?> USD
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-xs-12">
        <div class="row" data-block="coupon_total">
          <?= isset($coupon_total) ? $coupon_total : ''; ?>
        </div>
        <div class="row text-center">
          <div class="col-xs-12 inner-offset-top wc-proceed-to-checkout">
            <a class="checkout-button button alt wc-forward cont-shop" href="<?= _A_::$app->router()->UrlTo('shop') ?>">
              <?php if((isset($cart_samples_items) && strlen($cart_samples_items) > 0) || (isset($cart_items) && strlen($cart_items) > 0)): ?>
                CONTINUE SHOPPING
              <?php else: ?>
                GO SHOPPING
              <?php endif; ?>
            </a>
            <?php if((isset($cart_items) && strlen($cart_items) > 0) || (isset($cart_samples_items) && strlen($cart_samples_items) > 0)): ?>
              <a data-block="proceed_button" class="checkout-button button alt wc-forward"
                 href="<?= _A_::$app->router()->UrlTo('cart/proceed_checkout') ?>">Proceed to Checkout</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
