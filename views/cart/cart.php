<div class="row">
  <div class="col-md-12">

    <article class="page type-page status-publish entry" style="overflow:hidden;">
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

              if(isset($cart_items) && strlen($cart_items) > 0) { ?>
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
            if(isset($cart_samples_items) && strlen($cart_samples_items) > 0) { ?>

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
                    if(isset($cart_samples_items) && strlen($cart_samples_items) > 0) { ?>
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
              <?php if(
                (isset($cart_items) && strlen($cart_items) > 0) ||
                (isset($cart_samples_items) && strlen($cart_samples_items) > 0)
              ) { ?>
                <div id="div_subtotal_table">
                  <table id="subtotal_table" style="background-color: rgb(238, 238, 238);" cellspacing="0"
                         class="shop_table  cart">
                    <tbody>
                    <?php if((isset($cart_samples_items) && strlen($cart_samples_items) > 0)
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

                <?php if(
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
    </article>
  </div>
</div>
