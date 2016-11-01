<div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12">
      <h4><b>Shipping</b></h4>
    </div>
  </div>
  <?php if ($systemAllowExpressSamples): if (!$bExpressSamples): ?>
    <div class="row">
      <div class="col-sm-12 inner-offset-bottom">
        Express Post... generally delivered within 5-7 days
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 inner-offset-bottom">
        <div class="form-row">
          <label for="express_samples" class="inline">
            <input id="express_samples" type="checkbox" name="express_samples"
                   value="1" <?= ($bExpressSamples) ? 'checked' : ''; ?>>
            DELIVER MY SAMPLES BY OVERNIGHT COURIER
          </label>
        </div>
        &nbsp;<span color="#663300">$<?= number_format(SAMPLES_PRICE_EXPRESS_SHIPPING, 2); ?> USD
                    surcharge</span>
        <?php if ($bExpressSamples) { ?>
          <small style="color:#999;">
            <b>NOTE: </b>
            Only orders placed Monday through Thursday prior to 2:00 PM Eastern time will be processed
            for overnight delivery. Orders placed outside those hours will be processed the next open
            business day.
          </small>
        <?php } ?>
      </div>
    </div>
  <?php endif; endif; ?>
  <?php if ($bExpressSamples): ?>
    <div class="row">
      <div class="col-sm-12 inner-offset-bottom">
        <div class="form-row">
          <label class="inline">
            <input id="accept_express" type="checkbox" name="accept_express"
                   value="1" <?= ($bAcceptExpress) ? 'checked' : ''; ?>>
            I acknowledge that in rare cases samples may not arrive overnight due to circumstances beyond the control of
            iLuvFabrix.com. There are no guarantees or refunds given for this service.
          </label>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>