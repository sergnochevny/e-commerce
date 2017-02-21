<?php include_once 'views/messages/alert-boxes.php'; ?>
<div class="col-xs-12">
  <div class="row afterhead-row">
    <div class="col-sm-2 back_button_container">
      <div class="row">
        <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
          <i class="fa fa-angle-left" aria-hidden="true"></i>
          Back
        </a>
      </div>
    </div>
    <div class="col-sm-8 text-center">
      <div class="row">
        <h4 class="page-title">PLEASE REVIEW AND CONFIRM ORDER</h4>
      </div>
    </div>
    <div class="col-sm-2"></div>
  </div>
</div>

<div class="col-xs-12 cart-data-view">
  <div class="row">
    <div class="col-xs-12 table-list-header hidden-xs">
      <div class="col-sm-6 col">
        <div class="row">
          Products
        </div>
      </div>
      <div class="col-sm-2 col">
        <div class="row">
          Sale Price
        </div>
      </div>
      <div class="col-sm-2 col">
        <div class="row">
          Quantity
        </div>
      </div>
      <div class="col-sm-2 col">
        <div class="row">
          Total
        </div>
      </div>
    </div>
    <div class="col-xs-12 table-list-body">
      <div class="row">
        <?php
          echo isset($cart_items) ? $cart_items : '';//products
          echo isset($cart_samples_items) ? $cart_samples_items : '';//samples
        ?>
        <?php if(isset($cart_samples_items) && strlen($cart_samples_items) > 0) { ?>
          <div class="col-xs-12 table-list-row" data-block="cart_item" data-pid="<?= $pid; ?>" data-row="items">
            <div class="col-xs-12 col-sm-6 table-list-row-item">
              <div class="row">
                SAMPLES
              </div>
            </div>
            <div class="col-xs-12 col-sm-2 col-sm-offset-4 table-list-row-item">
              <div class="row">
                <div class="col-xs-4 visible-xs">
                  <div class="row"><b>Total:</b></div>
                </div>
                <div class="col-xs-8 col-sm-12">
                  <div class="row"><span class="amount"><?= isset($sum_samples) ? $sum_samples : ''; ?></span></div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
        <?= isset($shipping) ? $shipping : ''; ?>
      </div>
    </div>
  </div>
</div>

<div class="col-xs-12 inner-offset-top">
  <div class="row">
    <?php
      if((isset($cart_items) && strlen($cart_items) > 0) || (isset($cart_samples_items) && strlen($cart_samples_items) > 0)) {
        echo isset($total_proceed) ? $total_proceed : '';
      }
    ?>
  </div>
</div>

<div class="col-xs-12 row_bill_ship">
  <div class="row">
    <div class="col-xs-12 text-center afterhead-row">
      <h3 class="page-title" style="font-size: 1.4em">PLEASE REVIEW AND CONFIRM YOUR DETAILS</h3>
    </div>
    <div data-block="proceed_bill_ship" class="col-xs-12 cart-data-view">
      <div class="row">
        <?= isset($bill_ship_info) ? $bill_ship_info : '' ?>

        <div class="col-xs-12 text-center inner-offset-bottom inner-offset-top">
          <div class="row">
            <a data-block="change_user_data" class="checkout-button button alt wc-forward"
               href="<?= $change_user_url; ?>">
              Edit Billing or Shipping
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-xs-12">
  <div class="row text-center">
    <?php if(
      (isset($cart_items) && strlen($cart_items) > 0) ||
      (isset($cart_samples_items) && strlen($cart_samples_items) > 0)
    ) { ?>

      <a data-block="proceed_agreem_button" style="margin-top: 15px" class="checkout-button button alt wc-forward"
         href="<?= /** @noinspection PhpUndefinedMethodInspection */
           _A_::$app->router()->UrlTo('cart/proceed_agreem') ?>">
        Proceed to Agreement</a>
    <?php } ?>
  </div>
</div>
<div data-load="<?= /** @noinspection PhpUndefinedMethodInspection */
  _A_::$app->router()->UrlTo('info/view', ['method' => 'cart']) ?>"></div>
<script type='text/javascript' src='<?= /** @noinspection PhpUndefinedMethodInspection */
  _A_::$app->router()->UrlTo('views/js/cart/checkout.min.js'); ?>'></script>