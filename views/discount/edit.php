<link rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('views/css/jquery-ui.css'); ?>">
<script src="<?= _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js'); ?>"></script>
<div class="site-container">
  <?php include "views/header.php"; ?>
  <div class="main-content main-content-shop">
    <div class="container">
      <div id="content" class="main-content-inner" role="main">
        <a href="<?= $back_url; ?>" class="button back_button">Back</a>
        <div>
          <h1 class="page-title"><?= $form_title ?></h1>
          <div class="col-sm-12 text-center" style="margin-bottom: 25px">
            <small style="color: black; font-size: 12px;">
              Use this form to add/update discounts to the system. <br/>
            </small>
            <div class="row">
              <hr>
            </div>
            <small style="color: black; font-size: 12px;">
              Clicking on the section title will open a help file explaining that section.
            </small>
          </div>
          <div id="form_content">
            <?= $form; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="promotion" class="overlay" style="z-index: 99999999;"></div>
<div class="popup" style="z-index: 99999999; font-size: 12px; color: black; max-width: 700px;">
  <h2>promotion</h2>
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
<div id="coupon_code" class="overlay" style="z-index: 99999999;"></div>
<div class="popup" style="z-index: 99999999; font-size: 12px; color: black;">
  <h2>coupon code</h2>
  <p>
    Adding a coupon code requies that the customer enters in the coupon code to get the discount. If no coupon code
    exists then the customer will receive the discount if they qualify. The user must still meet the requirements even
    if a coupon code is entered. Clicking 'Generate Coupon Code for me' will generate a 10 digit unique code.
    <br/><b>NOTE: </b> All coupon code discounts must be multiple discounts.
    <br/><b>NOTE: </b> coupon code discounts must apply to all products.
  </p>
</div>
<div id="discount_details" class="overlay" style="z-index: 99999999;"></div>
<div class="popup" style="z-index: 99999999; font-size: 12px; color: black;">
  <h2>discount details</h2>
  <p>
    Allows the admin to set the percentage or total dollars off as the discount - when percentage is chosen then the
    percentage can be taken off either of the sub total (price of all products * quantities), the shipping.
    <br/><b>NOTE: </b> All shipping discounts must be multiple discounts.
  </p>
</div>
<div id="required_amount" class="overlay" style="z-index: 99999999;"></div>
<div class="popup" style="z-index: 99999999; font-size: 12px; color: black;">
  <h2>restrictions</h2>
  <p>Allows for a limit to be imposed before the promotion is applied. Generally only the Total dollar amount will be
    used. Purchases only applies to the Users account total, Users account total for last month promotion types, all
    others will only check for a number to be entered.</p>
</div>
<div id="users" class="overlay" style="z-index: 99999999;"></div>
<div class="popup" style="z-index: 99999999;">
  <h2>users</h2>
  <p><b>All users </b>No restriction on the users that the promotion applies to.</p>
  <p><b>All new users </b>The promotion applies to only the users who have not made a purchase.</p>
  <p><b>All registered users </b>The promotion applies to only the users who have previously made a purchase.</p>
  <p><b>All selected users </b>Allows the admin to select one or more users from the list of all users.</p>
</div>
<div id="fabrics" class="overlay" style="z-index: 99999999;"></div>
<div class="popup" style="z-index: 99999999;">
  <h2>fabrics</h2>
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
<div id="allow_multiple" class="overlay" style="z-index: 99999999;"></div>
<div class="popup" style="z-index: 99999999;">
  <h2>allow multiple</h2>
  <p>
    Checking this allows this discount to be used in conjunction with another discount. The sum of all applicable
    discounts will be added to the total amount of discount given by all applicable non-multiple discounts.
    <br/><b>NOTE:</b> All shipping discounts must be multiple discounts.
    <br/><b>NOTE:</b> All discounts involving a coupon code are multiple discounts.
  </p>
</div>
<div id="date" class="overlay" style="z-index: 99999999;"></div>
<div class="popup" style="z-index: 99999999;">
  <h2>date</h2>
  <p>The start date the promotion takes effect (12:01 am).</p>
  <p>The end date the promotion ends (11:59pm).</p>
</div>
<div id="date_start" class="overlay" style="z-index: 99999999;"></div>
<div class="popup" style="z-index: 99999999;">
  <h2>start date</h2>
  <p>The date the promotion takes effect (12:01 am).</p>
</div>
<div id="date_end" class="overlay" style="z-index: 99999999;"></div>
<div class="popup" style="z-index: 99999999;">
  <h2>end date</h2>
  <p>The date the promotion ends (11:59pm).</p>
</div>
<div id="enabled" class="overlay" style="z-index: 99999999;"></div>
<div class="popup" style="z-index: 99999999;">
  <h2>enabled</h2>
  <p>Overrides all date settings, unchecking enabled will prevent anyone from receiving the promotion.</p>
</div>
<div id="disable_sale_countdown" class="overlay" style="z-index: 99999999;"></div>
<div class="popup" style="z-index: 99999999;">
  <h2>disable sale countdown</h2>
  <p>Checking this will not include it in the sale countdown on the product list, and product details page.</p>
</div>
<script src="<?= _A_::$app->router()->UrlTo('views/js/discount/modal_rules.js'); ?>"></script>