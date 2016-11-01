<div class="row">
  <div class="col-md-12">

    <div class="row">
      <div class="col-xs-12 text-center afterhead-row">
        <h3 class="page-title">
          <?php if ((isset($cart_samples_items) && strlen($cart_samples_items) > 0) && (isset($cart_items) && strlen($cart_items) > 0)): ?>
            Cart
          <?php else: ?>
            Your cart is empty, yet...
          <?php endif; ?>
        </h3>
      </div>
    </div>

    <?php if (isset($cart_items) && strlen($cart_items) > 0): ?>
    <div class="row products-cart-list">
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

        <div class="col-xs-12 table-list-row" id="product_in_cart">
          <div class="row">
            <?= isset($cart_items) ? $cart_items : ''; ?>
          </div>
        </div>

      </div>
    </div>

      <div class="col-xs-12 inner-offset-vertical" id="row_subtotal_items">
        <div class="row">
          <div class="col-sm-2 col-sm-offset-8"><b>Subtotal:</b></div>
          <div class="col-sm-2" id="subtotal_items" data-title="Subtotal">
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

    <?php if (isset($cart_samples_items) && strlen($cart_samples_items) > 0): ?>
      <div class="col-xs-12 inner-offset-bottom" id="samples_legend">
        <div class="row">
          <?= isset($cart_samples_legend) ? $cart_samples_legend : ''; ?>
        </div>
      </div>

      <div class="row" id="samples_table">
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

      <div class="col-xs-12 inner-offset-vertical" id="row_subtotal_samples">
        <div class="row">
          <div class="col-sm-2 col-sm-offset-8">Simples Subtotal:</div>
          <div class="col-sm-2" id="subtotal_samples_items"><b><?= isset($sum_samples) ? $sum_samples : ''; ?></b></div>
        </div>
      </div>

      <?php if ((isset($cart_samples_items) && strlen($cart_samples_items) > 0) && (isset($cart_items) && strlen($cart_items) > 0)): ?>
        <div class="col-xs-12 inner-offset-bottom" id="row_subtotal">
          <div class="row">
            <div class="col-xs-12 col-sm-2 col-sm-offset-8">
              Subtotal
            </div>
            <div class="col-xs-12 col-sm-2">
              <b id="subtotal"><?= $sum_all_items; ?></b>
            </div>
          </div>
        </div>
      <?php endif; ?>


    <?php endif; ?>


    <?php if ((isset($cart_items) && strlen($cart_items) > 0) || (isset($cart_samples_items) && strlen($cart_samples_items) > 0)): ?>

      <div id="div_subtotal_table">
        <div class="row">
          <div class="col-xs-12 data-view">

            <div class="col-xs-12 table-list-row" id="subtotal_table">
              <div class="row">

                <div class="" id="shipping">
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
            <div class="col-xs-12 col-sm-4" id="subtotal_ship">
              $<?= number_format($subtotal_ship, 2); ?> USD
            </div>
          </div>
        </div>
      </div>


    <?php endif; ?>


    <div class="row">
      <div class="col-xs-12">

        <div class="row" id="coupon_total">
          <?= isset($coupon_total) ? $coupon_total : ''; ?>
        </div>

        <div class="row text-center">
          <div class="col-xs-12 inner-offset-top wc-proceed-to-checkout">
            <a class="checkout-button button alt wc-forward cont-shop" href="<?= _A_::$app->router()->UrlTo('shop') ?>">
              <?php if ((isset($cart_samples_items) && strlen($cart_samples_items) > 0) && (isset($cart_items) && strlen($cart_items) > 0)): ?>
                CONTINUE SHOPPING
              <?php else: ?>
                GO SHOPPING
              <?php endif; ?>

            </a>
            <?php if ((isset($cart_items) && strlen($cart_items) > 0) || (isset($cart_samples_items) && strlen($cart_samples_items) > 0)): ?>
              <a id="proceed_button" class="checkout-button button alt wc-forward"
                 href="<?= _A_::$app->router()->UrlTo('cart/proceed_checkout') ?>">Proceed to Checkout</a>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </div>

    <?php if (isset($abc)): ?>

    <div class="page type-page status-publish entry">
      <br/>

      <h1 class="entry-title">Cart</h1>

      <div class="entry-content">
        <div class="woocommerce">
          <!--<form method="post">-->
          <table cellspacing="0" class="shop_table shop_table_responsive cart">
            <thead>
            <tr>
              <th class="product-thumbnail">&nbsp;</th>
              <th class="product-name">Product</th>
              <!--<th class="product-name">#</th>-->
              <th class="product-price">Price</th>
              <th class="product-subtotal">Discount</th>
              <th class="product-price">Sale Price</th>
              <th class="product-quantity">Quantity</th>
              <th class="product-subtotal">Total</th>
              <th class="product-remove">&nbsp;</th>
            </tr>
            </thead>
            <tbody id="product_in_cart">

            <?php

              echo isset($cart_items) ? $cart_items : '';//products

              if (isset($cart_items) && strlen($cart_items) > 0) { ?>
                <tr id="row_subtotal_items">
                <th colspan="6" style="padding-left: 0">
                  Subtotal:
                </th>
                <td colspan="1" id="subtotal_items" data-title="Subtotal">
                  <?= isset($sum_items) ? $sum_items : ''; ?>
                </td>
                </tr><?php } ?>
            </tbody>
          </table>
          <?php
            if (isset($cart_samples_items) && strlen($cart_samples_items) > 0) { ?>

              <div id="samples_legend" class="darckBoxTable">
                <?= isset($cart_samples_legend) ? $cart_samples_legend : ''; ?>
              </div>
              <div id="samples_table" class="darckBoxTable">
                <table cellspacing="0" class="shop_table shop_table_responsive cart">
                  <thead>
                  <tr>
                    <th class="product-thumbnail">&nbsp;</th>
                    <th class="product-name">Product</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-remove">&nbsp;</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?= isset($cart_samples_items) ? $cart_samples_items : '';
                    if (isset($cart_samples_items) && strlen($cart_samples_items) > 0) { ?>
                      <tr id="row_subtotal_samples">
                        <th colspan="3">
                          Subtotal:
                        </th>
                        <td colspan="1" id="subtotal_samples_items" data-title="Subtotal">
                          <?= isset($sum_samples) ? $sum_samples : ''; ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            <?php } ?>
          <!--</form>-->

          <div class="collaterals">

            <div class="cart_totals">
              <?php if (
                (isset($cart_items) && strlen($cart_items) > 0) ||
                (isset($cart_samples_items) && strlen($cart_samples_items) > 0)
              ) { ?>
                <div id="div_subtotal_table">
                  <table id="subtotal_table" style="background-color: rgb(238, 238, 238);" cellspacing="0"
                         class="shop_table  cart">
                    <tbody>
                    <?php if ((isset($cart_samples_items) && strlen($cart_samples_items) > 0)
                      && (isset($cart_items) && strlen($cart_items) > 0)
                    ) { ?>
                      <tr id="row_subtotal" class="subtotal">
                        <th>Subtotal</th>
                        <td data-title="Subtotal" style="">
                          <span class="amount">
                            <b id="subtotal"><?= $sum_all_items; ?></b>
                          </span>
                        </td>
                      </tr>
                    <?php } ?>
                    <tr class="shipping" id="shipping">
                      <?= isset($shipping) ? $shipping : ''; ?>
                    </tr>

                    <tr class="subtotal">
                      <th>Subtotal</th>
                      <td data-title="Subtotal">
                        <span class="amount">
                          <b id="subtotal_ship">
                            $<?= number_format($subtotal_ship, 2); ?> USD
                          </b>
                        </span>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                  <hr/>
                </div>
              <?php } ?>
              <div id="coupon_total">
                <?= isset($coupon_total) ? $coupon_total : ''; ?>
              </div>

              <div class="wc-proceed-to-checkout">
                <a class="checkout-button button alt wc-forward" href="<?= _A_::$app->router()->UrlTo('shop') ?>">
                  CONTINUE SHOPPING
                </a>

                <?php if (
                  (isset($cart_items) && strlen($cart_items) > 0) ||
                  (isset($cart_samples_items) && strlen($cart_samples_items) > 0)
                ) { ?>

                  <a id="proceed_button" class="checkout-button button alt wc-forward"
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
</div>
<?php endif; ?>