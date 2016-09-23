<?php

class Controller_Discount extends Controller_Controller
{

    public function discount()
    {
        $this->main->test_access_rights();
        $this->get_list();
        $this->main->view_admin('discounts');
    }

    private function get_list()
    {
        $results = Model_Discount::getFabrixSpecialsIds();
        if (!is_null($results)) {
            ob_start();
            foreach ($results as $key => $row) {
                $this->template->vars('row', $row);
                $this->template->view_layout('row_list');
            }
            $list = ob_get_contents();
            ob_end_clean();
        }
        $this->template->vars('list', $list);
        ob_start();
        $this->template->view_layout('list');
        $list = ob_get_contents();
        ob_end_clean();
        $this->template->vars('list', $list);
    }

    public function del()
    {
        $this->main->test_access_rights();
        $id = Model_Discount::validData(_A_::$app->get('id'));
        if (!empty($id)) {
            Model_Discount::del_discount($id);
        }
        $this->get_list();
    }

    public function usage()
    {
        $this->main->test_access_rights();
        $this->data_usage();
        $this->data_usage_order();
        $this->main->view_admin('usage');
    }

    private function data_usage()
    {
        if (!empty($discount_id)) {
            ob_start();
            $row = Model_Discount::getFabrixSpecialsByID((integer)Model_Discount::validData(_A_::$app->get('id')));
            $allow_multiple = $row['allow_multiple'];
            $date_start = $row['date_start'];
            $date_end = $row['date_end'];
            $enabled = $row['enabled'];
            $sid = $row['sid'];
            $enabled = $enabled == "1" ? "YES" : "NO";

            $this->template->vars('coupon_code', $row['coupon_code']);
            $this->template->vars('discount_comment1', $row['discount_comment1']);
            $this->template->vars('p_discount_amount', $row['discount_amount']);
            $this->template->vars('allow_multiple', $allow_multiple == "1" ? "YES" : "NO");
            $this->template->vars('date_start', gmdate("F j, Y, g:i a", $date_start));
            $this->template->vars('date_end', gmdate("F j, Y, g:i a", $date_end));
            $this->template->view_layouts('get_list');
            $data_usage_discounts = ob_get_contents();
            ob_end_clean();
            $this->main->template->vars('data_usage_discounts', $data_usage_discounts);
        }
    }

    private function data_usage_order()
    {
        $this->main->test_access_rights();
        if (!empty($discount_id)) {
            $rows = Model_Discount::getFabrixSpecialsUsageById((integer)Model_Discount::validData(_A_::$app->get('discount_id')));
            ob_start();
            foreach ($rows as $key => $row) {
                $orders = Model_Discount::getFabrixOrdersById($row[2]);
                $order_aid = $orders['aid'];
                $order_date = gmdate("F j, Y, g:i a", $orders['order_date']);
                $account = Model_Discount::getFabrixAccountByOrderId($order_aid);
                $u_email = $account['email'];
                $u_bill_firstname = $account['bill_firstname'];
                $u_bill_lastname = $account['bill_lastname'];

                $this->template->vars('i', $key + 1);
                $this->template->vars('order_date', $order_date);
                $this->template->vars('u_bill_firstname', $u_bill_firstname);
                $this->template->vars('u_email', $u_email);
                $this->template->vars('row', $row);
                $this->template->view_layouts('data_usage_discounts');
            }
            $data_usage_order_discounts = ob_get_contents();
            ob_end_clean();

            $this->main->template->vars('data_usage_order_discounts', $data_usage_order_discounts);
        }
    }

    public function add()
    {
        $this->main->test_access_rights();
        if (_A_::$app->request_is_post()) {
            $this->save_data('discount/add');
        }
        ob_start();
        $this->form('discount/add');
        $form = ob_get_contents();
        ob_end_clean();
        $this->template->vars('form', $form);
        $this->main->view_admin('add');
    }

