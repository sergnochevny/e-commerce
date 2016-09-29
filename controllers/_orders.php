<?php

class Controller_Orders extends Controller_Controller
{

    function orders()
    {
        $this->main->test_access_rights();
        $back_url = _A_::$app->router()->UrlTo('users', ['page' => !empty(_A_::$app->get('page')) ? _A_::$app->get('page') : '1']);
        $this->get();
        $this->main->template->vars('back_url', $back_url);
        $this->main->view_admin('orders');
    }

    function get()
    {
        $this->main->test_access_rights();
        $user_id = Model_Order::validData(_A_::$app->get('user_id'));
        $orders_count = Model_Order::get_count_orders_by_user($user_id);
        $page = !empty(_A_::$app->get('page')) ? _A_::$app->get('page') : '1';
        $per_page = 12;

        $total = $orders_count;
        if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
        if ($page <= 0) $page = 1;
        $start = (($page - 1) * $per_page);
        if ($total < ($start + $per_page)) $per_page = $total - $start;
        $res_count_rows = 0;
        $this->template->vars('page', $page);
        $this->template->vars('user_id', $user_id);
        if (!empty($orders_count) && ((int)$orders_count > 0)) {
            $rows = Model_Order::get_orders_by_user($user_id, $start, $per_page, $res_count_rows);
            $this->main->template->vars('count_rows', $res_count_rows);
            ob_start();
            foreach ($rows as $row) {
                $row[22] = gmdate("F j, Y, g:i a", $row[22]);
                $this->template->vars('row', $row);
                $this->template->view_layout('list');
            }
            $orders_list = ob_get_contents();
            ob_end_clean();
            ob_start();
            $this->template->vars('orders_list', $orders_list);
            $this->template->view_layout('detail');
            $orders = ob_get_contents();
            ob_end_clean();
        } else {
            ob_start();
            $this->template->view_layout('not_found');
            $orders = ob_get_contents();
            ob_end_clean();
        }
        $this->main->template->vars('orders', $orders);
        (new Controller_Paginator($this->main))->paginator($total, $page, 'orders', ($per_page != 0) ? $per_page : 1);
    }

    function order()
    {
        $this->main->test_access_rights();
        $prms = null;
        $order_id = Model_Order::validData(_A_::$app->get('order_id'));

        if (!is_null(_A_::$app->get('order_id'))) {
            $prms['order_id'] = _A_::$app->get('order_id');
        }
        if (!is_null(_A_::$app->get('user_id'))) {
            $prms['user_id'] = _A_::$app->get('user_id');
        }
        if (!is_null(_A_::$app->get('page'))) {
            $prms['page'] = _A_::$app->get('page');
        }
        $this->get_details();
        $userInfo = Model_Order::get_order($order_id);
        $this->main->template->vars('back_url', _A_::$app->router()->UrlTo('user/registration', $prms));
        $this->main->template->vars('userInfo', $userInfo);
        $this->main->view_admin('order');
    }

    function get_details()
    {
        $this->main->test_access_rights();
        $order_id = Model_Order::validData(_A_::$app->get('order_id'));
        $order_details = '';
        if (!empty($order_id)) {
            ob_start();
            $rows = Model_Order::get_order_details($order_id);
            foreach ($rows as $row) {
                $this->template->vars('row', $row);
                $this->template->view_layout('details');
            }
            $order_details = ob_get_contents();
            ob_end_clean();
        }
        $this->main->template->vars('order_details', $order_details);
    }

    function discount()
    {
        $this->main->test_access_rights();
        $prms = null;
        $order_id = Model_Order::validData(_A_::$app->get('order_id'));
        if (!empty(_A_::$app->get('discount_id'))) {
            $prms['discount_id'] = _A_::$app->get('discount_id');
        }
        $this->get_details();
        $userInfo = Model_Order::get_order($order_id);
        $this->main->template->vars('back_url', _A_::$app->router()->UrlTo(empty(_A_::$app->get('discount_id')) ? 'discount' : 'discount/usage', $prms));
        $this->main->template->vars('userInfo', $userInfo);
        $this->main->view_admin('order');
    }

    public function customer_history()
    {
        $this->main->is_user_authorized(true);
        $user_id = (integer)_A_::$app->session('user')['aid'];
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
                $action = _A_::$app->router()->UrlTo('/customer_order_info',['oid' => urlencode(base64_encode($oid)),'page' => $page]);
                $end_date = $end_date ? date('F m, Y', strtotime($end_date)) : '';

                $this->template->vars('action', $action);
                $this->template->vars('order_date', $order_date);
                $this->template->vars('end_date', $end_date);
                $this->template->vars('shipping_cost', $shipping_cost);
                $this->template->vars('track_code', $track_code);
                $this->template->vars('trid', $trid);
                $this->template->vars('total', $total);
                $this->template->view_layout('customer_list');
            }
            $customer_orders_list = ob_get_contents();
            ob_end_clean();

