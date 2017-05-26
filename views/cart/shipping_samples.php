<div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12">
      <h4><b>Shipping</b></h4>
    </div>
  </div>

  <?php if($systemAllowExpressSamples): ?>
    <?php if(!$bExpressSamples): ?>
      <div class="row">
        <div class="col-sm-10 col-sm-offset-2 inner-offset-bottom">
          Express Post... generally delivered within 5-7 days
        </div>
      </div>
    <?php endif; ?>
    <div class="row">
      <div class="col-sm-10 col-sm-offset-2">
        <label for="express_samples" class="inline">
          <input data-block="express_samples" type="checkbox" name="express_samples"
                 value="1" <?= ($bExpressSamples) ? 'checked' : ''; ?>>
          DELIVER MY SAMPLES BY OVERNIGHT COURIER
        </label>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-10 col-sm-offset-2 inner-offset-bottom">
        &nbsp;
        <span color="#663300">
          $<?= number_format((!is_null(_A_::$app->keyStorage()->shop_samples_price_express_shipping) ? _A_::$app->keyStorage()->shop_samples_price_express_shipping : SAMPLES_PRICE_EXPRESS_SHIPPING), 2); ?>
          USD surcharge
        </span>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-10 col-sm-offset-2 inner-offset-bottom">
        <?php if($bExpressSamples) { ?>
          <small class="note">
            <b>NOTE: </b>
            Only orders placed Monday through Thursday prior to 2:00 PM Eastern time will be processed
            for overnight delivery. Orders placed outside those hours will be processed the next open
            business day.
          </small>
        <?php } ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if($bExpressSamples): ?>
    <div class="row">
      <div class="col-sm-10 col-sm-offset-2 inner-offset-bottom">
        <label class="inline">
          <input data-block="accept_express" type="checkbox" name="accept_express"
                 value="1" <?= ($bAcceptExpress) ? 'checked' : ''; ?>>
          I acknowledge that in rare cases samples may not arrive overnight due to circumstances beyond the control of
          iLuvFabrix.com. There are no guarantees or refunds given for this service.
        </label>
      </div>
    </div>
  <?php endif; ?>
</div>