<?php

class Controller_Order extends Controller_Base
{

    protected $main;

    function __construct($main)
    {

        $this->main = $main;
        $this->registry = $main->registry;
        $this->template = $main->template;

    }

    function orders()
    {
        $this->main->test_access_rights();

//        if(isset($_SESSION['last_url'])) {
//            $back_url = $_SESSION['last_url'];
//        } else {
        $back_url = BASE_URL . '/users?page=';
        if (!empty(_A_::$app->get('page'))) {
            $back_url .= _A_::$app->get('page');
        } else
            $back_url .= '1';
//        }

        $this->get_orders();
        $this->template->vars('back_url', $back_url);

        $this->main->view_admin('order/orders');
    }

    function get_orders()
    {
        $this->main->test_access_rights();
        $model = new Model_Order();
        $userInfo = $model->validData(_A_::$app->get('user_id'));
        $user_id = $userInfo['data'];
        $orders_count = $model->get_count_orders_by_user($user_id);
        if (!empty(_A_::$app->get('page'))) {
            $page = _A_::$app->get('page');
        } else
            $page = '1';

        if (!empty($orders_count) && ((int)$orders_count > 0)) {

            $rows = $model->get_orders_by_user($user_id);
            ob_start();
            foreach ($rows as $row) {
                $row[22] = gmdate("F j, Y, g:i a", $row[22]);
                include('./views/order/orders_list.php');
            }
            $orders_list = ob_get_contents();
            ob_end_clean();
            ob_start();
            include('./views/order/orders_detail.php');
            $orders = ob_get_contents();
            ob_end_clean();
        } else {
            ob_start();
            include('./views/order/no_orders_found.php');
            $orders = ob_get_contents();
            ob_end_clean();
        }
        $this->template->vars('orders', $orders);
    }

    function order()
    {
        $this->main->test_access_rights();
        $model = new Model_Order();
        $userInfo = $model->validData(_A_::$app->get('order_id'));
        $order_id = $userInfo['data'];

//        if(isset($_SESSION['last_url'])) {
//            $back_url = $_SESSION['last_url'];
//        } else {
        $back_url = BASE_URL . '/orders';
        if (!is_null(_A_::$app->get('order_id'))) {
            $back_url .= '?order_id=' . _A_::$app->get('order_id');
        }

        if (!is_null(_A_::$app->get('user_id'))) {
            if (is_null(_A_::$app->get('order_id'))) {
                $back_url .= '?';
            } else $back_url .= '&';
            $back_url .= 'user_id=' . _A_::$app->get('user_id');
        }

        if (!is_null(_A_::$app->get('page'))) {
            if (empty(_A_::$app->get('order_id')) && empty(_A_::$app->get('user_id'))) {
                $back_url .= '?';
            } else $back_url .= '&';
            $back_url .= 'page=' . _A_::$app->get('page');
        }
//        }
        $this->get_order_details();
        $userInfo = $model->get_order($order_id);

        $this->template->vars('back_url', $back_url);
        $this->template->vars('userInfo', $userInfo);
        $this->main->view_admin('order/order');
    }

    function discount_order()
    {
        $this->main->test_access_rights();
        $model = new Model_Order();
        $userInfo = $model->validData(_A_::$app->get('order_id'));
        $order_id = $userInfo['data'];

//        if(isset($_SESSION['last_url'])) {
//            $back_url = $_SESSION['last_url'];
//        } else {
        $back_url = BASE_URL . (empty(_A_::$app->get('discounts_id'){0}) ? '/discounts' : '/usage_discounts');

        if (!empty(_A_::$app->get('discounts_id'){0})) {
            $back_url .= '?discounts_id=' . _A_::$app->get('discounts_id');
        }
//        }
        $this->get_order_details();
        $userInfo = $model->get_order($order_id);

        $this->template->vars('back_url', $back_url);
        $this->template->vars('userInfo', $userInfo);
        $this->main->view_admin('order/order');
    }

    function get_order_details()
    {
        $this->main->test_access_rights();
        $model = new Model_Order();
        $userInfo = $model->validData(_A_::$app->get('order_id'));
        $order_id = $userInfo['data'];
        $order_details = '';
        if (!empty($order_id)) {
            ob_start();
            $rows = $model->get_order_details($order_id);
            foreach ($rows as $row) {
                include('./views/order/order_details.php');
            }
            $order_details = ob_get_contents();
            ob_end_clean();
        }
        $this->template->vars('order_details', $order_details);
    }

