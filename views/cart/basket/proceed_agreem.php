<a href="<?php echo $back_url; ?>" class="back_button"><input type="button" value="Back" class="button"></a>
<div class="row">
    <div class="col-md-12">
        <article class="page type-page status-publish entry" style="overflow:hidden;">
            <br/>

            <h1 class="entry-title">Agreement terms</h1>

            <div class="entry-content">
                <div class="woocommerce">
                    <p><b>Please acknowledge you agree with our website Terms and Conditions. </b>
                    </p>
                    <p><br>
                        Shipping</p>
                    <p class="copyProducts">We ship Worldwide. <br>
                        <br>
                        Products are generally shipped within 24 to 72 hours from
                        the time of approved payment received. <br>
                    </p>
                    <p class="copyContact">Sales Terms</p>
                    <p class="copyProducts">Please purchase a sample (we offer samples at very reasonable prices) if you
                        are not
                        entirely confident in
                        your fabric purchase, as there are no returns or refunds.<br><br>
                        We cannot guarantee dye lot if a sample is purchased more than 2 weeks prior to the purchase of
                        your
                        order. Dye lots are normally close but each dye lot is different.<br>
                        <br>
                        ALL SALES ARE FINAL<br>
                        <br>
                        All special orders are final sale. No refunds. No cancellations. No returns.<br>
                        <br>
                        Please <a href="mailto:info@iluvfabrix.com?subject=Information%20on%20Fabric%20Samples"
                                  class="copyProducts">contact
                            us</a> for information on fabric sample purchases. <br>
                        <br>
                        We are confident you'll find our products to be of the highest
                        quality. If however your are not completely satisfied with
                        a product, please contact us by email or phone and we will
                        endeavor to rectify the problem. <br>
                        <br>
                        Should ILuvFabrix.com accept a return (at ILuvFabrix's sole discretion), it must be accompanied
                        by a
                        return authorization number. No fabric is to be returned without a Return Authorization
                        Number. Any fabric returned without such a number will not
                        be accepted. If a return is authorized by iluvfabrix or
                        Michelle&#146;s Fabrics, all return shipping costs and any
                        customs duties or taxes are to be paid in their entirety
                        by the purchaser, unless otherwise agreed to in advance
                        of the return by iluvfabrix or Michelle&#146;s Fabrics.
                        Please examine your package immediately upon receipt so
                        as to ensure the integrity of its contents. Please contact
                        us by email at: <br>
                        <br>
                        <a href="mailto:info@iluvfabrix.com" class="copyProducts">info@iluvfabrix.com</a>
                        <br>
                        or phone at: (915) 587-0200<br>
                    </p>
                    <p class="copyCopy">Contact Information</p>
                    <p class="copyProducts"><strong>iluvfabrix</strong> (Division of Fabric Love LLC)<br>
                        4725 Ripley, Unit B<br>
                        El Paso, Texas, 79922<br>
                        United States<br>

                        <br>
                        Email: <a href="mailto:info@iluvfabrix.com" class="copyProducts">info@iluvfabrix.com</a><br>
                        Tel: (915) 587-0200<br>


                    </p>
                    <p class="copyCopy">Privacy Policy</p>
                    <p class="copyProducts">Your personal information is never
                        under any circumstances shared with any other individuals
                        or organizations.<br>
                        <A href="<?php echo _A_::$app->router()->UrlTo('privacy'); ?>" class="copyProducts">privacy policy</A>.<br>
                    </p>
                    <p class="copyCopy">Security Information</p>
                    <p class="copyProducts">All purchase transactions made on
                        our site are fully and completely secured.<br>
                    </p>
                    <p>
                </div>
        </article>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <input type="checkbox" name="agreeterm" id="agreeterm"/>
        I have read and agreed to your website Terms and Conditions.</p><br/>
        <div id="container_proceed_pay" class="wc-proceed-to-pay" style="display: none;">
            <form method="post" id="paypal_form" name="paypal_form" action="<?php echo $paypal['url']?>">

                <!-- PayPal Configuration -->
                <input type="hidden" name="business" value="<?php echo $paypal['business']?>">
                <input type="hidden" name="cmd" value="<?php echo $paypal['cmd']?>">
                <input type="hidden" name="image_url" value="<?php echo $paypal['image_url']?>">
                <input type="hidden" name="return" value="<?php echo $paypal['return']?>">
                <input type="hidden" name="cancel_return" value="<?php echo $paypal['cancel_return']?>">
                <input type="hidden" name="notify_url" value="<?php echo $paypal['notify_url']?>">
                <input type="hidden" name="rm" value="<?php echo $paypal['rm']?>">

                <input type="hidden" name="currency_code" value="<?php echo $paypal['currency_code']?>">
                <input type="hidden" name="lc" value="<?php echo $paypal['lc']?>">
                <input type="hidden" name="bn" value="<?php echo $paypal['bn']?>">
                <input type="hidden" name="cbt" value="Continue >>">

                <!-- Payment Page Information -->
                <input type="hidden" name="no_shipping" value="">
                <input type="hidden" name="no_note" value="1">
                <input type="hidden" name="cn" value="Comments">
                <input type="hidden" name="cs" value="">

                <!-- Product Information -->
                <input type=hidden name="item_name" value="Fabric">
                <input type=hidden name="item_number" value="1">
                <input type="hidden" name="quantity" value="">
                <input type=hidden name="amount" value="<?php echo $total; ?>">

                <input type="hidden" name="undefined_quantity" value="">

                <input type="hidden" name="on0" value="">
                <input type="hidden" name="os0" value="">
                <input type="hidden" name="on1" value="">
                <input type="hidden" name="os1" value="">

                <!-- Customer Information -->
                <input type=hidden name="first_name" value="<?php echo $bill_firstname; ?>">
                <input type=hidden name="last_name" value="<?php echo $bill_lastname; ?>">
                <input type=hidden name="address1" value="<?php echo $bill_address1; ?>">
                <input type=hidden name="address2" value="<?php echo $bill_address2; ?>">
                <input type=hidden name="city" value="<?php echo $bill_city; ?>">
                <input type=hidden name="state" value="<?php echo $bill_province; ?>">
                <input type=hidden name="zip" value="<?php echo $bill_postal; ?>">
                <input type=hidden name="email" value="<?php echo $email; ?>">
                <input type=hidden name="night_phone_a" value="<?php echo substr($bill_phone, 0, 3); ?>">
                <input type=hidden name="night_phone_b" value="<?php echo substr($bill_phone, 3, 6); ?>">
                <input type=hidden name="night_phone_c" value="<?php echo substr($bill_phone, 6, 10); ?>">

                <input type="submit" name="Submit" value="Pay with PayPal">

                <!-- Shipping and Misc Information -->
                <input type="hidden" name="shipping" value="">
                <input type="hidden" name="shipping2" value="">
                <input type="hidden" name="handling" value="">
                <input type="hidden" name="tax" value="">
                <input type="hidden" name="custom" value="">
                <input type="hidden" name="invoice" value="">

            </form>

        </div>
    </div>
</div>
