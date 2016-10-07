<?php

  class Controller_Orders extends Controller_Controller {

    protected function get_list() {
      $any = $this->main->test_any_logged('orders');
      $user_id = _A_::$app->get('user_id');
      if($any == 'user') {
        $user = Controller_User::get_from_session();
        $user_id = $user['aid'];
      }

      $is_admin = Controller_Admin::is_logged();
      $total = Model_Order::get_total_count($user_id);
      $page = !empty(_A_::$app->get('page')) ? _A_::$app->get('page') : 1;
      $per_page = 12;

      if($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
      if($page <= 0) $page = 1;
      $start = (($page - 1) * $per_page);

      $res_count_rows = 0;
      if(!empty($total) && ((int)$total > 0)) {
        $rows = Model_Order::get_all($user_id, $start, $per_page, $res_count_rows);
        $this->main->template->vars('count_rows', $res_count_rows);
        $prms_back = $prms = null;
        if(!empty(_A_::$app->get('page'))) {
          $prms['page'] = _A_::$app->get('page');
          $prms_back['page'] = _A_::$app->get('page');
        }
        if(!empty(_A_::$app->get('user_id'))) {
          $prms['user_id'] = _A_::$app->get('user_id');
          $back_url = 'users';
        }
        if(!empty(_A_::$app->get('back'))) {
          $back_url = _A_::$app->get('back');
        }
        $back_url = isset($back_url) ? _A_::$app->router()->UrlTo($back_url, $prms_back) : null;
        $this->main->template->vars('back_url', $back_url);

        ob_start();
        $this->template->vars('user_id', $user_id);
        $this->template->vars('is_admin', $is_admin);
        $this->template->vars('prms', $prms);
        $this->template->vars('rows', $rows);
        $this->template->view_layout('rows');
        $list = ob_get_contents();
        ob_end_clean();
      } else {
        ob_start();
        $this->template->view_layout('not_found');
        $list = ob_get_contents();
        ob_end_clean();
      }
      $this->main->template->vars('list', $list);
      (new Controller_Paginator($this->main))->paginator($total, $page, 'orders', $per_page);
      $this->template->view_layout('list');
    }

    private function get_details() {
      $order_id = Model_Order::validData(_A_::$app->get('order_id'));
      $order_details = '';
      if(!empty($order_id)) {
        ob_start();
        $rows = Model_Order::get_order_details($order_id);
        foreach($rows as $row) {
          $this->template->vars('row', $row);
          $this->template->view_layout('details');
        }
        $order_details = ob_get_contents();
        ob_end_clean();
      }
      $this->main->template->vars('order_details', $order_details);
    }

    private function sendMail($email, $subject, $body, $headers) {
      mail($email, $subject, $body, $headers);
    }

    private function updateOrderInfo(){
      $track_code = (string)trim(htmlspecialchars(_A_::$app->post('track_code')));
      $status = (string)trim(htmlspecialchars(_A_::$app->post('status')));
      $order_id = (integer)trim(htmlspecialchars(_A_::$app->post('order_id')));
      $end_date = trim(htmlspecialchars((_A_::$app->post('end_date') != null) ? _A_::$app->get('end_date') : null));

      $result = ['track_code' => $track_code, 'status' => $status, 'end_date' => $end_date, 'result' => null,];

      if(Model_Order::update_order_detail_info($status, $status, $track_code, $end_date, $order_id)) {

        if($result['status'] === 1) {

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

    /**
     * @export
     */
    public function orders() {
      $this->main->test_any_logged('orders');
      ob_start();
      $this->get_list();
      $list = ob_get_contents();
      ob_end_clean();
      $this->template->vars('orders', $list);
      if(Controller_Admin::is_logged()) $this->main->view_admin('orders');
      else  $this->main->view('orders');
    }

    /**
     * @export
     */
    public function order() {
      $this->main->test_access_rights();
      $prms = null;
      $order_id = Model_Order::validData(_A_::$app->get('order_id'));

      if(!is_null(_A_::$app->get('order_id'))) {
        $prms['order_id'] = _A_::$app->get('order_id');
      }
      if(!is_null(_A_::$app->get('user_id'))) {
        $prms['user_id'] = _A_::$app->get('user_id');
      }
      if(!is_null(_A_::$app->get('page'))) {
        $prms['page'] = _A_::$app->get('page');
      }
      $this->get_details();
      $userInfo = Model_Order::get_order($order_id);
      $this->main->template->vars('back_url', _A_::$app->router()->UrlTo('user/registration', $prms));
      $this->main->template->vars('userInfo', $userInfo);
      $this->main->view_admin('order');
    }

    /**
     * @export
     */
    public function discount() {
      $this->main->test_access_rights();
      $prms = null;
      $order_id = Model_Order::validData(_A_::$app->get('order_id'));
      if(!empty(_A_::$app->get('discount_id'))) {
        $prms['discount_id'] = _A_::$app->get('discount_id');
      }
      $this->get_details();
      $userInfo = Model_Order::get_order($order_id);
      $this->main->template->vars('back_url', _A_::$app->router()->UrlTo(empty(_A_::$app->get('discount_id')) ? 'discount' : 'discount/usage', $prms));
      $this->main->template->vars('userInfo', $userInfo);
      $this->main->view_admin('order');
    }

    /**
     * @export
     */
    public function info() {
      $this->main->test_any_logged('orders');
      $page = !is_null(_A_::$app->get('page')) ? _A_::$app->get('page') : 1;
      $oid = !is_null(_A_::$app->get('oid')) ? _A_::$app->get('oid') : null;
      $prms['page'] = $page;

      if(!is_null(_A_::$app->get('orders_search_query'))) {
        $prms['orders_search_query'] = _A_::$app->get('orders_search_query');
      }
      if(!is_null(_A_::$app->get('page'))) {
        $prms['page'] = _A_::$app->get('page');
      }
      if(!is_null(_A_::$app->get('user_id'))) {
        $prms['user_id'] = _A_::$app->get('user_id');
      }
      if(!is_null(_A_::$app->get('oid'))) {
        $prms['d_id'] = _A_::$app->get('d_id');
        unset($prms['page']);
      }

      $back_url = '';
      if(!is_null(_A_::$app->get('discount'))) {
        $back_url = _A_::$app->router()->UrlTo('discount/usage', $prms);
      } else {
        $back_url = _A_::$app->router()->UrlTo('orders', $prms);
      }

      $config = ['oid' => (int)$oid];

      $customer_order = Model_Order::getOrderDetailInfo($config);
      if(!empty($customer_order) && $customer_order > 0) {
        ob_start();
        $sub_price_count = (integer)0;
        foreach($customer_order as $order) {
          extract($order);
          $sub_price_count = $sub_price_count + $sale_price;
          $sale_price = strlen(trim($sale_price)) > 0 && !$is_sample ? '$' . number_format((double)$sale_price, 2) : '';
          $total = strlen(trim($total)) > 0 ? '$' . number_format((double)$total, 2) : '';
          $handling = strlen(trim($handling)) > 0 ? '$' . number_format((double)$handling, 2) : '';
          $shipping_discount = strlen(trim($shipping_discount)) > 0 ? '$' . number_format((double)$shipping_discount, 2) : '';
          $shipping_cost = strlen(trim($shipping_cost)) > 0 ? '$' . number_format((double)$shipping_cost, 2) : '';
          $taxes = strlen(trim($taxes)) > 0 ? '$' . number_format((double)$taxes, 2) : '';
          $status_code = $status;
          $status = ($status == 0 ? 'In process' : 'Completed');
          $discount = strlen(trim($discount)) > 0 ? '$' . number_format((double)$discount, 2) : '';

          if($is_sample == 1) {
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
      if($is_sample == 1) {
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

    /**
     * @export
     */
    public function edit() {
      $this->main->test_access_rights();
      $order_id = _A_::$app->get('oid');
      $page = !is_null(_A_::$app->get('page')) ? _A_::$app->get('page') : 1;
      $order = Model_Order::get_order($order_id);

      $prms['page'] = $page;

      if(!is_null(_A_::$app->get('orders_search_query'))) {
        $prms['orders_search_query'] = _A_::$app->get('orders_search_query');
      }
      if(!is_null(_A_::$app->get('page'))) {
        $prms['page'] = _A_::$app->get('page');
      }

      $back_url = _A_::$app->router()->UrlTo('orders', $prms);


      $this->main->template->vars('order', $order);
      $this->main->template->vars('back_url', $back_url);
      $this->main->view_admin('edit');
    }

  }