    public function customer_orders_history()
    {
        $user_id = (integer) _A_::$app->session('user')['aid'];
        $page = (integer)(empty(_A_::$app->get('page')) ? 0 : _A_::$app->get('page'));
        $this->template->vars('page', $page);

        $per_page = 12;
        $total_pages = (integer)Model_Order::getOrderLength((integer)$user_id);

        if ($page > ceil($total_pages / $per_page)) $page = ceil($total_pages / $per_page);
        if ($page <= 0) $page = 1;
        $start = (($page - 1) * $per_page);

        $config = (array)[
            'aid' => $user_id,
            'from' => $start,
            'to' => $per_page,
        ];

        $orders = Model_Order::getUserOrdersList($config);

        if (count($orders) > 0) {
            ob_start();
            foreach ($orders as $order) {
                extract($order);

                $shipping_cost = strlen(trim($shipping_cost)) > 0 ? '$' . number_format($shipping_cost, 2) : '';
                $shipping_discount = strlen(trim($shipping_discount)) > 0 ? '$' . number_format($shipping_discount, 2) : '';
                $coupon_discount = strlen(trim($coupon_discount)) > 0 ? '$' . number_format($coupon_discount, 2) : '';
                $total = strlen(trim($total)) > 0 ? '$' . number_format($total, 2) : '';
                $handling = strlen(trim($handling)) > 0 ? '$' . number_format($handling, 2) : '';
                $status = ($status == 0 ? '<i title="In process" class="fa fa-clock-o"></i>' : '<i title="Done" class="fa fa-check"></i>');
                $order_date = date('F j, Y, g:i a', $order_date);
                $action = BASE_URL . '/customer_order_info?oid=' . urlencode(base64_encode($oid)) . '&=page' . $page;
                $end_date = $end_date ? date('F m, Y', strtotime($end_date)) : '';
                include('views/order/customer_orders_list.php');

            }
            $customer_orders_list = ob_get_contents();
            ob_end_clean();

            if (isset($customer_orders_list) && !empty($customer_orders_list)) {
                $this->template->vars('customer_orders_list', $customer_orders_list);
            }

            $paginator = new Controller_Paginator($this->main);
            $paginator->orders_paginator($total_pages, $page);
        } else {
            $mess = 'You have no orders yet.';
            $this->template->vars('no_orders', $mess);

        }


        $this->template->vars('page', $page);


        $this->main->view('order/customer_orders_history');
    }

    public function orders_history()
    {
        $this->main->test_access_rights();

        if (is_null(_A_::$app->get('orders_search_query'))) {
            $like = htmlspecialchars(trim(_A_::$app->get('orders_search_query')));
            $page = (integer)(empty(_A_::$app->get('page')) ? 0 : _A_::$app->get('page'));
            $this->template->vars('page', $page);

            $per_page = 12;
            $total_pages = (integer)Model_Order::getOrdersListLengthByQuery($like);

            if ($page > ceil($total_pages / $per_page)) $page = ceil($total_pages / $per_page);
            if ($page <= 0) $page = 1;
            $start = (($page - 1) * $per_page);

            $config = [
                'like' => $like,
                'from' => $start,
                'to' => $per_page
            ];
            $orders = Model_Order::getOrdersListByQuery($config);
            if (count($orders) > 0) {
                ob_start();
                foreach ($orders as $order) {
                    extract($order);


                    $total_price = strlen(trim($total_price)) > 0 ? '$' . number_format($total_price, 2) : '';
                    $handling = strlen(trim($handling)) > 0 ? '$' . number_format($handling, 2) : '';
                    $end_date = $end_date ? date('F m, Y', strtotime($end_date)) : '';
                    $action = BASE_URL . '/order_info?oid=' . urlencode(base64_encode($oid)) . '&page=' . $page . '&orders_search_query=' . _A_::$app->get('orders_search_query');
                    include('views/order/admin_orders_list.php');

                }
                $admin_orders_list = ob_get_contents();
                ob_end_clean();
            }

            $this->template->vars('admin_orders_list', $admin_orders_list);


        } else {
            $page = (integer)(empty(_A_::$app->get('page')) ? 0 : _A_::$app->get('page'));
            $this->template->vars('page', $page);

            $per_page = 12;
            $total_pages = (integer) Model_Order::getOrdersHistoryLength();

            if ($page > ceil($total_pages / $per_page)) $page = ceil($total_pages / $per_page);
            if ($page <= 0) $page = 1;
            $start = (($page - 1) * $per_page);

            $config = [
                'from' => $start,
                'to' => $per_page
            ];


            $orders = Model_Order::getOrdersList($config);

            if (count($orders) > 0) {
                ob_start();
                foreach ($orders as $order) {
                    extract($order);


                    $total_price = strlen(trim($total_price)) > 0 ? '$' . number_format($total_price, 2) : '';
                    $handling = strlen(trim($handling)) > 0 ? '$' . number_format($handling, 2) : '';
                    $date = date('F j, Y, g:i a', $date);
                    $end_date = $end_date ? date('F m, Y', strtotime($end_date)) : '';
                    $action = BASE_URL . '/order_info?oid=' . urlencode(base64_encode($oid));
                    include('views/order/admin_orders_list.php');

                }
                $admin_orders_list = ob_get_contents();
                ob_end_clean();
            }

            $this->template->vars('admin_orders_list', $admin_orders_list);
        }

        $paginator = new Controller_Paginator($this->main);
        $paginator->orders_history_paginator($total_pages, $page);

        $this->main->view_admin('order/orders_history');
    }

