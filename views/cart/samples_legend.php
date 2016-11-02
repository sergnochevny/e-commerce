<div class="row">

  <div class="panel panel-default panel-body">
    <div class="row">
      <div class="col-sm-12 text-center">
        <h4><b>SAMPLES DETAILS & COST</b></h4>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 inner-offset-bottom">
        Samples are sent through the Post Office and are usually
        delivered within 5&dash;7 days. Samples will be sent the next
        business day after order confirmation.
      </div>
    </div>
    <div class="row inner-offset-bottom">
      <div class="col-sm-12">
        <b>You may order Next Day courier for an additional charge.</b>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">1) Sample 1:</div>
      <div class="col-sm-6"><?= '$' . number_format(SAMPLES_PRICE_SINGLE, 2); ?></div>
    </div>
    <div class="row">
      <div class="col-sm-6">2) Samples 2 - 5:</div>
      <div class="col-sm-6"><?= '$' . number_format(SAMPLES_PRICE_MULTIPLE, 2); ?></div>
    </div>
    <div class="row">
      <div class="col-sm-6">3) Samples 6 & over:</div>
      <div class="col-sm-6"><?= '$' . number_format(SAMPLES_PRICE_ADDITIONAL, 2); ?> / sample</div>
    </div>
    <?php if(!(isset($cart_items) && strlen($cart_items) > 0)): ?>
      <div class="row">
        <div class="col-sm-6">4) Courier delivery surcharge:</div>
        <div class="col-sm-6"><?= '$' . number_format(SAMPLES_PRICE_EXPRESS_SHIPPING, 2); ?></div>
      </div>
    <?php endif; ?>
  </div>
</div>