<?php
  $discount_id = Model_Discount::validData(!is_null(_A_::$app->get('d_id')) ? _A_::$app->get('d_id') : null);
  $discount_id = strlen($discount_id) ? intval($discount_id) : null;
  $iType = Model_Discount::validData(!is_null(_A_::$app->post('iType')) ? _A_::$app->post('iType') : '');
  $coupon_code = Model_Discount::validData(!is_null(_A_::$app->post('coupon_code')) ? _A_::$app->post('coupon_code') : '');
  $generate_code = Model_Discount::validData(!is_null(_A_::$app->post('generate_code')) ? _A_::$app->post('generate_code') : false);
  $discount_amount = Model_Discount::validData(_A_::$app->post('discount_amount'));
  $iAmntType = Model_Discount::validData(_A_::$app->post('iAmntType'));
  $iDscntType = Model_Discount::validData(_A_::$app->post('iDscntType'));
  $shipping_type = !is_null(_A_::$app->post('shipping_type')) ? _A_::$app->post('shipping_type') : '0';
  $restrictions = Model_Discount::validData(!is_null(_A_::$app->post('restrictions')) ? _A_::$app->post('restrictions') : '0');
  $iReqType = Model_Discount::validData(_A_::$app->post('iReqType'));
  $users_check = Model_Discount::validData(_A_::$app->post('users_check'));
  $users = !is_null(_A_::$app->post('users')) ? _A_::$app->post('users') : null;
  $sel_fabrics = Model_Discount::validData(_A_::$app->post('sel_fabrics'));
  $filter_products = !is_null(_A_::$app->post('filter_products')) ? _A_::$app->post('filter_products') : null;
  $allow_multiple = Model_Discount::validData(!is_null(_A_::$app->post('allow_multiple')) ? _A_::$app->post('allow_multiple') : '0');
  $start_date = Model_Discount::validData(!is_null(_A_::$app->post('start_date')) ? _A_::$app->post('start_date') : '');
  $date_end = Model_Discount::validData(!is_null(_A_::$app->post('date_end')) ? _A_::$app->post('date_end') : '');
  $enabled = Model_Discount::validData(!is_null(_A_::$app->post('enabled')) ? _A_::$app->post('enabled') : 0);
  $countdown = Model_Discount::validData(!is_null(_A_::$app->post('countdown')) ? _A_::$app->post('countdown') : 0);
  $data = Model_Discount::validData(!is_null(_A_::$app->post('discount_comment1')) ? _A_::$app->post('discount_comment1') : '');
  $discount_comment1 = mysql_real_escape_string($data);
  $data = Model_Discount::validData(!is_null(_A_::$app->post('discount_comment2')) ? _A_::$app->post('discount_comment2') : '');
  $discount_comment2 = mysql_real_escape_string($data);
  $data = Model_Discount::validData(!is_null(_A_::$app->post('discount_comment3')) ? _A_::$app->post('discount_comment3') : '');
  $discount_comment3 = mysql_real_escape_string($data);
  if($enabled == "1") {
    $enabled = "1";
  } else {
    $enabled = "0";
  }
  if($countdown == "1") {
    $countdown = "1";
  } else {
    $countdown = "0";
  }
  if($allow_multiple == "1") {
    $allow_multiple = "1";
  } else {
    $allow_multiple = "0";
  }

//if (!empty($discount_id)) {
//    if (!empty($start_date)) {
//        $d = substr($start_date, 0, 2);
//        $m = substr($start_date, -3, 2);
//        $y = substr($start_date, -4);
//        $start_date = "$d-$m-$y";
//        $start_date = strtotime($start_date);
//        $result = mysql_query("update fabrix_specials set date_start='$start_date' WHERE sid ='$discount_id'");
//    }
//    if (!empty($date_end)) {
//        $d = substr($date_end, 0, 2);
//        $m = substr($date_end, -3, 2);
//        $y = substr($date_end, -4);
//        $date_end = "$d-$m-$y";
//        $date_end = strtotime($date_end);
//        $result = mysql_query("update fabrix_specials set date_end='$date_end' WHERE sid ='$discount_id'");
//    }
//} else {
//    if (!empty($date_end)) {
//        $d = substr($date_end, 0, 2);
//        $m = substr($date_end, -3, 2);
//        $y = substr($date_end, -4);
//        $date_end = "$d-$m-$y";
//        $date_end = strtotime($date_end);
//    }
//    if (!empty($start_date)) {
//        $d = substr($start_date, 0, 2);
//        $m = substr($start_date, -3, 2);
//        $y = substr($start_date, -4);
//        $start_date = "$d-$m-$y";
//        $start_date = strtotime($start_date);
//    }
//}
?>