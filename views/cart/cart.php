<div class="col-md-12">
  <div class="row">
    <div class="col-xs-12 text-center afterhead-row">
      <div class="row">
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
      <div class="col-xs-12 cart-data-view" data-block="products-cart-list">
        <div class="row">
          <div class="col-xs-12 table-list-header hidden-xs">
            <div class="col-sm-4 col">
              <div class="row">
                Products
              </div>
            </div>
            <div class="col-sm-2 col">
              <div class="row">
                Price
              </div>
            </div>
            <div class="col-sm-2 col">
              <div class="row">
                Discount
              </div>
            </div>
            <div class="col-sm-2 col">
              <div class="row">
                Quantity
              </div>
            </div>
            <div class="col-sm-1 col">
              <div class="row">
                Total
              </div>
            </div>
          </div>
          <div class="col-xs-12 table-list-body" data-block="product_in_cart">
            <div class="row">
              <?= isset($cart_items) ? $cart_items : ''; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 inner-offset-vertical" data-block="row_subtotal_items">
        <div class="row">
          <div class="col-xs-6 col-sm-4 col-sm-offset-5">
            <div class="row text-right">
              <b>Fabrics Subtotal:</b>
            </div>
          </div>
          <div class="col-xs-4 col-xs-offset-2 col-sm-2 col-sm-offset-1" data-block="subtotal_items"
               data-title="Subtotal">
            <div class="row">
              <b><?= isset($sum_items) ? $sum_items : ''; ?></b>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php if(isset($cart_samples_items) && strlen($cart_samples_items) > 0): ?>
      <div class="col-xs-12 inner-offset-bottom">
        <div class="row" data-block="samples_legend">
          <?= isset($cart_samples_legend) ? $cart_samples_legend : ''; ?>
        </div>
      </div>
      <div class="col-xs-12 cart-data-view" data-block="samples_table">
        <div class="row">
          <div class="col-xs-12 table-list-header hidden-xs">
            <div class="col-sm-8 col">
              <div class="row">
                Product
              </div>
            </div>
            <div class="col-sm-2 col">
              <div class="row">
                Quantity
              </div>
            </div>
          </div>
          <div class="col-xs-12 table-list-body">
            <div class="row">
              <?= isset($cart_samples_items) ? $cart_samples_items : ''; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 inner-offset-vertical" data-block="row_subtotal_samples">
        <div class="row">
          <div class="col-xs-6 col-sm-4 col-sm-offset-5">
            <div class="row text-right">
              <b>Samples Subtotal:</b>
            </div>
          </div>
          <div class="col-xs-4 col-xs-offset-2 col-sm-2 col-sm-offset-1" data-block="subtotal_samples_items">
            <div class="row">
              <b><?= isset($sum_samples) ? $sum_samples : ''; ?></b>
            </div>
          </div>
        </div>
      </div>

      <?php if((isset($cart_samples_items) && strlen($cart_samples_items) > 0) && (isset($cart_items) && strlen($cart_items) > 0)): ?>
        <div class="col-xs-12 inner-offset-bottom" data-block="row_subtotal">
          <div class="row">
            <div class="col-xs-6 col-sm-4 col-sm-offset-5">
              <div class="row text-right">
                <b>Subtotal:</b>
              </div>
            </div>
            <div class="col-xs-4 col-xs-offset-2 col-sm-2 col-sm-offset-1">
              <div class="row">
                <b data-block="subtotal"><?= $sum_all_items; ?></b>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <?php if((isset($cart_items) && strlen($cart_items) > 0) || (isset($cart_samples_items) && strlen($cart_samples_items) > 0)): ?>
      <div class="col-xs-12" data-block="div_subtotal_table">
        <div class="row">
          <div class="col-xs-12 cart-data-view table-list-row" data-block="subtotal_table">
            <div class="row" data-block="shipping">
              <?= isset($shipping) ? $shipping : ''; ?>
            </div>
          </div>

          <div class="col-xs-12 inner-offset-top">
            <div class="row">
              <div class="col-xs-4">
                <div class="row">
                  <b>Subtotal:</b>
                </div>
              </div>
              <div class="col-xs-2" data-block="subtotal_ship">
                <div class="row">
                  <b>$<?= number_format($subtotal_ship, 2); ?> USD</b>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="col-xs-12">
      <div class="row" data-block="coupon_total">
        <?= isset($coupon_total) ? $coupon_total : ''; ?>
      </div>
    </div>
    <div class="col-xs-12 inner-offset-top wc-proceed-to-checkout">
      <div class="row text-center">
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
