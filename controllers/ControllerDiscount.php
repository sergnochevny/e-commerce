<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerController;
use classes\controllers\ControllerFormSimple;
use models\ModelDiscount;

/**
 * Class ControllerDiscount
 * @package controllers
 */
class ControllerDiscount extends ControllerFormSimple{

  /**
   * @var string
   */
  protected $id_field = 'sid';
  /**
   * @var string
   */
  protected $form_title_add = 'NEW DISCOUNT';
  /**
   * @var string
   */
  protected $form_title_edit = 'MODIFY DISCOUNT';
  /**
   * @var array
   */
  protected $resolved_scenario = ['', 'orders'];

  /**
   * @param $data
   * @param bool $return
   * @return string
   * @throws \Exception
   */
  private function generate_prod_filter($data, $return = false){
    $filter_products = $data['filter_products'];
    $product_type = $data['product_type'];
    $title = "Select Products";
    if($product_type == 3) $title = "Select Types";
    if($product_type == 4) $title = "Select Manufacturers";
    $this->template->vars('filters', $filter_products);
    $this->template->vars('filter_type', $data['filter_type']);
    $this->template->vars('destination', 'filter_products');
    $this->template->vars('title', $title);
    if($return) return $this->template->view_layout_return('filter/filter');

    return $this->template->view_layout('filter/filter');
  }

  /**
   * @param $data
   * @param bool $return
   * @return string
   * @throws \Exception
   */
  private function generate_users_filter($data, $return = true){
    $users = $data['users'];
    $this->template->vars('filters', $users);
    $this->template->vars('filter_type', 'users');
    $this->template->vars('filter_data_start', 0);
    $this->template->vars('destination', 'users');
    $this->template->vars('title', 'Select Users');
    if($return) return $this->template->view_layout_return('filter/filter');

    return $this->template->view_layout('filter/filter');
  }

  /**
   * @param $method
   * @param $filters
   * @param null $start
   * @param null $search
   * @param bool $return
   * @return string
   * @throws \Exception
   */
  private function select_filter($method, $filters, $start = null, $search = null, $return = false){
    $selected = isset($filters) ? array_values($filters) : [];
    $filter = ModelDiscount::get_filter_data($method, $count, $start, $search);
    $this->template->vars('destination', App::$app->post('type'));
    $this->template->vars('total', $count);
    $this->template->vars('search', $search);
    $this->template->vars('type', $method . '_select');
    $this->template->vars('filter_type', $method);
    $this->template->vars('filter_data_start', isset($start) ? $start : 0);
    $this->template->vars('selected', $selected);
    $this->template->vars('filter', $filter);
    if($return) return $this->template->view_layout_return('filter/select');

    return $this->template->view_layout('filter/select');
  }

  /**
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  private function selected_filter_data($data){

    $data['users_select'] = App::$app->post('users_select');
    $data['prod_select'] = App::$app->post('prod_select');
    $data['mnf_select'] = App::$app->post('mnf_select');
    $data['cat_select'] = App::$app->post('cat_select');

    ModelDiscount::get_filter_selected(App::$app->post('type'), $data);

    return $data;
  }

  /**
   * @param $data
   * @param bool $return
   * @return string
   * @throws \Exception
   */
  private function selected_filter($data, $return = false){
    if($return || (App::$app->post('type') === 'users')) {
      return $this->generate_users_filter($data, $return);
    }

    return $this->generate_prod_filter($data, $return);
  }

  /**
   * @param bool $view
   * @return array|null
   */
  protected function search_fields($view = false){
    if($view && $this->scenario() == 'orders') return ['c.sid'];

    return [
      'sid', 'promotion_type', 'user_type', 'discount_type', 'product_type', 'coupon_code', 'date_start', 'date_end'
    ];
  }

