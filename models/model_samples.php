<?php

Class Model_Samples extends Model_Model
{

    public static function calculateSamplesPrice($products, $samples){

        $numberSamples = count($samples);

        #check that there are samples
        if($numberSamples==0){
            return 0.00;
        }

        #check if they are purchasing the samples with a product
        #if so then they are charged a flat rate per sample
//        if(count($products) > 0){
//            return $numberSamples * SAMPLES_PRICE_WITH_PRODUCTS;
//        }

        #check if the number of samples is larger then the multiple minimum
        if($numberSamples < SAMPLES_QTY_MULTIPLE_MIN){
            return SAMPLES_PRICE_SINGLE;
        }

        if(($numberSamples >= SAMPLES_QTY_MULTIPLE_MIN) && ($numberSamples <= SAMPLES_QTY_MULTIPLE_MAX)){
            return SAMPLES_PRICE_MULTIPLE;
        }

        if($numberSamples > SAMPLES_QTY_MULTIPLE_MAX){
            return SAMPLES_PRICE_MULTIPLE + (($numberSamples-SAMPLES_QTY_MULTIPLE_MAX) * SAMPLES_PRICE_ADDITIONAL);
        }

    }

    public static function allowSamplesExpressShipping(){

        $bol = false;

        $minute = (int)date('i');
        $hour = (int)date('G');
        $dayOfWeek = (int)date('w');

        #check to make sure the day of the week is between the before and after day (i.e. if the range is monday-thursday check that today is between)
        #check to see if the hour is less then the deadline hour
        #check to see if the minute is less then the deadline minute
        if((($dayOfWeek >= SAMPLES_PURCHASE_AFTER_DAY) && ($dayOfWeek <= SAMPLES_PURCHASE_BEFORE_DAY)) && (($hour < SAMPLES_PURCHASE_BEFORE_TIME_HOUR) || (($hour = SAMPLES_PURCHASE_BEFORE_TIME_HOUR) && ($minute < SAMPLES_PURCHASE_BEFORE_TIME_MINUTE)))){
            $bol = true;
        }

    }

    public static function systemAllowSamplesExpressShipping(){

        #default to false
        $return = false;

        $sql = 'SELECT allow_sample_express_shipping FROM fabrix_system_master;';
        $result = mysql_query($sql) or die(mysql_error());
        $rs = mysql_fetch_row($result);
        if((int)$rs[0] === 1){
            $return = true;
        }
        mysql_free_result($result);

        return $return;

    }

    public static function allowedSamples($pid) {

        $sql = sprintf("SELECT piece FROM fabrix_products WHERE pid = %u ", $pid);
        $res = mysql_query($sql);
        $piece = mysql_fetch_assoc($res);
        $piece = $piece['piece'];

        if($piece == 1) return false;

        #select the product id where the product is in one of the non allowed sample categories
        $sql = sprintf("SELECT pid FROM fabrix_product_categories WHERE pid = %u AND (cid = %u OR cid = %u OR cid = %u)", $pid, 14, 4, 26);

        #if the query fails, return false to disallow samples
        if (($res = mysql_query($sql)) === false) {
            return false;
        }

        if (mysql_num_rows($res) > 0) {
            return false;
        }
        else {
            return true;
        }

    }

}