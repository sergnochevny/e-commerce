<?php

  class Controller_Matches extends Controller_Controller {

    /**
     * @export
     */
    public function matches() {
      $matches = null;
      if(isset(_A_::$app->session('matches')['items'])) {
        $matches_items = _A_::$app->session('matches')['items'];
        if(count($matches_items) > 0) {
          ob_start();
          $left = 2;
          $top = 2;
          foreach($matches_items as $key => $item) {
            $this->template->vars('product_id', $item['pid']);
            $this->template->vars('img', _A_::$app->router()->UrlTo('upload/upload/' . $item['img']));
            $this->template->vars('top', $top);
            $this->template->vars('left', $left);
            $this->template->view_layout('matches_item');
            $left += 6;
            $top += 4;
          }
          $matches = ob_get_contents();
          ob_end_clean();
        }
      }
      $this->template->vars('matches_items', $matches);
      $this->main->view('matches');
    }

    /**
     * @export
     */
    public function add() {
      $added = 0;

      if(!is_null(_A_::$app->get('pid')) && !empty(_A_::$app->get('pid'))) {
        $pid = _A_::$app->get('pid');
        $matches_items = isset(_A_::$app->session('matches')['items']) ? _A_::$app->session('matches')['items'] : [];
        $item_added = false;
        if(count($matches_items) > 0) {
          foreach($matches_items as $key => $item) {
            if($item['pid'] == $pid) {
              $item_added = true;
            }
          }
        }

        if(!$item_added) {
          $suffix_img = 'b_';
          $images = Model_Product::images($pid);

          if(isset($images['image1'])) {
            $file_img = 'upload/upload/' . $images['image1'];
            if(file_exists($file_img) && is_file($file_img)) {
              $images['image1'] = $suffix_img . $images['image1'];
              $matches_items[] = ['pid' => $pid, 'img' => $images['image1']];
            }
            $message = 'This Fabric has been added to your Matches.<br>Click the Matches to view your list.';
            $added = 1;
          } else {
            $message = 'Error with added fabric to Matches.<br>Main image of the fabric is empty.';
          }
        }
        $_matches = _A_::$app->session('matches');
        $_matches['items'] = $matches_items;
        _A_::$app->setSession('matches', $_matches);
      } else
        $message = 'Error with added fabric to Matches.';
      $this->template->vars('message', $message);

      ob_start();
      $this->template->view_layout('msg_add');
      $data = ob_get_contents();
      ob_end_clean();
      echo json_encode(['data' => $data, 'added' => $added]);
    }

    /**
     * @export
     */
    public function del() {
      if(!is_null(_A_::$app->post('pid')) && !empty(_A_::$app->post('pid'))) {
        $pid = _A_::$app->post('pid');
        $matches_items = isset(_A_::$app->session('matches')['items']) ? _A_::$app->session('matches')['items'] : [];
        if(count($matches_items) > 0) {
          foreach($matches_items as $key => $item) {
            if($item['pid'] == $pid) {
              unset($matches_items[$key]);
            }
          }
        }
        $_matches = _A_::$app->session('matches');
        _A_::$app->session('matches')['items'] = $matches_items;
        _A_::$app->setSession('matches', $_matches);
      }
    }

    /**
     * @export
     */
    public function clear() {
      if(isset(_A_::$app->session('matches')['items'])) {
        _A_::$app->setSession('matches', null);
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
                if($item['pid'] == $product_id) {
                  // $cart_items[$key]['quantity'] += 1;
                  $item_added = true;
                }
              }
              if(!$item_added) {
                $product = Model_Product::get_by_id($product_id);

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
                  $cart_items[$product['pid']] = $product;
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

    public function product_in($pid) {
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

  }