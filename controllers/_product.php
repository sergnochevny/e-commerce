<?php

  class Controller_Product extends Controller_FormSimple {

    protected $id_name = 'pid';
    protected $form_title_add = 'NEW PRODUCT';
    protected $form_title_edit = 'MODIFY PRODUCT';

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
      $this->template->view_layout('filter/select');
    }

    private function images($data) {
      $not_image = _A_::$app->router()->UrlTo('upload/upload/not_image.jpg');
      $data['u_image1'] = empty($data['image1']) || !is_file('upload/upload/' . $data['image1']) ? '' : _A_::$app->router()->UrlTo('upload/upload/v_' . $data['image1']);
      $data['u_image2'] = empty($data['image2']) || !is_file('upload/upload/' . $data['image2']) ? '' : _A_::$app->router()->UrlTo('upload/upload/b_' . $data['image2']);
      $data['u_image3'] = empty($data['image3']) || !is_file('upload/upload/' . $data['image3']) ? '' : _A_::$app->router()->UrlTo('upload/upload/b_' . $data['image3']);
      $data['u_image4'] = empty($data['image4']) || !is_file('upload/upload/' . $data['image4']) ? '' : _A_::$app->router()->UrlTo('upload/upload/b_' . $data['image4']);
      $data['u_image5'] = empty($data['image5']) || !is_file('upload/upload/' . $data['image5']) ? '' : _A_::$app->router()->UrlTo('upload/upload/b_' . $data['image5']);
      $this->template->vars('not_image', $not_image);
      $this->template->vars('data', $data);
      $this->template->view_layout('images');
    }

    private function images_handling(&$data = null) {
      $method = _A_::$app->post('method');
      if($method == 'images.main') {
        if(!is_null(_A_::$app->post('idx'))) {
          $idx = _A_::$app->post('idx');
          $image = $data['image' . $idx];
          $data['image' . $idx] = $data['image1'];
          $data['image1'] = $image;
        }
      } elseif($method == 'images.upload') {
        $idx = !is_null(_A_::$app->post('idx')) ? _A_::$app->post('idx') : 1;
        $uploaddir = 'upload/upload/';
        $file = 't' . uniqid() . '.jpg';
        $ext = strtolower(substr($_FILES['uploadfile']['name'], strpos($_FILES['uploadfile']['name'], '.'), strlen($_FILES['uploadfile']['name']) - 1));
        $filetypes = ['.jpg', '.gif', '.bmp', '.png', '.jpeg'];

        if(!in_array($ext, $filetypes)) {
          $this->template->vars('error', 'Error format');
        } else {
          if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploaddir . $file)) {
            if(substr($data['image' . $idx], 0, 1) == 't') Model_Product::delete_img($data['image' . $idx]);
            $data['image' . $idx] = $file;
            Model_Product::convert_image($uploaddir, $file);
          } else {
            $this->template->vars('error', 'Upload error');
          }
        }
      } elseif($method == 'images.delete') {
        $idx = _A_::$app->post('idx');
        $data['image' . $idx] = '';
      }
      $this->images($data);
    }

    private function filters_handling(&$data = null) {
      $method = _A_::$app->post('method');
      if($method !== 'filter') {
        if(in_array($method, ['categories', 'colours', 'patterns'])) {
          $this->select_filter($method, array_keys($data[$method]));
        }
      } else {
        if(!is_null(_A_::$app->post('filter-type'))) {
          $method = _A_::$app->post('filter-type');
          $resporse = [];

          ob_start();
          Model_Product::get_filter_selected($method, $data);
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
          Model_Product::get_filter_selected($method, $data);
          $this->generate_filter($data, $method);
        }
      }
    }

    private function generate_filter($data, $type) {
      $filters = $data[$type];
      $this->template->vars('filters', $filters);
      $this->template->vars('filter_type', $type);
      $this->template->vars('destination', $type);
      $this->template->vars('title', 'Select ' . ucfirst($type));
      $this->template->view_layout('filter/filter');
    }

    private function generate_select($data, $selected) {
      $this->template->vars('selected', is_array($selected) ? $selected : [$selected]);
      $this->template->vars('data', is_array($data) ? $data : [$data]);
      $this->template->view_layout('select');
    }

    protected function load(&$data) {
      $data['pid'] = _A_::$app->get('pid');
      $data['metadescription'] = Model_Product::validData(_A_::$app->post('metadescription') ? _A_::$app->post('metadescription') : '');
      $data['metakeywords'] = Model_Product::validData(_A_::$app->post('metakeywords') ? _A_::$app->post('metakeywords') : '');
      $data['metatitle'] = Model_Product::validData(_A_::$app->post('metatitle') ? _A_::$app->post('metatitle') : '');
      $data['pname'] = Model_Product::validData(_A_::$app->post('pname') ? _A_::$app->post('pname') : '');
      $data['pnumber'] = Model_Product::validData(_A_::$app->post('pnumber')) ? _A_::$app->post('pnumber') : '';
      $data['width'] = Model_Product::validData(_A_::$app->post('width')) ? _A_::$app->post('width') : '';
      $data['priceyard'] = Model_Product::validData(_A_::$app->post('priceyard')) ? _A_::$app->post('priceyard') : '';
      $data['hideprice'] = Model_Product::validData(!is_null(_A_::$app->post('hideprice'))) ? _A_::$app->post('hideprice') : '';
      $data['dimensions'] = Model_Product::validData(_A_::$app->post('dimensions')) ? _A_::$app->post('dimensions') : '';
      $data['weight'] = Model_Product::validData(!is_null(_A_::$app->post('weight'))) ? _A_::$app->post('weight') : '';
      $data['manufacturerId'] = Model_Product::validData(_A_::$app->post('manufacturerId')) ? _A_::$app->post('manufacturerId') : '';
      $data['sdesc'] = Model_Product::validData(_A_::$app->post('sdesc') ? _A_::$app->post('sdesc') : '');
      $data['ldesc'] = Model_Product::validData(_A_::$app->post('ldesc') ? _A_::$app->post('ldesc') : '');;
      $data['weight_id'] = Model_Product::validData(_A_::$app->post('weight_id') ? _A_::$app->post('weight_id') : '');
      $data['colours'] = !is_null(_A_::$app->post('colours')) ? _A_::$app->post('colours') : [];
      $data['colours_select'] = !is_null(_A_::$app->post('colours_select')) ? _A_::$app->post('colours_select') : [];
      $data['categories'] = !is_null(_A_::$app->post('categories')) ? _A_::$app->post('categories') : [];
      $data['categories_select'] = !is_null(_A_::$app->post('categories_select')) ? _A_::$app->post('categories_select') : [];
      $data['patterns'] = !is_null(_A_::$app->post('patterns')) ? _A_::$app->post('patterns') : [];
      $data['patterns_select'] = !is_null(_A_::$app->post('patterns_select')) ? _A_::$app->post('patterns_select') : [];
      $data['specials'] = Model_Product::validData(!is_null(_A_::$app->post('specials')) ? _A_::$app->post('specials') : 0);
      $data['pvisible'] = Model_Product::validData(_A_::$app->post('pvisible') ? _A_::$app->post('pvisible') : 0);
      $data['best'] = Model_Product::validData(!is_null(_A_::$app->post('best')) ? _A_::$app->post('best') : 0);
      $data['piece'] = !is_null(_A_::$app->post('piece')) ? _A_::$app->post('piece') : 0;
      $data['whole'] = !is_null(_A_::$app->post('whole')) ? _A_::$app->post('whole') : 0;
      $data['stock_number'] = Model_Product::validData(_A_::$app->post('stock_number') ? _A_::$app->post('stock_number') : '');
      $data['image1'] = Model_Product::validData(_A_::$app->post('image1') ? _A_::$app->post('image1') : '');
      $data['image2'] = Model_Product::validData(_A_::$app->post('image2') ? _A_::$app->post('image2') : '');
      $data['image3'] = Model_Product::validData(_A_::$app->post('image3') ? _A_::$app->post('image3') : '');
      $data['image4'] = Model_Product::validData(_A_::$app->post('image4') ? _A_::$app->post('image4') : '');
      $data['image5'] = Model_Product::validData(_A_::$app->post('image5') ? _A_::$app->post('image5') : '');
      $data['inventory'] = !is_null(_A_::$app->post('inventory')) ? _A_::$app->post('inventory') : 0;
    }

    protected function validate(&$data, &$error) {

      if(
        empty($data['pnumber']) || empty($data['pname']) || empty($data['priceyard']) ||
        empty($data['image1'])
      ) {
        $error = [];
        if(empty($data['pnumber'])) $error[] = 'Identify Product Number field !';
        if(empty($data['pname'])) $error[] = 'Identify Product Name field !';
        if(empty($data['priceyard']) || ($data['priceyard'] == 0)) $error[] = 'Identify Price field !';
        if(empty($data['image1'])) $error[] = 'Identify Main Image!';
        $this->template->vars('error', $error);
        return false;
      }
      return true;
    }

    protected function form_handling(&$data = null) {
      if(_A_::$app->request_is_post()) {
        if(!is_null(_A_::$app->post('method'))) {
          if(explode('.', _A_::$app->post('method'))[0] == 'images') exit($this->images_handling($data));
          exit($this->filters_handling($data));
        }
      }
      return true;
    }

    protected function before_form_layout(&$data = null) {

      $data['manufacturers'] = Model_Product::get_manufacturers();
      foreach(['categories', 'colours', 'patterns'] as $type) {
        ob_start();
        Model_Product::get_filter_selected($type, $data);
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
      $this->images($data);
      $images = ob_get_contents();
      ob_end_clean();
      $this->template->vars('images', $images);
    }

    /**
     * @export
     */
    public function view() {
      $pid = _A_::$app->get('pid');
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
        $search = strtolower(htmlspecialchars(trim(_A_::$app->post('s'))));
        $this->main->template->vars('search', _A_::$app->post('s'));
      }

      $allowed_samples = Model_Samples::allowedSamples($pid);
      $this->template->vars('allowed_samples', $allowed_samples);
      $this->template->vars('cart_enable', '_');
      $this->template->vars('back_url', $back_url);
      $this->main->view('view');
    }

  }