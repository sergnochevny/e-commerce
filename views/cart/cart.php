<div class="row">
  <div class="col-md-12">

    <div class="page type-page status-publish entry" style="overflow:hidden;">

      <div class="col-xs-12 text-center afterhead-row">
        <h3 class="page-title">Cart</h3>
      </div>

      <div class="row">
        <div class="col-xs-12 data-view">

          <div class="col-xs-12 table-list-header hidden-xs">
            <div class="row">
              <div class="col-sm-5 col">Product</div>
              <div class="col-sm-1 col">Price</div>
              <div class="col-sm-2 col">Discount</div>
              <div class="col-sm-2 col">Quantity</div>
              <div class="col-sm-1 col">Total</div>
            </div>
          </div>

          <div id="product_in_cart" class="col-xs-12 table-list-row">
            <?= isset($cart_items) ? $cart_items : ''; ?>
            <?php
              if (isset($cart_items) && strlen($cart_items) > 0) { ?>
                <div class="row cart_item table-list-row-item">
                  <hr class="half-outer-offset-vertical">
                </div>
                <div id="row_subtotal_items" class="row cart_item table-list-row-item">
                  <div class="col-xs-12 table-list-row-item">
                    <div class="row">
                      <div class="col-xs-2 text-right">
                        <b>Subtotal:</b>
                      </div>
                      <div id="subtotal_items" class="col-xs-10">
                        <?= isset($sum_items) ? $sum_items : ''; ?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col-xs-12 data-view">

          <?php if (isset($cart_samples_items) && strlen($cart_samples_items) > 0) { ?>
            <div class="col-xs-12 table-list-row">
              <div id="samples_legend" class="row">
                <?= isset($cart_samples_legend) ? $cart_samples_legend : ''; ?>
              </div>
            </div>

            <?php if (isset($cart_samples_items)) { ?>

              <div id="samples_table" class="row">
                <div class="col-xs-12 data-view">

                  <div class="col-xs-12 table-list-header hidden-xs">
                    <div class="row">
                      <div class="col-sm-10 col">Product</div>
                      <div class="col-sm-2 col">Quantity</div>
                    </div>
                  </div>

                  <div class="col-xs-12 table-list-row">
                    <?= $cart_samples_items ?>
                    <?php if (isset($cart_items) && strlen($cart_items) > 0) { ?>
                      <div id="row_subtotal_samples" class="row">
                        <div class="col-xs-12 table-list-row-item">
                          <div class="row">
                            <div class="col-xs-2">
                              Subtotal:
                            </div>
                            <div id="subtotal_samples_items" class="col-xs-10">
                              <?= isset($sum_samples) ? $sum_samples : ''; ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>

            <?php } ?>
          <?php } ?>

          <?php if ((isset($cart_items) && strlen($cart_items) > 0) || (isset($cart_samples_items) && strlen($cart_samples_items) > 0)) { ?>
            <?php
            if ((isset($cart_samples_items) && strlen($cart_samples_items) > 0)
              && (isset($cart_items) && strlen($cart_items) > 0)
            ) {
              ?>
              <div class="col-xs-12 table-list-row">
                <div id="div_subtotal_table" class="row">
                  <div id="subtotal_table" class="col-xs-12 table-list-row-item">
                    <div id="row_subtotal" class="row">
                      <div class="col-xs-2">
                        Subtotal:
                      </div>
                      <div id="subtotal" class="col-xs-10">
                        <?= isset($sum_all_items) ? $sum_all_items : ''; ?>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            <?php } ?>
          <?php } ?>

          <div class="col-xs-12 half-inner-offset-vertical">
            <?php if ((isset($cart_samples_items) && strlen($cart_samples_items) > 0)
              && (isset($cart_items) && strlen($cart_items) > 0)
            ) { ?>
              <div id="shipping" class="row">
                <?php echo isset($shipping) ? $shipping : ''; ?>
              </div>
              <div class="row">
                <div class="col-xs-12 table-list-row-item">
                  <div class="row">
                    <div class="col-xs-2">
                      Subtotal:
                    </div>
                    <div id="subtotal_ship" class="col-xs-10">
                      $<?= number_format($subtotal_ship, 2); ?> USD
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
            <div class="row">
              <div id="coupon_total">
                <?= isset($coupon_total) ? $coupon_total : ''; ?>
              </div>

              <div class="col-xs-12 text-center">
                <a class="checkout-button button" href="<?= _A_::$app->router()->UrlTo('shop') ?>">
                  CONTINUE SHOPPING
                </a>

                <?php if (
                  (isset($cart_items) && strlen($cart_items) > 0) ||
                  (isset($cart_samples_items) && strlen($cart_samples_items) > 0)
                ) { ?>

                  <a id="proceed_button" class="checkout-button button"
                     href="<?= _A_::$app->router()->UrlTo('cart/proceed_checkout') ?>">
                    Proceed to Checkout
                  </a>
                <?php } ?>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>


