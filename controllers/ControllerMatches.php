<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerFormSimple;
use Exception;
use models\ModelPrice;
use models\ModelShop;

/**
 * Class ControllerMatches
 * @package controllers
 */
class ControllerMatches extends ControllerFormSimple{

  /**
   * @var string
   */
  protected $id_field = 'pid';

  /**
   * @param $data
   */
  protected function load(&$data){
    $data[$this->id_field] = App::$app->get($this->id_field);
  }

  /**
   * @param $id
   * @param $data
   */
  protected function after_save($id, &$data){
    $data['message'] = 'This Fabric has been added to your Matches.<br>Click the Matches to view your list.';
    if(!$id) {
      $data['message'] = empty($data[$this->id_field]) ?
        'Error with added fabric to Matches.' :
        'Error with adding fabric to Matches.<br> Main image of the fabric is empty.';
    }
    $data['res'] = $id ? 1 : 0;
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
   * @param null $data
   * @throws \Exception
   */
  protected function before_form_layout(&$data = null){
    $this->main->template->vars('message', $data['message']);
    $added = $data['res'];
    exit(json_encode(['data' => $this->render_layout_return('msg_add'), 'added' => $added]));
  }

  /**
   * @param bool $partial
   * @param bool $required_access
   */
  public function view($partial = false, $required_access = false){
  }

  /**
   * @param bool $required_access
   */
  public function edit($required_access = true){
  }

  /**
   * @export
   * @throws \Exception
   */
  public function matches(){
    $this->main->is_user_authorized(true);
    App::$app->router()->parse_referrer_url($route, $controller, $action, $args);
    if($controller == 'shop' && $action == 'product') $this->main->template->vars('back_url', App::$app->server('HTTP_REFERER'));
    $this->main->template->vars('cart_not_empty', !empty(App::$app->session('cart')['items']));
    parent::index(false);
  }

  /**
   * @param bool $required_access
   */
  public function index($required_access = true){
  }

  /**
   * @export
   * @param bool $required_access
   * @throws \Exception
   */
  public function add($required_access = true){
    if($this->form_handling($data) && App::$app->request_is_post()) {
      parent::add(false);
    } else throw new Exception('404');
  }

  /**
   * @export
   * @param bool $required_access
   * @throws \Exception
   */
  public function delete($required_access = true){
    $this->main->is_user_authorized();
    if(App::$app->request_is_post() && App::$app->request_is_ajax() && ($id = App::$app->get($this->id_field))) {
      try {
        forward_static_call([ App::$modelsNS . '\Model' . ucfirst($this->controller), 'delete'], $id);
        $this->after_delete($id);
      } catch(Exception $e) {
        $error[] = $e->getMessage();
        $this->main->template->vars('error', $error);
      }
    }
  }

  /**
   * @export
   * @throws \Exception
   */
  public function clear(){
    $this->main->is_user_authorized();
    if(App::$app->request_is_ajax()) {
      try {
        forward_static_call([ App::$modelsNS . '\Model' . ucfirst($this->controller), 'clear']);
      } catch(Exception $e) {
        $error[] = $e->getMessage();
        $this->main->template->vars('error', $error);
      }
    }
  }

  /**
   * @export
   * @throws \Exception
   */
  public function add_to_cart(){
    $added = 0;
    $this->main->is_user_authorized();
    if(!is_null(App::$app->post('data')) && !empty(App::$app->post('data'))) {
      try {
        $products = json_decode(App::$app->post('data'));
        $cart_items = isset(App::$app->session('cart')['items']) ? App::$app->session('cart')['items'] : [];
        $message = '';
        if(is_array($products) && (count($products) > 0)) {
          foreach($products as $product_id) {
            $item_added = false;

            foreach($cart_items as $key => $item) {
              if($item[$this->id_field] == $product_id) {
                // $cart_items[$key]['quantity'] += 1;
                $item_added = true;
              }
            }
            $product = ModelShop::get_product_params($product_id);
            if(!$item_added) {

              ////////////
              $pid = $product_id;
              $price = $product['price'];
              $inventory = $product['inventory'];
              $piece = $product['piece'];

              if($inventory > 0) {

                $format_price = '';
                $price = ModelPrice::getPrintPrice($price, $format_price, $inventory, $piece);

                $discountIds = [];
                $saleprice = $product['price'];
                $sDiscount = 0;
                $saleprice = ModelPrice::calculateProductSalePrice($pid, $saleprice, $discountIds);
                $bProductDiscount = ModelPrice::checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds);
                $format_sale_price = '';
                $saleprice = ModelPrice::getPrintPrice($saleprice, $format_sale_price, $inventory, $piece);
                $discount = $price - $saleprice;
                $format_discount = "$" . number_format($discount, 2);;

                $product['price'] = $price;
                $product['saleprice'] = $saleprice;
                $product['discount'] = $discount;
                $product['format_discount'] = $format_discount;
                $product['format_price'] = $format_price;
                $product['format_sale_price'] = $format_sale_price;
                $cart_items[$product[$this->id_field]] = $product;
                $message .= 'The product ' . $product['pname'] . ' has been added to your Cart.<br>';
              } else {
                $message .= 'The product ' . $product['pname'] . ' is unavailable. The product was not added.<br>';
              }
            } else {
              $message .= 'The product ' . $product['pname'] . ' already exists in your Cart.<br>';
            }
          }
          $cart = App::$app->session('cart');
          $cart ['items'] = $cart_items;
          App::$app->setSession('cart', $cart);

          $SUM = 0;
          foreach($cart_items as $key => $item) {
            $SUM += $item['quantity'] * $item['saleprice'];
          }

          $cart_sum = "$" . number_format($SUM, 2);

          $message .= '<br>Click the Cart to view your Order.';
          $message .= '<br>Subtotal sum of cart is ' . $cart_sum;
          $added = 1;
        } else
          $message = 'Empty Matches Area. Nothing added to the Cart.';
      } catch(Exception $e) {
        $message = 'Empty Matches Area. Nothing added to the Cart.';
      }
    } else
      $message = 'Empty Matches Area. Nothing added to the Cart.';

    $this->main->template->vars('message', $message);
    $this->render_layout('msg_add_to_cart');
  }
}