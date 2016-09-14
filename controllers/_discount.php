<?php

class Controller_Discount extends Controller_Base
{

    function discount()
    {
        $this->main->test_access_rights();
        $this->get_list();

        $this->main->view_admin('discounts');
    }

    function get_list()
    {
        $this->main->test_access_rights();
        $results = mysql_query("select * from fabrix_specials ORDER BY  `fabrix_specials`.`sid`DESC");
        ob_start();
        while ($row = mysql_fetch_array($results)) {
            if ($row[14] == "1") {
                $row[14] = "YES";
            } else {
                $row[14] = "NO";
            }
            if ($row[11] == "1") {
                $row[11] = "YES";
            } else {
                $row[11] = "NO";
            }
            include('./views/discount/get_list.php');
        }
        $list = ob_get_contents();
        ob_end_clean();

        $this->template->vars('list', $list);
    }

    function del()
    {
        $this->main->test_access_rights();
        $model = new Model_Discount();
        $id = $model->validData(_A_::$app->get('id'));
        if (!empty($discounts_id)) {
            $model->del_discount($discounts_id);
        }

        $this->get_list();
        $this->main->view_layout('list');
    }

    function add()
    {
        $this->main->test_access_rights();
        $model = new Model_Discount();

        $userInfo = $model->get_new_discounts_data();
        $this->template->vars('userInfo', $userInfo);

        $this->main->view_admin('add');
    }

    function edit()
    {
        $this->main->test_access_rights();
        $model = new Model_Discount();
        $id = $model->validData(_A_::$app->get('id'));
        $userInfo = $model->get_edit_discounts_data($id);
        $this->template->vars('userInfo', $userInfo);
        $this->main->view_admin('edit');
    }

    function edit_form()
    {
        $this->main->test_access_rights();
        $model = new Model_Discount();
        $id = $model->validData(_A_::$app->get('id'));
        $userInfo = $model->get_edit_discounts_data($id);
        $this->template->vars('userInfo', $userInfo);
        $this->main->view_layout('edit_form');
    }


    function usage()
    {
        $this->main->test_access_rights();
        $this->data_usage();
        $this->data_usage_order();

        $this->main->view_admin('usage');
    }

    function data_usage()
    {
        $this->main->test_access_rights();
        $model = new Model_Discount();
        $id = $model->validData(_A_::$app->get('id'));
        if (!empty($discounts_id)) {
            $resulthatistim = mysql_query("select * from fabrix_specials WHERE sid='" . $id . "'");
            $rowsni = mysql_fetch_array($resulthatistim);
            $p_discount_amount = $rowsni['discount_amount'];
            $allow_multiple = $rowsni['allow_multiple'];
            $date_start = $rowsni['date_start'];
            $date_end = $rowsni['date_end'];
            $coupon_code = $rowsni['coupon_code'];
            $discount_comment1 = $rowsni['discount_comment1'];
            $enabled = $rowsni['enabled'];
            $sid = $rowsni['sid'];
            if ($enabled == "1") {
                $enabled = "YES";
            } else {
                $enabled = "NO";
            }
            if ($allow_multiple == "1") {
                $allow_multiple = "YES";
            } else {
                $allow_multiple = "NO";
            }
            $date_start = gmdate("F j, Y, g:i a", $date_start);
            $date_end = gmdate("F j, Y, g:i a", $date_end);

            ob_start();
            include('data_usage.php');
            $data_usage_discounts = ob_get_contents();
            ob_end_clean();
            $this->main->template->vars('data_usage_discounts', $data_usage_discounts);
        }
    }

