<?php

namespace controllers;

use app\core\App;
use classes\Auth;
use classes\controllers\ControllerSimple;
use classes\helpers\AdminHelper;
use classes\helpers\UserHelper;
use models\ModelOrders;
use models\ModelSamples;

/**
 * Class ControllerOrders
 * @package controllers
 */
class ControllerOrders extends ControllerSimple{

  /**
   * @var string
   */
  protected $id_field = 'oid';
  /**
   * @var string
   */
  protected $form_title_edit = 'MODIFY ORDER STATUS';

  /**
   * @param bool $view
   * @return array|null
   */
  protected function search_fields($view = false){
    return [
      'a.aid', 'a.oid', 'a.trid', 'username', 'b.bill_firstname', 'b.bill_lastname', 'a.order_date', 'a.status', 'c.sid'
    ];
  }

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function BuildOrder(&$sort, $view = false, $filter = null){
    parent::BuildOrder($sort, $view, $filter);
    if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
      $sort = ['a.order_date' => 'desc'];
    }
  }

  /**
   * @param $filter
   * @param bool $view
   * @return array|null
   * @throws \InvalidArgumentException
   */
  public function build_search_filter(&$filter, $view = false){
    $search_form = parent::build_search_filter($filter, $view);
    if(UserHelper::is_logged()) {
      $filter['hidden']['a.aid'] = UserHelper::get_from_session()['aid'];
    } elseif(AdminHelper::is_logged()) {
      if(!is_null(App::$app->get('aid'))) {
        $filter['hidden']['a.aid'] = App::$app->get('aid');
      }
      if(!is_null(App::$app->get('sid'))) {
        $filter['hidden']['c.sid'] = App::$app->get('sid');
      }
    }

    return $search_form;
  }

  /**
   * @param $data
   */
  protected function load(&$data){
    $data['oid'] = App::$app->get('oid');
    $data['track_code'] = ModelOrders::sanitize(App::$app->post('track_code'));
    $data['status'] = ModelOrders::sanitize(App::$app->post('status'));
    $data['end_date'] = ModelOrders::sanitize(App::$app->post('end_date'));
  }

  /**
   * @param $data
   * @param $error
   * @return bool|mixed
   */
  protected function validate(&$data, &$error){
    return true;
  }

  /**
   * @param bool $required_access
   * @throws \Exception
   */
  public function add($required_access = true){
    parent::add($required_access); // TODO: Change the autogenerated stub
  }

  /**
   * @param bool $required_access
   * @throws \Exception
   */
  public function delete($required_access = true){
    parent::delete($required_access); // TODO: Change the autogenerated stub
  }

  /**
   * @export
   * @param bool $partial
   * @param bool $required_access
   * @throws \Exception
   */

  public function view($partial = false, $required_access = false){

    Auth::check_any_authorized('orders');

    $oid = !is_null(App::$app->get('oid')) ? App::$app->get('oid') : null;
    if(!is_null(App::$app->get('orders_search_query'))) $prms['orders_search_query'] = App::$app->get('orders_search_query');
    if(!is_null(App::$app->get('user_id'))) $prms['user_id'] = App::$app->get('user_id');
//      if(!is_null(App::$app->get('oid'))) $prms['d_id'] = App::$app->get('d_id');

    if(!is_null(App::$app->get('discount'))) {
      $prms['sid'] = App::$app->get('sid');
      $back_url = App::$app->router()->UrlTo('discount/view', $prms);
    } elseif(!is_null(App::$app->get('user'))) {
      $prms['aid'] = App::$app->get('aid');
      $prms['back'] = 'users';
      $back_url = App::$app->router()->UrlTo('orders', $prms);
    } else {
      $back_url = App::$app->router()->UrlTo('orders');
    }

    $config = ['oid' => (int)$oid];

    $customer_order = ModelOrders::getOrderDetailInfo($config);
    if(!empty($customer_order) && $customer_order > 0) {
      ob_start();
      ob_implicit_flush(false);
      $sub_price_count = (integer)0;
      foreach($customer_order as $order) {
        extract($order);
        $sub_price_count = $sub_price_count + $sale_price;
        $sale_price = strlen(trim($sale_price)) > 0 && !$is_sample ? '$' . number_format((double)$sale_price, 2) : '';
        $total = strlen(trim($total)) > 0 ? '$' . number_format((double)$total, 2) : '';
        $handling = !empty((double)$handling) ? '$' . number_format((double)$handling, 2) : '';
        $shipping_discount = !empty((double)$shipping_discount) ? '$' . number_format((double)$shipping_discount, 2) : '';
        $shipping_cost = !empty((double)$shipping_cost) ? '$' . number_format((double)$shipping_cost, 2) : '';
        $item_price = strlen(trim($price)) > 0 ? '$' . number_format((double)$price, 2) : '';
        $taxes = !empty((double)$taxes) ? '$' . number_format((double)$taxes, 2) : '';
        $status_code = $status;
        $status = ($status == 0 ? 'In process' : 'Completed');
        $discount = !empty((double)$discount) ? '$' . number_format((double)$discount, 2) : '';

        if($is_sample == 1) {
          $length = array_fill(0, $quantity, 0);
          $sample_cost = ModelSamples::calculateSamplesPrice(0, $length);
          $sub_price_count = $sub_price_count + $sample_cost;
          $sample_cost = strlen(trim($sample_cost)) > 0 ? '$' . number_format((double)$sample_cost, 2) : '';
        }

        $this->main->view->setVars('is_sample', $is_sample);
        $this->main->view->setVars('product_name', $product_name);
        $this->main->view->setVars('sale_price', $sale_price);
        $this->main->view->setVars('quantity', $quantity);
        $this->main->view->setVars('item_price', $item_price);
        $this->RenderLayout('detail_info');
      }
      $end_date = $end_date ? date('/m/d/Y', strtotime($end_date)) : '';
      $total_discount = strlen(trim($total_discount)) > 0 ? '$' . number_format((double)$total_discount, 2) : '';

      $sub_price_count = $sub_price_count + $order['shipping_cost'];
      $sub_price = strlen(trim($sub_price_count)) > 0 ? '$' . number_format((double)$sub_price_count, 2) : '';
      $detail_info = ob_get_clean();
    }

    $this->main->view->setVars('back_url', $back_url);
    $this->main->view->setVars('detail_info', $detail_info);
    $this->main->view->setVars('handling', $handling);
    $this->main->view->setVars('shipping_cost', $shipping_cost);
    $this->main->view->setVars('shipping_discount', $shipping_discount);
    $this->main->view->setVars('taxes', $taxes);
    $this->main->view->setVars('total', $total);
    $this->main->view->setVars('sub_price', $sub_price);
    $this->main->view->setVars('is_sample', $is_sample);
    if($is_sample == 1) {
      $this->main->view->setVars('sample_cost', $sample_cost);
    }
    $this->main->view->setVars('shipping_type', $shipping_type);
    $this->main->view->setVars('track_code', $track_code);
    $this->main->view->setVars('status', $status);
    $this->main->view->setVars('end_date', $end_date);
    $this->main->view->setVars('order_id', $order_id);
    $this->main->view->setVars('status_code', $status_code);
    $this->main->view->setVars('total_discount', $total_discount);

    if(AdminHelper::is_logged()) $this->main-> render_view_admin('view'); else  $this->render_view('view');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function orders(){
    Auth::check_any_authorized('orders');
    parent::index(false);
  }
}
