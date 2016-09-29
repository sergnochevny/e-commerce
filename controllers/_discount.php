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
        $this->data_usage(_A_::$app->get('d_id'));
        $this->data_usage_order();
        $this->main->view_admin('usage');
    }

    private function data_usage($discount_id = null)
    {
        if (!empty($discount_id)) {
            ob_start();
            $row = Model_Discount::getFabrixSpecialsByID((integer)$discount_id);
            $allow_multiple = $row['allow_multiple'];
            $date_start = $row['date_start'];
            $date_end = $row['date_end'];
            $enabled = $row['enabled'];
            $sid = $row['sid'];
            $enabled = $enabled == "1" ? "YES" : "NO";
            $opt = ['oid' => $sid];
            $view_url = _A_::$app->router()->UrlTo('orders/info', $opt);
            $this->template->vars('row', $row);
            $this->template->vars('coupon_code', $row['coupon_code']);
            $this->template->vars('discount_comment1', $row['discount_comment1']);
            $this->template->vars('p_discount_amount', $row['discount_amount']);
            $this->template->vars('allow_multiple', $allow_multiple == "1" ? "YES" : "NO");
            $this->template->vars('date_start', gmdate("F j, Y, g:i a", $date_start));
            $this->template->vars('date_end', gmdate("F j, Y, g:i a", $date_end));
            $this->template->vars('sid', $row['sid']);
            $this->template->vars('view_url', $view_url);
            $this->template->view_layout('row_list');
            $data_usage_discounts = ob_get_contents();
            ob_end_clean();
            $this->main->template->vars('data_usage_discounts', $data_usage_discounts);
        }
    }

    private function data_usage_order()
    {
        $this->main->test_access_rights();
        $discount_id = _A_::$app->get('d_id');
        if (!empty($discount_id)) {
            $rows = Model_Discount::getFabrixSpecialsUsageById((integer)Model_Discount::validData(_A_::$app->get('discount_id')));
            ob_start();
            foreach ($rows as $key => $row) {
                $orders = Model_Discount::getFabrixOrdersById((integer) $row);
                $order_aid = $orders['aid'];
                $order_date = gmdate("M j, Y, g:i a", $orders['order_date']);
                $account = Model_Discount::getFabrixAccountByOrderId($order_aid);
                $u_email = $account['email'];
                $u_bill_firstname = $account['bill_firstname'];
                $u_bill_lastname = $account['bill_lastname'];

                $this->template->vars('i', $key + 1);
                $this->template->vars('order_date', $order_date);
                $this->template->vars('u_bill_firstname', $u_bill_firstname);
                $this->template->vars('u_email', $u_email);
                $this->template->vars('row', $row);
                $this->template->view_layout('data_usage');
            }
            $data_usage_order_discounts = ob_get_contents();
            ob_end_clean();

            $this->main->template->vars('data_usage_order_discounts', $data_usage_order_discounts);
        }
    }

    private function save_data()
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
        if ($users_check != '4') $users = [];

        if (
            ($iDscntType == '2' && $shipping_type == '0') ||
            (($generate_code == "0") && (strlen($coupon_code) > 0) && Model_Discount::checkCouponCode($discount_id, $coupon_code)) ||
            (!isset($users) && ($users_check == '4')) ||
            (!isset($filter_products) && ($sel_fabrics !== "1")) ||
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
            if (!isset($users) && ($users_check == '4')) {
                $error[] = "Set the option 'All selected users'. Select at least one user from the list , in this case!";
            }
            if (!isset($filter_products) && ($sel_fabrics == '2')) {
                $error[] = "Set the option 'All selected fabrics'. Select at least one fabric from the list , in this case!";
            }
            if (!isset($filter_products) && ($sel_fabrics == '3')) {
                $error[] = "Set the option 'All selected categories'. Select at least one category from the list, in this case!";
            }
            if (!isset($filter_products) && ($sel_fabrics == '4')) {
                $error[] = "Set the option 'All selected manufacturers'. Select at least one manufacture from the list , in this case!";
            }

            $this->template->vars('error', $error);

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
                'users' => $users,
                'filter_products' => $filter_products,
                'countdown' => !is_null(_A_::$app->post('countdown')) ? _A_::$app->post('countdown') : '',
                'sel_fabrics' => $sel_fabrics,
                'users_check' => $users_check,
                'required_amount' => !is_null(_A_::$app->post('restrictions')) ? _A_::$app->post('restrictions') : '',
                'promotion_type' => !is_null(_A_::$app->post('iType')) ? _A_::$app->post('iType') : '0',
                'discount_type' => $iDscntType,
                'required_type' => !is_null(_A_::$app->post('iReqType')) ? _A_::$app->post('iReqType') : '0',
                'discount_amount_type' => !is_null(_A_::$app->post('iAmntType')) ? _A_::$app->post('iAmntType') : '0',
                'shipping_type' => $shipping_type,
                'generate_code' => $generate_code
            );

        } else {

            if ($generate_code == '1') {
                $coupon_code = Model_Discount::generateCouponCode($discount_id);
                $allow_multiple = 1;
                $sel_fabrics = 1;
                $filter_products = [];
            }

            $data =  array(
                'discount_comment1' => !is_null(_A_::$app->post('discount_comment1')) ? _A_::$app->post('discount_comment1') : '',
                'discount_comment2' => !is_null(_A_::$app->post('discount_comment2')) ? _A_::$app->post('discount_comment2') : '',
                'discount_comment3' => !is_null(_A_::$app->post('discount_comment3')) ? _A_::$app->post('discount_comment3') : '',
                'discount_amount' => !is_null(_A_::$app->post('discount_amount')) ? _A_::$app->post('discount_amount') : '',
                'coupon_code' => $coupon_code,
                'allow_multiple' => $allow_multiple,
                'date_start' => !is_null(_A_::$app->post('start_date')) ? _A_::$app->post('start_date') : '',
                'date_end' => !is_null(_A_::$app->post('date_end')) ? _A_::$app->post('date_end') : '',
                'enabled' => !is_null(_A_::$app->post('enabled')) ? _A_::$app->post('enabled') : '',
                'users' => $users,
                'filter_products' => $filter_products,
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

            try {
                $discount_id = Model_Discount::saveFabrixSpecial($discount_id, $coupon_code, $discount_amount, $iAmntType, $iDscntType, $users_check, $shipping_type, $sel_fabrics, $iType, $restrictions, $iReqType, $allow_multiple, $enabled, $countdown, $discount_comment1, $discount_comment2, $discount_comment3, $start_date, $date_end);
                Model_Discount::saveFabrixSpecialsUser($discount_id, $users_check, $users);
                Model_Discount::deleteFabrixSpecialsProductById($discount_id);
                $filter_types = [1 => null, 2 => 1, 3 => 2, 4 => 3];
                Model_Discount::saveFabrixSpecialsProducts($discount_id, $filter_products, $filter_types[$sel_fabrics]);
                $warning = ["The data saved successfully!"];
                $data = null;
            } catch (Exception $e) {
                $error = [$e->getMessage()];
            }
            $this->template->vars('warning', $warning);
            $this->template->vars('error', $error);
        }
        return $data;
    }

    private function form($url, $data = null)
    {
        $prms = null;
        $id = Model_Discount::validData(_A_::$app->get('d_id'));
        if (!isset($data)){
            $data = Model_Discount::get_discounts_data($id);
        }
        else {
            $filter_types = [1 => null, 2 => 'prod', 3 => 'mnf', 4 => 'cat'];
            $data['filter_type'] = $filter_types[$data['sel_fabrics']];
            Model_Discount::get_filter_selected($data['filter_type'], $data, $id);
            Model_Discount::get_filter_selected('users', $data, $id);
        }
        if (!empty($id) && isset($id)) {
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
        $this->template->vars('filters', $filter_products);
        $this->template->vars('filter_type', $data['filter_type']);
        $this->template->vars('destination', 'filter_products');
        $this->template->vars('title', $title);
        $this->template->view_layout('filter');
    }

    private function generate_users_filter($data)
    {
        $users = $data['users'];
        $this->template->vars('filters', $users);
        $this->template->vars('filter_type', 'users');
        $this->template->vars('filter_data_start', 0);
        $this->template->vars('destination', 'users');
        $this->template->vars('title', 'Select Users');
        $this->template->view_layout('filter');
    }

    private function filters_handling(){
        include('include/post_edit_discounts_data.php');
        $method = _A_::$app->post('method');
        if ($method !== 'filter') {
            $this->select_filter($method, $users, $filter_products);
        } else {
            if (!is_null(_A_::$app->post('filter-type'))) {
                $method = _A_::$app->post('filter-type');
                $resporse = [];

                ob_start();
                $data = $this->selected_filter_data($users, $filter_products, $sel_fabrics, $users_check, $discount_id);
                $this->selected_filter($data);
                $resporse[0] = ob_get_contents();
                ob_end_clean();

                ob_start();
                $filter_products = $data['filter_products'];
                $users = $data['users'];
                $search = _A_::$app->post('filter_select_search_' . $method);
                $start = _A_::$app->post('filter_start_' . $method);
                if (!is_null(_A_::$app->post('down'))) $start = FILTER_LIMIT + (isset($start) ? $start : 0);
                if (!is_null(_A_::$app->post('up'))) $start = (isset($start) ? $start : 0) - FILTER_LIMIT;
                if (($start < 0) || (is_null(_A_::$app->post('down')) && is_null(_A_::$app->post('up')))) $start = 0;
                $this->select_filter($method, array_keys($users), array_keys($filter_products), $start, $search);
                $resporse[1] = ob_get_contents();
                ob_end_clean();
                exit(json_encode($resporse));
            } else {
                $data = $this->selected_filter_data($users, $filter_products, $sel_fabrics, $users_check, $discount_id);
                $this->selected_filter($data);
            }
        }
    }

    private function edit_add_handling($template, $url){
        $this->main->test_access_rights();
        if (_A_::$app->request_is_post()) {
            if (!is_null(_A_::$app->post('method'))) {
                $this->filters_handling();
            } else {
                $data = $this->save_data();
                $this->form($url, $data);
            }
            exit;
        }
        ob_start();
        $this->form($url);
        $form = ob_get_contents();
        ob_end_clean();
        $this->template->vars('form', $form);
        $this->main->view_admin($template);
    }

    public function edit()
    {
        $this->edit_add_handling('edit','discount/edit');
    }

    public function add()
    {
        $this->edit_add_handling('add','discount/add');
    }


    /**
     * @param $users
     * @param $filter_products
     */
    private function select_filter($method, $users, $filter_products, $start = null, $search = null)
    {
        switch ($method) {
            case 'users':
                $selected = isset($users) ? array_values($users) : [];
                break;
            case 'prod':
            case 'mnf':
            case 'cat':
                $selected = isset($filter_products) ? array_values($filter_products) : [];
                break;
        }
        $filter = Model_Discount::get_filter_data($method, $count, $start, $search);
        $this->template->vars('destination', _A_::$app->post('type'));
        $this->template->vars('total', $count);
        $this->template->vars('search', $search);
        $this->template->vars('type', $method . '_select');
        $this->template->vars('filter_type', $method);
        $this->template->vars('filter_data_start', isset($start) ? $start : 0);
        $this->template->vars('selected', $selected);
        $this->template->vars('filter', $filter);
        $this->template->view_layout('select_filter');
    }

    /**
     * @param $users
     * @param $sel_fabrics
     * @param $users_check
     * @param $id
     * @return array
     */
    private function selected_filter_data($users, $filter_products, $sel_fabrics, $users_check, $id)
    {
        $data = array(
            'users' => $users,
            'sel_fabrics' => $sel_fabrics,
            'users_check' => $users_check,
            'filter_products' => $filter_products,
            'users_select' => _A_::$app->post('users_select'),
            'prod_select' => _A_::$app->post('prod_select'),
            'mnf_select' => _A_::$app->post('mnf_select'),
            'cat_select' => _A_::$app->post('cat_select'),
        );

        Model_Discount::get_filter_selected(_A_::$app->post('type'), $data, $id);
        return $data;
    }

    /**
     * @param $users
     * @param $sel_fabrics
     * @param $users_check
     * @param $method
     * @param $id
     */
    private function selected_filter($data)
    {
        if (_A_::$app->post('type') === 'users') {
            $this->generate_users_filter($data);
        } else {
            $this->generate_prod_filter($data);
        }
    }

}