    public function order_info()
    {
        $base_url = BASE_URL;
        $this->main->test_access_rights();
        $page = !is_null(_A_::$app->get('page')) ? _A_::$app->get('page') : 1;
        $oid = (integer)urldecode(base64_decode(!is_null(_A_::$app->get('oid')) ? _A_::$app->get('oid') : null));
        $back_url = BASE_URL . '/orders_history' . '?page=' . $page;
        if (!is_null(_A_::$app->get('orders_search_query'))) {
            $back_url = $back_url . '&orders_search_query=' . _A_::$app->get('orders_search_query');
        }
        $this->template->vars('base_url', $base_url);

        $config = [
            'oid' => $oid
        ];

        $customer_order = Model_Order::getOrderDetailInfo($config);
        if (count($customer_order) > 0) {
            ob_start();
            $sub_price_count = (integer)0;
            foreach ($customer_order as $order) {
                extract($order);

                $sub_price_count = $sub_price_count + $sale_price;


                $sale_price = strlen(trim($sale_price)) > 0 && !$is_sample
                    ? '$' . number_format((double)$sale_price, 2) : '';

                $total = strlen(trim($total)) > 0
                    ? '$' . number_format((double)$total, 2) : '';

                $handling = strlen(trim($handling)) > 0
                    ? '$' . number_format((double)$handling, 2) : '';

                $shipping_discount = strlen(trim($shipping_discount)) > 0
                    ? '$' . number_format((double)$shipping_discount, 2) : '';

                $shipping_cost = strlen(trim($shipping_cost)) > 0
                    ? '$' . number_format((double)$shipping_cost, 2) : '';

                $taxes = strlen(trim($taxes)) > 0
                    ? '$' . number_format((double)$taxes, 2) : '';

                $status_code = $status;

                $status = ($status == 0 ? 'In process' : 'Completed');

                $discount = strlen(trim($discount)) > 0
                    ? '$' . number_format((double)$discount, 2) : '';

                if ($is_sample == 1) {
                    $length = array_fill(0, $quantity, 0);
                    $sample_cost = (new Model_Samples())->calculateSamplesPrice(0, $length);
                    $sub_price_count = $sub_price_count + $sample_cost;
                    $sample_cost = strlen(trim($sample_cost)) > 0 ? '$' . number_format((double)$sample_cost, 2) : '';
                }
                include('views/order/detail_info.php');

            }
            $end_date = $end_date ? date('d/m/Y', strtotime($end_date)) : '';

            $total_discount = strlen(trim($total_discount)) > 0 ? '$' . number_format((double)$total_discount, 2) : '';

            $sub_price_count = $sub_price_count + $order['shipping_cost'];
            $sub_price = strlen(trim($sub_price_count)) > 0 ? '$' . number_format((double)$sub_price_count, 2) : '';
            $detail_info = ob_get_contents();
            ob_end_clean();


        }

        $this->template->vars('back_url', $back_url);
        $this->template->vars('detail_info', $detail_info);
        $this->template->vars('handling', $handling);
        $this->template->vars('shipping_cost', $shipping_cost);
        $this->template->vars('shipping_discount', $shipping_discount);
        $this->template->vars('taxes', $taxes);
        $this->template->vars('total', $total);
        $this->template->vars('sub_price', $sub_price);
        $this->template->vars('is_sample', $is_sample);
        if ($is_sample == 1) {
            $this->template->vars('sample_cost', $sample_cost);
        }
        $this->template->vars('shipping_type', $shipping_type);
        $this->template->vars('track_code', $track_code);
        $this->template->vars('status', $status);
        $this->template->vars('end_date', $end_date);
        $this->template->vars('order_id', $order_id);
        $this->template->vars('status_code', $status_code);
        $this->template->vars('total_discount', $total_discount);

        $this->main->view_admin('order/order_info');
    }

