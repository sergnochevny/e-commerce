<div class="col-xs-12 col-sm-12 table-list-row-item">
    <div class="row">
        <div class="col-sm-12 half-inner-offset-vertical"><strong>SAMPLES DETAILS & COST</strong></div>
    </div>
    <div class="row">
        <div class="col-sm-12 inner-offset-bottom">
            Samples are sent through the Post Office and are usually
            delivered within 5&dash;7 days. Samples will be sent the next
            business day after order confirmation.
        </div>
    </div>
    <div class="row inner-offset-bottom">
        <div class="col-sm-6">
            You may order Next Day courier for an additional charge.
        </div>
        <div class="col-sm-6">
            <div class="row half-inner-offset-bottom">
                <div class="col-xs-6 col-sm-5">1) Sample 1:</div>
                <div class="col-xs-6 col-sm-7"><?= '$' . number_format(SAMPLES_PRICE_SINGLE, 2); ?></div>
            </div>
            <div class="row half-inner-offset-bottom">
                <div class="col-xs-6 col-sm-5">2) Samples 2 - 5:</div>
                <div class="col-xs-6 col-sm-7"><?= '$' . number_format(SAMPLES_PRICE_MULTIPLE, 2); ?></div>
            </div>
            <div class="row half-inner-offset-bottom">
                <div class="col-xs-6 col-sm-5">3) Samples 6 & over:</div>
                <div class="col-xs-6 col-sm-7"><?= '$' . number_format(SAMPLES_PRICE_ADDITIONAL, 2); ?> <sup>/ sample</sup></div>
            </div>
            <?php if(!(isset($cart_items) && strlen($cart_items) > 0)){?>
                <div class="row half-inner-offset-vertical">
                    <div class="col-xs-6 col-sm-5">4) Courier delivery surcharge:</div>
                    <div class="col-xs-6 col-sm-7"><?= '$' . number_format(SAMPLES_PRICE_EXPRESS_SHIPPING, 2); ?></div>
                </div>
            <?php }?>
        </div>
    </div>
</div>
