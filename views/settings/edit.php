<script src='<?= _A_::$app->router()->UrlTo('views/js/settings/edit.min.js'); ?>' type="text/javascript"></script>
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

<div id="system_site_name" class="overlay"></div>
<div class="popup hint">
  <h2>Site Name</h2>
  <p>
    The name of the site that is used by the system as the title, description, keywords, when these parameters are empty.
  </p>
</div>

<div id="system_enable_sef" class="overlay"></div>
<div class="popup hint">
  <h2>Enable SEF</h2>
  <p>
    System for converting SEF links. System uses TITLE as a base. This function works on Products and Blog pages. The whole title goes in the link without any reduction.
  </p>
</div>
<div id="system_filter_amount" class="overlay"></div>
<div class="popup hint">
  <h2>Filter Limit Amount</h2>
  <p>
    Limitation of length list in the filter. You can choose how long this list will be (25 or 50 or 100).
  </p>
</div>
<div id="system_captcha_time" class="overlay"></div>
<div class="popup hint">
  <h2>Captcha Relevant Time</h2>
  <p>
    In what time catpcha becomes irrelevant. After expiry this time need to update the capcha image.
  </p>
</div>
<div id="system_info_email" class="overlay"></div>
<div class="popup hint">
  <h2>System Information Email</h2>
  <p>Main Email of the WEB-site, all information from the site comes on this Email or from it.</p>
</div>
<div id="system_csv_use_gz" class="overlay"></div>
<div class="popup hint">
  <h2>Export Users CSV, use gz compression</h2>
  <p>
    Allows to export information that clients have left in compressed form. Use this function when you know that file will be very big.
  </p>
</div>
<div id="system_csv_fields_dlm" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Export Users CSV, fields delimiter</h2>
  <p>
    This is CSV format which can be read in Ms Excel. Here you can change the way to delimit the info (, Comma, : Semicolon, | Vertical Bar).
  </p>
</div>
<div id="system_csv_fields" class="overlay"></div>
<div class="popup hint">
  <h2 class="text-center">Export Users CSV fields</h2>
  <p>
    Allows to export information that clients have left.
    You can add or delete the allowed fields. Change the order of fields in the target file.
    <br/><b>NOTE: </b>Push the action spots or drag and drop the field box to add or remove fields you need.
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
<script src="<?= _A_::$app->router()->UrlTo('views/js/hints.min.js'); ?>"></script>