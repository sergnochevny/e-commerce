<div class="col-xs-12 cart-legend-view">
  <div class="col-sm-12 text-center">
    <div class="row">
      <h4><b>SAMPLES DETAILS & COST</b></h4>
    </div>
  </div>
  <div class="col-sm-12 inner-offset-bottom">
    <div class="row">
      Samples are sent through the Post Office and are usually
      delivered within 5&dash;7 days. Samples will be sent the next
      business day after order confirmation.
    </div>
  </div>
  <div class="col-sm-12 inner-offset-bottom">
    <div class="row">
      <b>You may order Next Day courier for an additional charge.</b>
    </div>
  </div>
  <div class="col-sm-12 inner-offset-bottom">
    <div class="row">
      <div class="col-sm-6">1) Sample 1:</div>
      <div
          class="col-sm-6"><?= '$' . number_format((!is_null(_A_::$app->keyStorage()->shop_samples_price_single) ? _A_::$app->keyStorage()->shop_samples_price_single : SAMPLES_PRICE_SINGLE), 2); ?></div>
      <div class="col-sm-6">2) Samples 2 - 5:</div>
      <div
          class="col-sm-6"><?= '$' . number_format((!is_null(_A_::$app->keyStorage()->shop_samples_price_multiple) ? _A_::$app->keyStorage()->shop_samples_price_multiple : SAMPLES_PRICE_MULTIPLE), 2); ?></div>
      <div class="col-sm-6">3) Samples 6 & over:</div>
      <div class="col-sm-6"><?= '$' . number_format(!empty($data['shop_samples_price_additional']) ? $data['shop_samples_price_additional'] : SAMPLES_PRICE_ADDITIONAL, 2); ?> / sample</div>
      <?php if(!(isset($cart_items) && strlen($cart_items) > 0)): ?>
        <div class="col-sm-6">4) Courier delivery surcharge:</div>
        <div
            class="col-sm-6"><?= '$' . number_format((!is_null(_A_::$app->keyStorage()->shop_samples_price_express_shipping) ? _A_::$app->keyStorage()->shop_samples_price_express_shipping : SAMPLES_PRICE_EXPRESS_SHIPPING), 2); ?></div>
      <?php endif; ?>
    </div>
  </div>
</div>