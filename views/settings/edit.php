<?php

use app\core\App;

?>
<script src='<?= App::$app->router()->UrlTo('js/settings/edit.min.js'); ?>' type="text/javascript"></script>
<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="box col-xs-12">
    <div class="row">
      <div class="col-sm-12 text-center">
        <div class="row">
          <h1 class="page-title"><?= $form_title ?></h1>
        </div>
      </div>
    </div>

    <div data-role="form_content" class="row">
      <?= $form; ?>
    </div>
  </div>
</div>

<div id="system_site_name" class="overlay"></div>
<div class="popup hint">
  <h2>Site Name</h2>
  <p>
    The name of the website that is used by the system as the title, description and keywords if these parameters aren’t
    filled in.
  </p>
</div>

<div id="system_enable_sef" class="overlay"></div>
<div class="popup hint">
  <h2>Enable SEF</h2>
  <p>
    System for converting in Search Engine Friendly links. System uses TITLE as a base for the URL. This function works
    on Products and Blog pages. The whole title goes into the link without any reduction. Example:
    website.com/12-oz-cup-with-straw or website.com/how-to-create-something-from-nothing-with-glue.
  </p>
</div>
<div id="system_filter_amount" class="overlay"></div>
<div class="popup hint">
  <h2>Filter Limit Amount</h2>
  <p>
    Limitation of list length in the filter. You can choose how long this list will be (25 or 50 or 100).
  </p>
</div>
<div id="system_captcha_time" class="overlay"></div>
<div class="popup hint">
  <h2>Captcha Relevant Time</h2>
  <p>
    This is the amount of time before the captcha expires. Update the captcha image after the time expiry.
  </p>
</div>
<div id="system_info_email" class="overlay"></div>
<div class="popup hint">
  <h2>System Information Email</h2>
  <p>Main Email of the site; All email sent from the server will be from this email address, and this will also be the
    reply to email for when customers respond. This will also be the form submission email address too.</p>
</div>
<div id="system_csv_use_gz" class="overlay"></div>
<div class="popup hint">
  <h2>Export Users CSV, use gz compression</h2>
  <p>
    Allows export information that clients have uploaded, but export is in compressed form. Use this function if you
    know that file will be too large.
  </p>
</div>
<div id="system_csv_fields_dlm" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Export Users CSV, fields delimiter</h2>
  <p>
    This is CSV format which can be read in Ms Excel. Here you can change the way to delimit the info (, Comma, :
    Semicolon, | Pipe).
  </p>
</div>
<div id="system_csv_fields" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Export Users CSV fields</h2>
  <p>
    You can add or delete allowed fields that will be included in the export. Only export the information you need.
    <small class="note"><b>NOTE:</b>Push the action spots or drag and drop the field box to add or remove fields you
      need.
    </small>
  </p>
</div>
<div id="system_allow_sample_express_shipping" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Allow Sample EXPRESS SHIPPING</h2>
  <p>
    The minimum number of samples to qualify for the multiple price.
  </p>
</div>
<div id="paypal_business" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">PayPal Business Account</h2>
  <p>
    Specify your PayPal business Account.
  </p>
</div>
<div id="shop_rate_express_light" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Rate Express Light</h2>
  <p>
    Rate to ship light products via express.
  </p>
</div>
<div id="shop_rate_express_heavy" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Rate Express Heavy</h2>
  <p>
    Rate to ship heavy products via express.
  </p>
</div>
<div id="shop_rate_ground_medium" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Rate Ground Medium</h2>
  <p>
    Rate to ship medium products via ground.
  </p>
</div>
<div id="shop_rate_express_light_multiplier" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Light Express Rate Multiplier</h2>
  <p>
    All products marked as "Light" will have this amount multiplied by the sale amount if the customer selects Express
    Shipping.
  </p>
</div>
<div id="shop_rate_express_heavy_multiplier" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Heavy Express Rate Multiplier</h2>
  <p>
    All products marked as "Heavy" will have this amount multiplied by the sale amount if the customer selects Express
    Shipping.
  </p>
</div>
<div id="shop_rate_ground_medium_multiplier" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Medium Ground Rate Multiplier</h2>
  <p>
    All products marked as "Medium" will have this amount multiplied by the sale amount if the customer selects Ground
    Shipping.
  </p>