    function data_usage_order()
    {
        $this->main->test_access_rights();
        $model = new Model_Discount();
        $discounts_id = $model->validData(_A_::$app->get('discounts_id'));
        if (!empty($discounts_id)) {
            $i = 0;
            ob_start();
            $results = mysql_query("select * from fabrix_specials_usage WHERE specialId='" . $discounts_id . "'");
            while ($row = mysql_fetch_array($results)) {
                $resulthatistim = mysql_query("select * from fabrix_orders WHERE oid='" . $row[2] . "'");
                $rowsni = mysql_fetch_array($resulthatistim);
                $order_aid = $rowsni['aid'];
                $order_date = gmdate("F j, Y, g:i a", $rowsni['order_date']);
                $resulthatistim = mysql_query("select * from fabrix_accounts WHERE aid='" . $order_aid . "'");
                $rowsni = mysql_fetch_array($resulthatistim);
                $u_email = $rowsni['email'];
                $u_bill_firstname = $rowsni['bill_firstname'];
                $u_bill_lastname = $rowsni['bill_lastname'];
                $i++;

                include('views/discount/data_usage_order_discounts.php');
            }
            $data_usage_order_discounts = ob_get_contents();
            ob_end_clean();

            $this->template->vars('data_usage_order_discounts', $data_usage_order_discounts);
        }
    }

