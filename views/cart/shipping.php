<div class="col-xs-12 table-list-row-item">
  <div class="row">

    <div class="col-xs-2">
      Shipping:
    </div>
    <div class="col-xs-10">

      <label for="select_ship inline">Method:
        <select id="select_ship" size="1" name="ship">
          <option value="0">select shipping method</option>
          <option <?= ($shipping == 1) ? 'selected' : '' ?> value="1">express post</option>
          <option <?= ($shipping == 3) ? 'selected' : '' ?> value="3">ground ship</option>
        </select>
      </label>

    </div>

  </div>
</div>

<?php if (count($cart_items) > 0) { ?>
  <div class="col-xs-12 table-list-row-item">
    <div class="row">

      <div class="col-xs-10 col-sm-push-2 bordered-item-container">
        <div class="row">

          <div class="col-sm-6 bordered-item half-inner-offset-vertical">
            <label for="roll" class="inline">
              <input id="roll" type="checkbox" name="roll" value="1" <?= $bShipRoll ? 'checked' : ''; ?>>
              Ship my fabric on a roll.
            </label>
          </div>
          <div class="col-sm-6 bordered-item half-inner-offset-vertical">
            <b>NOTE:</b> This cost $<?= number_format(RATE_ROLL, 2); ?> USD
          </div>

        </div>
      </div>

    </div>
  </div>
<?php } ?>

<div class="col-xs-12 table-list-row-item">
  <div class="row">

    <div class="col-xs-10 col-sm-push-2 bordered-item-container">
      <div class="row">

        <div class="col-sm-6 bordered-item half-inner-offset-vertical">
          <b>SHIPPING</b>
        </div>
        <div class="col-sm-6 bordered-item half-inner-offset-vertical">
          <b><span style="color: #663300">$<?= number_format($shipcost, 2); ?> USD</span></b>
        </div>

      </div>
    </div>

  </div>
</div>
<?php if (count($cart_items) > 0) { ?>
  <div class="col-xs-12 table-list-row-item">
    <div class="row">

      <div class="col-xs-10 col-sm-push-2 bordered-item-container">
        <div class="row">

          <div class="col-sm-6 bordered-item half-inner-offset-vertical">
            <b>HANDLING</b>
          </div>
          <div class="col-sm-6 bordered-item half-inner-offset-vertical">
            <b><span style="color: #663300">$<?= number_format(RATE_HANDLING, 2); ?> USD</span></b>
          </div>

        </div>
      </div>

    </div>
  </div>
<?php } ?>
<?php if ($shipDiscount > 0) { ?>
  <div class="col-xs-12 table-list-row-item">
    <div class="row">

      <div class="col-xs-10 col-sm-push-2 bordered-item-container">
        <div class="row">

          <div class="col-sm-6 bordered-item inner-offset-bottom">
            <b>SHIPPING DISCOUNT</b>
          </div>
          <div class="col-sm-6 bordered-item inner-offset-bottom">
            <b><span style="color: #663300">$<?= number_format($shipDiscount, 2); ?> USD</span></b>
          </div>

        </div>
      </div>

    </div>
  </div>
<?php } ?>


<?php if (count($cart_items) > 0) { ?>
  <div class="col-xs-12 table-list-row-item inner-offset-vertical">

    <p>
      <b>NOTE: </b>
      <?php
        if ($shipping == 1) {
          echo "Delivery can be generally expected within 5 days from the shipping date of the order (orders usually ship within 48 hours of payment).  Please note that this is an approximation as it relies on the mail, a service over which we have no control.";
        } else {
          echo "Delivery can be generally expected within 2 weeks from the shipping date of the order (orders usually ship within 48 hours of payment).  Please note that this is an approximation as it relies on the mail, a service over which we have no control.";
        }
      ?>
    </p>


  </div>
<?php } ?>

<section style="display:none;" class="shipping-calculator-form">

  <p id="calc_shipping_country_field"
     class="form-row form-row-wide">
    <select rel="calc_shipping_state"
            class="country_to_state"
            id="calc_shipping_country"
            name="calc_shipping_country">
      <option value="">Select a country…</option>
      <option value="CA">Canada</option>
      <option value="US">United States (US)</option>
    </select>
  </p>

  <p id="calc_shipping_state_field"
     class="form-row form-row-wide">
    <input type="text" id="calc_shipping_state"
           name="calc_shipping_state"
           placeholder="State / county" value=""
           class="input-text"></p>


  <p id="calc_shipping_postcode_field"
     class="form-row form-row-wide">
    <input type="text" id="calc_shipping_postcode"
           name="calc_shipping_postcode"
           placeholder="Postcode / ZIP" value=""
           class="input-text">
  </p>


</section>

</td>
