<?php
$userInfo = $model->validData(!is_null(_A_::$app->request()->get('discount_id'))?_A_::$app->request()->get('discount_id'):null);
$discount_id = $userInfo['data'];
$userInfo = $model->validData(!is_null(_A_::$app->request()->post('iType'))?_A_::$app->request()->post('iType'):'');
$iType = $userInfo['data'];
$userInfo = $model->validData(!is_null(_A_::$app->request()->post('coupon_code'))?_A_::$app->request()->post('coupon_code'):'');
$coupon_code = $userInfo['data'];
$userInfo = $model->validData(!is_null(_A_::$app->request()->post('generate_code'))?_A_::$app->request()->post('generate_code'):false);
$generate_code = $userInfo['data'];
$userInfo = $model->validData(_A_::$app->request()->post['discount_amount']);
$discount_amount = $userInfo['data'];
$userInfo = $model->validData(_A_::$app->request()->post['iAmntType']);
$iAmntType = $userInfo['data'];
$userInfo = $model->validData(_A_::$app->request()->post['iDscntType']);
$iDscntType = $userInfo['data'];
$shipping_type = !is_null(_A_::$app->request()->post('shipping_type') ? _A_::$app->request()->post('shipping_type') : 0);
$userInfo = $model->validData(!is_null(_A_::$app->request()->post('restrictions')) ? _A_::$app->request()->post('restrictions') : 0);
$restrictions = $userInfo['data'];
$userInfo = $model->validData(_A_::$app->request()->post('iReqType'));
$iReqType = $userInfo['data'];
$userInfo = $model->validData(!is_null(_A_::$app->request()->post('users_check')) ? _A_::$app->request()->post('users_check') : 0);
$users_check = $userInfo['data'];
$users_list = !is_null(_A_::$app->request()->post('users_list')) ? _A_::$app->request()->post('users_list') : null;
$userInfo = $model->validData($_POST['sel_fabrics']);
$sel_fabrics = $userInfo['data'];
$fabric_list = !is_null(_A_::$app->request()->post('fabric_list')) ? _A_::$app->request()->post('fabric_list') : null;
$userInfo = $model->validData(!is_null(_A_::$app->request()->post('allow_multiply')) ? _A_::$app->request()->post('allow_multiply') : 0);
$allow_multiple = $userInfo['data'];

$userInfo = $model->validData(!is_null(_A_::$app->request()->post('start_date')) ? _A_::$app->request()->post('start_date') : 0);
$start_date = $userInfo['data'];
$userInfo = $model->validData(!is_null(_A_::$app->request()->post('date_end')) ? _A_::$app->request()->post('date_end') : 0);
$date_end = $userInfo['data'];
$userInfo = $model->validData(!is_null(_A_::$app->request()->post('enabled')) ? _A_::$app->request()->post('enabled') : 0);
$enabled = $userInfo['data'];
$userInfo = $model->validData(!is_null(_A_::$app->request()->post('countdown')) ? _A_::$app->request()->post('countdown') : 0);
$countdown = $userInfo['data'];
$userInfo = $model->validData(!is_null(_A_::$app->request()->post('discount_comment1')) ? _A_::$app->request()->post('discount_comment1') : '');
$discount_comment1 = mysql_real_escape_string($userInfo['data']);
$userInfo = $model->validData(!is_null(_A_::$app->request()->post('discount_comment2')) ? _A_::$app->request()->post('discount_comment2') : '');
$discount_comment2 = mysql_real_escape_string($userInfo['data']);
$userInfo = $model->validData(!is_null(_A_::$app->request()->post('discount_comment3')) ? _A_::$app->request()->post('discount_comment3') : '');
$discount_comment3 = mysql_real_escape_string($userInfo['data']);
if ($enabled == "1") {
    $enabled = "1";
} else {
    $enabled = "0";
}
if ($countdown == "1") {
    $countdown = "1";
} else {
    $countdown = "0";
}
if ($allow_multiple == "1") {
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