            if (isset($customer_orders_list) && !empty($customer_orders_list)) {
                $this->main->template->vars('customer_orders_list', $customer_orders_list);
            }
            (new Controller_Paginator($this->main))->paginator($total, $page, 'orders/customer_history', $per_page);
        } else {
            $mess = 'You have no orders yet.';
            $this->main->template->vars('no_orders', $mess);

        }
        $this->main->template->vars('page', $page);
        $this->main->view('customer_history');
    }

    public function history()
    {
        $this->main->test_access_rights();

        if (is_null(_A_::$app->get('orders_search_query'))) {
            $like = htmlspecialchars(trim(_A_::$app->get('orders_search_query')));
            $page = (integer)(empty(_A_::$app->get('page')) ? 0 : _A_::$app->get('page'));
            $this->template->vars('page', $page);

            $per_page = 12;
            $total = (integer)Model_Order::getOrdersListLengthByQuery($like);

            if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
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
                    $action = _A_::$app->router()->UrlTo('orders/info', [
                        'oid' => urlencode(base64_encode($oid)),
                        'page' => $page,
                        'orders_search_query' => _A_::$app->get('orders_search_query')
                    ]);
                    $this->template->vars('action', $action);
                    $this->template->vars('date', $date);
                    $this->template->vars('end_date', $end_date);
                    $this->template->vars('track_code', $track_code);
                    $this->template->vars('status', $status);
                    $this->template->vars('trid', $trid);
                    $this->template->vars('total_price', $total_price);
                    $this->template->vars('username', $username);
                    $this->template->view_layout('admin_list');
                }
                $admin_orders_list = ob_get_contents();
                ob_end_clean();
            }
            $this->main->template->vars('admin_orders_list', $admin_orders_list);
        } else {
            $page = (integer)(empty(_A_::$app->get('page')) ? 0 : _A_::$app->get('page'));
            $this->template->vars('page', $page);
            $per_page = 12;
            $total = (integer)Model_Order::getOrdersHistoryLength();
            if ($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
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
                    $action = _A_::$app->router()->UrlTo('orders/info', [
                        'oid' => urlencode(base64_encode($oid))
                    ]);
                    $this->template->vars('action', $action);
                    $this->template->vars('date', $date);
                    $this->template->vars('end_date', $end_date);
                    $this->template->vars('track_code', $track_code);
                    $this->template->vars('trid', $trid);
                    $this->template->vars('$total_price', $total_price);
                    $this->template->vars('username', $username);
                    $this->template->view_layout('admin_list');
                }
                $admin_orders_list = ob_get_contents();
                ob_end_clean();
            }

            $this->main->template->vars('admin_orders_list', $admin_orders_list);
        }
        (new Controller_Paginator($this->main))->paginator($total, $page, 'orders/history', $per_page);
        $this->main->view_admin('history');
    }

    public function info()
    {
        $this->main->test_access_rights();
        $page = !is_null(_A_::$app->get('page')) ? _A_::$app->get('page') : 1;
        $oid = !is_null(_A_::$app->get('oid')) ? _A_::$app->get('oid') : null;
        $prms['page'] = $page;

        if (!is_null(_A_::$app->get('orders_search_query'))) {
            $prms['orders_search_query'] = _A_::$app->get('orders_search_query');
        }
        if (!is_null(_A_::$app->get('page'))) {
            $prms['page'] = _A_::$app->get('page');
        }
        if (!is_null(_A_::$app->get('user_id'))) {
            $prms['user_id'] = _A_::$app->get('user_id');
        }
        $back_url = _A_::$app->router()->UrlTo('orders/history', $prms);

        $config = [
            'oid' => (int) $oid
        ];

        $customer_order = Model_Order::getOrderDetailInfo($config);
        if (!empty($customer_order) && $customer_order > 0) {
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
                    $sample_cost = Model_Samples::calculateSamplesPrice(0, $length);
                    $sub_price_count = $sub_price_count + $sample_cost;
                    $sample_cost = strlen(trim($sample_cost)) > 0 ? '$' . number_format((double)$sample_cost, 2) : '';
                }

                $this->template->vars('is_sample', $is_sample);
                $this->template->vars('product_name', $product_name);
                $this->template->vars('sale_price', $sale_price);
                $this->template->vars('quantity', $quantity);
                $this->template->view_layout('detail_info');
            }
            $end_date = $end_date ? date('d/m/Y', strtotime($end_date)) : '';
            $total_discount = strlen(trim($total_discount)) > 0 ? '$' . number_format((double)$total_discount, 2) : '';

            $sub_price_count = $sub_price_count + $order['shipping_cost'];
            $sub_price = strlen(trim($sub_price_count)) > 0 ? '$' . number_format((double)$sub_price_count, 2) : '';
            $detail_info = ob_get_contents();
            ob_end_clean();
        }

        $this->main->template->vars('back_url', $back_url);
        $this->main->template->vars('detail_info', $detail_info);
        $this->main->template->vars('handling', $handling);
        $this->main->template->vars('shipping_cost', $shipping_cost);
        $this->main->template->vars('shipping_discount', $shipping_discount);
        $this->main->template->vars('taxes', $taxes);
        $this->main->template->vars('total', $total);
        $this->main->template->vars('sub_price', $sub_price);
        $this->main->template->vars('is_sample', $is_sample);
        if ($is_sample == 1) {
            $this->main->template->vars('sample_cost', $sample_cost);
        }
        $this->main->template->vars('shipping_type', $shipping_type);
        $this->main->template->vars('track_code', $track_code);
        $this->main->template->vars('status', $status);
        $this->main->template->vars('end_date', $end_date);
        $this->main->template->vars('order_id', $order_id);
        $this->main->template->vars('status_code', $status_code);
        $this->main->template->vars('total_discount', $total_discount);


        $this->main->view_admin('info');
    }

    public function customer_info()
    {
        $page = (integer)(!is_null(_A_::$app->get('page')) ? 0 : _A_::$app->get('page'));
        $back_url = _A_::$app->router()->UrlTo('customer_orders_history', ['page' => $page]);
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
                    $sample_cost = Model_Samples::calculateSamplesPrice(0, $length);
                    $sub_price_count = $sub_price_count + $sample_cost;
                    $sample_cost = strlen(trim($sample_cost)) > 0 ? '$' . number_format((double)$sample_cost, 2) : '';
                }

                $this->template->vars('is_sample', $is_sample);
                $this->template->vars('product_name', $product_name);
                $this->template->vars('sale_price', $sale_price);
                $this->template->vars('quantity', $quantity);
                $this->template->view_layout('detail_info_customer');

            }
            $end_date = $end_date ? date('F m, Y', strtotime($end_date)) : '';
            $status_code = $status;
            $sub_price_count = $sub_price_count + $order['shipping_cost'];
            $sub_price = strlen(trim($sub_price_count)) > 0 ? '$' . number_format((double)$sub_price_count, 2) : '';
            $detail_info_customer = ob_get_contents();
            ob_end_clean();
        }

        $this->main->template->vars('detail_info_customer', $detail_info_customer);
        $this->main->template->vars('handling', $handling);
        $this->main->template->vars('shipping_cost', $shipping_cost);
        $this->main->template->vars('shipping_discount', $shipping_discount);
        $this->main->template->vars('taxes', $taxes);
        $this->main->template->vars('total', $total);
        $this->main->template->vars('sub_price', $sub_price);
        $this->main->template->vars('is_sample', $is_sample);
        if ($is_sample) {
            $this->main->template->vars('sample_cost', $sample_cost);
        }
        $this->main->template->vars('shipping_type', $shipping_type);
        $this->main->template->vars('total_discount', $total_discount);
        $this->main->template->vars('track_code', $track_code);
        $this->main->template->vars('end_date', $end_date);
        $this->main->template->vars('status', $status);
        $this->main->template->vars('status_code', $status_code);


        $this->main->view('customer_info');
    }

    public function edit()
    {
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

        if (Model_Order::update_order_detail_info($status, $status, $track_code, $end_date, $order_id)) {

            if ($result['status'] === 1) {

                $user_id = Model_Order::get_user_by_order($order_id);
                $user_data = Model_User::get_user_by_id($user_id);
                $headers = "From: \"I Luv Fabrix\"<info@iluvfabrix.com>\n";
                $subject = "Order delivery";
                $body = 'Order №' . $order_id . ' is delivered';

                $this->sendMail($user_data['email'], $subject, $body, $headers);

            }
            $result['result'] = 1;
        } else {
            $result['result'] = 0;
        }
        echo json_encode($result);
    }

    private function sendMail($email, $subject, $body, $headers)
    {
        mail($email, $subject, $body, $headers);
    }

}
