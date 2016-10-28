<?php

  class Controller_Discount extends Controller_FormSimple {

    protected $id_name = 'sid';
    protected $form_title_add = 'NEW DISCOUNT';
    protected $form_title_edit = 'MODIFY DISCOUNT';

    private function generate_prod_filter($data) {
      $filter_products = $data['filter_products'];
      $product_type = $data['product_type'];
      $title = "Select Products";
      if($product_type == 3) $title = "Select Categories";
      if($product_type == 4) $title = "Select Manufacturers";
      $this->template->vars('filters', $filter_products);
      $this->template->vars('filter_type', $data['filter_type']);
      $this->template->vars('destination', 'filter_products');
      $this->template->vars('title', $title);
      $this->template->view_layout('filter/filter');
    }

    private function generate_users_filter($data) {
      $users = $data['users'];
      $this->template->vars('filters', $users);
      $this->template->vars('filter_type', 'users');
      $this->template->vars('filter_data_start', 0);
      $this->template->vars('destination', 'users');
      $this->template->vars('title', 'Select Users');
      $this->template->view_layout('filter/filter');
    }

    private function select_filter($method, $filters, $start = null, $search = null) {
      $selected = isset($filters) ? array_values($filters) : [];
      $filter = Model_Discount::get_filter_data($method, $count, $start, $search);
      $this->template->vars('destination', _A_::$app->post('type'));
      $this->template->vars('total', $count);
      $this->template->vars('search', $search);
      $this->template->vars('type', $method . '_select');
      $this->template->vars('filter_type', $method);
      $this->template->vars('filter_data_start', isset($start) ? $start : 0);
      $this->template->vars('selected', $selected);
      $this->template->vars('filter', $filter);
      $this->template->view_layout('filter/select');
    }

    private function selected_filter_data($data) {

      $data['users_select'] = _A_::$app->post('users_select');
      $data['prod_select'] = _A_::$app->post('prod_select');
      $data['mnf_select'] = _A_::$app->post('mnf_select');
      $data['cat_select'] = _A_::$app->post('cat_select');

      Model_Discount::get_filter_selected(_A_::$app->post('type'), $data);
      return $data;
    }

    private function selected_filter($data) {
      if(_A_::$app->post('type') === 'users') {
        $this->generate_users_filter($data);
      } else {
        $this->generate_prod_filter($data);
      }
    }

    protected function load(&$data) {
      $data[$this->id_name] = _A_::$app->get($this->id_name);
      $data['promotion_type'] = Model_Discount::validData(!is_null(_A_::$app->post('promotion_type')) ? _A_::$app->post('promotion_type') : '');
      $data['coupon_code'] = Model_Discount::validData(!is_null(_A_::$app->post('coupon_code')) ? _A_::$app->post('coupon_code') : '');
      $data['generate_code'] = Model_Discount::validData(!is_null(_A_::$app->post('generate_code')) ? _A_::$app->post('generate_code') : false);
      $data['discount_amount'] = Model_Discount::validData(_A_::$app->post('discount_amount'));
      $data['discount_amount_type'] = Model_Discount::validData(_A_::$app->post('discount_amount_type'));
      $data['discount_type'] = Model_Discount::validData(_A_::$app->post('discount_type'));
      $data['shipping_type'] = !is_null(_A_::$app->post('shipping_type')) ? _A_::$app->post('shipping_type') : 0;
      $data['required_amount'] = Model_Discount::validData(!is_null(_A_::$app->post('required_amount')) ? _A_::$app->post('required_amount') : 0);
      $data['required_type'] = Model_Discount::validData(_A_::$app->post('required_type'));
      $data['user_type'] = Model_Discount::validData(_A_::$app->post('user_type'));
      $data['users'] = !is_null(_A_::$app->post('users')) ? _A_::$app->post('users') : null;
      $data['product_type'] = Model_Discount::validData(_A_::$app->post('product_type'));
      $data['filter_products'] = !is_null(_A_::$app->post('filter_products')) ? _A_::$app->post('filter_products') : null;
      $data['allow_multiple'] = Model_Discount::validData(!is_null(_A_::$app->post('allow_multiple')) ? _A_::$app->post('allow_multiple') : 0);
      $data['date_start'] = Model_Discount::validData(!is_null(_A_::$app->post('date_start')) ? _A_::$app->post('date_start') : '');
      $data['date_end'] = Model_Discount::validData(!is_null(_A_::$app->post('date_end')) ? _A_::$app->post('date_end') : '');
      $data['enabled'] = Model_Discount::validData(!is_null(_A_::$app->post('enabled')) ? _A_::$app->post('enabled') : 0);
      $data['countdown'] = Model_Discount::validData(!is_null(_A_::$app->post('countdown')) ? _A_::$app->post('countdown') : 0);
      $data['discount_comment1'] =  Model_Discount::validData(!is_null(_A_::$app->post('discount_comment1')) ? _A_::$app->post('discount_comment1') : '');
      $data['discount_comment2'] = Model_Discount::validData(!is_null(_A_::$app->post('discount_comment2')) ? _A_::$app->post('discount_comment2') : '');
      $data['discount_comment3'] = Model_Discount::validData(!is_null(_A_::$app->post('discount_comment3')) ? _A_::$app->post('discount_comment3') : '');
      $data['date_end'] = strlen($data['date_end']) > 0 ? strtotime($data['date_end']) : 0;
      $data['date_start'] = strlen($data['date_start']) > 0 ? strtotime($data['date_start']) : 0;

      if(($data['generate_code'] == 1) || (strlen($data['coupon_code']) > 0)) {
        $data['allow_multiple'] = 1;
        $data['product_type'] = 1;
      }

      if($data['product_type'] == 2) $data['discount_type'] = 1;
      if($data['discount_type'] == 2) $data['allow_multiple'] = 1;
      else $data['shipping_type'] = 0;
      if($data['user_type'] != 4) $data['users'] = [];

      if($data['generate_code'] == 1) {
        $data['coupon_code'] = Model_Discount::generateCouponCode($data[$this->id_name]);
        $data['allow_multiple'] = 1;
        $data['product_type'] = 1;
        $data['filter_products'] = [];
      }
    }

    protected function validate(&$data, &$error) {
      if(
        ($data['discount_type'] == 2 && $data['shipping_type'] == 0) ||
        (($data['generate_code'] == 0) && (strlen($data['coupon_code']) > 0) &&
          Model_Discount::checkCouponCode($data[$this->id_name], $data['coupon_code'])) ||
        (!isset($data['users']) && ($data['user_type'] == 4)) ||
        (!isset($data['filter_products']) && ($data['product_type'] != 1)) ||
        ($data['date_start'] == 0) || ($data['date_end'] == 0) ||
        ($data['promotion_type'] == '0') ||
        (!isset($data['discount_amount']) || $data['discount_amount'] == '' || $data['discount_amount'] == '0.00' || $data['discount_type'] == '0') ||
        ($data['required_amount'] == '')
      ) {
        $error = [];

        if($data['discount_type'] == 2 && $data['shipping_type'] == 0) $error[] = "The shipping type is required.";
        if(($data['generate_code'] == 0) && (strlen($data['coupon_code']) > 0)
          && Model_Discount::checkCouponCode(0, $data['coupon_code'])
        ) $error[] = "The coupon code is in use.";
        if(empty($data['required_amount'])) $error[] = "Identify 'required_amount' field";
        if($data['promotion_type'] == 0) $error[] = "Identify 'promotion' field";
        if(empty($data['discount_amount']) ||
          $data['discount_amount'] == '' ||
          $data['discount_amount'] == '0.00' ||
          $data['discount_type'] == 0
        ) $error[] = "Identify 'discount details' fields";
        if($data['date_start'] == 0) $error[] = "Identify 'start date' field";
        if($data['date_end'] == 0) $error[] = "Identify 'end date' field";
        if(!isset($data['users']) && ($data['user_type'] == 4))
          $error[] = "Set the option 'All selected users'. Select at least one user from the list , in this case!";
        if(!isset($data['filter_products']) && ($data['product_type'] == 2))
          $error[] = "Set the option 'All selected fabrics'. Select at least one fabric from the list , in this case!";
        if(!isset($data['filter_products']) && ($data['product_type'] == 3))
          $error[] = "Set the option 'All selected categories'. Select at least one category from the list, in this case!";
        if(!isset($data['filter_products']) && ($data['product_type'] == 4))
          $error[] = "Set the option 'All selected manufacturers'. Select at least one manufacture from the list , in this case!";
      } else return true;
      return false;
    }

    protected function before_form_layout(&$data = null) {
      Model_Discount::get_filter_selected('filter_products', $data);
      Model_Discount::get_filter_selected('users', $data);
      if($data['product_type'] == 1) $data['filter_products'] = null;
      if($data['user_type'] != 4) $data['users'] = null;
      $data['date_start'] = date("m/d/Y", $data['date_start']);
      $data['date_end'] = date("m/d/Y", $data['date_end']);
      ob_start();
      $this->generate_prod_filter($data);
      $data['filter_products'] = ob_get_contents();
      ob_end_clean();
      ob_start();
      $this->generate_users_filter($data);
      $data['users'] = ob_get_contents();
      ob_end_clean();
    }

    protected function form_handling(&$data = null) {
      if(!is_null(_A_::$app->post('method'))) {
        $method = _A_::$app->post('method');
        if($method !== 'filter') {
          if(in_array($method, ['users', 'prod', 'cat', 'mnf'])) {
            $filters = ($method == 'users') ? $data['users'] : $data['filter_products'];
            exit($this->select_filter($method, $filters));
          }
        } else {
          if(!is_null(_A_::$app->post('filter-type'))) {
            $method = _A_::$app->post('filter-type');
            $resporse = [];

            ob_start();
            $data = $this->selected_filter_data($data);
            $this->selected_filter($data);
            $resporse[0] = ob_get_contents();
            ob_end_clean();

            ob_start();
            $search = _A_::$app->post('filter_select_search_' . $method);
            $start = _A_::$app->post('filter_start_' . $method);
            if(!is_null(_A_::$app->post('down'))) $start = FILTER_LIMIT + (isset($start) ? $start : 0);
            if(!is_null(_A_::$app->post('up'))) $start = (isset($start) ? $start : 0) - FILTER_LIMIT;
            if(($start < 0) || (is_null(_A_::$app->post('down')) && is_null(_A_::$app->post('up')))) $start = 0;
            if(in_array($method, ['users', 'prod', 'cat', 'mnf'])) {
              $filters = ($method == 'users') ? (isset($data['users']) ? array_keys($data['users']) : null) : (isset($data['filter_products']) ? array_keys($data['filter_products']) : null);
              $this->select_filter($method, $filters, $start, $search);
            }
            $resporse[1] = ob_get_contents();
            ob_end_clean();
            exit(json_encode($resporse));
          } else {
            $data = $this->selected_filter_data($data);
            exit($this->selected_filter($data));
          }
        }
      }
      return true;
    }

    protected function search_fields($view = false) {
      return [
        'sid', 'promotion_type', 'user_type',
        'discount_type', 'product_type', 'coupon_code',
        'date_start', 'date_end'
      ];
    }


    protected function detailed($back_url){
      $id = _A_::$app->get($this->id_name);

      $discount = null;
      $orders = null;

      if(!isset($data)) {
        $discount = Model_Discount::get_by_id($id);
        $orders = Model_Orders::get_list_by_discount_id($id);
      }
      $prms = null;
      if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
      $back_url = _A_::$app->router()->UrlTo($back_url, $prms);
      $this->template->vars('back_url', $back_url);

      $this->template->vars($this->id_name, $id);
      $this->template->vars('discount', $discount);
      $this->template->vars('orders', $orders);
      $this->main->view_admin('view');
    }

    /**
     * @export
     */
    public function view() {
      $this->main->test_access_rights();
      $this->detailed($this->controller);
    }

  }