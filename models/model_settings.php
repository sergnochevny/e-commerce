<?php

  Class Model_Settings extends Model_Base {

    public static function get_by_id($id) {

      $data = [
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
      ];
      return $data;
    }

    public static function save(&$data) {
      extract($data);
      $discount_comment1 = mysql_real_escape_string($discount_comment1);
      $discount_comment2 = mysql_real_escape_string($discount_comment2);
      $discount_comment3 = mysql_real_escape_string($discount_comment3);
      if(isset($sid)) {
        $q = "UPDATE " . static::$table .
          " SET" .
          " coupon_code='$coupon_code'," .
          " discount_amount='$discount_amount'," .
          " discount_amount_type='$discount_amount_type'," .
          " discount_type='$discount_type'," .
          " user_type='$user_type'," .
          " shipping_type='$shipping_type'," .
          " product_type='$product_type'," .
          " promotion_type='$promotion_type'," .
          " required_amount='$required_amount'," .
          " required_type='$required_type'," .
          " allow_multiple='$allow_multiple'," .
          " enabled='$enabled'," .
          " countdown='$countdown'," .
          " discount_comment1='$discount_comment1'," .
          " discount_comment2='$discount_comment2'," .
          " discount_comment3='$discount_comment3'," .
          " date_start='$date_start'," .
          " date_end='$date_end'" .
          " WHERE sid ='$sid'";
        $res = mysql_query($q);
      } else {
        $q = "INSERT INTO " . static::$table .
          " SET" .
          " coupon_code='$coupon_code'," .
          " discount_amount='$discount_amount'," .
          " discount_amount_type='$discount_amount_type'," .
          " discount_type='$discount_type'," .
          " user_type='$user_type'," .
          " shipping_type='$shipping_type'," .
          " product_type='$product_type'," .
          " promotion_type='$promotion_type'," .
          " required_amount='$required_amount'," .
          " required_type='$required_type'," .
          " allow_multiple='$allow_multiple'," .
          " enabled='$enabled'," .
          " countdown='$countdown'," .
          " discount_comment1='$discount_comment1'," .
          " discount_comment2='$discount_comment2'," .
          " discount_comment3='$discount_comment3'," .
          " date_start='$date_start'," .
          " date_end='$date_end'";

        $res = mysql_query($q);
        if($res) $sid = mysql_insert_id();
      }
      if($res) {
        $res = mysql_query("DELETE FROM fabrix_specials_users WHERE sid ='$sid'");
        if($res && ($user_type == 4)) {
          foreach($users as $aid) {
            $res = mysql_query("INSERT INTO  fabrix_specials_users (sid ,aid)VALUES('$sid',  '$aid')");
            if(!$res) break;
          }
        }
      }
      if($res) {
        $res = mysql_query("DELETE FROM fabrix_specials_products WHERE sid='$sid'");
        if($res && isset($product_type) && ($product_type > 1)) {
          foreach($filter_products as $pid) {
            $res = mysql_query("INSERT INTO  fabrix_specials_products (sid ,pid, stype) VALUES ('$sid',  '$pid', '$product_type')");
            if(!$res) break;
          }
        }
      }
      if(!$res) throw new Exception(mysql_error());
      return $sid;
    }

  }