  /**
   * @param $filter
   * @param bool $view
   * @return array|null
   */
  protected function build_search_filter(&$filter, $view = false){
    $res = parent::build_search_filter($filter, $view);
    if($view && ($this->scenario() == 'orders')) {
      $this->per_page = 24;
      $filter['hidden']['c.sid'] = App::$app->get('sid');
    }

    return $res;
  }

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function build_order(&$sort, $view = false, $filter = null){
    parent::build_order($sort, $view, $filter);
    if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
      if($view && $this->scenario() == 'orders') {
        $sort = ['a.order_date' => 'desc'];
      } else {
        $sort = ['date_start' => 'desc'];
      }
    }
  }

  /**
   * @param $data
   * @throws \Exception
   */
  protected function load(&$data){
    $data[$this->id_field] = App::$app->get($this->id_field);
    $data['promotion_type'] = ModelDiscount::sanitize(!is_null(App::$app->post('promotion_type')) ? App::$app->post('promotion_type') : '');
    $data['coupon_code'] = ModelDiscount::sanitize(!is_null(App::$app->post('coupon_code')) ? App::$app->post('coupon_code') : '');
    $data['generate_code'] = ModelDiscount::sanitize(!is_null(App::$app->post('generate_code')) ? App::$app->post('generate_code') : false);
    $data['discount_amount'] = ModelDiscount::sanitize(App::$app->post('discount_amount'));
    $data['discount_amount_type'] = ModelDiscount::sanitize(App::$app->post('discount_amount_type'));
    $data['discount_type'] = ModelDiscount::sanitize(App::$app->post('discount_type'));
    $data['shipping_type'] = !is_null(App::$app->post('shipping_type')) ? App::$app->post('shipping_type') : 0;
    $data['required_amount'] = ModelDiscount::sanitize(!is_null(App::$app->post('required_amount')) ? App::$app->post('required_amount') : '0.00');
    $data['required_type'] = ModelDiscount::sanitize(App::$app->post('required_type'));
    $data['user_type'] = ModelDiscount::sanitize(App::$app->post('user_type'));
    $data['users'] = !is_null(App::$app->post('users')) ? App::$app->post('users') : null;
    $data['product_type'] = ModelDiscount::sanitize(App::$app->post('product_type'));
    $data['filter_products'] = !is_null(App::$app->post('filter_products')) ? App::$app->post('filter_products') : null;
    $data['allow_multiple'] = ModelDiscount::sanitize(!is_null(App::$app->post('allow_multiple')) ? App::$app->post('allow_multiple') : 0);
    $data['date_start'] = ModelDiscount::sanitize(!is_null(App::$app->post('date_start')) ? App::$app->post('date_start') : '');
    $data['date_end'] = ModelDiscount::sanitize(!is_null(App::$app->post('date_end')) ? App::$app->post('date_end') : '');
    $data['enabled'] = ModelDiscount::sanitize(!is_null(App::$app->post('enabled')) ? App::$app->post('enabled') : 0);
    $data['countdown'] = ModelDiscount::sanitize(!is_null(App::$app->post('countdown')) ? App::$app->post('countdown') : 0);
    $data['discount_comment1'] = ModelDiscount::sanitize(!is_null(App::$app->post('discount_comment1')) ? App::$app->post('discount_comment1') : '');
    $data['discount_comment2'] = ModelDiscount::sanitize(!is_null(App::$app->post('discount_comment2')) ? App::$app->post('discount_comment2') : '');
    $data['discount_comment3'] = ModelDiscount::sanitize(!is_null(App::$app->post('discount_comment3')) ? App::$app->post('discount_comment3') : '');
    $data['date_end'] = strlen($data['date_end']) > 0 ? strtotime($data['date_end']) : 0;
    $data['date_start'] = strlen($data['date_start']) > 0 ? strtotime($data['date_start']) : 0;

    if(($data['generate_code'] == 1) || (strlen($data['coupon_code']) > 0)) {
      $data['allow_multiple'] = 1;
      $data['product_type'] = 1;
    }

    if($data['product_type'] == 2) $data['discount_type'] = 1;
    if($data['discount_type'] == 2) $data['allow_multiple'] = 1; else $data['shipping_type'] = 0;
    if($data['user_type'] != 4) $data['users'] = [];

    if($data['generate_code'] == 1) {
      $data['coupon_code'] = ModelDiscount::generateCouponCode($data[$this->id_field]);
      $data['allow_multiple'] = 1;
      $data['product_type'] = 1;
      $data['filter_products'] = [];
    }
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   * @throws \Exception
   */
  protected function validate(&$data, &$error){
    if(($data['discount_type'] == 2 && $data['shipping_type'] == 0) || (($data['generate_code'] == 0) && (strlen($data['coupon_code']) > 0) && ModelDiscount::checkCouponCode($data[$this->id_field], $data['coupon_code'])) || (!isset($data['users']) && ($data['user_type'] == 4)) || (!isset($data['filter_products']) && ($data['product_type'] != 1)) || ($data['date_start'] == 0) || ($data['date_end'] == 0) || ($data['promotion_type'] == '0') || (empty($data['discount_amount']) || $data['discount_amount'] == '0.00' || $data['discount_type'] == '0') || (empty((float)$data['discount_amount'])) || (!empty((float)$data['discount_amount']) && ((float)$data['discount_amount'] < 0)) || (empty($data['required_amount'])) || (!empty((float)$data['required_amount']) && ((float)$data['required_amount'] < 0)) || (($data['discount_amount_type'] == 2) && !empty((float)$data['discount_amount']) && ((float)$data['discount_amount'] > 100))) {
      $error = [];

      if($data['discount_type'] == 2 && $data['shipping_type'] == 0) $error[] = "The Shipping Type is required.";
      if(($data['generate_code'] == 0) && (strlen($data['coupon_code']) > 0) && ModelDiscount::checkCouponCode(0, $data['coupon_code'])) $error[] = "The coupon code is in use.";
      if(empty($data['required_amount'])) $error[] = "Identify Restrictions field";
      if(!empty($data['required_amount']) && ((float)$data['required_amount'] < 0)) $error[] = "The field 'Restrictions' value must be greater than zero or equal";
      if($data['promotion_type'] == 0) $error[] = "Identify Promotion field";
      if(empty($data['discount_amount'])) $error[] = "Identify 'Discount details' fields";
      if(!empty($data['discount_amount']) && (empty((float)$data['discount_amount']) || ((float)$data['discount_amount'] <= 0))) $error[] = "The field 'Discount details' value must be greater than zero";
      if((($data['discount_amount_type'] == 2) && !empty((float)$data['discount_amount']) && ((float)$data['discount_amount'] > 100))) $error[] = "The field 'Discount details' value must be less than 100 for this a discount type";
      if($data['date_start'] == 0) $error[] = "Identify 'start date' field";
      if($data['date_end'] == 0) $error[] = "Identify 'end date' field";
      if(!isset($data['users']) && ($data['user_type'] == 4)) $error[] = "Set the option 'All selected users'. Select at least one user from the list , in this case!";
      if(!isset($data['filter_products']) && ($data['product_type'] == 2)) $error[] = "Set the option 'All selected fabrics'. Select at least one fabric from the list , in this case!";
      if(!isset($data['filter_products']) && ($data['product_type'] == 3)) $error[] = "Set the option 'All selected categories'. Select at least one category from the list, in this case!";
      if(!isset($data['filter_products']) && ($data['product_type'] == 4)) $error[] = "Set the option 'All selected manufacturers'. Select at least one manufacture from the list , in this case!";
    } else
      return true;

    return false;
  }

  /**
   * @param null $data
   * @throws \Exception
   */
  protected function before_form_layout(&$data = null){
    ModelDiscount::get_filter_selected('filter_products', $data);
    ModelDiscount::get_filter_selected('users', $data);
    if($data['product_type'] == 1) $data['filter_products'] = null;
    if($data['user_type'] != 4) $data['users'] = null;
    $data['date_start'] = date("m/d/Y", $data['date_start']);
    $data['date_end'] = date("m/d/Y", $data['date_end']);
    $data['filter_products'] = $this->generate_prod_filter($data, true);
    $data['users'] = $this->generate_users_filter($data);
  }

  /**
   * @param null $data
   * @return bool
   * @throws \Exception
   */
  protected function form_handling(&$data = null){
    if(!is_null(App::$app->post('method'))) {
      $method = App::$app->post('method');
      if($method !== 'filter') {
        if(in_array($method, ['users', 'prod', 'cat', 'mnf', 'prc'])) {
          $filters = ($method == 'users') ? $data['users'] : $data['filter_products'];
          exit($this->select_filter($method, $filters));
        }
      } else {
        if(!is_null(App::$app->post('filter-type'))) {
          $method = App::$app->post('filter-type');
          $resporse = [];

          $data = $this->selected_filter_data($data);

          $resporse[0] = $this->selected_filter($data);

          $resporse[1] = null;
          $search = App::$app->post('filter_select_search_' . $method);
          $start = App::$app->post('filter_start_' . $method);
          $filter_limit = (!is_null(App::$app->keyStorage()->system_filter_amount) ? App::$app->keyStorage()->system_filter_amount : FILTER_LIMIT);
          if(!is_null(App::$app->post('down'))) $start = $filter_limit + (isset($start) ? $start : 0);
          if(!is_null(App::$app->post('up'))) $start = (isset($start) ? $start : 0) - $filter_limit;
          if(($start < 0) || (is_null(App::$app->post('down')) && is_null(App::$app->post('up')))) $start = 0;
          if(in_array($method, ['users', 'prod', 'cat', 'mnf', 'prc'])) {
            $filters = ($method == 'users') ? (isset($data['users']) ? array_keys($data['users']) : null) : (isset($data['filter_products']) ? array_keys($data['filter_products']) : null);
            $resporse[1] = $this->select_filter($method, $filters, $start, $search, true);
          }
          exit(json_encode($resporse));
        } else {
          $data = $this->selected_filter_data($data);
          exit($this->selected_filter($data));
        }
      }
    }

    return true;
  }

  /**
   * @export
   * @param bool $partial
   * @param bool $required_access
   * @throws \Exception
   */
  public function view($partial = true, $required_access = true){
    ob_start();
    parent::view($partial, $required_access);
    $discount = ob_get_contents();
    ob_end_clean();
    ob_start();
    $this->scenario('orders');
    ControllerController::view($partial, $required_access);
    $orders = ob_get_contents();
    ob_end_clean();
    $this->set_back_url();
    $this->template->vars('discount', $discount);
    $this->template->vars('orders', $orders);
    $this->main->view_admin('view' . DS . $this->controller);
  }

}