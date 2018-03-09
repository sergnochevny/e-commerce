<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;

/**
 * Class ModelSettings
 * @package models
 */
class ModelSettings extends ModelBase{

  /**
   * @param $id
   * @return array
   */
  public static function get_by_id($id){
    $data = [
      'system_site_name' => (!is_null(App::$app->keyStorage()->system_site_name) ? App::$app->keyStorage()->system_site_name : ''),
      'system_enable_sef' => (!is_null(App::$app->keyStorage()->system_enable_sef) ? App::$app->keyStorage()->system_enable_sef : ENABLE_SEF),
      'system_captcha_time' => (!is_null(App::$app->keyStorage()->system_captcha_time) ? App::$app->keyStorage()->system_captcha_time : CAPTCHA_RELEVANT),
      'system_hide_all_regular_prices' => (!is_null(App::$app->keyStorage()->system_hide_all_regular_prices) ? App::$app->keyStorage()->system_hide_all_regular_prices : HIDE_REGULAR_PRICE),
      'system_filter_amount' => (!is_null(App::$app->keyStorage()->system_filter_amount) ? App::$app->keyStorage()->system_filter_amount : FILTER_LIMIT),
      'system_allow_sample_express_shipping' => (!is_null(App::$app->keyStorage()->system_allow_sample_express_shipping) ? App::$app->keyStorage()->system_allow_sample_express_shipping : SAMPLE_EXPRESS_SHIPPING),
      'system_csv_use_gz' => (!is_null(App::$app->keyStorage()->system_csv_use_gz) ? App::$app->keyStorage()->system_csv_use_gz : CSV_USE_GZ),
      'paypal_business' => (!is_null(App::$app->keyStorage()->paypal_business) ? App::$app->keyStorage()->paypal_business : ''),
      'paypal_url' => (!is_null(App::$app->keyStorage()->paypal_url) ? App::$app->keyStorage()->paypal_url : ''),
      'system_csv_fields' => (!is_null(App::$app->keyStorage()->system_csv_fields) ? App::$app->keyStorage()->system_csv_fields : CSV_FIELDS),
      'system_info_email' => (!is_null(App::$app->keyStorage()->system_info_email) ? App::$app->keyStorage()->system_info_email : ''),
      'system_send_from_email' => (!is_null(App::$app->keyStorage()->system_send_from_email) ? App::$app->keyStorage()->system_send_from_email : ''),
      'system_csv_fields_dlm' => (!is_null(App::$app->keyStorage()->system_csv_fields_dlm) ? App::$app->keyStorage()->system_csv_fields_dlm : ','),

      'shop_bestsellers_amount' => (!is_null(App::$app->keyStorage()->shop_bestsellers_amount) ? App::$app->keyStorage()->shop_bestsellers_amount : SHOP_BSELLS_AMOUNT),
      'shop_specials_amount' => (!is_null(App::$app->keyStorage()->shop_specials_amount) ? App::$app->keyStorage()->shop_specials_amount : SHOP_SPECIALS_AMOUNT),
      'shop_under_amount' => (!is_null(App::$app->keyStorage()->shop_under_amount) ? App::$app->keyStorage()->shop_under_amount : SHOP_UNDER_AMOUNT),
      'shop_last_amount' => (!is_null(App::$app->keyStorage()->shop_last_amount) ? App::$app->keyStorage()->shop_last_amount : SHOP_LAST_AMOUNT),
      'shop_best_amount' => (!is_null(App::$app->keyStorage()->shop_best_amount) ? App::$app->keyStorage()->shop_best_amount : SHOP_BEST_AMOUNT),
      'shop_popular_amount' => (!is_null(App::$app->keyStorage()->shop_popular_amount) ? App::$app->keyStorage()->shop_popular_amount : SHOP_POPULAR_AMOUNT),

      'shop_price_groups_count' => (!is_null(App::$app->keyStorage()->shop_price_groups_count) ? App::$app->keyStorage()->shop_price_groups_count : PRICE_GROUPS_COUNT),
      'shop_rate_handling' => (!is_null(App::$app->keyStorage()->shop_rate_handling) ? App::$app->keyStorage()->shop_rate_handling : RATE_HANDLING),
      'shop_rate_roll' => (!is_null(App::$app->keyStorage()->shop_rate_roll) ? App::$app->keyStorage()->shop_rate_roll : RATE_ROLL),

      'shop_rate_express_light' => (!is_null(App::$app->keyStorage()->shop_rate_express_light) ? App::$app->keyStorage()->shop_rate_express_light : RATE_EXPRESS_LIGHT),
      'shop_rate_express_light_multiplier' => (!is_null(App::$app->keyStorage()->shop_rate_express_light_multiplier) ? App::$app->keyStorage()->shop_rate_express_light_multiplier : RATE_EXPRESS_LIGHT_MULTIPLIER),
      'shop_rate_express_medium' => (!is_null(App::$app->keyStorage()->shop_rate_express_medium) ? App::$app->keyStorage()->shop_rate_express_medium : RATE_EXPRESS_MEDIUM),
      'shop_rate_express_medium_multiplier' => (!is_null(App::$app->keyStorage()->shop_rate_express_medium_multiplier) ? App::$app->keyStorage()->shop_rate_express_medium_multiplier : RATE_EXPRESS_MEDIUM_MULTIPLIER),
      'shop_rate_express_heavy' => (!is_null(App::$app->keyStorage()->shop_rate_express_heavy) ? App::$app->keyStorage()->shop_rate_express_heavy : RATE_EXPRESS_HEAVY),
      'shop_rate_express_heavy_multiplier' => (!is_null(App::$app->keyStorage()->shop_rate_express_heavy_multiplier) ? App::$app->keyStorage()->shop_rate_express_heavy_multiplier : RATE_EXPRESS_HEAVY_MULTIPLIER),
      'shop_rate_ground_light' => (!is_null(App::$app->keyStorage()->shop_rate_ground_light) ? App::$app->keyStorage()->shop_rate_ground_light : RATE_GROUND_LIGHT),
      'shop_rate_ground_light_multiplier' => (!is_null(App::$app->keyStorage()->shop_rate_ground_light_multiplier) ? App::$app->keyStorage()->shop_rate_ground_light_multiplier : RATE_GROUND_LIGHT_MULTIPLIER),
      'shop_rate_ground_medium' => (!is_null(App::$app->keyStorage()->shop_rate_ground_medium) ? App::$app->keyStorage()->shop_rate_ground_medium : RATE_GROUND_MEDIUM),
      'shop_rate_ground_medium_multiplier' => (!is_null(App::$app->keyStorage()->shop_rate_ground_medium_multiplier) ? App::$app->keyStorage()->shop_rate_ground_medium_multiplier : RATE_GROUND_MEDIUM_MULTIPLIER),
      'shop_rate_ground_heavy' => (!is_null(App::$app->keyStorage()->shop_rate_ground_heavy) ? App::$app->keyStorage()->shop_rate_ground_heavy : RATE_GROUND_HEAVY),
      'shop_rate_ground_heavy_multiplier' => (!is_null(App::$app->keyStorage()->shop_rate_ground_heavy_multiplier) ? App::$app->keyStorage()->shop_rate_ground_heavy_multiplier : RATE_GROUND_HEAVY_MULTIPLIER),

      'shop_samples_price_express_shipping' => (!is_null(App::$app->keyStorage()->shop_samples_price_express_shipping) ? App::$app->keyStorage()->shop_samples_price_express_shipping : SAMPLES_PRICE_EXPRESS_SHIPPING),
      'shop_samples_qty_multiple_min' => (!is_null(App::$app->keyStorage()->shop_samples_qty_multiple_min) ? App::$app->keyStorage()->shop_samples_qty_multiple_min : SAMPLES_QTY_MULTIPLE_MIN),
      'shop_samples_qty_multiple_max' => (!is_null(App::$app->keyStorage()->shop_samples_qty_multiple_max) ? App::$app->keyStorage()->shop_samples_qty_multiple_max : SAMPLES_QTY_MULTIPLE_MAX),
      'shop_samples_price_single' => (!is_null(App::$app->keyStorage()->shop_samples_price_single) ? App::$app->keyStorage()->shop_samples_price_single : SAMPLES_PRICE_SINGLE),
      'shop_samples_price_multiple' => (!is_null(App::$app->keyStorage()->shop_samples_price_multiple) ? App::$app->keyStorage()->shop_samples_price_multiple : SAMPLES_PRICE_MULTIPLE),
      'shop_samples_price_additional' => (!is_null(App::$app->keyStorage()->shop_samples_price_additional) ? App::$app->keyStorage()->shop_samples_price_additional : SAMPLES_PRICE_ADDITIONAL),
      'shop_samples_price_with_products' => (!is_null(App::$app->keyStorage()->shop_samples_price_with_products) ? App::$app->keyStorage()->shop_samples_price_with_products : SAMPLES_PRICE_WITH_PRODUCTS),
      'shop_yrds_for_multiplier' => (!is_null(App::$app->keyStorage()->shop_yrds_for_multiplier) ? App::$app->keyStorage()->shop_yrds_for_multiplier : YRDS_FOR_MULTIPLIER),

      'system_emails_debug' => !is_null(App::$app->keyStorage()->system_emails_debug) ? App::$app->keyStorage()->system_emails_debug : 1,
      'system_emails_host' => !is_null(App::$app->keyStorage()->system_emails_host) ? App::$app->keyStorage()->system_emails_host : '',
      'system_emails_port' => !is_null(App::$app->keyStorage()->system_emails_port) ? App::$app->keyStorage()->system_emails_port : '',
      'system_emails_user_name' => !is_null(App::$app->keyStorage()->system_emails_user_name) ? App::$app->keyStorage()->system_emails_user_name : '',
      'system_emails_password' => !is_null(App::$app->keyStorage()->system_emails_password) ? App::$app->keyStorage()->system_emails_password : '',
      'system_emails_encryption' => !is_null(App::$app->keyStorage()->system_emails_encryption) ? App::$app->keyStorage()->system_emails_encryption : '',
      'system_emails_admins' => (!is_null(App::$app->keyStorage()->system_emails_admins) ? App::$app->keyStorage()->system_emails_admins : ''),
      'system_emails_sellers' => (!is_null(App::$app->keyStorage()->system_emails_sellers) ? App::$app->keyStorage()->system_emails_sellers : '')

    ];

    return $data;
  }

