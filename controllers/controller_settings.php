<?php

  class Controller_Settings extends Controller_FormSimple {

    private $csv_fields_avail = [
      'aid', 'email', 'bill_firstname', 'bill_lastname', 'bill_organization', 'bill_address1',
      'bill_address2', 'bill_province', 'bill_city', 'bill_country', 'bill_postal', 'bill_phone',
      'bill_fax', 'bill_email', 'ship_firstname', 'ship_lastname', 'ship_organization', 'ship_address1',
      'ship_address2', 'ship_city', 'ship_province', 'ship_country', 'ship_postal', 'ship_phone', 'ship_fax',
      'ship_email', 'date_registered'
    ];
    protected $form_title_edit = 'MODIFY SETTINGS';

    protected function load(&$data) {

      if(_A_::$app->request_is_post()) {
        $data = [
          'system_site_name' => Model_Settings::sanitize(_A_::$app->post('system_site_name')),
          'system_enable_sef' => Model_Settings::sanitize(_A_::$app->post('system_enable_sef')),
          'system_captcha_time' => Model_Settings::sanitize(_A_::$app->post('system_captcha_time')),
          'system_hide_all_regular_prices' => Model_Settings::sanitize(_A_::$app->post('system_hide_all_regular_prices')),
          'system_filter_amount' => Model_Settings::sanitize(_A_::$app->post('system_filter_amount')),
          'system_allow_sample_express_shipping' => Model_Settings::sanitize(_A_::$app->post('system_allow_sample_express_shipping')),
          'system_csv_use_gz' => Model_Settings::sanitize(_A_::$app->post('system_csv_use_gz')),
          'paypal_business' => Model_Settings::sanitize(_A_::$app->post('paypal_business')),
          'paypal_url' => Model_Settings::sanitize(_A_::$app->post('paypal_url')),
          'system_csv_fields' => Model_Settings::sanitize(_A_::$app->post('system_csv_fields')),
          'system_info_email' => Model_Settings::sanitize(_A_::$app->post('system_info_email')),
          'system_csv_fields_dlm' => Model_Settings::sanitize(_A_::$app->post('system_csv_fields_dlm')),

          'shop_bestsellers_amount' => Model_Settings::sanitize(_A_::$app->post('shop_bestsellers_amount')),
          'shop_specials_amount' => Model_Settings::sanitize(_A_::$app->post('shop_specials_amount')),
          'shop_under_amount' => Model_Settings::sanitize(_A_::$app->post('shop_under_amount')),

          'shop_price_groups_count' => Model_Settings::sanitize(_A_::$app->post('shop_price_groups_count')),
          'shop_rate_handling' => Model_Settings::sanitize(_A_::$app->post('shop_rate_handling')),
          'shop_rate_roll' => Model_Settings::sanitize(_A_::$app->post('shop_rate_roll')),

          'shop_rate_express_light' => Model_Settings::sanitize(_A_::$app->post('shop_rate_express_light')),
          'shop_rate_express_light_multiplier' => Model_Settings::sanitize(_A_::$app->post('shop_rate_express_light_multiplier')),
          'shop_rate_express_medium' => Model_Settings::sanitize(_A_::$app->post('shop_rate_express_medium')),
          'shop_rate_express_medium_multiplier' => Model_Settings::sanitize(_A_::$app->post('shop_rate_express_medium_multiplier')),
          'shop_rate_express_heavy' => Model_Settings::sanitize(_A_::$app->post('shop_rate_express_heavy')),
          'shop_rate_express_heavy_multiplier' => Model_Settings::sanitize(_A_::$app->post('shop_rate_express_heavy_multiplier')),
          'shop_rate_ground_light' => Model_Settings::sanitize(_A_::$app->post('shop_rate_ground_light')),
          'shop_rate_ground_light_multiplier' => Model_Settings::sanitize(_A_::$app->post('shop_rate_ground_light_multiplier')),
          'shop_rate_ground_medium' => Model_Settings::sanitize(_A_::$app->post('shop_rate_ground_medium')),
          'shop_rate_ground_medium_multiplier' => Model_Settings::sanitize(_A_::$app->post('shop_rate_ground_medium_multiplier')),
          'shop_rate_ground_heavy' => Model_Settings::sanitize(_A_::$app->post('shop_rate_ground_heavy')),
          'shop_rate_ground_heavy_multiplier' => Model_Settings::sanitize(_A_::$app->post('shop_rate_ground_heavy_multiplier')),

          'shop_samples_price_express_shipping' => Model_Settings::sanitize(_A_::$app->post('shop_samples_price_express_shipping')),
          'shop_samples_qty_multiple_min' => Model_Settings::sanitize(_A_::$app->post('shop_samples_qty_multiple_min')),
          'shop_samples_qty_multiple_max' => Model_Settings::sanitize(_A_::$app->post('shop_samples_qty_multiple_max')),
          'shop_samples_price_single' => Model_Settings::sanitize(_A_::$app->post('shop_samples_price_single')),
          'shop_samples_price_multiple' => Model_Settings::sanitize(_A_::$app->post('shop_samples_price_multiple')),
          'shop_samples_price_additional' => Model_Settings::sanitize(_A_::$app->post('shop_samples_price_additional')),
          'shop_samples_price_with_products' => Model_Settings::sanitize(_A_::$app->post('shop_samples_price_with_products')),
          'shop_yrds_for_multiplier' => Model_Settings::sanitize(_A_::$app->post('shop_yrds_for_multiplier')),
        ];
        if(!is_null(_A_::$app->post('current_tab'))) $data['current_tab'] = _A_::$app->post('current_tab');
        $data['system_csv_fields'] = implode((!empty($data['system_csv_fields_dlm']) ? $data['system_csv_fields_dlm'] : ','), $data['system_csv_fields']);
      }
    }

    protected function validate(&$data, &$error) {

      $data['system_site_name'] = !empty($data['system_site_name']) ? $data['system_site_name'] : '';
      $data['system_enable_sef'] = !empty($data['system_enable_sef']) ? $data['system_enable_sef'] : 0;
      $data['system_captcha_time'] = !empty((int)$data['system_captcha_time']) ? $data['system_captcha_time'] : CAPTCHA_RELEVANT;
      $data['system_hide_all_regular_prices'] = !empty($data['system_hide_all_regular_prices']) ? $data['system_hide_all_regular_prices'] : 0;
      $data['system_filter_amount'] = !empty($data['system_filter_amount']) ? $data['system_filter_amount'] : FILTER_LIMIT;
      $data['system_allow_sample_express_shipping'] = !empty($data['system_allow_sample_express_shipping']) ? $data['system_allow_sample_express_shipping'] : SAMPLE_EXPRESS_SHIPPING;
      $data['system_csv_use_gz'] = !empty($data['system_csv_use_gz']) ? $data['system_csv_use_gz'] : 0;

      $data['system_csv_fields'] = !empty($data['system_csv_fields']) ? $data['system_csv_fields'] : CSV_FIELDS;
      $data['system_csv_fields_dlm'] = !empty($data['system_csv_fields_dlm']) ? $data['system_csv_fields_dlm'] : ',';

      $data['shop_bestsellers_amount'] = !empty($data['shop_bestsellers_amount']) ? $data['shop_bestsellers_amount'] : SHOP_BSELLS_AMOUNT;
      $data['shop_specials_amount'] = !empty($data['shop_specials_amount']) ? $data['shop_specials_amount'] : SHOP_SPECIALS_AMOUNT;
      $data['shop_under_amount'] = !empty($data['shop_specials_amount']) ? $data['shop_specials_amount'] : SHOP_UNDER_AMOUNT;

      $data['shop_price_groups_count'] = !empty((int)$data['shop_price_groups_count']) ? $data['shop_price_groups_count'] : PRICE_GROUPS_COUNT;
      $data['shop_rate_handling'] = !empty((float)$data['shop_rate_handling']) ? $data['shop_rate_handling'] : RATE_HANDLING;
      $data['shop_rate_roll'] = !empty((float)$data['shop_rate_roll']) ? $data['shop_rate_roll'] : RATE_ROLL;

      $data['shop_rate_express_light'] = !empty((float)$data['shop_rate_express_light']) ? $data['shop_rate_express_light'] : RATE_EXPRESS_LIGHT;
      $data['shop_rate_express_light_multiplier'] = !empty($data['shop_rate_express_light_multiplier']) ? $data['shop_rate_express_light_multiplier'] : RATE_EXPRESS_LIGHT_MULTIPLIER;
      $data['shop_rate_express_medium'] = !empty((float)$data['shop_rate_express_medium']) ? $data['shop_rate_express_medium'] : RATE_EXPRESS_MEDIUM;
      $data['shop_rate_express_medium_multiplier'] = !empty((float)$data['shop_rate_express_medium_multiplier']) ? $data['shop_rate_express_medium_multiplier'] : RATE_EXPRESS_MEDIUM_MULTIPLIER;
      $data['shop_rate_express_heavy'] = !empty((float)$data['shop_rate_express_heavy']) ? $data['shop_rate_express_heavy'] : RATE_EXPRESS_HEAVY;
      $data['shop_rate_express_heavy_multiplier'] = !empty((float)$data['shop_rate_express_heavy_multiplier']) ? $data['shop_rate_express_heavy_multiplier'] : RATE_EXPRESS_HEAVY_MULTIPLIER;
      $data['shop_rate_ground_light'] = !empty((float)$data['shop_rate_ground_light']) ? $data['shop_rate_ground_light'] : RATE_GROUND_LIGHT;
      $data['shop_rate_ground_light_multiplier'] = !empty((float)$data['shop_rate_ground_light_multiplier']) ? $data['shop_rate_ground_light_multiplier'] : RATE_GROUND_LIGHT_MULTIPLIER;
      $data['shop_rate_ground_medium'] = !empty((float)$data['shop_rate_ground_medium']) ? $data['shop_rate_ground_medium'] : RATE_GROUND_MEDIUM;
      $data['shop_rate_ground_medium_multiplier'] = !empty((float)$data['shop_rate_ground_medium_multiplier']) ? $data['shop_rate_ground_medium_multiplier'] : RATE_GROUND_MEDIUM_MULTIPLIER;
      $data['shop_rate_ground_heavy'] = !empty((float)$data['shop_rate_ground_heavy']) ? $data['shop_rate_ground_heavy'] : RATE_GROUND_HEAVY;
      $data['shop_rate_ground_heavy_multiplier'] = !empty((float)$data['shop_rate_ground_heavy_multiplier']) ? $data['shop_rate_ground_heavy_multiplier'] : RATE_GROUND_HEAVY_MULTIPLIER;

      $data['shop_samples_price_express_shipping'] = !empty((float)$data['shop_samples_price_express_shipping']) ? $data['shop_samples_price_express_shipping'] : SAMPLES_PRICE_EXPRESS_SHIPPING;
      $data['shop_samples_qty_multiple_min'] = !empty((float)$data['shop_samples_qty_multiple_min']) ? $data['shop_samples_qty_multiple_min'] : SAMPLES_QTY_MULTIPLE_MIN;
      $data['shop_samples_qty_multiple_max'] = !empty((float)$data['shop_samples_qty_multiple_max']) ? $data['shop_samples_qty_multiple_max'] : SAMPLES_QTY_MULTIPLE_MAX;
      $data['shop_samples_price_single'] = !empty((float)$data['shop_samples_price_single']) ? $data['shop_samples_price_single'] : SAMPLES_PRICE_SINGLE;
      $data['shop_samples_price_multiple'] = !empty((float)$data['shop_samples_price_multiple']) ? $data['shop_samples_price_multiple'] : SAMPLES_PRICE_MULTIPLE;
      $data['shop_samples_price_additional'] = !empty((float)$data['shop_samples_price_additional']) ? $data['shop_samples_price_additional'] : SAMPLES_PRICE_ADDITIONAL;
      $data['shop_samples_price_with_products'] = !empty((float)$data['shop_samples_price_with_products']) ? $data['shop_samples_price_with_products'] : SAMPLES_PRICE_WITH_PRODUCTS;
      $data['shop_yrds_for_multiplier'] = !empty((float)$data['shop_yrds_for_multiplier']) ? $data['shop_yrds_for_multiplier'] : YRDS_FOR_MULTIPLIER;

      if(
        empty($data['paypal_business']) ||
        empty($data['paypal_url']) ||
        empty($data['system_info_email']) ||
        empty($data['system_site_name']) ||
        ($data['shop_rate_handling'] <= 0) ||
        ($data['shop_rate_roll'] <= 0) ||
        ($data['shop_rate_express_light'] <= 0) ||
        ($data['shop_rate_express_light_multiplier'] <= 0) ||
        ($data['shop_rate_express_medium'] <= 0) ||
        ($data['shop_rate_express_medium_multiplier'] <= 0) ||
        ($data['shop_rate_express_heavy'] <= 0) ||
        ($data['shop_rate_express_heavy_multiplier'] <= 0) ||
        ($data['shop_rate_ground_light'] <= 0) ||
        ($data['shop_rate_ground_light_multiplier'] <= 0) ||
        ($data['shop_rate_ground_medium'] <= 0) ||
        ($data['shop_rate_ground_medium_multiplier'] <= 0) ||
        ($data['shop_rate_ground_heavy'] <= 0) ||
        ($data['shop_rate_ground_heavy_multiplier'] <= 0) ||
        ($data['shop_samples_price_express_shipping'] <= 0) ||
        ($data['shop_samples_qty_multiple_min'] <= 0) ||
        ($data['shop_samples_qty_multiple_max'] <= 0) ||
        ($data['shop_samples_price_single'] <= 0) ||
        ($data['shop_samples_price_multiple'] <= 0) ||
        ($data['shop_samples_price_additional'] <= 0) ||
        ($data['shop_samples_price_with_products'] <= 0) ||
        ($data['shop_yrds_for_multiplier'] <= 0)

      ) {

        $error = ['Please fill in all required fields (marked with * )'];
        $error1 = [];
        $error2 = [];

        $error_ = '';
        if(empty($data['system_site_name']))
          $error_ .= '<br>&#9;Identify <b>Site Name</b> field!';
        if(empty($data['system_info_email'])) {
          if(!empty($error_)) $error_ .= '<br>';
          $error_ .= '<br>&#9;Identify <b>System Information Email</b> field!';
        }
        if(!empty($error_)) {
          $error1[] = 'PANEL SYSTEM:<br>' . $error_;
        }
        $error = array_merge($error, $error1);
        $error_ = '';
        if(empty($data['paypal_url']))
          $error_ .= '&#9;Identify <b>PayPal preceed URI</b> field!';
        if(empty($data['paypal_business'])) {
          if(!empty($error_)) $error_ .= '<br>';
          $error_ .= '&#9;Identify <b>PayPal Business Account</b> field!';
        }

        if($data['shop_rate_handling'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Rate Handling</b> value must be greater than zero';
        }
        if($data['shop_rate_roll'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Rate Roll</b> value must be greater than zero';
        }
        if($data['shop_rate_express_light'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Rate Express Light</b> value must be greater than zero';
        }
        if($data['shop_rate_express_light_multiplier'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Rate Express Light Multiplier</b> value must be greater than zero';
        }
        if($data['shop_rate_express_medium'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Rate Express Medium</b> value must be greater than zero';
        }
        if($data['shop_rate_express_medium_multiplier'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Rate Express Medium Multiplier</b> value must be greater than zero';
        }
        if($data['shop_rate_express_heavy'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Rate Express Heavy</b> value must be greater than zero';
        }
        if($data['shop_rate_express_heavy_multiplier'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Rate Express Heavy Multiplier</b> value must be greater than zero';
        }
        if($data['shop_rate_ground_light'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Rate Ground Light</b> value must be greater than zero';
        }
        if($data['shop_rate_ground_light_multiplier'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Rate Ground Light Multiplier</b> value must be greater than zero';
        }
        if($data['shop_rate_ground_medium'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Rate Ground Medium</b> value must be greater than zero';
        }
        if($data['shop_rate_ground_medium_multiplier'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Rate Ground Medium Multiplier</b> value must be greater than zero';
        }
        if($data['shop_rate_ground_heavy'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Rate Ground Heavy</b> value must be greater than zero';
        }
        if($data['shop_rate_ground_heavy_multiplier'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Rate Ground Heavy Multiplier</b> value must be greater than zero';
        }
        if($data['shop_samples_price_express_shipping'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Samples Price Express Shipping</b> value must be greater than zero';
        }
        if($data['shop_samples_qty_multiple_min'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Samples Qty Multiple Min</b> value must be greater than zero';
        }
        if($data['shop_samples_qty_multiple_max'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Samples Qty Multiple Max</b> value must be greater than zero';
        }
        if($data['shop_samples_price_single'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Samples Price Single</b> value must be greater than zero';
        }
        if($data['shop_samples_price_multiple'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Samples Price Multiple</b> value must be greater than zero';
        }
        if($data['shop_samples_price_additional'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Samples Price Additional</b> value must be greater than zero';
        }
        if($data['shop_samples_price_with_products'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Samples Price With Products</b> value must be greater than zero';
        }
        if($data['shop_yrds_for_multiplier'] <= 0) {
          if(!$error_) $error_ .= '<br>';
          $error_ .= '&#9;The field <b>Shop Yrds For Multiplier</b> value must be greater than zero';
        }

        if(!empty($error_)) {
          $error2[] = 'TAB SHOP:<br>' . $error_;
        }
        $error = array_merge($error, $error2);
      } else return true;
      return false;
    }

    protected function before_form_layout(&$data = null) {
      $csv_fields_dlm = (!is_null(_A_::$app->keyStorage()->system_csv_fields_dlm) ? _A_::$app->keyStorage()->system_csv_fields_dlm : ',');
      $data['system_csv_fields'] = explode($csv_fields_dlm, $data['system_csv_fields']);
      $data['system_csv_fields_avail'] = array_diff($this->csv_fields_avail, $data['system_csv_fields']);
    }

    public function view($partial = false, $required_access = false) { }

    public function delete($required_access = true) { }

    public function index($required_access = true) { }

    public function add($required_access = true) { }

  }