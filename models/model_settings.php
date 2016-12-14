<?php

  Class Model_Settings extends Model_Base {

    public static function get_by_id($id) {

      $data = [
        'system_enable_sef' =>  Model_Settings::sanitize(_A_::$app->post('system_enable_sef')),
       'system_demo' =>  Model_Settings::sanitize(_A_::$app->post('system_demo')),
       'system_captcha_time' =>  Model_Settings::sanitize(_A_::$app->post('system_captcha_time')),
       'system_hide_all_regular_prices' =>  Model_Settings::sanitize(_A_::$app->post('system_hide_all_regular_prices')),
       'system_filter_amount' =>  Model_Settings::sanitize(_A_::$app->post('system_filter_amount')),
       'system_allow_sample_express_shipping' =>  Model_Settings::sanitize(_A_::$app->post('system_allow_sample_express_shipping')),
       'system_csv_use_gz' =>  Model_Settings::sanitize(_A_::$app->post('system_csv_use_gz')),
       'paypal_business' =>  Model_Settings::sanitize(_A_::$app->post('paypal_business')),
       'paypal_url' =>  Model_Settings::sanitize(_A_::$app->post('paypal_url')),
       'system_csv_fields' =>  Model_Settings::sanitize(_A_::$app->post('system_csv_fields')),
       'system_info_email' =>  Model_Settings::sanitize(_A_::$app->post('system_info_email')),
       'system_csv_fields_dlm' =>  Model_Settings::sanitize(_A_::$app->post('system_csv_fields_dlm')),

       'shop_price_groups_count' =>  Model_Settings::sanitize(_A_::$app->post('shop_price_groups_count')),
       'shop_rate_handling' =>  Model_Settings::sanitize(_A_::$app->post('shop_rate_handling')),
       'shop_rate_roll' =>  Model_Settings::sanitize(_A_::$app->post('shop_rate_roll')),

       'shop_rate_express_light' =>  Model_Settings::sanitize(_A_::$app->post('shop_rate_express_light')),
       'shop_rate_express_light_multiplier' =>  Model_Settings::sanitize(_A_::$app->post('shop_rate_express_light_multiplier')),
       'shop_rate_express_medium' =>  Model_Settings::sanitize(_A_::$app->post('shop_rate_express_medium')),
       'shop_rate_express_medium_multiplier' =>  Model_Settings::sanitize(_A_::$app->post('shop_rate_express_medium_multiplier')),
       'shop_rate_express_heavy' =>  Model_Settings::sanitize(_A_::$app->post('shop_rate_express_heavy')),
       'shop_rate_express_heavy_multiplier' =>  Model_Settings::sanitize(_A_::$app->post('shop_rate_express_heavy_multiplier')),
       'shop_rate_ground_light' =>  Model_Settings::sanitize(_A_::$app->post('shop_rate_ground_light')),
       'shop_rate_ground_light_multiplier' =>  Model_Settings::sanitize(_A_::$app->post('shop_rate_ground_light_multiplier')),
       'shop_rate_ground_medium' =>  Model_Settings::sanitize(_A_::$app->post('shop_rate_ground_medium')),
       'shop_rate_ground_medium_multiplier' =>  Model_Settings::sanitize(_A_::$app->post('shop_rate_ground_medium_multiplier')),
       'shop_rate_ground_heavy' =>  Model_Settings::sanitize(_A_::$app->post('shop_rate_ground_heavy')),
       'shop_rate_ground_heavy_multiplier' =>  Model_Settings::sanitize(_A_::$app->post('shop_rate_ground_heavy_multiplier')),

       'shop_samples_price_express_shipping' =>  Model_Settings::sanitize(_A_::$app->post('shop_samples_price_express_shipping')),
       'shop_samples_qty_multiple_min' =>  Model_Settings::sanitize(_A_::$app->post('shop_samples_qty_multiple_min')),
       'shop_samples_qty_multiple_max' =>  Model_Settings::sanitize(_A_::$app->post('shop_samples_qty_multiple_max')),
       'shop_samples_price_single' =>  Model_Settings::sanitize(_A_::$app->post('shop_samples_price_single')),
       'shop_samples_price_multiple' =>  Model_Settings::sanitize(_A_::$app->post('shop_samples_price_multiple')),
       'shop_samples_price_additional' =>  Model_Settings::sanitize(_A_::$app->post('shop_samples_price_additional')),
       'shop_samples_price_with_products' =>  Model_Settings::sanitize(_A_::$app->post('shop_samples_price_with_products')),
       'shop_yrds_for_multiplier' =>  Model_Settings::sanitize(_A_::$app->post('shop_yrds_for_multiplier')),
      ];
      return $data;
    }

    public static function save(&$data) {
      extract($data);
      _A_::$app->keyStorage()->system_enable_sef = $system_enable_sef;
      _A_::$app->keyStorage()->system_demo = $system_demo;
      _A_::$app->keyStorage()->system_captcha_time = $system_captcha_time;
      _A_::$app->keyStorage()->system_hide_all_regular_prices = $system_hide_all_regular_prices;
      _A_::$app->keyStorage()->system_filter_amount = $system_filter_amount;
      _A_::$app->keyStorage()->system_allow_sample_express_shipping = $system_allow_sample_express_shipping;
      _A_::$app->keyStorage()->system_csv_use_gz = $system_csv_use_gz;
      _A_::$app->keyStorage()->paypal_business = $paypal_business;
      _A_::$app->keyStorage()->paypal_url = $paypal_url;
      _A_::$app->keyStorage()->system_csv_fields = $system_csv_fields;
      _A_::$app->keyStorage()->system_info_email = $system_info_email;
      _A_::$app->keyStorage()->system_csv_fields_dlm = $system_csv_fields_dlm;

      _A_::$app->keyStorage()->shop_price_groups_count = $shop_price_groups_count;
      _A_::$app->keyStorage()->shop_rate_handling = $shop_rate_handling;
      _A_::$app->keyStorage()->shop_rate_roll = $shop_rate_roll;

      _A_::$app->keyStorage()->shop_rate_express_light = $shop_rate_express_light;
      _A_::$app->keyStorage()->shop_rate_express_light_multiplier = $shop_rate_express_light_multiplier;
      _A_::$app->keyStorage()->shop_rate_express_medium = $shop_rate_express_medium;
      _A_::$app->keyStorage()->shop_rate_express_medium_multiplier = $shop_rate_express_medium_multiplier;
      _A_::$app->keyStorage()->shop_rate_express_heavy = $shop_rate_express_heavy;
      _A_::$app->keyStorage()->shop_rate_express_heavy_multiplier = $shop_rate_express_heavy_multiplier;
      _A_::$app->keyStorage()->shop_rate_ground_light = $shop_rate_ground_light;
      _A_::$app->keyStorage()->shop_rate_ground_light_multiplier = $shop_rate_ground_light_multiplier;
      _A_::$app->keyStorage()->shop_rate_ground_medium = $shop_rate_ground_medium;
      _A_::$app->keyStorage()->shop_rate_ground_medium_multiplier = $shop_rate_ground_medium_multiplier;
      _A_::$app->keyStorage()->shop_rate_ground_heavy = $shop_rate_ground_heavy;
      _A_::$app->keyStorage()->shop_rate_ground_heavy_multiplier = $shop_rate_ground_heavy_multiplier;

      _A_::$app->keyStorage()->shop_samples_price_express_shipping = $shop_samples_price_express_shipping;
      _A_::$app->keyStorage()->shop_samples_qty_multiple_min = $shop_samples_qty_multiple_min;
      _A_::$app->keyStorage()->shop_samples_qty_multiple_max = $shop_samples_qty_multiple_max;
      _A_::$app->keyStorage()->shop_samples_price_single = $shop_samples_price_single;
      _A_::$app->keyStorage()->shop_samples_price_multiple = $shop_samples_price_multiple;
      _A_::$app->keyStorage()->shop_samples_price_additional = $shop_samples_price_additional;
      _A_::$app->keyStorage()->shop_samples_price_with_products = $shop_samples_price_with_products;
      _A_::$app->keyStorage()->shop_yrds_for_multiplier = $shop_yrds_for_multiplier;

      return null;
    }

  }
