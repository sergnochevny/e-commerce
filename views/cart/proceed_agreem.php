<?php

use app\core\App;

?>
<div class="row">
  <div class="col-xs-12">
    <div class="row">
      <div class="col-xs-12 col-sm-2 back_button_container">
        <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
          <i class="fa fa-angle-left" aria-hidden="true"></i>
          Back
        </a>
      </div>
      <div class="col-xs-12 col-sm-8 text-center">
        <div class="row">
          <h1 class="page-title">Agreement terms</h1>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <article class="col-xs-12 text-justify">
    <p><b>PLEASE ACKNOWLEDGE YOU AGREE TO OUR WEBSITE TERMS AND CONDITIONS TO CONTINUE WITH YOUR PURCHASE.</b></p>
    <p><h6><b>Shipping</b></h6></p>
    <p>We ship Worldwide.</p>
    <p>
      Products are generally shipped within 24 to 72 hours of receipt of the full payment. Some fabrics take
      longer to ship. This is clearly mentioned in the fabric description should this be the case.
    </p>
    <p>
      Please always examine your package immediately upon receipt so as to ensure the integrity of the
      packaging and its contents. Our contact information appears just below. Many times when we package
      fabrics we put layers of tissue paper around the fabric before the plastic sleeve, which is sometimes
      mistaken for the fabric that was ordered. Please OPEN your package to see your fabric to verify its
      contents and integrity.
    </p>
    <p>
      Phone at: <a href="tel:9155870200">(915) 587-0200</a><br>
      Email: <a
          href="mailto:<?= App::$app->keyStorage()->system_info_email; ?>"><?= App::$app->keyStorage()->system_info_email; ?></a><br>
      Address: <a href="<?= App::$app->router()->base_url; ?>"><?= App::$app->router->host; ?></a> (Division
      of Fabric Love LLC)<br>
      211 Teramar Way<br>
      El Paso, Texas, 79922<br>
      United States<br>
    </p>
    <p><h6><b>Sales Terms</b></h6></p>
    <p>
      All Sales are final. Please purchase a sample (we offer samples at very reasonable prices) if you are
      not entirely confident in your fabric purchase, as there are no returns or refunds. You can purchase a
      Sample of most of our products. It is initiated from the Fabric Details page. </p>
    <p>
      Also, we cannot guarantee your fabric when purchased will be from the same dye lot as your sample, if
      your fabric purchase is initiated more than 2 weeks beyond the purchase of your sample. Dye lots are
      normally close but each dye lot is different. Please check with us if you are not sure of your dates
      before you make your fabric purchase.
    </p>
    <p>
      We are confident you'll find our products to be of the highest quality. If however your are not
      completely satisfied with a product, please contact us by phone and email. The email must clearly
      delineate the issue and be accompanied by pictures. We will endeavor to rectify the problem if both
      possible, and deemed appropriate.
    </p>
    <p>
      It is up to the sole discretion of <a
          href="<?= App::$app->router()->base_url; ?>"><?= App::$app->router()->host; ?></a> / Fabric Love
      LLC. to decide whether your purchase
      qualifies for any sort of remedy. Should <a
          href="<?= App::$app->router()->base_url; ?>"><?= App::$app->router()->host; ?></a> / Fabric Love
      LLC. accept a return (at
      <a href="<?= App::$app->router()->base_url; ?>"><?= App::$app->router()->host; ?>’s</a> sole
      discretion), we will generate and provide you with a Return Authorization
      Number. No fabric return will be accepted by our warehouse without a Return Authorization Number marked
      and clearly visible on the outside of the return package. Any fabric returned without such a number will
      not be accepted and will be returned to the sender at the sender’s expense.
    </p>
    <p>
      If a return is authorized by <a
          href="<?= App::$app->router()->base_url; ?>"><?= App::$app->router()->host; ?></a> / Fabric Love
      LLC., all return shipping costs and
      customs duties or taxes, if any, are to be paid in their entirety by the purchaser, unless otherwise
      agreed to in advance of the return by <a
          href="<?= App::$app->router()->base_url; ?>"><?= App::$app->router()->host; ?></a> / Fabric Love
      LLC. Depending on the nature of
      the issue, <a href="<?= App::$app->router()->base_url; ?>"><?= App::$app->router->host; ?></a> / Fabric
      Love LLC. may be unable to provide any sort of rectification.
      However, as we do want to keep our customers happy, we always endeavor to find a mutually agreeable
      solution to the problem which may, in certain cases, allow for the return of a fabric, usually
      accompanied by a modest restocking fee. In these cases we generally provide the customer with a website
      credit for the purchase of another fabric of their choice. Our website credits are usable for one year
      from the date of your original fabric purchase.
    </p>
    <p><h6><b>Privacy Policy</b></h6></p>
    <p>
      Your personal information is never under any circumstances shared with any other individuals or
      organizations. For a complete understanding of our Privacy Policy, please click the following link:
      <a href="<?= App::$app->router()->UrlTo('privacy'); ?>">privacy policy.</a>
    </p>
    <p><h6><b>Security Information</b></h6></p>
    <p>All purchase transactions made on our site are fully and completely secure.</p>
  </article>
</div>


<div class="row">
  <div class="col-xs-12">
    <p><h6><b>Please Sign to Agree to Terms and Proceed with your Purchase.</b></h6></p>
    <label for="agreeterm" class="inline">
      <input type="checkbox" name="agreeterm" data-block="agreeterm"/>
      I have read and agreed to your website Terms and Conditions.
    </label>
  </div>
</div>
<div class="row offset-top">
  <div class="col-xs-12">
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

        <input class="button" type="submit" name="Submit" value="Pay with PayPal">

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
<div data-load-cart="<?= App::$app->router()->UrlTo('info/view', ['method' => 'cart']) ?>"></div>

<?php $this->registerJSFile(App::$app->router()->UrlTo('js/cart/load.min.js'), 4); ?>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/cart/checkout.min.js'), 5); ?>