    function edit_data()
    {
        $this->main->test_access_rights();
        $model = new Model_Discount();
        include('include/post_edit_discounts_data.php');

        setlocale(LC_TIME, 'UTC');
        date_default_timezone_set('UTC');
        if (strlen($date_end) > 0) {
            $date_end = strtotime($date_end);
        } else $date_end = 0;

        if (strlen($start_date) > 0) {
            $start_date = strtotime($start_date);
        } else $start_date = 0;

        if (($generate_code == '1') || (strlen($coupon_code) > 0)) {
            $allow_multiple = 1;
            $sel_fabrics = 1;
            $fabric_list = [];
        }

        if ($sel_fabrics == "2") {
            $iDscntType = '1';
        }
        if ($iDscntType == '2') {
            $allow_multiple = 1;
        }
        if ($iDscntType != '2')
            $shipping_type = '0';

        if ($users_check != '4') {
            $users_list = [];
        }

        if (!empty($discounts_id)) {
            if (
                ($iDscntType == '2' && $shipping_type == '0') ||
                ((strlen($coupon_code) > 0) && ($generate_code == "0") && $model->checkCouponCode($discounts_id, $coupon_code)) ||
                (!isset($users_list) && ($users_check == '4')) ||
                (!isset($fabric_list) && ($sel_fabrics == "2")) ||
                ($start_date == 0) || ($date_end == 0) ||
                ($iType == '0') ||
                (!isset($discount_amount) || $discount_amount == '' || $discount_amount == '0.00' || $iDscntType == '0') ||
                ($restrictions == '')
            ) {
                $error = [];

                if ($iDscntType == '2' && $shipping_type == '0') $error[] = "The shipping type is required.";
                if (($generate_code == "0") && (strlen($coupon_code) > 0) && $model->checkCouponCode($discounts_id, $coupon_code))
                    $error[] = "The coupon code is in use.";
                if (($restrictions == '')) $error[] = "Identify 'retrictions' field";
                if ($iType == '0') $error[] = "Identify 'promotion' field";
                if (!isset($discount_amount) || $discount_amount == '' || $discount_amount == '0.00' || $iDscntType == '0') $error[] = "Identify 'discount details' fields";
                if ($start_date == 0) $error[] = "Identify 'start date' field";
                if ($date_end == 0) $error[] = "Identify 'end date' field";
                if (!isset($users_list) && ($users_check == '4')) {
                    $error[] = "Set the option 'All selected users'. Select at least one user from the list , in this case!";
                }
                if (!isset($fabric_list) && ($sel_fabrics == '2')) {
                    $error[] = "Set the option 'All selected fabrics'. Select at least one fabric from the list , in this case!";
                }

                if (!isset($fabric_list)) $fabric_list = [];
                if (!isset($users_list)) $users_list = [];

                $this->template->vars('error', $error);

                $fabrics = $model->get_edit_form_checked_fabrics_by_array($fabric_list, $sel_fabrics);
                $users = $model->get_edit_form_checked_users_by_array($users_list, $users_check);

                $userInfo = array(
                    'discount_comment1' => !is_null(_A_::$app->post('discount_comment1')) ? _A_::$app->post('discount_comment1') : '',
                    'discount_comment2' => !is_null(_A_::$app->post('discount_comment2')) ? _A_::$app->post('discount_comment2') : '',
                    'discount_comment3' => !is_null(_A_::$app->post('discount_comment3')) ? _A_::$app->post('discount_comment3') : '',
                    'discount_amount' => !is_null(_A_::$app->post('discount_amount')) ? _A_::$app->post('discount_amount') : '',
                    'coupon_code' => $coupon_code,
                    'allow_multiple' => $allow_multiple,
                    'date_start' => !is_null(_A_::$app->post('start_date')) ? _A_::$app->post('start_date') : '',
                    'date_end' => !is_null(_A_::$app->post('date_end')) ? _A_::$app->post('date_end') : '',
                    'enabled' => !is_null(_A_::$app->post('enabled')) ? _A_::$app->post('enabled') : '',
                    'fabric_list' => $fabrics,
                    'users_list' => $users,
                    'countdown' => !is_null(_A_::$app->post('countdown')) ? _A_::$app->post('countdown') : '',
                    'sel_fabrics' => $sel_fabrics,
                    'users_check' => $users_check,
                    'required_amount' => !is_null(_A_::$app->post('restrictions')) ? _A_::$app->post('restrictions') : '0.00',
                    'promotion_type' => !is_null(_A_::$app->post('iType')) ? _A_::$app->post('iType') : '0',
                    'discount_type' => $iDscntType,
                    'required_type' => !is_null(_A_::$app->post('iReqType')) ? _A_::$app->post('iReqType') : '0',
                    'discount_amount_type' => !is_null(_A_::$app->post('iAmntType')) ? _A_::$app->post('iAmntType') : '0',
                    'shipping_type' => $shipping_type,
                    'generate_code' => $generate_code
                );

                $this->template->vars('userInfo', $userInfo);

                $this->main->view_admin('edit_discounts');

            } else {

                if ($generate_code == '1') {
                    $coupon_code = $model->generateCouponCode($discounts_id);
                    $allow_multiple = 1;
                    $sel_fabrics = 1;
                    $fabric_list = [];
                }

                $result = mysql_query("DELETE FROM fabrix_specials_users WHERE sid ='" . $discounts_id . "'");
                if ($users_check == "4") {
                    foreach ($users_list as $user_id) {
                        $result = mysql_query("INSERT INTO  `fabrix_specials_users` (`sid` ,`aid`)VALUES('" . $discounts_id . "',  '" . $user_id . "');");
                    }
                }
//                else {
//                    $results = mysql_query("select * from fabrix_accounts");
//                    while ($row = mysql_fetch_array($results)) {
//                        $result = mysql_query("INSERT INTO  `fabrix_specials_users` (`sid` ,`aid`)VALUES('" . $discounts_id . "',  '" . $row[0] . "');");
//                    }
//                }

                $result = mysql_query("DELETE FROM `fabrix_specials_products` WHERE `sid`='" . $discounts_id . "'");
                if ($sel_fabrics == "2") {
                    foreach ($fabric_list as $fabric_id) {
                        $result = mysql_query("INSERT INTO  `fabrix_specials_products` (`sid` ,`pid`)VALUES('" . $discounts_id . "',  '" . $fabric_id . "');");
                    }
                }
//                if ($sel_fabrics == "1") {
//                    $results = mysql_query("select * from fabrix_products");
//                    while ($row = mysql_fetch_array($results)) {
//                        $result = mysql_query("INSERT INTO  `fabrix_specials_products` (`sid` ,`pid`)VALUES('" . $discounts_id . "',  '" . $row[0] . "')");
//                    }
//                }
                $result = mysql_query("update fabrix_specials set coupon_code='$coupon_code',discount_amount='$discount_amount',discount_amount_type='$iAmntType',discount_type='$iDscntType',user_type='$users_check',shipping_type='$shipping_type',product_type='$sel_fabrics',promotion_type='$iType',required_amount='$restrictions',required_type='$iReqType',allow_multiple='$allow_multiple',enabled='$enabled',countdown='$countdown',discount_comment1='$discount_comment1',discount_comment2='$discount_comment2',discount_comment3='$discount_comment3',date_start='$start_date', date_end='$date_end' WHERE sid ='$discounts_id'");
                $error = [];
                if ($result) {


                    $warning = ["The data updated successfully!"];
                } else {
                    $error = [mysql_error()];
                }
                $this->template->vars('warning', $warning);
                $this->template->vars('error', $error);

                $this->edit();

            }
        }
    }

