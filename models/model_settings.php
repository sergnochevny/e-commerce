<?php

  Class Model_Settings extends Model_Base {

    public static function get_by_id($id) {
      $data = [
        'system_site_name' => (!is_null(_A_::$app->keyStorage()->system_site_name) ? _A_::$app->keyStorage()->system_site_name : ''),
        'system_enable_sef' => (!is_null(_A_::$app->keyStorage()->system_enable_sef) ? _A_::$app->keyStorage()->system_enable_sef : ENABLE_SEF),
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
      return $data;
    }

    public static function save(&$data) {
      extract($data);
      _A_::$app->keyStorage()->system_site_name = $system_site_name;
      _A_::$app->keyStorage()->system_enable_sef = $system_enable_sef;
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