    private function save_data($url)
    {
        include('include/post_edit_discounts_data.php');

        $date_end = strlen($date_end) > 0 ? strtotime($date_end) : 0;
        $start_date = strlen($start_date) > 0 ? strtotime($start_date) : 0;

        if (($generate_code == '1') || (strlen($coupon_code) > 0)) {
            $allow_multiple = 1;
            $sel_fabrics = 1;
            $fabric_list = [];
        }

        if ($sel_fabrics == "2") $iDscntType = '1';
        if ($iDscntType == '2') $allow_multiple = 1;
        else $shipping_type = '0';
        if ($users_check != '4') $users_list = [];

        if (
            ($iDscntType == '2' && $shipping_type == '0') ||
            (($generate_code == "0") && (strlen($coupon_code) > 0) && Model_Discount::checkCouponCode($discount_id, $coupon_code)) ||
            (!isset($users_list) && ($users_check == '4')) ||
            (!isset($fabric_list) && ($sel_fabrics == "2")) ||
            ($start_date == 0) || ($date_end == 0) ||
            ($iType == '0') ||
            (!isset($discount_amount) || $discount_amount == '' || $discount_amount == '0.00' || $iDscntType == '0') ||
            ($restrictions == '')
        ) {
            $error = [];

            if ($iDscntType == '2' && $shipping_type == '0') $error[] = "The shipping type is required.";
            if (($generate_code == "0") && (strlen($coupon_code) > 0) && Model_Discount::checkCouponCode(0, $coupon_code))
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

            $fabrics = Model_Discount::get_edit_form_checked_fabrics_by_array($fabric_list, $sel_fabrics);
            $users = Model_Discount::get_edit_form_checked_users_by_array($users_list, $users_check);

            $data = array(
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
            $this->form($url, $data);

        } else {

            if ($generate_code == '1') {
                $coupon_code = Model_Discount::generateCouponCode($discount_id);
                $allow_multiple = 1;
                $sel_fabrics = 1;
                $fabric_list = [];
            }

            $timestamp = time();
            $result = Model_Discount::saveFabrixSpecial($coupon_code, $discount_amount, $iAmntType, $iDscntType, $users_check, $shipping_type, $sel_fabrics, $iType, $restrictions, $iReqType, $allow_multiple, $enabled, $countdown, $discount_comment1, $discount_comment2, $discount_comment3, $start_date, $date_end);
            $error = [];
            if ($result) {
                $discount_id = mysql_insert_id();

                $result = Model_Discount::deleteFabrixSpecialsUserById($discount_id);
                if ($users_check == "4") {
                    foreach ($users_list as $user_id) {
                        Model_Discount::saveFabrixSpecialsUser($discount_id, $user_id);
                    }
                }

                $result = Model_Discount::deleteFabrixSpecialsProductById($discount_id);
                if ($sel_fabrics == "2") {
                    foreach ($fabric_list as $fabric_id) {
                        $result = Model_Discount::saveFabrixSpecialsProducts($discount_id, $fabric_id);
                    }
                }

                $warning = ["The data saved successfully!"];

            } else {
                $error = [mysql_error()];
            }
            $this->template->vars('warning', $warning);
            $this->template->vars('error', $error);
        }
    }

    private function form($url, $data = null)
    {
        $prms = null;
        if (!isset($data)) {
            $id = Model_Discount::validData(_A_::$app->get('d_id'));
            $data = Model_Discount::get_discounts_data($id);
            $prms['d_id'] = $id;
        }
        ob_start();
        $this->generate_prod_filter($data);
        $data['filter_products'] = ob_get_contents();
        ob_end_clean();
        ob_start();
        $this->generate_users_filter($data);
        $data['users'] = ob_get_contents();
        ob_end_clean();
        $this->template->vars('action', _A_::$app->router()->UrlTo($url, $prms));
        $this->template->vars('data', $data);
        $this->main->view_layout('form');
    }

    private function generate_prod_filter($data)
    {
        $filter_products = $data['filter_products'];
        $sel_fabrics = $data['sel_fabrics'];
        $title = "Select Products";
        if ($sel_fabrics == 3) $title = "Select Categories";
        if ($sel_fabrics == 4) $title = "Select Manufacturers";
        $this->template->vars('filter_products', $filter_products);
        $this->template->vars('filter_type', $data['filter_type']);
        $this->template->vars('destination', 'filter_products');
        $this->template->vars('title', $title);
        $this->template->view_layout('filter');
    }

    private function generate_users_filter($data)
    {
        $users = $data['users'];
        $this->template->vars('filter_products', $users);
        $this->template->vars('filter_type', 'users');
        $this->template->vars('destination', 'users');
        $this->template->vars('title', 'Select Users');
        $this->template->view_layout('filter');
    }

    private function edit_data()
    {
        include('include/post_edit_discounts_data.php');

        $date_end = strlen($date_end) > 0 ? strtotime($date_end) : $date_end = 0;
        $start_date = strlen($start_date) > 0 ? strtotime($start_date) : $start_date = 0;

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

        if (!empty($discount_id)) {
            if (
                ($iDscntType == '2' && $shipping_type == '0') ||
                ((strlen($coupon_code) > 0) && ($generate_code == "0") && Model_Discount::checkCouponCode($discount_id, $coupon_code)) ||
                (!isset($users_list) && ($users_check == '4')) ||
                (!isset($fabric_list) && ($sel_fabrics == "2")) ||
                ($start_date == 0) || ($date_end == 0) ||
                ($iType == '0') ||
                (!isset($discount_amount) || $discount_amount == '' || $discount_amount == '0.00' || $iDscntType == '0') ||
                ($restrictions == '')
            ) {
                $error = [];

                if ($iDscntType == '2' && $shipping_type == '0') $error[] = "The shipping type is required.";
                if (($generate_code == "0") && (strlen($coupon_code) > 0) && Model_Discount::checkCouponCode($discount_id, $coupon_code))
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

                $fabrics = Model_Discount::get_edit_form_checked_fabrics_by_array($fabric_list, $sel_fabrics);
                $users = Model_Discount::get_edit_form_checked_users_by_array($users_list, $users_check);

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
                    $coupon_code = Model_Discount::generateCouponCode($discount_id);
                    $allow_multiple = 1;
                    $sel_fabrics = 1;
                    $fabric_list = [];
                }

                Model_Discount::deleteFabrixSpecialsUserById($discount_id);
                if ($users_check == "4") {
                    foreach ($users_list as $user_id) {
                        Model_Discount::saveFabrixSpecialsUser($discount_id, $user_id);
                    }
                }

                Model_Discount::deleteFabrixSpecialsProductById($discount_id);
                if ($sel_fabrics == "2") {
                    foreach ($fabric_list as $fabric_id) {
                        Model_Discount::saveFabrixSpecialsUser($discount_id, $fabric_id);
                    }
                }

                $result = Model_Discount::updateFabrixSpecials($coupon_code, $discount_amount, $iAmntType, $iDscntType, $users_check, $shipping_type, $sel_fabrics, $iType, $restrictions, $iReqType, $allow_multiple, $enabled, $countdown, $discount_comment1, $discount_comment2, $discount_comment3, $start_date, $date_end, $discount_id);
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

    public function edit()
    {
        $this->main->test_access_rights();
        if (_A_::$app->request_is_post()) {
            if (!is_null(_A_::$app->post('method'))) {
                include('include/post_edit_discounts_data.php');
                if (_A_::$app->post('method') !== 'filter') {
                    switch (_A_::$app->post('method')) {
                        case 'users':
                            $selected = isset($users)?array_values($users):[];

                            break;
                        case 'prod':
                        case 'mnf':
                        case 'cat':
                            $selected = isset($filter_products)?array_values($filter_products):[];
                            break;
                    }
                    $this->template->vars('type', _A_::$app->post('method') . '_select');
                    $this->template->vars('selected', $selected);
                    $filter = Model_Discount::get_filter_data(_A_::$app->post('method'));
                    $this->template->vars('filter', $filter);
                    $this->template->view_layout('select_filter');
                } else {
                    $data = array(
                        'users' => $users,
                        'sel_fabrics' => $sel_fabrics,
                        'users_check' => $users_check,
                        'prod_select' => !is_null(_A_::$app->post('prod_select')) ? _A_::$app->post('prod_select') : null,
                        'mnf_select' => !is_null(_A_::$app->post('mnf_select')) ? _A_::$app->post('mnf_select') : null,
                        'cat_select' => !is_null(_A_::$app->post('cat_select')) ? _A_::$app->post('cat_select') : null,
                    );
                    Model_Discount::get_filter_selected(_A_::$app->post('type'), $data);

                    if (_A_::$app->post('type') === 'users') {
                        $this->generate_users_filter($data);
                    } else {
                        $this->generate_prod_filter($data);
                    }
                }
                exit;
            } else {
                $this->save_data('discount/edit');
            }
        }
        ob_start();
        $this->form('discount/edit');
        $form = ob_get_contents();
        ob_end_clean();
        $this->template->vars('form', $form);
        $this->main->view_admin('edit');
    }

}