<div class="container">
  <div id="content" class="main-content-inner" role="main">

    <div class="row">
      <div class="col-xs-12">
        <div class="row afterhead-row">
          <div class="col-sm-2 back_button_container">
            <a href="<?= $back_url; ?>" class="button back_button">Back</a>
          </div>
          <div class="col-sm-8 text-center">
            <div class="row">
              <h3 class="page-title">Agreement terms</h3>
            </div>
          </div>
          <div class="col-sm-2"></div>
        </div>
      </div>
    </div>

    <div class="row">
      <article class="col-md-12 text-justify">
        <p><b>Please acknowledge you agree with our website Terms and Conditions.</b></p>
        <p><h6><b>Shipping</b></h6></p>
        <p>We ship Worldwide.</p>
        <p>Products are generally shipped within 24 to 72 hours from the time of approved payment received.</p>
        <p><h6><b>Sales Terms</b></h6></p>
        <p>
          Please purchase a sample (we offer samples at very reasonable prices) if you are not entirely confident in
          your fabric purchase, as there are no returns or refunds.
        </p>
        <p>
          We cannot guarantee dye lot if a sample is purchased more than 2 weeks prior to the purchase of
          your order. Dye lots are normally close but each dye lot is different.
        </p>
        <p>
          ALL SALES ARE FINAL
        </p>
        <p>
          All special orders are final sale. No refunds. No cancellations. No returns.
        </p>
        <p>
          Please
          <a href="mailto:info@iluvfabrix.com?subject=Information%20on%20Fabric%20Samples" class="copyProducts">
            contact us
          </a> for information on fabric sample purchases.
        </p>
        <p>
          We are confident you'll find our products to be of the highest
          quality. If however your are not completely satisfied with
          a product, please contact us by email or phone and we will
          endeavor to rectify the problem.
        </p>
        <p>
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
          us by email at:
        </p>
        <p>
          All special orders are final sale. No refunds. No cancellations. No returns.
        </p>
        <p>
          <a href="mailto:info@iluvfabrix.com" class="copyProducts">info@iluvfabrix.com</a><br>
          or phone at: (915) 587-0200
        </p>
        <p>
          <b>Contact Information:</b>
        </p>
        <p>
          <b>iluvfabrix</b> <br>
          (Division of Fabric Love LLC)<br>
          4725 Ripley, Unit B<br>
          El Paso, Texas, 79922<br>
          United States<br>

          <br>
          Email: <a href="mailto:info@iluvfabrix.com" class="copyProducts">info@iluvfabrix.com</a><br>
          Tel: (915) 587-0200<br>
        </p>
        <p>Privacy Policy</p>
        <p>
          Your personal information is never
          under any circumstances shared with any other individuals
          or organizations.<br>
          <a href="<?= _A_::$app->router()->UrlTo('privacy'); ?>">privacy policy</a>.<br>
        </p>
        <p>Security Information</p>
        <p>All purchase transactions made on
          our site are fully and completely secured.<br>
        </p>
      </article>
    </div>


    <div class="row">
      <div class="col-md-12">
        <div class="col-sm-12">
          <div class="row">
            <div class="form-row">
              <label for="agreeterm" class="inline">
                <input type="checkbox" name="agreeterm" id="agreeterm"/>
                I have read and agreed to your website Terms and Conditions.
              </label>
            </div>
          </div>
        </div>
        <div data-block="container_proceed_pay" class="wc-proceed-to-pay" style="display: none;">
          <form method="post" data-block="paypal_form" name="paypal_form" action="<?= $paypal['url'] ?>">

            <!-- PayPal Configuration -->
            <input type="hidden" name="business" value="<?= $paypal['business'] ?>">
            <input type="hidden" name="cmd" value="<?= $paypal['cmd'] ?>">
            <input type="hidden" name="image_url" value="<?= $paypal['image_url'] ?>">
            <input type="hidden" name="return" value="<?= $paypal['return'] ?>">
            <input type="hidden" name="cancel_return" value="<?= $paypal['cancel_return'] ?>">
            <input type="hidden" name="notify_url" value="<?= $paypal['notify_url'] ?>">
            <input type="hidden" name="rm" value="<?= $paypal['rm'] ?>">

            <input type="hidden" name="currency_code" value="<?= $paypal['currency_code'] ?>">
            <input type="hidden" name="lc" value="<?= $paypal['lc'] ?>">
            <input type="hidden" name="bn" value="<?= $paypal['bn'] ?>">
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
            <input type=hidden name="amount" value="<?= $total; ?>">

            <input type="hidden" name="undefined_quantity" value="">

            <input type="hidden" name="on0" value="">
            <input type="hidden" name="os0" value="">
            <input type="hidden" name="on1" value="">
            <input type="hidden" name="os1" value="">

            <!-- Customer Information -->
            <input type=hidden name="first_name" value="<?= $bill_firstname; ?>">
            <input type=hidden name="last_name" value="<?= $bill_lastname; ?>">
            <input type=hidden name="address1" value="<?= $bill_address1; ?>">
            <input type=hidden name="address2" value="<?= $bill_address2; ?>">
            <input type=hidden name="city" value="<?= $bill_city; ?>">
            <input type=hidden name="state" value="<?= $bill_province; ?>">
            <input type=hidden name="zip" value="<?= $bill_postal; ?>">
            <input type=hidden name="email" value="<?= $email; ?>">
            <input type=hidden name="night_phone_a" value="<?= substr($bill_phone, 0, 3); ?>">
            <input type=hidden name="night_phone_b" value="<?= substr($bill_phone, 3, 6); ?>">
            <input type=hidden name="night_phone_c" value="<?= substr($bill_phone, 6, 10); ?>">

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

  </div>
</div>