</div>
<div id="shop_samples_price_express_shipping" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Samples Express Shipping Price</h2>
  <p>
    In the event that a customer wants samples, and wants express shipping, this price will be used for shipping.
  </p>
</div>
<div id="shop_samples_qty_multiple_max" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Samples Qty Multiple Max</h2>
  <p>
    The maximum number of samples to qualify for the multiple price, after this number they are charged the additional
    price.
  </p>
</div>
<div id="shop_samples_price_multiple" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Samples Price Multiple</h2>
  <p>
    The price if multiple minimum qty is met.
  </p>
</div>
<div id="shop_samples_price_with_products" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Samples Price With Products</h2>
  <p>
    The price charge for samples if they are purchased with any other products.
  </p>
</div>
<div id="system_hide_all_regular_prices" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Hide all regular prices</h2>
  <p>
    In this event that you want to hide regular prices and only show the sale price for items, click this checkbox.
  </p>
</div>
<div id="paypal_url" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">PayPal proceed URI</h2>
  <p>
    Specify your PayPal proceed URL.
  </p>
</div>
<div id="shop_rate_roll" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Rate Roll</h2>
  <p>
    If a customer chooses to have in shipped on the roll.
  </p>
</div>
<div id="shop_bsells_amount" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center"> Best Sellers amount items</h2>
  <p>
    Best Sellers container total amount items.
  </p>
</div>
<div id="shop_specials_amount" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Specials amount items</h2>
  <p>
    Specials container total amount items.
  </p>
</div>
<div id="shop_rate_express_medium" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Rate Express Medium</h2>
  <p>
    Rate to ship medium products via express.
  </p>
</div>
<div id="shop_rate_ground_light" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Rate Ground Light</h2>
  <p>
    Rate to ship light products via ground.
  </p>
</div>
<div id="shop_rate_ground_heavy" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Rate Ground Heavy</h2>
  <p>
    Rate to ship heavy products via ground.
  </p>
</div>
<div id="shop_rate_express_medium_multiplier" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Medium Express Rate Multiplier</h2>
  <p>
    All products marked as "Medium" will have this amount multiplied by the sale amount if the customer selects Express
    Shipping.
  </p>
</div>
<div id="shop_rate_ground_light_multiplier" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Light Ground Rate Multiplier</h2>
  <p>
    All products marked as "Light" will have this amount multiplied by the sale amount if the customer selects Ground
    Shipping.
  </p>
</div>
<div id="shop_rate_ground_heavy_multiplier" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Heavy Ground Rate Multiplier</h2>
  <p>
    All products marked as "Heavy" will have this amount multiplied by the sale amount if the customer selects Ground
    Shipping.
  </p>
</div>
<div id="shop_samples_qty_multiple_min" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Samples Qty Multiple Min</h2>
  <p>
    The minimum number of samples to qualify for the multiple price.
  </p>
</div>
<div id="shop_samples_price_single" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Samples Price Single</h2>
  <p>
    The price if only one sample is purchased.
  </p>
</div>
<div id="shop_samples_price_additional" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Samples Price Additional</h2>
  <p>
    The price for each additional sample after the multiple max quantity.
  </p>
</div>
<div id="shop_yrds_for_multiplier" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Yrds for Multiplier</h2>
  <p>
    Total yardage allowed before a multiplier is added.
  </p>
</div>
<div id="shop_rate_handling" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Rate Handling</h2>
  <p>
    Rate to prepare the parcel.
  </p>
</div>
<div id="date_end" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">End date</h2>
  <p>The date the promotion ends (11:59pm).</p>
</div>
<div id="enabled" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Enabled</h2>
  <p>Overrides all date settings, unchecking enabled will prevent anyone from receiving the promotion.</p>
</div>
<div id="disable_sale_countdown" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Disable sale countdown</h2>
  <p>Checking this will not include it in the sale countdown on the product list, and product details page.</p>
</div>
<script src="<?= App::$app->router()->UrlTo('js/hints.min.js'); ?>"></script>
<script src="<?= App::$app->router()->UrlTo('js/formsimple/simples.min.js'); ?>"></script>
