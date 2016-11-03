<div class="col-xs-12 table-list-row">
  <div class="row">
    <div class="col-xs-12 col-sm-4 table-list-row-item">
      Shipping
    </div>
    <div class="col-xs-12 col-sm-8 table-list-row-item">

      <div class="row">
        <div class="col-xs-12">
          <div class="form-row">
            <label for="select_ship">
              Method:
              <select data-block="select_ship" size="1" name="ship">
                <option value="0">select shipping method</option>
                <option <?= ($shipping == 1) ? 'selected' : '' ?> value="1">express post</option>
                <option <?= ($shipping == 3) ? 'selected' : '' ?> value="3">ground ship</option>
              </select>
            </label>
          </div>
        </div>
      </div>

      <?php if(count($cart_items) > 0): ?>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="row form-row">
              <label for="roll" class="inline">
                <input data-block="roll" type="checkbox" id="roll" name="roll" value="1" <?= $bShipRoll ? 'checked' : ''; ?>>
                Ship my fabric on a roll.
              </label>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <b>NOTE: </b> This cost $<?= number_format(RATE_ROLL, 2); ?> USD
          </div>
        </div>
      <?php endif; ?>

      <div class="row">
        <div class="col-xs-6 col-sm-6">
          <b>SHIPPING</b>
        </div>
        <div class="col-xs-6 col-sm-6">
          $<?= number_format($shipcost, 2); ?> USD
        </div>
      </div>
      <?php if(count($cart_items) > 0): ?>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <b>HANDLING</b>
          </div>
          <div class="col-xs-6 col-sm-6">
            $<?= number_format(RATE_HANDLING, 2); ?> USD
          </div>
        </div>
      <?php endif; ?>

      <?php if($shipDiscount > 0) : ?>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <b>SHIPPING DISCOUNT</b>
          </div>
          <div class="col-xs-6 col-sm-6">
            $<?= number_format($shipDiscount, 2); ?> USD
          </div>
        </div>
      <?php endif; ?>
    </div>

    <div class="col-xs-12 col-sm-8 col-sm-offset-4 inner-offset-top">
      <small style="color: #999">NOTE:
        <?php
          if($shipping == 1) {
            echo "Delivery can be generally expected within 5 days from the shipping date of the order (orders usually ship within 48 hours of payment).  Please note that this is an approximation as it relies on the mail, a service over which we have no control.";
          } else {
            echo "Delivery can be generally expected within 2 weeks from the shipping date of the order (orders usually ship within 48 hours of payment).  Please note that this is an approximation as it relies on the mail, a service over which we have no control.";
          }
        ?>
      </small>
    </div>

  </div>
</div>