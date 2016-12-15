<script src='<?= _A_::$app->router()->UrlTo('views/js/settings/edit.js'); ?>' type="text/javascript"></script>
<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="row afterhead-row">
        <div class="col-sm-12 text-center">
          <div class="row">
            <h3 class="page-title"><?= $form_title ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div data-role="form_content" class="row">
    <?= $form; ?>
  </div>
</div>

<div id="system_demo" class="overlay"></div>
<div class="popup" style="z-index: 99999999; font-size: 12px; color: black; max-width: 700px;">
  <h2>Demo Mode</h2>
  <b>Any purchase</b>
  <p>no restriction on the type of purchase, uses only the restriction, users, and date fields to limit who receives the
    discount.</p>
  <b>First purchase</b>
  <p>restricts the purchase to be the first purchase for the user type chosen. obeys all other restrictions, adds the
    need for the purchase to be the first purchase by the user.</p>
  <b>Next purchase after the start date</b>
  <p>checks to see if a purchase has been made after the start date. If none has been made, the other restrictions are
    checked, if they are met then the user will receive the discount.</p>
  <b>Total current order amount</b>
  <p>uses the restrictions number field, if the total of all the items purchased (before shipping and handling) is
    greater then the number entered in to the restrictions number field then they will receive the discount.</p>
</div>
<div id="system_enable_sef" class="overlay"></div>
<div class="popup" style="z-index: 99999999; font-size: 12px; color: black;">
  <h2>Enable SEF</h2>
  <p>
    Adding a coupon code requies that the customer enters in the coupon code to get the discount. If no coupon code
    exists then the customer will receive the discount if they qualify. The user must still meet the requirements even
    if a coupon code is entered. Clicking 'Generate Coupon Code for me' will generate a 10 digit unique code.
    <br/><b>NOTE: </b> All coupon code discounts must be multiple discounts.
    <br/><b>NOTE: </b> coupon code discounts must apply to all products.
  </p>
</div>
<div id="system_filter_amount" class="overlay"></div>
<div class="popup" style="z-index: 99999999; font-size: 12px; color: black;">
  <h2>Filter Limit Amount</h2>
  <p>
    Allows the admin to set the percentage or total dollars off as the discount - when percentage is chosen then the
    percentage can be taken off either of the sub total (price of all products * quantities), the shipping.
    <br/><b>NOTE: </b> All shipping discounts must be multiple discounts.
  </p>
</div>
<div id="system_captcha_time" class="overlay"></div>
<div class="popup" style="z-index: 99999999; font-size: 12px; color: black;">
  <h2>Captcha Relevant Time</h2>
  <p>Allows for a limit to be imposed before the promotion is applied. Generally only the Total dollar amount will be
    used. Purchases only applies to the Users account total, Users account total for last month promotion types, all
    others will only check for a number to be entered.</p>
</div>
<div id="system_info_email" class="overlay"></div>
<div class="popup">
  <h2>System Information Email</h2>
  <p><b>All users </b>No restriction on the users that the promotion applies to.</p>
  <p><b>All new users </b>The promotion applies to only the users who have not made a purchase.</p>
  <p><b>All registered users </b>The promotion applies to only the users who have previously made a purchase.</p>
  <p><b>All selected users </b>Allows the admin to select one or more users from the list of all users.</p>
</div>
<div id="system_csv_use_gz" class="overlay"></div>
<div class="popup">
  <h2>Export Users CSV, use gz compression</h2>
  <p>
    <b>All fabrics</b><br/>
    No restriction on the fabrics that the promotion applies to.
  </p>
  <p>
    <b>All selected fabrics</b><br/>
    Allows the admin to select one or more fabrics from the list of all fabrics.
    <br/><b>NOTE:</b> this option will only apply to the subtotal of the selected product regardless of the discount
    details selection.
    <br/><b>NOTE:</b> the list contains all products, not just those that are visible.
    <br/><b>NOTE:</b> coupon code discounts must apply to all products.
  </p>
</div>
<div id="system_csv_fields_dlm" class="overlay"></div>
<div class="popup">
  <h2 class="text-center">Export Users CSV, fields delimiter</h2>
  <p>
    Checking this allows this discount to be used in conjunction with another discount. The sum of all applicable
    discounts will be added to the total amount of discount given by all applicable non-multiple discounts.
    <br/><b>NOTE:</b> All shipping discounts must be multiple discounts.
    <br/><b>NOTE:</b> All discounts involving a coupon code are multiple discounts.
  </p>
</div>
<div id="system_csv_fields" class="overlay"></div>
<div class="popup">
  <h2 class="text-center">Export Users CSV fields</h2>
  <p>The date the promotion takes effect (12:01 am).</p>
</div>


<div id="date_end" class="overlay"></div>
<div class="popup">
  <h2 class="text-center">End date</h2>
  <p>The date the promotion ends (11:59pm).</p>
</div>
<div id="enabled" class="overlay"></div>
<div class="popup">
  <h2 class="text-center">Enabled</h2>
  <p>Overrides all date settings, unchecking enabled will prevent anyone from receiving the promotion.</p>
</div>
<div id="disable_sale_countdown" class="overlay"></div>
<div class="popup">
  <h2 class="text-center">Disable sale countdown</h2>
  <p>Checking this will not include it in the sale countdown on the product list, and product details page.</p>
</div>
<script src="<?= _A_::$app->router()->UrlTo('views/js/discount/modal_rules.min.js'); ?>"></script>