  /**
   * @param $data
   * @return null
   */
  public static function save(&$data){
    extract($data);
    App::$app->keyStorage()->system_site_name = $system_site_name;
    App::$app->keyStorage()->system_enable_sef = $system_enable_sef;
    App::$app->keyStorage()->system_captcha_time = $system_captcha_time;
    App::$app->keyStorage()->system_hide_all_regular_prices = $system_hide_all_regular_prices;
    App::$app->keyStorage()->system_filter_amount = $system_filter_amount;
    App::$app->keyStorage()->system_allow_sample_express_shipping = $system_allow_sample_express_shipping;
    App::$app->keyStorage()->system_csv_use_gz = $system_csv_use_gz;
    App::$app->keyStorage()->paypal_business = $paypal_business;
    App::$app->keyStorage()->paypal_url = $paypal_url;
    App::$app->keyStorage()->system_csv_fields = $system_csv_fields;
    App::$app->keyStorage()->system_info_email = $system_info_email;
    App::$app->keyStorage()->system_send_from_email = $system_send_from_email;
    App::$app->keyStorage()->system_csv_fields_dlm = $system_csv_fields_dlm;

    App::$app->keyStorage()->shop_bestsellerss_amount = $shop_bestsellers_amount;
    App::$app->keyStorage()->shop_specials_amount = $shop_specials_amount;
    App::$app->keyStorage()->shop_under_amount = $shop_under_amount;
    App::$app->keyStorage()->shop_last_amount =$shop_last_amount;
    App::$app->keyStorage()->shop_best_amount = $shop_best_amount;
    App::$app->keyStorage()->shop_popular_amount = $shop_popular_amount;

    App::$app->keyStorage()->shop_price_groups_count = $shop_price_groups_count;
    App::$app->keyStorage()->shop_rate_handling = $shop_rate_handling;
    App::$app->keyStorage()->shop_rate_roll = $shop_rate_roll;

    App::$app->keyStorage()->shop_rate_express_light = $shop_rate_express_light;
    App::$app->keyStorage()->shop_rate_express_light_multiplier = $shop_rate_express_light_multiplier;
    App::$app->keyStorage()->shop_rate_express_medium = $shop_rate_express_medium;
    App::$app->keyStorage()->shop_rate_express_medium_multiplier = $shop_rate_express_medium_multiplier;
    App::$app->keyStorage()->shop_rate_express_heavy = $shop_rate_express_heavy;
    App::$app->keyStorage()->shop_rate_express_heavy_multiplier = $shop_rate_express_heavy_multiplier;
    App::$app->keyStorage()->shop_rate_ground_light = $shop_rate_ground_light;
    App::$app->keyStorage()->shop_rate_ground_light_multiplier = $shop_rate_ground_light_multiplier;
    App::$app->keyStorage()->shop_rate_ground_medium = $shop_rate_ground_medium;
    App::$app->keyStorage()->shop_rate_ground_medium_multiplier = $shop_rate_ground_medium_multiplier;
    App::$app->keyStorage()->shop_rate_ground_heavy = $shop_rate_ground_heavy;
    App::$app->keyStorage()->shop_rate_ground_heavy_multiplier = $shop_rate_ground_heavy_multiplier;

    App::$app->keyStorage()->shop_samples_price_express_shipping = $shop_samples_price_express_shipping;
    App::$app->keyStorage()->shop_samples_qty_multiple_min = $shop_samples_qty_multiple_min;
    App::$app->keyStorage()->shop_samples_qty_multiple_max = $shop_samples_qty_multiple_max;
    App::$app->keyStorage()->shop_samples_price_single = $shop_samples_price_single;
    App::$app->keyStorage()->shop_samples_price_multiple = $shop_samples_price_multiple;
    App::$app->keyStorage()->shop_samples_price_additional = $shop_samples_price_additional;
    App::$app->keyStorage()->shop_samples_price_with_products = $shop_samples_price_with_products;
    App::$app->keyStorage()->shop_yrds_for_multiplier = $shop_yrds_for_multiplier;

    App::$app->keyStorage()->system_emails_debug = $system_emails_debug;
    App::$app->keyStorage()->system_emails_host = $system_emails_host;
    App::$app->keyStorage()->system_emails_port = $system_emails_port;
    App::$app->keyStorage()->system_emails_user_name = $system_emails_user_name;
    App::$app->keyStorage()->system_emails_password = $system_emails_password;
    App::$app->keyStorage()->system_emails_encryption = $system_emails_encryption;
    App::$app->keyStorage()->system_emails_admins = $system_emails_admins;
    App::$app->keyStorage()->system_emails_sellers = $system_emails_sellers;

    return null;
  }

}
