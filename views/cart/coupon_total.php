<?php if (isset($cart_items) && count($cart_items) > 0) { ?>
    <div id="coupon_section">
        <div class="row" style="margin:0">
            <div class="col-md-3">Coupon code:</div>
            <div class="col-md-9">
                <div id="coupon">

                    <input type="text" placeholder="Coupon code"
                           value="= isset($coupon_code) ? $coupon_code : '' ?>"
                           id="coupon_code"
                           class="input-text" name="coupon_code">
                    <input type="button" value="Apply Coupon"
                           id="apply_coupon" class="">
                </div>
            </div>
        </div>
        <hr/>
        <div class="row" style="margin:0">
            <div class="col-md-3 col-sm-3 col-xs-6">COUPON REDEMPTION:</div>
            <div class="col-md-9 col-sm-9 col-xs-6">
                <div id="coupon_discount">
                    <b>$= number_format($coupon_discount, 2); ?>
                        USD</b></div>
            </div>
        </div>
        <hr/>
    </div>
<?php } ?>
<?php if (isset($taxes) && ($taxes > 0)) { ?>
    <div class="row" style="margin:0;">
        <div class="col-md-3 col-sm-3 col-xs-6">TAXES</div>
        <div class="col-md-9 col-sm-9 col-xs-6">
            <div>
                <b>$= number_format($taxes, 2); ?> USD</b>
            </div>
        </div>
    </div>
    <hr/>
<?php } ?>

<div class="row" style="margin:0">
    <div class="col-md-3 col-sm-3 col-xs-6 alert-danger">TOTAL:</div>
    <div class="col-md-9 col-sm-9 col-xs-6 alert-danger">
        <div id="cart_total"><b>$= number_format($total, 2); ?>
                USD</b></div>
    </div>
</div>
<hr/>
