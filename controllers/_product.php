<?php

  class Controller_Product extends Controller_Controller {

    private function select_filter($method, $filters, $start = null, $search = null) {
      $selected = isset($filters) ? $filters : [];
      $filter = Model_Product::get_filter_data($method, $count, $start, $search);
      $this->template->vars('destination', $method);
      $this->template->vars('total', $count);
      $this->template->vars('search', $search);
      $this->template->vars('type', $method . '_select');
      $this->template->vars('filter_type', $method);
      $this->template->vars('filter_data_start', isset($start) ? $start : 0);
      $this->template->vars('selected', $selected);
      $this->template->vars('filter', $filter);
      $this->template->view_layout('select_filter');
    }

    private function selected_filter_data($method, $filters, $selected, $id) {
      $data = [
        $method => $filters,
        $method . '_select' => $selected,
      ];

      Model_Product::get_filter_selected($method, $data, $id);
      return $data;
    }

    private function images_handling() {
      include('include/post_edit_product_data.php');
      $method = _A_::$app->get('method');
      if($method == 'save_link') {
        (new Controller_Image())->save();
      } elseif($method == 'upload_img') {
        (new Controller_Image())->upload();
      } elseif($method == 'del_pic') {
        (new Controller_Image())->del();
      } else {
        (new Controller_Image())->modify();
      }
    }

    private function filters_handling() {
      include('include/post_edit_product_data.php');
      $method = _A_::$app->post('method');
      if($method !== 'filter') {
        if(in_array($method, ['categories', 'colours', 'patterns'])) {
          $this->select_filter($method, array_keys(${$method}));
        }
      } else {
        if(!is_null(_A_::$app->post('filter-type'))) {
          $method = _A_::$app->post('filter-type');
          $resporse = [];

          ob_start();
          $data = $this->selected_filter_data($method, ${$method}, ${$method . '_select'}, $p_id);
          $filters = array_keys($data[$method]);
          $this->generate_filter($data, $method);
          $resporse[0] = ob_get_contents();
          ob_end_clean();

          ob_start();
          $search = _A_::$app->post('filter_select_search_' . $method);
          $start = _A_::$app->post('filter_start_' . $method);
          if(!is_null(_A_::$app->post('down'))) $start = FILTER_LIMIT + (isset($start) ? $start : 0);
          if(!is_null(_A_::$app->post('up'))) $start = (isset($start) ? $start : 0) - FILTER_LIMIT;
          if(($start < 0) || (is_null(_A_::$app->post('down')) && is_null(_A_::$app->post('up')))) $start = 0;
          if(in_array($method, ['colours', 'patterns', 'categories'])) {
            $this->select_filter($method, $filters, $start, $search);
          }
          $resporse[1] = ob_get_contents();
          ob_end_clean();
          exit(json_encode($resporse));
        } else {
          $method = _A_::$app->post('type');
          $data = $this->selected_filter_data($method, ${$method}, ${$method . '_select'}, $p_id);
          $this->generate_filter($data, $method);
        }
      }
    }

    private function save($new = false) {
      include('include/post_edit_product_data.php');
      $data = [
        'weight_id' => $post_weight_cat,
        'categories' => $categories,
        'pvisible' => $post_vis,
        'metadescription' => $post_desc,
        'p_id' => $p_id,
        'Meta_Description' => $post_desc,
        'Meta_Keywords' => $post_mkey,
        'Product_name' => $post_tp_name,
        'Product_number' => $post_product_num,
        'Width' => $post_width,
        'Price_Yard' => $post_p_yard,
        'Stock_number' => $post_st_nom,
        'Dimensions' => $post_dimens,
        'Current_inventory' => $post_curret_in,
        'Specials' => $post_special,
        'Weight' => $post_weight_cat,
        'manufacturers' => $manufacturers,
        'New_Manufacturer' => $New_Manufacturer,
        'colours' => $colours,
        'New_Colour' => $post_new_color,
        'patterns' => $patterns,
        'New_Pattern' => $pattern_type,
        'Short_description' => $post_short_desk,
        'Long_description' => $post_Long_description,
        'visible' => $post_hide_prise,
        'best' => $best,
        'piece' => $piece,
        'whole' => $whole
      ];

      if(!empty(_A_::$app->get('p_id'))) {
        if(empty($post_product_num{0}) || empty($post_tp_name{0}) || empty($post_p_yard{0})) {
          $error = [];
          if(empty($post_product_num{0})) $error[] = 'Identify Product Number field !';
          if(empty($post_tp_name{0})) $error[] = 'Identify Product Name field !';
          if(empty($post_p_yard{0})) $error[] = 'Identify Price field !';
          $this->template->vars('error', $error);
        } else {
          try {
            Model_Product::save($p_id, $categories, $patterns, $colours, $manufacturers,
                                $New_Manufacturer, $post_new_color, $pattern_type, $post_weight_cat,
                                $post_special, $post_curret_in, $post_dimens, $post_hide_prise,
                                $post_st_nom, $post_p_yard, $post_width, $post_product_num, $post_vis,
                                $post_mkey, $post_desc, $post_Long_description, $post_tp_name,
                                $post_short_desk, $best, $piece, $whole);

            $this->template->vars('warning', ["Product Data saved successfully!"]);
            if($new) {
              $data = null;
              Model_Product::getNewproduct();
            }
          } catch(Exception $e) {
            $this->template->vars('error', [$e->getMessage()]);
          }
        }
      } else {
        $this->template->vars('error', ["Error! Not product id identity"]);
        if($new) {
          $data = null;
          Model_Product::getNewproduct();
        }
      }
      return $data;
    }

    private function generate_filter($data, $type) {
      $filters = $data[$type];
      $this->template->vars('filters', $filters);
      $this->template->vars('filter_type', $type);
      $this->template->vars('destination', $type);
      $this->template->vars('title', 'Select ' . ucfirst($type));
      $this->template->view_layout('filter');
    }

    private function generate_select($data, $selected) {
      $this->template->vars('selected', is_array($selected) ? $selected : [$selected]);
      $this->template->vars('data', is_array($data) ? $data : [$data]);
      $this->template->view_layout('select');
    }

    private function form($url, $data = null) {
      $pid = _A_::$app->get('p_id');
      if(isset($data)) {
        foreach(['categories', 'colours', 'patterns'] as $method) {
          $filters = $this->selected_filter_data($method, $data[$method], null, $pid);
          $data[$method] = $filters[$method];
        }
        $data['manufacturerId'] = $data['manufacturers'];
        $data['manufacturers'] = Model_Product::get_manufacturers();
      } else {
        $data = Model_Product::getProductInfo($pid);
      }

      foreach(['categories', 'colours', 'patterns'] as $type) {
        ob_start();
        $this->generate_filter($data, $type);
        $filter = ob_get_contents();
        ob_end_clean();
        $data[$type] = $filter;
      }

      ob_start();
      $this->generate_select($data['manufacturers'], $data['manufacturerId']);
      $select = ob_get_contents();
      ob_end_clean();
      $data['manufacturers'] = $select;

      ob_start();
      $cimage = new Controller_Image($this->main);
      $cimage->modify();
      $m_images = ob_get_contents();
      ob_end_clean();

      $action_url = _A_::$app->router()->UrlTo($url, ['p_id' => $pid]);
      $this->template->vars('action_url', $action_url);
      $this->template->vars('modify_images', $m_images);
      $this->template->vars('data', $data);
      $this->main->view_layout('form');
    }

    /**
     * @param $url
     * @param $template
     */
    private function edit_form($url, $type) {

      $prms = null;
      if(!empty(_A_::$app->get('page'))) {
        $prms['page'] = _A_::$app->get('page');
      }
      if(!empty(_A_::$app->get('cat'))) {
        $prms['cat'] = _A_::$app->get('cat');
      }
      $back_url = _A_::$app->router()->UrlTo('admin/home', $prms);
      ob_start();
      $this->form($url);
      $edit_form = ob_get_contents();
      ob_end_clean();

      $this->template->vars('type', $type);
      $this->template->vars('back_url', $back_url);
      $this->main->template->vars('edit_form', $edit_form);
      $this->main->view_admin('edit');
    }

    private function del_image($pid) {
      $images = Model_Product::getImage($pid);
      $fields_idx = [1, 2, 3, 4, 5];
      foreach($fields_idx as $idx) {
        $filename = $images['image' . $idx];
        if(!empty($filename)) {
          if(file_exists("upload/upload/" . $filename)) {
            unlink("upload/upload/$filename");
          }
          if(file_exists("upload/upload/b_" . $filename)) {
            unlink("upload/upload/b_" . $filename);
          }
          if(file_exists("upload/upload/v_" . $filename)) {
            unlink("upload/upload/v_" . $filename);
          }
        }
      }
    }

    private function edit_add_handling($type, $url) {
      $this->main->test_access_rights();
      if(_A_::$app->request_is_post()) {
        if(!is_null(_A_::$app->post('method'))) {
          $this->filters_handling();
        } elseif(!is_null(_A_::$app->get('method'))) {
          $this->images_handling();
        } else {
          $data = $this->save();
          $this->form($url, $data);
        }
      } else {
        if(!is_null(_A_::$app->get('method'))) {
          $this->images_handling();
        } else {
          $this->edit_form($url, $type);
        }
      }
    }

    /**
     * @export
     */
    public function product() {
      $pid = Model_Product::validData(_A_::$app->get('p_id'));
      $data = Model_Product::getPrName($pid);

      $matches = new Controller_Matches($this->main);
      if($matches->product_in($pid))
        $this->template->vars('in_matches', '1');

      $this->template->vars('data', $data);
      $priceyard = $data['priceyard'];
      $aPrds = [];
      $aPrds[] = $pid;    #add product id
      $aPrds[] = 1;        #add qty

      #get the shipping
      if(!is_null(_A_::$app->session('cart')) && isset(_A_::$app->session('cart')['ship'])) {
        $shipping = (int)_A_::$app->session('cart')['ship'];
      } else {
        $shipping = DEFAULT_SHIPPING;
        $_cart = _A_::$app->session('cart');
        $_cart['ship'] = $shipping;
        _A_::$app->setSession('cart', $_cart);
      }

      if(!is_null(_A_::$app->get('cart')) && isset(_A_::$app->session('cart')['ship_roll'])) {
        $bShipRoll = (boolean)_A_::$app->session('cart')['ship_roll'];
      } else {
        $bShipRoll = false;
        $cart = _A_::$app->session('cart');
        $cart['ship_roll'] = 0;
        _A_::$app->setSession('cart', $cart);
      }

      $shipcost = 0;

      #grab the user id
      $uid = 0;
      if(!is_null(_A_::$app->session('user'))) {
        $uid = (int)_A_::$app->session('user')['aid'];
      }
      $bTemp = false;
      $sys_hide_price = Model_Price::sysHideAllRegularPrices();
      $hide_price = $data['vis_price'];
      $this->template->vars('sys_hide_price', $sys_hide_price);
      $this->template->vars('hide_price', $hide_price);

      $bSystemDiscount = false;
      $discountIds = [];
      $sSystemDiscount = false;
      $sPriceDiscount = '';
      $rSystemDiscount = 0;
      $rDiscountPrice = 0;
      $rSystemDiscount = Model_Price::calculateDiscount(DISCOUNT_CATEGORY_ALL, $uid, $aPrds, $priceyard, $shipcost, '', $bTemp, true, $sPriceDiscount, $sSystemDiscount, $shipping, $discountIds);
      if((strlen($sSystemDiscount) > 0) || ($rSystemDiscount > 0)) {
        $bSystemDiscount = true;
        $rDiscountPrice = $priceyard - $rSystemDiscount;
      }

      #check the price for the discount
      if($bSystemDiscount) {
        $rExDiscountPrice = $rDiscountPrice;
      } else {
        $rExDiscountPrice = $priceyard;
      }

      $inventory = $data['inventory'];
      $piece = $data['piece'];
      $format_price = '';
      $price = Model_Price::getPrintPrice($priceyard, $format_price, $inventory, $piece);

      #check if the product has its own discount
      $sDiscount = '';
      $bDiscount = Model_Price::checkProductDiscount($pid, $sDiscount, $rExDiscountPrice, $discountIds);
      $this->template->vars('format_price', $format_price);

      ob_start();
      if($rSystemDiscount > 0) {
        $tmp = Model_Price::getPrintPrice($rDiscountPrice, $sDiscountPrice, $inventory, $piece);
        $field_name = "Sale price:";
        $field_value = sprintf("%s<br><strong>%s</strong>", $sPriceDiscount, $sDiscountPrice);
        $this->template->vars('field_name', $field_name);
        $this->template->vars('field_value', $field_value);
        $this->template->view_layout('discount_info');
      }

      if($bDiscount) {
        $tmp = Model_Price::getPrintPrice($rExDiscountPrice, $sDiscountPrice, $inventory, $piece);
        if($bSystemDiscount) {
          $field_name = "Extra disc. price:";
        } else {
          $field_name = "Sale price:";
        }
        if($bSystemDiscount) {
          $field_value = sprintf("<strong>%s</strong><br>Reduced a further %s.", $sDiscountPrice, $sDiscount);
        } else {
          $field_value = sprintf("<strong>%s</strong><br>Reduced by %s.", $sDiscountPrice, $sDiscount);
        }
        $this->template->vars('field_name', $field_name);
        $this->template->vars('field_value', $field_value);
        $this->template->view_layout('discount_info');
      }

      if(strlen($sSystemDiscount) > 0) {
        $field_name = 'Shipping discount:';
        $field_value = $sSystemDiscount;
        $this->template->vars('field_name', $field_name);
        $this->template->vars('field_value', $field_value);
        $this->template->view_layout('discount_info');
      }

      if(count($discountIds) > 0) {
        if(Model_Price::getNextChangeInDiscoutDate($discountIds) > 0) {
          $field_name = 'Sale ends in:';
          $field_value = Model_Price::displayDiscountTimeRemaining($discountIds);
          $this->template->vars('field_name', $field_name);
          $this->template->vars('field_value', $field_value);
          $this->template->view_layout('discount_info');
        }
      }
      $discount_info = ob_get_contents();
      ob_end_clean();
      $this->template->vars('discount_info', $discount_info);

      if(isset(_A_::$app->session('cart')['items'])) {
        $cart_items = _A_::$app->session('cart')['items'];
      } else {
        $cart_items = [];
      }
      $cart = array_keys($cart_items);
      $in_cart = in_array($pid, $cart);
      if($in_cart)
        $this->template->vars('in_cart', '1');

      $url_prms = ['page' => '1'];
      if(!empty(_A_::$app->get('page'))) {
        $url_prms['page'] = _A_::$app->get('page');
      }
      if((!empty(_A_::$app->get('cat')))) {
        $url_prms['cat'] = _A_::$app->get('cat');
      }
      if((!empty(_A_::$app->get('mnf')))) {
        $url_prms['mnf'] = _A_::$app->get('mnf');
      }
      if((!empty(_A_::$app->get('ptrn')))) {
        $url_prms['ptrn'] = _A_::$app->get('ptrn');
      }

      if(!is_null(_A_::$app->get('back'))) {
        $back = _A_::$app->get('back');
        switch($back) {
          case 'matches':
            $back_url = _A_::$app->router()->UrlTo('matches');
            break;
          case 'cart':
            $back_url = _A_::$app->router()->UrlTo('cart');
            break;
          default:
            $back_url = _A_::$app->router()->UrlTo('shop' . DS . $back, $url_prms);
        }
      } else {
        $back_url = _A_::$app->router()->UrlTo('shop', $url_prms);
      }

      if(!is_null(_A_::$app->post('s')) && (!empty(_A_::$app->post('s')))) {
        $search = mysql_real_escape_string(strtolower(htmlspecialchars(trim(_A_::$app->post('s')))));
        $this->main->template->vars('search', _A_::$app->post('s'));
      }

      $allowed_samples = Model_Samples::allowedSamples($pid);
      $this->template->vars('allowed_samples', $allowed_samples);
      $this->template->vars('cart_enable', '_');
      $this->template->vars('back_url', $back_url);
      $this->main->view('product');
    }

    /**
     * @export
     */
    public function edit() {
      $this->edit_add_handling('edit', 'product/edit');
    }

    /**
     * @export
     */
    public function add() {
      Model_Product::getNewproduct();
      $this->edit_add_handling('add', 'product/add');
    }

    /**
     * @export
     */
    public function del() {
      $this->main->test_access_rights();
      $del_p_id = Model_Product::validData(_A_::$app->get('p_id'));
      if(!empty($del_p_id)) {

        $this->del_image($del_p_id);
        Model_Product::del_product($del_p_id);

        $prms = null;
        if(!is_null(_A_::$app->get('page'))) {
          $prms['page'] = _A_::$app->get('page');
        }
        if(!is_null(_A_::$app->get('cat'))) {
          $prms['cat'] = _A_::$app->get('cat');
        }
        $href = _A_::$app->router()->UrlTo('admin/home', $prms);
        exit ("<script>window.location.href='" . $href . "';</script>");
      }
    }
  }