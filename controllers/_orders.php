<?php

  class Controller_Orders extends Controller_Simple {

    protected $id_name = 'oid';
    protected $form_title_edit = 'MODIFY ORDER STATUS';

    public function add(){ }

    /**
     * @export
     */
    public function view() {

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
        $prms['sid'] = _A_::$app->get('sid');
        $back_url = _A_::$app->router()->UrlTo('discount/view', $prms);
      } else {
        $back_url = _A_::$app->router()->UrlTo('orders', $prms);
      }

      $config = ['oid' => (int) $oid];

      $customer_order = Model_Orders::getOrderDetailInfo($config);
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
          $item_price = strlen(trim($price)) > 0 ? '$' . number_format((double) $price, 2) : '';
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
      $this->main->template->vars('item_price', $item_price);
      $this->main->template->vars('total_discount', $total_discount);

      $this->main->view_admin('view');
    }


    protected function load(&$data) {
      $data['oid'] = _A_::$app->get('oid');
      $data['track_code'] = Model_Orders::validData(_A_::$app->post('track_code'));
      $data['status'] = Model_Orders::validData(_A_::$app->post('status'));
      $data['end_date'] = Model_Orders::validData(_A_::$app->post('end_date'));
    }

    protected function validate(&$data, &$error) {
      return true;
    }
  }
