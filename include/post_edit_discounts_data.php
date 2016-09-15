<?php
$userInfo = $model->validData(isset($_GET['discount_id'])?$_GET['discount_id']:null);
$discount_id = $userInfo['data'];
$userInfo = $model->validData(isset($_POST['iType'])?$_POST['iType']:'');
$iType = $userInfo['data'];
$userInfo = $model->validData(isset($_POST['coupon_code'])?$_POST['coupon_code']:'');
$coupon_code = $userInfo['data'];
$userInfo = $model->validData(isset($_POST['generate_code'])?$_POST['generate_code']:false);
$generate_code = $userInfo['data'];
$userInfo = $model->validData($_POST['discount_amount']);
$discount_amount = $userInfo['data'];
$userInfo = $model->validData($_POST['iAmntType']);
$iAmntType = $userInfo['data'];
$userInfo = $model->validData($_POST['iDscntType']);
$iDscntType = $userInfo['data'];
$shipping_type = isset($_POST['shipping_type']) ? $_POST['shipping_type'] : '0';
$userInfo = $model->validData(isset($_POST['restrictions'])?$_POST['restrictions']:'0');
$restrictions = $userInfo['data'];
$userInfo = $model->validData($_POST['iReqType']);
$iReqType = $userInfo['data'];
$userInfo = $model->validData($_POST['users_check']);
$users_check = $userInfo['data'];
$users_list = isset($_POST['users_list']) ? $_POST['users_list'] : null;
$userInfo = $model->validData($_POST['sel_fabrics']);
$sel_fabrics = $userInfo['data'];
$fabric_list = isset($_POST['fabric_list']) ? $_POST['fabric_list'] : null;
$userInfo = $model->validData(isset($_POST['allow_multiple'])?$_POST['allow_multiple']:'0');
$allow_multiple = $userInfo['data'];

$userInfo = $model->validData(isset($_POST['start_date'])?$_POST['start_date']:'');
$start_date = $userInfo['data'];
$userInfo = $model->validData(isset($_POST['date_end'])?$_POST['date_end']:'');
$date_end = $userInfo['data'];
$userInfo = $model->validData(isset($_POST['enabled'])?$_POST['enabled']:0);
$enabled = $userInfo['data'];
$userInfo = $model->validData(isset($_POST['countdown'])?$_POST['countdown']:0);
$countdown = $userInfo['data'];
$userInfo = $model->validData(isset($_POST['discount_comment1'])?$_POST['discount_comment1']:'');
$discount_comment1 = mysql_real_escape_string($userInfo['data']);
$userInfo = $model->validData(isset($_POST['discount_comment2'])?$_POST['discount_comment2']:'');
$discount_comment2 = mysql_real_escape_string($userInfo['data']);
$userInfo = $model->validData(isset($_POST['discount_comment3'])?$_POST['discount_comment3']:'');
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