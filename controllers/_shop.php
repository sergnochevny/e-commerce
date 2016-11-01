<?php

  class Controller_Shop extends Controller_Controller {

//    protected function show_category_list() {
//      $items = Model_Tools::get_items_for_menu('all');
//      $this->template->vars('items', $items, true);
//      ob_start();
//      $list = ob_get_contents();
//      $this->template->vars('list', $list, true);
//      ob_end_clean();
//      ob_start();
//      $this->template->view_layout('categories', 'menu');
//      $categories = ob_get_contents();
//      ob_end_clean();
//      $this->main->template->vars('categories', $categories);
//    }

    protected function search_fields($view = false) {
      return [
        'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber',
        'a.piece', 'a.best', 'a.specials', 'b.cid',
        'c.id', 'd.id', 'e.id'
      ];
    }

    protected function build_search_filter(&$filter, $view = false) {
      $search = null;
      $res = parent::build_search_filter($filter, $view);
      if(!isset($res['pname']) && !is_null(_A_::$app->post('s')) && (!empty(_A_::$app->post('s')))) {
        $search = strtolower(htmlspecialchars(trim(_A_::$app->post('s'))));
        $this->main->template->vars('search_str', _A_::$app->post('s'));
        $res['a.pname'] = _A_::$app->post('s');
        $filter['a.pname'] = $search;
      }
      if(!empty(_A_::$app->get('cat'))) {
        $cid = _A_::$app->get('cat');
        if($category = Model_Categories::get_by_id($cid)) $category_name = $category['cname'];
        $this->main->template->vars('category_name', isset($category_name) ? $category_name : null);
        $filter['hidden']['b.cid'] = $cid;
        unset($filter['b.cid']);
      }
      if(!empty(_A_::$app->get('ptrn'))) {
        $ptrn_id = _A_::$app->get('ptrn');
        if($ptrn = Model_Patterns::get_by_id($ptrn_id)) $ptrn_name = $ptrn['pattern'];
        $this->template->vars('ptrn_name', isset($ptrn_name) ? $ptrn_name : null);
        $filter['hidden']['d.id'] = $ptrn_id;
        unset($filter['d.id']);
      }
      if(!empty(_A_::$app->get('mnf'))) {
        $mnf_id = _A_::$app->get('mnf');
        if($mnf = Model_Manufacturers::get_by_id($mnf_id)) $mnf_name = $mnf['manufacturer'];
        $this->template->vars('mnf_name', isset($mnf_name) ? $mnf_name : null);
        $filter['hidden']['e.id'] = $mnf_id;
        unset($filter['e.id']);
      }
      return $res;
    }

    protected function build_order(&$sort, $view = false) {
      if(!empty(_A_::$app->get('cat'))) {
        $sort['b.display_order'] = 'asc';
      } else {
        $sort['a.pid'] = 'desc';
      }
    }

    protected function before_search_form_layout(&$search_data, $view = false) {
      $categories = [];
      $rows = Model_Categories::get_list(0, 0, $res_count);
      foreach($rows as $row) $categories[$row['cid']] = $row['cname'];
      $patterns = [];
      $rows = Model_Patterns::get_list(0, 0, $res_count);
      foreach($rows as $row) $patterns[$row['id']] = $row['pattern'];
      $colours = [];
      $rows = Model_Colours::get_list(0, 0, $res_count);
      foreach($rows as $row) $colours[$row['id']] = $row['colour'];
      $manufacturers = [];
      $rows = Model_Manufacturers::get_list(0, 0, $res_count);
      foreach($rows as $row) $manufacturers[$row['id']] = $row['manufacturer'];

      $search_data['categories'] = $categories;
      $search_data['patterns'] = $patterns;
      $search_data['colours'] = $colours;
      $search_data['manufacturers'] = $manufacturers;
    }

    protected function after_get_list(&$rows, $view = false, $type = null) {
      $url_prms = null;
      if(!empty(_A_::$app->get('page'))) $url_prms['page'] = _A_::$app->get('page');
      if(!empty(_A_::$app->get('cat'))) $url_prms['cat'] = _A_::$app->get('cat');
      if(!empty(_A_::$app->get('mnf'))) $url_prms['mnf'] = _A_::$app->get('mnf');
      if(!empty(_A_::$app->get('ptrn'))) $url_prms['ptrn'] = _A_::$app->get('ptrn');
      if(isset($type)) $url_prms['back'] = $type;
      $this->template->vars('url_prms', $url_prms);
    }

    protected function product_list_by_type($type = 'last', $max_count_items = 50) {
      $search_form = $this->build_search_filter($filter);
      $this->build_order($sort);
      $page = !empty(_A_::$app->get('page')) ? _A_::$app->get('page') : 1;
      $per_page = 12;
      $total = Model_Shop::get_count_by_type($type, $filter);
      if($total > $max_count_items) $total = $max_count_items;
      if($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
      if($page <= 0) $page = 1;
      $start = (($page - 1) * $per_page);
      $limit = $per_page;
      if($total < ($start + $per_page)) $limit = $total - $start;
      $rows = Model_Shop::get_list_by_type($type, $start, $limit, $res_count_rows, $filter, $sort);
      $this->after_get_list($rows, false, $type);
      if(isset($filter['active'])) $search_form['active'] = $filter['active'];
      $this->search_form($search_form);
      $this->template->vars('rows', $rows);
      $this->template->vars('sort', $sort);
      ob_start();
      $this->template->view_layout($type);
      $rows = ob_get_contents();
      ob_end_clean();
      $this->template->vars('count_rows', $res_count_rows);
      $this->template->vars('list', $rows);
      (new Controller_Paginator($this->main))->paginator($total, $page, 'shop' . DS . $type, $per_page);
      $this->before_list_layout();
      $this->main->view_layout('list');
    }

    protected function widget_products($type, $start, $limit, $layout = 'list') {
      $rows = Model_Shop::get_widget_list_by_type($type, $start, $limit, $row_count);
      $this->template->vars('rows', $rows);
      $this->template->view_layout('widget/' . $layout);
    }

    /**
     * @export
     */
    public function shop() {
      $this->template->vars('cart_enable', '_');
      $this->main->template->vars('page_title', "Product Catalog");
      $this->index(false);
    }

    /**
     * @export
     */
    public function last() {
      $this->template->vars('cart_enable', '_');
      $this->main->template->vars('page_title', "What's New");
      ob_start();
      $this->product_list_by_type('last', 50);
      $list = ob_get_contents();
      ob_end_clean();
      if(_A_::$app->request_is_ajax()) exit($list);
      $this->template->vars('list', $list);
      $this->main->view('shop');
    }

    /**
     * @export
     */
    public function specials() {
      $this->template->vars('cart_enable', '_');
      $page_title = "Limited time Specials.";
      $annotation = 'All specially priced items are at their marked down prices for a LIMITED TIME ONLY, after which they revert to their regular rates.<br>All items available on a FIRST COME, FIRST SERVED basis only.';
      $this->main->template->vars('page_title', $page_title);
      $this->main->template->vars('annotation', $annotation);
      ob_start();
      $this->product_list_by_type('specials', 360);
      $list = ob_get_contents();
      ob_end_clean();
      if(_A_::$app->request_is_ajax()) exit($list);
      $this->template->vars('list', $list);
      $this->main->view('shop');
    }

    /**
     * @export
     */
    public function popular() {
      $this->template->vars('cart_enable', '_');
      $this->main->template->vars('page_title', 'Popular Textile');
      ob_start();
      $this->product_list_by_type('popular', 360);
      $list = ob_get_contents();
      ob_end_clean();
      if(_A_::$app->request_is_ajax()) exit($list);
      $this->template->vars('list', $list);
      $this->main->view('shop');
    }

    /**
     * @export
     */
    public function best() {
      $this->template->vars('cart_enable', '_');
      $this->main->template->vars('page_title', 'Best Textile');
      ob_start();
      $this->product_list_by_type('best', 360);
      $list = ob_get_contents();
      ob_end_clean();
      if(_A_::$app->request_is_ajax()) exit($list);
      $this->template->vars('list', $list);
      $this->main->view('shop');
    }

    /**
     * @export
     */
    public function bestsellers() {
      $this->template->vars('cart_enable', '_');
      $this->main->template->vars('page_title', 'Best Sellers');
      ob_start();
      $this->product_list_by_type('bsells', 360);
      $list = ob_get_contents();
      ob_end_clean();
      if(_A_::$app->request_is_ajax()) exit($list);
      $this->template->vars('list', $list);
      $this->main->view('shop');
    }

//    public function modify_products_images() {
//      $c_image = new Controller_Image();
//      $per_page = 12;
//      $page = 1;
//
//      $total = Model_Shop::get_total_count();
//      $count = 0;
//      while($page <= ceil($total / $per_page)) {
//        $start = (($page++ - 1) * $per_page);
//        $rows = Model_Shop::get_list($start, $per_page);
//        foreach($rows as $row) {
//          for($i = 1; $i < 5; $i++) {
//            $fimage = $row['image' . $i];
//            if(isset($fimage) && is_string($fimage) && strlen($fimage) > 0) {
//              $c_image->modify_products($fimage);
//            }
//          }
//        }
//        $count += count($rows);
//        echo $count;
//      }
//    }

    /**
     * @export
     */
    public function widget() {
      switch(_A_::$app->get('type')) {
        case 'popular':
          $this->widget_products('popular', 0, 5);
          break;
        case 'new':
          $this->widget_products('new', 0, 5);
          break;
        case 'best':
          $this->widget_products('best', 0, 5);
          break;
        case 'bsells':
          $this->widget_products('bsells', 6, 5);
          break;
        case 'carousel':
          $this->widget_products('carousel', 0, 30, 'widget_new_products_carousel');
          break;
        case 'bsells_horiz':
          $this->widget_products('bsells', 0, 6, 'widget_bsells_products_horiz');
      }
    }

    /**
     * @export
     */
    public function product() {
      $pid = _A_::$app->get('pid');
      $data = Model_Shop::get_product($pid);
      if(Controller_Matches::product_in($data['pid'])) $this->template->vars('in_matches', '1');

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
      $hide_price = $data['hideprice'];
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
      $data['format_price'] = $format_price;

      ob_start();
      if($rSystemDiscount > 0) {
        $tmp = Model_Price::getPrintPrice($rDiscountPrice, $sDiscountPrice, $inventory, $piece);
        $field_name = "Sale price:";
        $field_value = sprintf("%s<br><strong>%s</strong>", $sPriceDiscount, $sDiscountPrice);
        $this->template->vars('field_name', $field_name);
        $this->template->vars('field_value', $field_value);
        $this->template->view_layout('product/discount');
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
        $this->template->view_layout('product/discount');
      }

      if(strlen($sSystemDiscount) > 0) {
        $field_name = 'Shipping discount:';
        $field_value = $sSystemDiscount;
        $this->template->vars('field_name', $field_name);
        $this->template->vars('field_value', $field_value);
        $this->template->view_layout('product/discount');
      }

      if(count($discountIds) > 0) {
        if(Model_Price::getNextChangeInDiscoutDate($discountIds) > 0) {
          $field_name = 'Sale ends in:';
          $field_value = Model_Price::displayDiscountTimeRemaining($discountIds);
          $this->template->vars('field_name', $field_name);
          $this->template->vars('field_value', $field_value);
          $this->template->view_layout('product/discount');
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
      if($in_cart) $this->template->vars('in_cart', '1');

      $url_prms = [];
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
        if(in_array($back, ['matches', 'cart', 'shop', ''])) $back_url = _A_::$app->router()->UrlTo($back, $url_prms);
        else $back_url = _A_::$app->router()->UrlTo('shop' . DS . $back, $url_prms);
      } else {
        $back_url = _A_::$app->router()->UrlTo('shop', $url_prms);
      }

      if(!is_null(_A_::$app->post('s')) && (!empty(_A_::$app->post('s')))) {
        $search = strtolower(htmlspecialchars(trim(_A_::$app->post('s'))));
        $this->main->template->vars('search_str', _A_::$app->post('s'));
      }

      $this->template->vars('data', $data);
      $this->template->vars('sys_hide_price', $sys_hide_price);

      $allowed_samples = Model_Samples::allowedSamples($pid);
      $this->template->vars('allowed_samples', $allowed_samples);
      $this->template->vars('cart_enable', '_');
      $this->template->vars('back_url', $back_url);
      $this->main->view('product/view');
    }

  }