<?php

class Controller_Matches extends Controller_FormSimple{

  protected $id_field = 'pid';

  protected function load(&$data){
    $data[$this->id_field] = _A_::$app->get($this->id_field);
  }

  protected function after_save($id, &$data){
    $data['message'] = 'This Fabric has been added to your Matches.<br>Click the Matches to view your list.';
    if(!$id) {
      $data['message'] = empty($data[$this->id_field]) ? 'Error with added fabric to Matches.' : 'Error with adding fabric to Matches.<br> Main image of the fabric is empty.';
    }
    $data['res'] = $id ? 1 : 0;
  }

  protected function validate(&$data, &$error){
    return true;
  }

  protected function before_form_layout(&$data = null){
    $this->template->vars('message', $data['message']);
    $added = $data['res'];
    exit(json_encode(['data' => $this->template->view_layout_return('msg_add'), 'added' => $added]));
  }

  public function view($partial = false, $required_access = false){
  }

  public function edit($required_access = true){
  }

  public static function product_in($pid){
    if(isset(_A_::$app->session('matches')['items'])) {
      $matches_items = _A_::$app->session('matches')['items'];
    } else {
      return false;
    }

    $item_added = false;
    foreach($matches_items as $key => $item) {
      if($item['pid'] == $pid) {
        $item_added = true;
        break;
      }
    }

    return $item_added;
  }

  /**
   * @export
   */
  public function matches(){
    $this->main->is_user_authorized(true);
    _A_::$app->router()->parse_referrer_url($route, $controller, $action, $args);
    if($controller == 'shop' && $action == 'product') $this->template->vars('back_url', _A_::$app->server('HTTP_REFERER'));
    $this->template->vars('cart_not_empty', !empty(_A_::$app->session('cart')['items']));
    parent::index(false);
  }

  public function index($required_access = true){
  }

  /**
   * @export
   */
  public function add($required_access = true){
    $this->main->is_user_authorized();
    if($this->form_handling($data) && _A_::$app->request_is_post()) parent::add(false); else throw new Exception('404');
  }

  /**
   * @export
   */
  public function delete($required_access = true){
    $this->main->is_user_authorized();
    if(_A_::$app->request_is_post() && _A_::$app->request_is_ajax() && ($id = _A_::$app->get($this->id_field))) {
      try {
        forward_static_call(['Model_' . ucfirst($this->controller), 'delete'], $id);
        $this->after_delete($id);
      } catch(Exception $e) {
        $error[] = $e->getMessage();
        $this->template->vars('error', $error);
      }
    }
  }

  /**
   * @export
   */
  public function clear(){
    $this->main->is_user_authorized();
    if(_A_::$app->request_is_ajax()) {
      try {
        forward_static_call(['Model_' . ucfirst($this->controller), 'clear']);
      } catch(Exception $e) {
        $error[] = $e->getMessage();
        $this->template->vars('error', $error);
      }
    }
  }

  /**
   * @export
   */
  public function add_to_cart(){
    $added = 0;
    $this->main->is_user_authorized();
    if(!is_null(_A_::$app->post('data')) && !empty(_A_::$app->post('data'))) {
      try {
        $products = json_decode(_A_::$app->post('data'));
        $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
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
            $product = Model_Shop::get_product_params($product_id);
            if(!$item_added) {

              ////////////
              $pid = $product_id;
              $price = $product['price'];
              $inventory = $product['inventory'];
              $piece = $product['piece'];

              if($inventory > 0) {

                $format_price = '';
                $price = Model_Price::getPrintPrice($price, $format_price, $inventory, $piece);

                $discountIds = [];
                $saleprice = $product['price'];
                $sDiscount = 0;
                $saleprice = Model_Price::calculateProductSalePrice($pid, $saleprice, $discountIds);
                $bProductDiscount = Model_Price::checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds);
                $format_sale_price = '';
                $saleprice = Model_Price::getPrintPrice($saleprice, $format_sale_price, $inventory, $piece);
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
          $cart = _A_::$app->session('cart');
          $cart ['items'] = $cart_items;
          _A_::$app->setSession('cart', $cart);

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

    $this->template->vars('message', $message);
    $this->main->view_layout('msg_add_to_cart');
  }
}