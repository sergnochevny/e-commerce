<?php

class Model_Samples extends Model_Base{

  public static function calculateSamplesPrice($products, $samples){

    $numberSamples = count($samples);

    #check that there are samples
    if($numberSamples == 0) {
      return 0.00;
    }

    #check if they are purchasing the samples with a product
    #if so then they are charged a flat rate per sample
//        if(count($products) > 0){
//            return $numberSamples * SAMPLES_PRICE_WITH_PRODUCTS;
//        }

    #check if the number of samples is larger then the multiple minimum
    if($numberSamples < !empty($data['shop_samples_qty_multiple_min']) ? $data['shop_samples_qty_multiple_min'] : SAMPLES_QTY_MULTIPLE_MIN) {
      return (!is_null(_A_::$app->keyStorage()->shop_samples_price_single) ? _A_::$app->keyStorage()->shop_samples_price_single : SAMPLES_PRICE_SINGLE);
    }

    if(($numberSamples >= !empty($data['shop_samples_qty_multiple_min']) ? $data['shop_samples_qty_multiple_min'] : SAMPLES_QTY_MULTIPLE_MIN) && ($numberSamples <= !empty($data['shop_samples_qty_multiple_max']) ? $data['shop_samples_qty_multiple_max'] : SAMPLES_QTY_MULTIPLE_MAX)) {
      return (!is_null(_A_::$app->keyStorage()->shop_samples_price_multiple) ? _A_::$app->keyStorage()->shop_samples_price_multiple : SAMPLES_PRICE_MULTIPLE);
    }

    if($numberSamples > !empty($data['shop_samples_qty_multiple_max']) ? $data['shop_samples_qty_multiple_max'] : SAMPLES_QTY_MULTIPLE_MAX) {
      return ((!is_null(_A_::$app->keyStorage()->shop_samples_price_multiple) ? _A_::$app->keyStorage()->shop_samples_price_multiple : SAMPLES_PRICE_MULTIPLE)) + (($numberSamples - (!empty($data['shop_samples_qty_multiple_max']) ? $data['shop_samples_qty_multiple_max'] : SAMPLES_QTY_MULTIPLE_MAX)) * (!empty($data['shop_samples_price_additional']) ? $data['shop_samples_price_additional'] : SAMPLES_PRICE_ADDITIONAL));
    }

    return null;
  }

  public static function allowSamplesExpressShipping(){

    $result = false;

    $minute = (int)date('i');
    $hour = (int)date('G');
    $dayOfWeek = (int)date('w');

    if((($dayOfWeek >= SAMPLES_PURCHASE_AFTER_DAY) && ($dayOfWeek <= SAMPLES_PURCHASE_BEFORE_DAY)) && (($hour < SAMPLES_PURCHASE_BEFORE_TIME_HOUR) || (($hour = SAMPLES_PURCHASE_BEFORE_TIME_HOUR) && ($minute < SAMPLES_PURCHASE_BEFORE_TIME_MINUTE)))) {
      $result = true;
    }

    return $result;
  }

  public static function systemAllowSamplesExpressShipping(){
    $result = (!is_null(_A_::$app->keyStorage()->system_allow_sample_express_shipping) ? _A_::$app->keyStorage()->system_allow_sample_express_shipping : SAMPLE_EXPRESS_SHIPPING);
    if(!isset($result)) $result = false;

    return $result;
  }

  public static function allowedSamples($pid){

    $sql = sprintf("SELECT piece FROM shop_products WHERE pid = %u ", $pid);
    $res = static::query($sql);
    $piece = static::fetch_assoc($res);
    $piece = $piece['piece'];

    if($piece == 1) return false;

    #select the product id where the product is in one of the non allowed sample categories
    $sql = sprintf("SELECT pid FROM shop_product_categories WHERE pid = %u AND (cid = %u OR cid = %u OR cid = %u)", $pid, 14, 4, 26);

    #if the query fails, return false to disallow samples
    if(($res = static::query($sql)) === false) {
      return false;
    }

    if(static::num_rows($res) > 0) {
      return false;
    } else {
      return true;
    }
  }

}