    function save_data()
    {
        $this->main->test_access_rights();
        $model = new Model_Discount();
        include('include/post_edit_discounts_data.php');

        setlocale(LC_TIME, 'UTC');
        date_default_timezone_set('UTC');
        if (strlen($date_end) > 0) {
            $date_end = strtotime($date_end);
        } else $date_end = 0;

        if (strlen($start_date) > 0) {
            $start_date = strtotime($start_date);
        } else $start_date = 0;

        if (($generate_code == '1') || (strlen($coupon_code) > 0)) {
            $allow_multiple = 1;
            $sel_fabrics = 1;
            $fabric_list = [];
        }

        if ($sel_fabrics == "2") {
            $iDscntType = '1';
        }
        if ($iDscntType == '2') {
            $allow_multiple = 1;
        }
        if ($iDscntType != '2')
            $shipping_type = '0';

        if ($users_check != '4') {
            $users_list = [];
        }

        if (
            ($iDscntType == '2' && $shipping_type == '0') ||
            (($generate_code == "0") && (strlen($coupon_code) > 0) && $model->checkCouponCode(0, $coupon_code)) ||
            (!isset($users_list) && ($users_check == '4')) ||
            (!isset($fabric_list) && ($sel_fabrics == "2")) ||
            ($start_date == 0) || ($date_end == 0) ||
            ($iType == '0') ||
            (!isset($discount_amount) || $discount_amount == '' || $discount_amount == '0.00' || $iDscntType == '0') ||
            ($restrictions == '')
        ) {
            $error = [];

            if ($iDscntType == '2' && $shipping_type == '0') $error[] = "The shipping type is required.";
            if (($generate_code == "0") && (strlen($coupon_code) > 0) && $model->checkCouponCode(0, $coupon_code))
                $error[] = "The coupon code is in use.";
            if (($restrictions == '')) $error[] = "Identify 'restrictions' field";
            if ($iType == '0') $error[] = "Identify 'promotion' field";
            if (!isset($discount_amount) || $discount_amount == '' || $discount_amount == '0.00' || $iDscntType == '0') $error[] = "Identify 'discount details' fields";
            if ($start_date == 0) $error[] = "Identify 'start date' field";
            if ($date_end == 0) $error[] = "Identify 'end date' field";
            if (!isset($users_list) && ($users_check == '4')) {
                $error[] = "Set the option 'All selected users'. Select at least one user from the list , in this case!";
            }
            if (!isset($fabric_list) && ($sel_fabrics == '2')) {
                $error[] = "Set the option 'All selected fabrics'. Select at least one fabric from the list , in this case!";
            }

            if (!isset($fabric_list)) $fabric_list = [];
            if (!isset($users_list)) $users_list = [];

            $this->template->vars('error', $error);

            $fabrics = $model->get_edit_form_checked_fabrics_by_array($fabric_list, $sel_fabrics);
            $users = $model->get_edit_form_checked_users_by_array($users_list, $users_check);

            $userInfo = array(
                'discount_comment1' => !is_null(_A_::$app->post('discount_comment1')) ? _A_::$app->post('discount_comment1') : '',
                'discount_comment2' => !is_null(_A_::$app->post('discount_comment2')) ? _A_::$app->post('discount_comment2') : '',
                'discount_comment3' => !is_null(_A_::$app->post('discount_comment3')) ? _A_::$app->post('discount_comment3') : '',
                'discount_amount' => !is_null(_A_::$app->post('discount_amount')) ? _A_::$app->post('discount_amount') : '',
                'coupon_code' => $coupon_code,
                'allow_multiple' => $allow_multiple,
                'date_start' => !is_null(_A_::$app->post('start_date')) ? _A_::$app->post('start_date') : '',
                'date_end' => !is_null(_A_::$app->post('date_end')) ? _A_::$app->post('date_end') : '',
                'enabled' => !is_null(_A_::$app->post('enabled')) ? _A_::$app->post('enabled') : '',
                'fabric_list' => $fabrics,
                'users_list' => $users,
                'countdown' => !is_null(_A_::$app->post('countdown')) ? _A_::$app->post('countdown') : '',
                'sel_fabrics' => $sel_fabrics,
                'users_check' => $users_check,
                'required_amount' => !is_null(_A_::$app->post('restrictions')) ? _A_::$app->post('restrictions') : '0.00',
                'promotion_type' => !is_null(_A_::$app->post('iType')) ? _A_::$app->post('iType') : '0',
                'discount_type' => $iDscntType,
                'required_type' => !is_null(_A_::$app->post('iReqType')) ? _A_::$app->post('iReqType') : '0',
                'discount_amount_type' => !is_null(_A_::$app->post('iAmntType')) ? _A_::$app->post('iAmntType') : '0',
                'shipping_type' => $shipping_type,
                'generate_code' => $generate_code
            );

            $this->template->vars('userInfo', $userInfo);

            $this->main->view_admin('add');

        } else {

            if ($generate_code == '1') {
                $coupon_code = $model->generateCouponCode(0);
                $allow_multiple = 1;
                $sel_fabrics = 1;
                $fabric_list = [];
            }

            $timestamp = time();
            $result = mysql_query("INSERT INTO fabrix_specials set coupon_code='$coupon_code',discount_amount='$discount_amount',discount_amount_type='$iAmntType',discount_type='$iDscntType',user_type='$users_check', shipping_type='$shipping_type', product_type='$sel_fabrics',promotion_type='$iType',required_amount='$restrictions',required_type='$iReqType',allow_multiple='$allow_multiple',enabled='$enabled',countdown='$countdown',discount_comment1='$discount_comment1',discount_comment2='$discount_comment2',discount_comment3='$discount_comment3',date_start='$start_date', date_end='$date_end', date_added = '$timestamp'");
            $error = [];
            if ($result) {
                $discounts_id = mysql_insert_id();

                $result = mysql_query("DELETE FROM fabrix_specials_users WHERE sid ='" . $discounts_id . "'");
                if ($users_check == "4") {
                    foreach ($users_list as $user_id) {
                        $result = mysql_query("INSERT INTO  `fabrix_specials_users` (`sid` ,`aid`)VALUES('" . $discounts_id . "',  '" . $user_id . "');");
                    }
                }
//                else {
//                    $results = mysql_query("select * from fabrix_accounts");
//                    while ($row = mysql_fetch_array($results)) {
//                        $result = mysql_query("INSERT INTO  `fabrix_specials_users` (`sid` ,`aid`)VALUES('" . $discounts_id . "',  '" . $row[0] . "');");
//                    }
//                }

                $result = mysql_query("DELETE FROM `fabrix_specials_products` WHERE `sid`='" . $discounts_id . "'");
                if ($sel_fabrics == "2") {
                    foreach ($fabric_list as $fabric_id) {
                        $result = mysql_query("INSERT INTO  `fabrix_specials_products` (`sid` ,`pid`)VALUES('" . $discounts_id . "',  '" . $fabric_id . "');");
                    }
                }
//                if ($sel_fabrics == "1") {
//                    $results = mysql_query("select * from fabrix_products");
//                    while ($row = mysql_fetch_array($results)) {
//                        $result = mysql_query("INSERT INTO  `fabrix_specials_products` (`sid` ,`pid`)VALUES('" . $discounts_id . "',  '" . $row[0] . "')");
//                    }
//                }

                $warning = ["The data saved successfully!"];

            } else {
                $error = [mysql_error()];
            }
            $this->template->vars('warning', $warning);
            $this->template->vars('error', $error);

            $this->add();
        }
    }


}