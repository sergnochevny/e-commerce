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
      $data = [
        'system_enable_sef' => (!is_null(_A_::$app->keyStorage()->system_enable_sef) ? _A_::$app->keyStorage()->system_enable_sef : ENABLE_SEF),
        'system_demo' => (!is_null(_A_::$app->keyStorage()->system_demo) ? _A_::$app->keyStorage()->system_demo : DEMO),
        'system_captcha_time' => (!is_null(_A_::$app->keyStorage()->system_captcha_time) ? _A_::$app->keyStorage()->system_captcha_time : CAPTCHA_RELEVANT),
        'system_hide_all_regular_prices' => (!is_null(_A_::$app->keyStorage()->system_hide_all_regular_prices) ? _A_::$app->keyStorage()->system_hide_all_regular_prices : HIDE_REGULAR_PRICE),
        'system_filter_amount' => (!is_null(_A_::$app->keyStorage()->system_filter_amount) ? _A_::$app->keyStorage()->system_filter_amount : FILTER_LIMIT),
        'system_allow_sample_express_shipping' => (!is_null(_A_::$app->keyStorage()->system_allow_sample_express_shipping) ? _A_::$app->keyStorage()->system_allow_sample_express_shipping : SAMPLE_EXPRESS_SHIPPING),
        'system_csv_use_gz' => (!is_null(_A_::$app->keyStorage()->system_csv_use_gz) ? _A_::$app->keyStorage()->system_csv_use_gz : CSV_USE_GZ),
        'paypal_business' => (!is_null(_A_::$app->keyStorage()->paypal_business) ? _A_::$app->keyStorage()->paypal_business : ''),
        'paypal_url' => (!is_null(_A_::$app->keyStorage()->paypal_url) ? _A_::$app->keyStorage()->paypal_url : ''),
        'system_csv_fields' => (!is_null(_A_::$app->keyStorage()->system_csv_fields) ? _A_::$app->keyStorage()->system_csv_fields : CSV_FIELDS),
        'system_info_email' => (!is_null(_A_::$app->keyStorage()->system_info_email) ? _A_::$app->keyStorage()->system_info_email : ''),
        'system_csv_fields_dlm' => (!is_null(_A_::$app->keyStorage()->system_csv_fields_dlm) ? _A_::$app->keyStorage()->system_csv_fields_dlm : ','),

        'shop_price_groups_count' => (!is_null(_A_::$app->keyStorage()->shop_price_groups_count) ? _A_::$app->keyStorage()->shop_price_groups_count : PRICE_GROUPS_COUNT),
        'shop_rate_handling' => (!is_null(_A_::$app->keyStorage()->shop_rate_handling) ? _A_::$app->keyStorage()->shop_rate_handling : RATE_HANDLING),
        'shop_rate_roll' => (!is_null(_A_::$app->keyStorage()->shop_rate_roll) ? _A_::$app->keyStorage()->shop_rate_roll : RATE_ROLL),

        'shop_rate_express_light' => (!is_null(_A_::$app->keyStorage()->shop_rate_express_light) ? _A_::$app->keyStorage()->shop_rate_express_light : RATE_EXPRESS_LIGHT),
        'shop_rate_express_light_multiplier' => (!is_null(_A_::$app->keyStorage()->shop_rate_express_light_multiplier) ? _A_::$app->keyStorage()->shop_rate_express_light_multiplier : RATE_EXPRESS_LIGHT_MULTIPLIER),
        'shop_rate_express_medium' => (!is_null(_A_::$app->keyStorage()->shop_rate_express_medium) ? _A_::$app->keyStorage()->shop_shop_rate_express_medium : RATE_EXPRESS_MEDIUM),
        'shop_rate_express_medium_multiplier' => (!is_null(_A_::$app->keyStorage()->shop_rate_express_medium_multiplier) ? _A_::$app->keyStorage()->shop_rate_express_medium_multiplier : RATE_EXPRESS_MEDIUM_MULTIPLIER),
        'shop_rate_express_heavy' => (!is_null(_A_::$app->keyStorage()->shop_rate_express_heavy) ? _A_::$app->keyStorage()->shop_rate_express_heavy : RATE_EXPRESS_HEAVY),
        'shop_rate_express_heavy_multiplier' => (!is_null(_A_::$app->keyStorage()->shop_rate_express_heavy_multiplier) ? _A_::$app->keyStorage()->shop_rate_express_heavy_multiplier : RATE_EXPRESS_HEAVY_MULTIPLIER),
        'shop_rate_ground_light' => (!is_null(_A_::$app->keyStorage()->shop_rate_ground_light) ? _A_::$app->keyStorage()->shop_rate_ground_light : RATE_GROUND_LIGHT),
        'shop_rate_ground_light_multiplier' => (!is_null(_A_::$app->keyStorage()->shop_rate_ground_light_multiplier) ? _A_::$app->keyStorage()->shop_rate_ground_light_multiplier : RATE_GROUND_LIGHT_MULTIPLIER),
        'shop_rate_ground_medium' => (!is_null(_A_::$app->keyStorage()->shop_rate_ground_medium) ? _A_::$app->keyStorage()->shop_rate_ground_medium : RATE_GROUND_MEDIUM),
        'shop_rate_ground_medium_multiplier' => (!is_null(_A_::$app->keyStorage()->shop_rate_ground_medium_multiplier) ? _A_::$app->keyStorage()->shop_rate_ground_medium_multiplier : RATE_GROUND_MEDIUM_MULTIPLIER),
        'shop_rate_ground_heavy' => (!is_null(_A_::$app->keyStorage()->shop_rate_ground_heavy) ? _A_::$app->keyStorage()->shop_rate_ground_heavy : RATE_GROUND_HEAVY),
        'shop_rate_ground_heavy_multiplier' => (!is_null(_A_::$app->keyStorage()->shop_rate_ground_heavy_multiplier) ? _A_::$app->keyStorage()->shop_rate_ground_heavy_multiplier : RATE_GROUND_HEAVY_MULTIPLIER),

        'shop_samples_price_express_shipping' => (!is_null(_A_::$app->keyStorage()->shop_samples_price_express_shipping) ? _A_::$app->keyStorage()->shop_samples_price_express_shipping : SAMPLES_PRICE_EXPRESS_SHIPPING),
        'shop_samples_qty_multiple_min' => (!is_null(_A_::$app->keyStorage()->shop_samples_qty_multiple_min) ? _A_::$app->keyStorage()->shop_samples_qty_multiple_min : SAMPLES_QTY_MULTIPLE_MIN),
        'shop_samples_qty_multiple_max' => (!is_null(_A_::$app->keyStorage()->shop_samples_qty_multiple_max) ? _A_::$app->keyStorage()->shop_samples_qty_multiple_max : SAMPLES_QTY_MULTIPLE_MAX),
        'shop_samples_price_single' => (!is_null(_A_::$app->keyStorage()->shop_samples_price_single) ? _A_::$app->keyStorage()->shop_samples_price_single : SAMPLES_PRICE_SINGLE),
        'shop_samples_price_multiple' => (!is_null(_A_::$app->keyStorage()->shop_samples_price_multiple) ? _A_::$app->keyStorage()->shop_samples_price_multiple : SAMPLES_PRICE_MULTIPLE),
        'shop_samples_price_additional' => (!is_null(_A_::$app->keyStorage()->shop_samples_price_additional) ? _A_::$app->keyStorage()->shop_samples_price_additional : SAMPLES_PRICE_ADDITIONAL),
        'shop_samples_price_with_products' => (!is_null(_A_::$app->keyStorage()->shop_samples_price_with_products) ? _A_::$app->keyStorage()->shop_samples_price_with_products : SAMPLES_PRICE_WITH_PRODUCTS),
        'shop_yrds_for_multiplier' => (!is_null(_A_::$app->keyStorage()->shop_yrds_for_multiplier) ? _A_::$app->keyStorage()->shop_yrds_for_multiplier : YRDS_FOR_MULTIPLIER),
      ];
    }

    protected function validate(&$data, &$error) {

      if(empty($data['email'])) {
        $error = ["Email can't be blank!"];
      } else {
        if(Model_User::exist($data['email'], $data['aid'])) {
          $error[] = 'User with such email already exists!';
        } else {
          if(($this->scenario() !== 'short') && (
              ((!isset($data['aid'])) && (empty($data['create_password']) || empty($data['confirm_password']))) ||
              empty($data['bill_firstname']) ||
              empty($data['bill_lastname']) ||
              (empty($data['bill_address1']) && empty($data['bill_address2'])) ||
              empty($data['bill_country']) ||
              empty($data['bill_postal']) ||
              empty($data['bill_phone']) ||
              ((isset($data['ship_as_billing'])) &&
                (empty($data['ship_firstname']) ||
                  empty($data['ship_lastname']) ||
                  (empty($data['ship_address1']) && empty($data['ship_address2'])) ||
                  empty($data['ship_country']) || empty($data['ship_postal']))))
          ) {

            $error = ['Please fill in all required fields (marked with * )'];
            $error1 = [];
            $error2 = [];

            if((!isset($data['aid'])) && (empty($data['create_password']) || empty($data['confirm_password'])))
              $error[] = '&#9;Identify <b>Create Password</b> and <b>Confirm Password</b> field!';
            if(empty($data['bill_firstname']))
              $error1[] = '&#9;Identify <b>First Name</b> field!';
            if(empty($data['bill_lastname']))
              $error1[] = '&#9;Identify <b>Last Name</b> field!';
            if((empty($data['bill_address1']) && empty($data['bill_address2'])))
              $error1[] = '&#9;Identify <b>Address</b> field!';
            if(empty($data['bill_country']{0}))
              $error1[] = '&#9;Identify <b>Country</b> field!';
            if(empty($data['bill_postal']))
              $error1[] = '&#9;Identify <b>Postal/Zip Code</b> field!';
            if(empty($data['bill_phone']))
              $error1[] = '&#9;Identify <b>Telephone</b> field!';
            if(count($error1) > 0) {
              if(count($error) > 0) $error[] = '<br>';
              $error[] = 'BILLING INFORMATION:';
              $error = array_merge($error, $error1);
            }
            if(isset($data['ship_as_billing'])) {

              if(empty($data['ship_firstname']))
                $error2[] = '&#9;Identify <b>First Name</b> field!';
              if(empty($data['ship_lastname']))
                $error2[] = '&#9;Identify <b>Last Name</b> field!';
              if((empty($data['ship_address1']) && empty($data['ship_address2'])))
                $error2[] = '&#9;Identify <b>Address</b> field!';
              if(empty($data['ship_country']{0}))
                $error2[] = '&#9;Identify <b>Country</b> field!';
              if(empty($data['ship_postal']))
                $error2[] = '&#9;Identify <b>Postal/Zip Code</b> field!';

              if(count($error2) > 0) {
                if(count($error) > 0)
                  $error[] = '';
                $error[] = 'SHIPPING INFORMATION:';
                $error = array_merge($error, $error2);
              }
            }
          } else {
            $verify = Controller_Captcha::check_captcha(isset($data['captcha']) ? $data['captcha'] : '', $error2);
            if(($this->scenario() == 'short') && (
                ((!isset($data['aid'])) && (empty($data['create_password']) || empty($data['confirm_password']))) ||
                empty($data['bill_firstname']) ||
                empty($data['bill_lastname']) ||
                empty($data['captcha']) || !$verify
              )
            ) {
              $error = ['Please fill in all required fields:'];
              $error1 = [];

              if((!isset($data['aid'])) && (empty($data['create_password']) || empty($data['confirm_password'])))
                $error1[] = '&#9;Identify <b>Password</b> and <b>Confirm Password</b> field!';
              if(empty($data['bill_firstname']))
                $error1[] = '&#9;Identify <b>First Name</b> field!';
              if(empty($data['bill_lastname']))
                $error1[] = '&#9;Identify <b>Last Name</b> field!';
              if(empty($data['captcha']))
                $error1[] = '&#9;Identify <b>Captcha</b> field!';
              if(!$verify)
                $error1[] = '&#9;' . $error2[0];
              if(count($error1) > 0) {
                if(count($error) > 0) $error[] = '';
                $error = array_merge($error, $error1);
              }
            } else {
              if(!empty($data['create_password'])) {
                $salt = Model_Auth::generatestr();
                $password = Model_Auth::hash_($data['create_password'], $salt, 12);
                $check = Model_Auth::check($data['confirm_password'], $password);
              } else $password = null;

              if(is_null($password) || (isset($check) && ($password == $check))) {
                $data['password'] = $password;
                return true;
              } else {
                $error[] = 'Confirm password doesn\'t match';
              }
            }
          }
        }
      }
      return false;
    }

    protected function before_form_layout(&$data = null) {
      $csv_fields_dlm = (!is_null(_A_::$app->keyStorage()->system_csv_fields_dlm) ? _A_::$app->keyStorage()->system_csv_fields_dlm : ',');
      $data['system_csv_fields'] = explode($csv_fields_dlm, $data['system_csv_fields']);
      $data['system_csv_fields_avail'] = array_diff($this->csv_fields_avail, $data['system_csv_fields']);
    }

    protected function before_save(&$data) {
      $data['system_csv_fields'] = implode($data['system_csv_fields_dlm'], $data['system_csv_fields']);
    }

    public function view() { }

    public function delete($required_access = true) { }

    public function index($required_access = true) { }

    public function add($required_access = true) { }

  }