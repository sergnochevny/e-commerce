<?php

  class Controller_Product extends Controller_Controller {

    private function save_product($url, $new = false) {
      include('include/post_edit_db.php');
      if(!empty(_A_::$app->get('p_id'))) {
        $pid = _A_::$app->get('p_id');
        if(!is_null(_A_::$app->post('build_categories'))) {
          $build_categories = _A_::$app->post('categories');
          $categories = _A_::$app->post('category');
          $data = Model_Product::getProductBuildCategories($build_categories, $categories);
          foreach($data as $cat_id => $category) {
            $this->template->vars('cat_id', $cat_id);
            $this->template->vars('category', $category);
            $this->template->view_layout('block_category');
          }
        } else {
          $action_url = _A_::$app->router()->UrlTo($url, ['p_id' => $pid]);
          $this->template->vars('action_url', $action_url);

          $data = ['weight_id' => $post_weight_cat, 'sd_cat' => $post_categories, 'pvisible' => $post_vis, 'metadescription' => $post_desc, 'p_id' => $p_id, 'Meta_Description' => $post_desc, 'Meta_Keywords' => $post_mkey, 'Product_name' => $post_tp_name, 'Product_number' => $post_product_num, 'Width' => $post_width, 'Price_Yard' => $post_p_yard, 'Stock_number' => $post_st_nom, 'Dimensions' => $post_dimens, 'Current_inventory' => $post_curret_in, 'Specials' => $post_special, 'Weight' => $post_weight_cat, 'Manufacturer' => $post_manufacturer, 'New_Manufacturer' => $New_Manufacturer, 'Colours' => $p_colors, 'New_Colour' => $post_new_color, 'Pattern_Type' => $patterns, 'New_Pattern' => $pattern_type, 'Short_description' => $post_short_desk, 'Long_description' => $post_Long_description, 'visible' => $post_hide_prise, 'best' => $best, 'piece' => $piece, 'whole' => $whole];

          if(empty($post_product_num{0}) || empty($post_tp_name{0}) || empty($post_p_yard{0})) {

            $error = [];
            if(empty($post_product_num{0}))
              $error[] = 'Identify Product Number field !';
            if(empty($post_tp_name{0}))
              $error[] = 'Identify Product Name field !';
            if(empty($post_p_yard{0}))
              $error[] = 'Identify Price field !';
            $this->template->vars('error', $error);
            $this->edit_form($pid, $data);
          } else {
            $result = Model_Product::save($p_id, $post_categories, $patterns, $p_colors, $post_manufacturer, $New_Manufacturer, $post_new_color, $pattern_type, $post_weight_cat, $post_special, $post_curret_in, $post_dimens, $post_hide_prise, $post_st_nom, $post_p_yard, $post_width, $post_product_num, $post_vis, $post_mkey, $post_desc, $post_Long_description, $post_tp_name, $post_short_desk, $best, $piece, $whole);

            if($result) {
              $this->template->vars('warning', ["Product Data saved successfully!"]);
              if($new) {
                Model_Product::getNewproduct();
                $pid = _A_::$app->get('p_id');
                $action_url = _A_::$app->router()->UrlTo($url, ['p_id' => $pid]);
                $this->template->vars('action_url', $action_url);
                $this->edit_form($pid);
              } else $this->edit_form($pid, $data);
            } else {
              $this->template->vars('error', [mysql_error()]);
              $this->edit_form($pid, $data);
            };
          }
        }
      } else {
        $this->template->vars('error', ["Error! Not product id identity"]);
        if($new) {
          Model_Product::getNewproduct();
          $pid = _A_::$app->get('p_id');
          $action_url = _A_::$app->router()->UrlTo($url, ['p_id' => $pid]);
          $this->template->vars('action_url', $action_url);
          $this->edit_form($pid);
        } else $this->edit_form();
      }
    }

    private function edit_form($pid, $data = null) {
      if(isset($data)) {
        $post_categories = $data['sd_cat'];
        $post_manufacturer = $data['Manufacturer'];
        $p_colors = $data['Colours'];
        $patterns = $data['Pattern_Type'];
        $cats = Model_Product::getProductCatInfo($post_categories, $post_manufacturer, $p_colors, $patterns);
        $data['sd_cat'] = $cats['sl_cat'];
        $data['Manufacturer'] = $cats['sl_cat2'];
        $data['Colours'] = $cats['sl_cat3'];
        $data['Pattern_Type'] = $cats['sl_cat4'];

        $categories = array_keys($post_categories);
        $data['categories'] = Model_Product::getProductBuildCategories($post_categories, $categories);
      } else $data = Model_Product::getProductInfo($pid);
      ob_start();
      foreach($data['categories'] as $cat_id => $category) {
        $this->template->vars('cat_id', $cat_id);
        $this->template->vars('category', $category);
        $this->template->view_layout('block_category');
      }
      $categories = ob_get_contents();
      ob_end_clean();
      $data['categories'] = $categories;

      ob_start();
      $cimage = new Controller_Image($this->main);
      $cimage->modify();
      $m_images = ob_get_contents();
      ob_end_clean();

      $this->template->vars('modify_images', $m_images);
      $this->template->vars('data', $data);
      $this->main->view_layout('edit_form');
    }

    /**
     * @param $url
     * @param $template
     */
    private function product_form($url, $template) {
      $pid = _A_::$app->get('p_id');
      $action_url = _A_::$app->router()->UrlTo($url, ['p_id' => $pid]);
      $this->template->vars('action_url', $action_url);
      $prms = null;
      if(!empty(_A_::$app->get('page'))) {
        $prms['page'] = _A_::$app->get('page');
      }
      if(!empty(_A_::$app->get('cat'))) {
        $prms['cat'] = _A_::$app->get('cat');
      }
      $back_url = _A_::$app->router()->UrlTo('admin/home', $prms);
      ob_start();
      $this->edit_form($pid);
      $edit_form = ob_get_contents();
      ob_end_clean();

      $this->template->vars('back_url', $back_url);
      $this->main->template->vars('edit_form', $edit_form);
      $this->main->view_admin($template);
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
      if(!is_null(_A_::$app->session('cart')['ship'])) {
        $shipping = (int)_A_::$app->session('cart')['ship'];
      } else {
        $shipping = DEFAULT_SHIPPING;
        $_cart = _A_::$app->session('cart');
        $_cart['ship'] = $shipping;
        _A_::$app->setSession('cart', $_cart);
      }

      if(!is_null(_A_::$app->get('cart')['ship_roll'])) {
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
      $this->main->test_access_rights();
      if(_A_::$app->request_is_post()) {
        $this->save_product('product/edit');
      } else {
        $this->product_form('product/edit', 'edit');
      }
    }

    /**
     * @export
     */
    public function add() {
      $this->main->test_access_rights();
      if(_A_::$app->request_is_post()) {
        $this->save_product('product/add', true);
      } else {
        Model_Product::getNewproduct();
        $this->product_form('product/add', 'add');
      }
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