    public function customer_order_info()
    {
        $page = (integer)(!is_null(_A_::$app->get('page')) ? 0 : _A_::$app->get('page'));
        $base_url = BASE_URL;
        $back_url = $base_url . '/' . 'customer_orders_history?page=' . $page;
        $this->template->vars('back_url', $back_url);

        $oid = (integer)urldecode(base64_decode(!is_null(_A_::$app->get('oid')) ? _A_::$app->get('oid') : null));

        $config = [
            'oid' => $oid
        ];

        $customer_order = Model_Order::getOrderDetailInfo($config);
        if (count($customer_order) > 0) {
            ob_start();
            $sub_price_count = (integer)0;
            foreach ($customer_order as $order) {
                extract($order);

                $sub_price_count = $sub_price_count + $sale_price;
                $sale_price = strlen(trim($sale_price)) > 0 && !$is_sample ? '$' . number_format((double)$sale_price, 2) : '';
                $total = strlen(trim($total)) > 0 ? '$' . number_format((double)$total, 2) : '';
                $total_discount = strlen(trim($total_discount)) > 0 ? '$' . number_format((double)$total_discount, 2) : '';
                $handling = strlen(trim($handling)) > 0 ? '$' . number_format((double)$handling, 2) : '';
                $shipping_discount = strlen(trim($shipping_discount)) > 4 ? '$' . number_format((double)$shipping_discount, 2) : '';
                $shipping_cost = strlen(trim($shipping_cost)) > 4 ? '$' . number_format((double)$shipping_cost, 2) : '';
                $taxes = strlen(trim($taxes)) > 0 ? '$' . number_format((double)$taxes, 2) : '';
                $discount = strlen(trim($discount)) > 0 ? '$' . number_format((double)$discount, 2) : '';

                if ($is_sample == 1) {
                    $length = array_fill(0, $quantity, 0);
                    $sample_cost = (new Model_Samples())->calculateSamplesPrice(0, $length);
                    $sub_price_count = $sub_price_count + $sample_cost;
                    $sample_cost = strlen(trim($sample_cost)) > 0 ? '$' . number_format((double)$sample_cost, 2) : '';
                }
                include('views/order/detail_info_customer.php');

            }
            $end_date = $end_date ? date('F m, Y', strtotime($end_date)) : '';
            $status_code = $status;
            $sub_price_count = $sub_price_count + $order['shipping_cost'];
            $sub_price = strlen(trim($sub_price_count)) > 0 ? '$' . number_format((double)$sub_price_count, 2) : '';
            $detail_info_customer = ob_get_contents();
            ob_end_clean();


        }

        $this->template->vars('detail_info_customer', $detail_info_customer);
        $this->template->vars('handling', $handling);
        $this->template->vars('shipping_cost', $shipping_cost);
        $this->template->vars('shipping_discount', $shipping_discount);
        $this->template->vars('taxes', $taxes);
        $this->template->vars('total', $total);
        $this->template->vars('sub_price', $sub_price);
        $this->template->vars('is_sample', $is_sample);
        if($is_sample){
            $this->template->vars('sample_cost', $sample_cost);
        }
        $this->template->vars('shipping_type', $shipping_type);
        $this->template->vars('total_discount', $total_discount);
        $this->template->vars('track_code', $track_code);
        $this->template->vars('end_date', $end_date);
        $this->template->vars('status', $status);
        $this->template->vars('status_code', $status_code);


        $this->main->view('order/customer_order_info');
    }

    public function edit_orders_info()
    {
        $model = new Model_Order();
        $track_code = (string)trim(htmlspecialchars(_A_::$app->post('track_code')));
        $status = (string)trim(htmlspecialchars(_A_::$app->post('status')));
        $order_id = (integer)trim(htmlspecialchars(_A_::$app->post('order_id')));
        $end_date = trim(htmlspecialchars((_A_::$app->post('end_date') != null) ? _A_::$app->get('end_date') : NULL));

        $result = [
            'track_code' => $track_code,
            'status' => $status,
            'end_date' => $end_date,
            'result' => null,
        ];


        if ($model->update_order_detail_info($status,$status,$track_code,$end_date,$order_id)) {
            
            if($result['status'] === 1){

                $user_id = $model->get_user_by_order($order_id);
                $user = new Model_User();
                $user_data = $user->get_user_by_id($user_id);
                $headers = "From: \"I Luv Fabrix\"<info@iluvfabrix.com>\n";
                $subject = "Order delivery";
                $body = 'Order №'.$order_id.' is delivered';

                $this->sendMail($user_data['email'], $subject, $body, $headers);

            }


            $result['result'] = 1;
        } else {
            $result['result'] = 0;
        }
        echo json_encode($result);
    }
    
    private function sendMail($email, $subject, $body, $headers){
        mail($email, $subject, $body, $headers);
    }

}