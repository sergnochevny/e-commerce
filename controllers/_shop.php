<?php

  class Controller_Shop extends Controller_Controller {

    protected function search_fields($view = false) {
      return [
        'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber',
        'a.piece', 'a.best', 'a.specials', 'b.cid',
        'c.id', 'd.id', 'e.id'
      ];
    }

    protected function build_search_filter(&$filter, $view = false) {
      $search = null;
      $type = isset($filter['type']) ? $filter['type'] : null;
      $res = parent::build_search_filter($filter, $view);

      $filter['hidden']['a.pnumber'] = 'null';
      $filter['hidden']['a.pvisible'] = '1';
      $filter['hidden']['a.image1'] = 'null';

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
        unset($filter['b.cid']);
        unset($res['b.cid']);
        $filter['hidden']['b.cid'] = $cid;
        $res['hidden']['b.cid'] = $cid;
      }
      if(!empty(_A_::$app->get('ptrn'))) {
        $ptrn_id = _A_::$app->get('ptrn');
        if($ptrn = Model_Patterns::get_by_id($ptrn_id)) $ptrn_name = $ptrn['pattern'];
        $this->template->vars('ptrn_name', isset($ptrn_name) ? $ptrn_name : null);
        unset($filter['d.id']);
        unset($res['d.id']);
        $filter['hidden']['d.id'] = $ptrn_id;
        $res['hidden']['d.id'] = $ptrn_id;
      }
      if(!empty(_A_::$app->get('mnf'))) {
        $mnf_id = _A_::$app->get('mnf');
        if($mnf = Model_Manufacturers::get_by_id($mnf_id)) $mnf_name = $mnf['manufacturer'];
        $this->template->vars('mnf_name', isset($mnf_name) ? $mnf_name : null);
        unset($filter['e.id']);
        unset($res['e.id']);
        $filter['hidden']['e.id'] = $mnf_id;
        $res['hidden']['e.id'] = $mnf_id;
      }
      if(!empty(_A_::$app->get('clr'))) {
        $clr_id = _A_::$app->get('clr');
        if($clr = Model_Colours::get_by_id($clr_id)) $colour_name = $clr['colour'];
        $this->template->vars('colour_name', isset($colour_name) ? $colour_name : null);
        unset($filter['c.id']);
        unset($res['c.id']);
        $filter['hidden']['c.id'] = $clr_id;
        $res['hidden']['c.id'] = $clr_id;
      }
      if(isset($type)) {
        $filter['type'] = $type;
        $res['type'] = $type;
        switch($type) {
          case 'best':
            unset($filter['a.best']);
            unset($res['a.best']);
            $filter['hidden']['a.best'] = '1';
            $res['hidden']['a.best'] = '1';
            break;
          case 'specials':
            unset($filter['a.specials']);
            unset($res['a.specials']);
            $filter['hidden']['a.specials'] = '1';
            $res['hidden']['a.specials'] = '1';
            break;
        }
      }
      return $res;
    }

    protected function build_order(&$sort, $view = false) {
      $type = isset($sort['type']) ? $sort['type'] : null;
      unset($sort['type']);
      if(isset($type)) {
        switch($type) {
          case 'last':
            $sort['a.dt'] = 'desc';
            $sort['a.pid'] = 'desc';
            break;
          case 'popular':
            $sort['a.popular'] = 'desc';
            break;
          case 'bestsellers':
            $sort['s'] = 'desc';
            break;
          default:
            $sort['a.pid'] = 'desc';
        }
      } else {
        if(!empty(_A_::$app->get('cat'))) {
          $sort['fabrix_product_categories.display_order'] = 'asc';
        } else  $sort['a.pid'] = 'desc';
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
      $type = isset($search_data['type']) ? $search_data['type'] : null;
      if(isset($type)) $this->template->vars('action', _A_::$app->router()->UrlTo($this->controller . DS . $type));
    }

    protected function after_get_list(&$rows, $view = false, $type = null) {
      $url_prms = null;
      if(!empty(_A_::$app->get('page'))) $url_prms['page'] = _A_::$app->get('page');
      if(!empty(_A_::$app->get('cat'))) $url_prms['cat'] = _A_::$app->get('cat');
      if(!empty(_A_::$app->get('mnf'))) $url_prms['mnf'] = _A_::$app->get('mnf');
      if(!empty(_A_::$app->get('ptrn'))) $url_prms['ptrn'] = _A_::$app->get('ptrn');
      if(!empty(_A_::$app->get('clr'))) $url_prms['clr'] = _A_::$app->get('clr');
      if(isset($type)) $url_prms['back'] = $type;
      $this->template->vars('url_prms', $url_prms);
    }

    protected function get_list_by_type($type = 'last', $max_count_items = 50) {
      $filter['type'] = $type;
      $sort['type'] = $type;
      $search_form = $this->build_search_filter($filter);
      $this->build_order($sort);
      $page = !empty(_A_::$app->get('page')) ? _A_::$app->get('page') : 1;
      $per_page = $this->per_page;
      $total = Model_Shop::get_total_count($filter);
      if($total > $max_count_items) $total = $max_count_items;
      if($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
      if($page <= 0) $page = 1;
      $start = (($page - 1) * $per_page);
      $limit = $per_page;
      if($total < ($start + $per_page)) $limit = $total - $start;
      $rows = Model_Shop::get_list($start, $limit, $res_count_rows, $filter, $sort);
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
      parent::index(false);
    }

    /**
     * @export
     */
    public function last() {
      $this->template->vars('cart_enable', '_');
      $this->main->template->vars('page_title', "What's New");
      ob_start();
      $this->get_list_by_type('last', 50);
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
      $this->get_list_by_type('specials', 360);
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
      $this->get_list_by_type('popular', 360);
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
      $this->get_list_by_type('best', 360);
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
      $this->get_list_by_type('bestsellers', 360);
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
        case 'bestsellers':
          $this->widget_products('bestsellers', 6, 5);
          break;
        case 'carousel':
          $this->widget_products('carousel', 0, 30, 'widget_new_products_carousel');
          break;
        case 'bsells_horiz':
          $this->widget_products('bestsellers', 0, 6, 'widget_bsells_products_horiz');
      }
    }

    /**
     * @export
     */
    public function product() {
      $pid = _A_::$app->get('pid');
      $data = Model_Shop::get_product($pid);
      ob_start();
      if($data['rSystemDiscount'] > 0) {
        $field_name = "Sale price:";
        $field_value = sprintf("%s<br><strong>%s</strong>", $data['sPriceDiscount'], $data['srDiscountPrice']);
        $this->template->vars('field_name', $field_name);
        $this->template->vars('field_value', $field_value);
        $this->template->view_layout('product/discount');
      }

      if($data['bDiscount']) {
        if($data['bSystemDiscount']) {
          $field_name = "Extra disc. price:";
        } else {
          $field_name = "Sale price:";
        }
        if($data['bSystemDiscount']) {
          $field_value = sprintf("Reduced a further %s.<br><strong>%s</strong>", $data['sDiscount'], $data['sDiscountPrice']);
        } else {
          $field_value = sprintf("Reduced by %s.<br><strong>%s</strong>", $data['rDiscount'], $data['sDiscountPrice']);
        }
        $this->template->vars('field_name', $field_name);
        $this->template->vars('field_value', $field_value);
        $this->template->view_layout('product/discount');
      }

      if(strlen($data['sSystemDiscount']) > 0) {
        $field_name = 'Shipping discount:';
        $field_value = $data['sSystemDiscount'];
        $this->template->vars('field_name', $field_name);
        $this->template->vars('field_value', $field_value);
        $this->template->view_layout('product/discount');
      }

      if(isset($data['next_change']) && $data['next_change']) {
        $field_name = 'Sale ends in:';
        $field_value = $data['time_rem'];
        $this->template->vars('field_name', $field_name);
        $this->template->vars('field_value', $field_value);
        $this->template->view_layout('product/discount');
      }
      $discount_info = ob_get_contents();
      ob_end_clean();
      $this->template->vars('discount_info', $discount_info);

      $url_prms = null;
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
      if((!empty(_A_::$app->get('clr')))) {
        $url_prms['clr'] = _A_::$app->get('clr');
      }

      if(!is_null(_A_::$app->get('back'))) {
        $back = _A_::$app->get('back');
        if(in_array($back, ['matches', 'cart', 'shop', 'favorites', ''])) $back_url = _A_::$app->router()->UrlTo($back, $url_prms);
        elseif(in_array($back, ['bestsellers', 'last', 'popular', 'specials'])) {
          $back_url = _A_::$app->router()->UrlTo('shop' . DS . $back, $url_prms);
        } else {
          $back_url = _A_::$app->router()->UrlTo(base64_decode(urldecode($back)), $url_prms);;
        }
      } else {
        $back_url = _A_::$app->router()->UrlTo('shop', $url_prms);
      }

      if(!is_null(_A_::$app->post('s')) && (!empty(_A_::$app->post('s')))) {
        $search = strtolower(htmlspecialchars(trim(_A_::$app->post('s'))));
        $this->main->template->vars('search_str', _A_::$app->post('s'));
      }

      $this->template->vars('in_favorites', Controller_Favorites::product_in($pid));
      $this->template->vars('data', $data);
      $allowed_samples = Model_Samples::allowedSamples($pid);
      $this->template->vars('allowed_samples', $allowed_samples);
      $this->template->vars('cart_enable', '_');
      $this->template->vars('back_url', $back_url);
      $this->main->view('product/view');
    }

    public function index($required_access = true) { }

    public function view() { }

  }