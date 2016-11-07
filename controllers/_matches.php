<?php

  class Controller_Matches extends Controller_FormSimple {

    protected $id_name = 'pid';

    protected function load(&$data) {
      $data[$this->id_name] = _A_::$app->get($this->id_name);
    }

    protected function after_save($id, &$data) {
      $data['message'] = 'This Fabric has been added to your Matches.<br>Click the Matches to view your list.';
      if(!$id) {
        $data['message'] = empty($data[$this->id_name]) ? 'Error with added fabric to Matches.' : 'Error with adding fabric to Matches.<br> Main image of the fabric is empty.';
      }
      $data['res'] = $id ? 1 : 0;
    }

    protected function validate(&$data, &$error) {
      return true;
    }

    protected function before_form_layout(&$data = null) {
      $this->template->vars('message', $data['message']);
      $added = $data['res'];
      ob_start();
      $this->template->view_layout('msg_add');
      $data = ob_get_contents();
      ob_end_clean();
      exit(json_encode(['data' => $data, 'added' => $added]));
    }

    public function view() { }

    public function edit($required_access = true) { }

    public static function product_in($pid) {
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
    public function matches() {
      parent::index(false);
    }

    /**
     * @export
     */
    public function add($required_access = true) {
      if($this->form_handling($data) && _A_::$app->request_is_post()) parent::add(false);
      else throw new Exception('404');
    }

    /**
     * @export
     */
    public function delete($required_access = true) {
      if(_A_::$app->request_is_ajax() && ($id = _A_::$app->get($this->id_name))) {
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
    public function clear() {
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
    public function all_to_cart() {
      $added = 0;
      if(!is_null(_A_::$app->post('data')) && !empty(_A_::$app->post('data'))) {
        try {
          $products = json_decode(_A_::$app->post('data'));
          $cart_items = isset(_A_::$app->session('cart')['items']) ? _A_::$app->session('cart')['items'] : [];
          $message = '';
          if(is_array($products) && (count($products) > 0)) {
            foreach($products as $product_id) {
              $item_added = false;

              foreach($cart_items as $key => $item) {
                if($item[$this->id_name] == $product_id) {
                  // $cart_items[$key]['quantity'] += 1;
                  $item_added = true;
                }
              }
              if(!$item_added) {
                $product = Model_Shop::get_product_params($product_id);

                ////////////
                $pid = $product_id;
                $price = $product['Price'];
                $inventory = $product['inventory'];
                $piece = $product['piece'];

                if($inventory > 0) {

                  $format_price = '';
                  $price = Model_Price::getPrintPrice($price, $format_price, $inventory, $piece);

                  $discountIds = [];
                  $saleprice = $product['Price'];
                  $sDiscount = 0;
                  $saleprice = Model_Price::calculateProductSalePrice($pid, $saleprice, $discountIds);
                  $bProductDiscount = Model_Price::checkProductDiscount($pid, $sDiscount, $saleprice, $discountIds);
                  $format_sale_price = '';
                  $saleprice = Model_Price::getPrintPrice($saleprice, $format_sale_price, $inventory, $piece);
                  $discount = $price - $saleprice;
                  $format_discount = "$" . number_format($discount, 2);;

                  $product['Price'] = $price;
                  $product['saleprice'] = $saleprice;
                  $product['discount'] = $discount;
                  $product['format_discount'] = $format_discount;
                  $product['format_price'] = $format_price;
                  $product['format_sale_price'] = $format_sale_price;
                  $cart_items[$product[$this->id_name]] = $product;
                  $message .= 'The product ' . $product['Product_name'] . ' have been added to your Basket.<br>';
                } else {
                  $message .= 'The product ' . $product['Product_name'] . ' is unavailable. The product was not added.<br>';
                }
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

            $message .= '<br>Click the Basket to view your Order.';
            $message .= '<br>Subtotal sum of basket is ' . $cart_sum;
            $added = 1;
          } else
            $message = 'Empty Matches Area. Nothing added to the Basket.';
        } catch(Exception $e) {
          $message = 'Empty Matches Area. Nothing added to the Basket.';
        }
      } else
        $message = 'Empty Matches Area. Nothing added to the Basket.';

      $this->template->vars('message', $message);
      $this->main->view_layout('msg_add');
    }

  }