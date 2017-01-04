<?php

  class Controller_Shop extends Controller_Controller {

    protected $id_field = 'pid';
    protected $name_field = 'pname';
    protected $data_field = 'dt';

    protected function search_fields($view = false) {
      return [
        'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber',
        'a.piece', 'a.best', 'a.specials', 'b.cid',
        'c.id', 'd.id', 'e.id', 'a.priceyard'
      ];
    }

    protected function build_search_filter(&$filter, $view = false) {
      $search = null;
      $type = isset($filter['type']) ? $filter['type'] : null;
      $res = parent::build_search_filter($filter, $view);
      _A_::$app->setSession('sidebar_idx', 0);
      $filter['hidden']['a.pnumber'] = 'null';
      if(!isset($filter['hidden']['a.priceyard']) && !isset($filter['a.priceyard'])) $filter['hidden']['a.priceyard'] = '0.00';
      $filter['hidden']['a.pvisible'] = '1';
      $filter['hidden']['a.image1'] = 'null';

      if(!isset($res['pname']) && !is_null(_A_::$app->post('s')) && (!empty(_A_::$app->post('s')))) {
        $search = strtolower(htmlspecialchars(trim(_A_::$app->post('s'))));
        $this->main->template->vars('search_str', _A_::$app->post('s'));
        $res['a.pname'] = _A_::$app->post('s');
        $filter['a.pname'] = $search;
      }
      if(!empty(_A_::$app->get('mnf'))) {
        $mnf_id = _A_::$app->get('mnf');
        if($mnf = Model_Manufacturers::get_by_id($mnf_id)) $mnf_name = $mnf['manufacturer'];
        $this->template->vars('mnf_name', isset($mnf_name) ? $mnf_name : null);
        unset($filter['e.id']);
        unset($res['e.id']);
        $filter['hidden']['e.id'] = $mnf_id;
        $res['hidden']['e.id'] = $mnf_id;
        _A_::$app->setSession('sidebar_idx', 1);
      }
      if(!empty(_A_::$app->get('cat'))) {
        $cid = _A_::$app->get('cat');
        if($category = Model_Categories::get_by_id($cid)) $category_name = $category['cname'];
        $this->main->template->vars('category_name', isset($category_name) ? $category_name : null);
        unset($filter['b.cid']);
        unset($res['b.cid']);
        $filter['hidden']['b.cid'] = $cid;
        $res['hidden']['b.cid'] = $cid;
        _A_::$app->setSession('sidebar_idx', 2);
      }
      if(!empty(_A_::$app->get('ptrn'))) {
        $ptrn_id = _A_::$app->get('ptrn');
        if($ptrn = Model_Patterns::get_by_id($ptrn_id)) $ptrn_name = $ptrn['pattern'];
        $this->template->vars('ptrn_name', isset($ptrn_name) ? $ptrn_name : null);
        unset($filter['d.id']);
        unset($res['d.id']);
        $filter['hidden']['d.id'] = $ptrn_id;
        $res['hidden']['d.id'] = $ptrn_id;
        _A_::$app->setSession('sidebar_idx', 3);
      }
      if(!empty(_A_::$app->get('clr'))) {
        $clr_id = _A_::$app->get('clr');
        if($clr = Model_Colors::get_by_id($clr_id)) $color_name = $clr['color'];
        $this->template->vars('color_name', isset($color_name) ? $color_name : null);
        unset($filter['c.id']);
        unset($res['c.id']);
        $filter['hidden']['c.id'] = $clr_id;
        $res['hidden']['c.id'] = $clr_id;
        _A_::$app->setSession('sidebar_idx', 4);
      }
      if(!is_null(_A_::$app->get('prc'))) {
        $prc_id = _A_::$app->get('prc');
        if($prc = Model_Prices::get_by_id($prc_id)) {
          unset($filter['hidden']['a.priceyard']);
          $filter['hidden']['a.priceyard']['from'] = (isset($prc['min_price']) ? $prc['min_price'] : null);
          $filter['hidden']['a.priceyard']['to'] = (isset($prc['max_price']) ? $prc['max_price'] : null);
          $this->template->vars('prc_from', isset($filter['hidden']['a.priceyard']['from']) ? $filter['hidden']['a.priceyard']['from'] : null);
          $this->template->vars('prc_to', isset($filter['hidden']['a.priceyard']['to']) ? $filter['hidden']['a.priceyard']['to'] : null);
        };
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
            _A_::$app->setSession('sidebar_idx', 6);
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
        } else {
          $sort['b.displayorder'] = 'asc';
          $sort['fabrix_product_categories.display_order'] = 'asc';
        };
      }
    }

    protected function before_search_form_layout(&$search_data, $view = false) {
      $categories = [];
      $filter = null;
      $sort = ['a.cname' => 'asc'];
      $rows = Model_Categories::get_list(0, 0, $res_count, $filter, $sort);
      foreach($rows as $row) $categories[$row['cid']] = $row['cname'];
      $patterns = [];
      $sort = ['a.pattern' => 'asc'];
      $rows = Model_Patterns::get_list(0, 0, $res_count, $filter, $sort);
      foreach($rows as $row) $patterns[$row['id']] = $row['pattern'];
      $colors = [];
      $sort = ['a.color' => 'asc'];
      $rows = Model_Colors::get_list(0, 0, $res_count, $filter, $sort);
      foreach($rows as $row) $colors[$row['id']] = $row['color'];
      $manufacturers = [];
      $sort = ['a.manufacturer' => 'asc'];
      $rows = Model_Manufacturers::get_list(0, 0, $res_count, $filter, $sort);
      foreach($rows as $row) $manufacturers[$row['id']] = $row['manufacturer'];

      $search_data['categories'] = $categories;
      $search_data['patterns'] = $patterns;
      $search_data['colors'] = $colors;
      $search_data['manufacturers'] = $manufacturers;
      $type = isset($search_data['type']) ? $search_data['type'] : null;
      if(!empty(_A_::$app->get('cat'))) $url_prms['cat'] = _A_::$app->get('cat');
      if(!empty(_A_::$app->get('mnf'))) $url_prms['mnf'] = _A_::$app->get('mnf');
      if(!empty(_A_::$app->get('ptrn'))) $url_prms['ptrn'] = _A_::$app->get('ptrn');
      if(!empty(_A_::$app->get('clr'))) $url_prms['clr'] = _A_::$app->get('clr');
      if(!empty(_A_::$app->get('prc'))) $url_prms['prc'] = _A_::$app->get('prc');

      if(isset($type)) $this->template->vars('action', _A_::$app->router()->UrlTo($this->controller . DS . $type));
      if(isset($url_prms)) $this->template->vars('action', _A_::$app->router()->UrlTo($this->controller, $url_prms));
    }

    protected function after_get_list(&$rows, $view = false, $type = null) {
      $url_prms = null;
      if(!empty(_A_::$app->get('cat'))) {
        $url_prms['cat'] = _A_::$app->get('cat');
        $data = Model_Categories::get_by_id(_A_::$app->get('cat'));
        if(!empty($data['cname'])) {
          $this->template->setMeta('description', $data['cname']);
          $this->template->setMeta('keywords', strtolower($data['cname']) . ',' . implode(',', array_filter(explode(' ', strtolower($data['cname'])))));
          $this->template->setMeta('title', $data['cname']);
        }
      };
      if(!empty(_A_::$app->get('mnf'))) {
        $url_prms['mnf'] = _A_::$app->get('mnf');
        $data = Model_Manufacturers::get_by_id(_A_::$app->get('mnf'));
        if(!empty($data['manufacturer'])) {
          $this->template->setMeta('description', $data['manufacturer']);
          $this->template->setMeta('keywords', strtolower($data['manufacturer']) . ',' . implode(',', array_filter(explode(' ', strtolower($data['manufacturer'])))));
          $this->template->setMeta('title', $data['manufacturer']);
        }
      }
      if(!empty(_A_::$app->get('ptrn'))) {
        $url_prms['ptrn'] = _A_::$app->get('ptrn');
        $data = Model_Patterns::get_by_id(_A_::$app->get('ptrn'));
        if(!empty($data['pattern'])) {
          $this->template->setMeta('description', $data['pattern']);
          $this->template->setMeta('keywords', strtolower($data['pattern']) . ',' . implode(',', array_filter(explode(' ', strtolower($data['pattern'])))));
          $this->template->setMeta('title', $data['pattern']);
        }
      }
      if(!empty(_A_::$app->get('clr'))) {
        $url_prms['clr'] = _A_::$app->get('clr');
        $data = Model_Colors::get_by_id(_A_::$app->get('clr'));
        if(!empty($data['color'])) {
          $this->template->setMeta('description', $data['color']);
          $this->template->setMeta('keywords', strtolower($data['color']) . ',' . implode(',', array_filter(explode(' ', strtolower($data['color'])))));
          $this->template->setMeta('title', $data['color']);
        }
      }
      if(!empty(_A_::$app->get('prc'))) {
        $url_prms['prc'] = _A_::$app->get('prc');
        $data = Model_Prices::get_by_id(_A_::$app->get('prc'));
        if(!empty($data['title'])) {
          $title = 'Fabrics Prices Range ' . $data['title'];
          $this->template->setMeta('description', $title);
          $this->template->setMeta('keywords', strtolower($title) . ',' . implode(',', array_filter(explode(' ', strtolower($title)))));
          $this->template->setMeta('title', $title);
        }
      }
      if(isset($type)) $url_prms['back'] = $type;
      $this->template->vars('url_prms', $url_prms);
    }

    protected function get_list_by_type($type = 'last', $max_count_items = 50) {
      $filter['type'] = $type;
      $sort['type'] = $type;
      $search_form = $this->build_search_filter($filter);
      $idx = $this->load_search_filter_get_idx($filter);
      $pages = _A_::$app->session('pages');
      $sort = $this->load_sort($filter);
      $page = !empty($pages[$this->controller][$idx]) ? $pages[$this->controller][$idx] : 1;
      $per_page = $this->per_page;
      $total = Model_Shop::get_total_count($filter);
      if(($total > $max_count_items) && ($max_count_items > 0)) $total = $max_count_items;
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
      (new Controller_Paginator($this->main))->paginator($total, $page, 'shop' . DS . $type, null, $per_page);
      $this->before_list_layout();
      $this->main->view_layout('list');
    }

    protected function widget_products($type, $start, $limit, $layout = 'list') {
      $rows = Model_Shop::get_widget_list_by_type($type, $start, $limit, $row_count);
      $this->template->vars('rows', $rows);
      $this->template->view_layout('widget/' . $layout);
    }

    protected function build_back_url(&$back_url = null, &$prms = null) {
      $prms = null;
      if((!empty(_A_::$app->get('cat')))) $prms['cat'] = _A_::$app->get('cat');
      if((!empty(_A_::$app->get('mnf')))) $prms['mnf'] = _A_::$app->get('mnf');
      if((!empty(_A_::$app->get('ptrn')))) $prms['ptrn'] = _A_::$app->get('ptrn');
      if((!empty(_A_::$app->get('clr')))) $prms['clr'] = _A_::$app->get('clr');
      if((!empty(_A_::$app->get('prc')))) $prms['prc'] = _A_::$app->get('prc');
      if(!is_null(_A_::$app->get('back'))) {
        $back = _A_::$app->get('back');
        if(in_array($back, ['matches', 'cart', 'shop', 'favorites', 'clearance', '']))
          $back_url = $back;
        elseif(in_array($back, ['bestsellers', 'last', 'popular', 'specials'])) {
          $back_url = 'shop' . DS . $back;
        } else {
          $back_url = base64_decode(urldecode($back));
        }
      } else {
        $back_url = 'shop';
      }
    }

    protected function load_search_filter_get_idx($filter, $view = false) {
      $idx = Controller_AdminBase::is_logged() . '_' . $view;
      if((!empty(_A_::$app->get('cat')))) $idx .= '_cat_' . _A_::$app->get('cat') . '_';
      if((!empty(_A_::$app->get('mnf')))) $idx .= '_mnf_' . _A_::$app->get('mnf') . '_';
      if((!empty(_A_::$app->get('ptrn')))) $idx .= '_ptrn_' . _A_::$app->get('ptrn') . '_';
      if((!empty(_A_::$app->get('clr')))) $idx .= '_clr_' . _A_::$app->get('clr') . '_';
      if((!empty(_A_::$app->get('prc')))) $idx .= '_prc_' . _A_::$app->get('prc') . '_';
      $idx .= (isset($filter['type']) ? $filter['type'] : '') . (!empty($this->scenario()) ? $this->scenario() : '');
      $idx = !empty($idx) ? $idx : 0;
      return $idx;
    }

    protected function build_sitemap_url($row, $view) {
    }

    protected function build_sitemap_item($row, $view) {
      $prms = [$this->id_field => $row[$this->id_field]];
      $url = 'shop/product';
      $sef = $row[$this->name_field];
      $loc = _A_::$app->router()->UrlTo($url, $prms, $sef);
      $item = ['loc' => $loc, 'changefreq' => 'daily', 'priority' => 0.5,];
      if(!empty($this->data_field)) $item['lastmod'] = date('Y-m-d', strtotime($row[$this->data_field]));
      return $item;
    }

    public static function urlto_sef_ignore_prms() {
      return [
        'product' => ['cat', 'mnf', 'ptrn', 'clr', 'prc'],
        'specials' => ['cat', 'mnf', 'ptrn', 'clr', 'prc'],
        'last' => ['cat', 'mnf', 'ptrn', 'clr', 'prc'],
        'popular' => ['cat', 'mnf', 'ptrn', 'clr', 'prc'],
        'best' => ['cat', 'mnf', 'ptrn', 'clr', 'prc'],
        'bestsellers' => ['cat', 'mnf', 'ptrn', 'clr', 'prc'],
        'widget' => ['cat', 'mnf', 'ptrn', 'clr', 'prc'],
      ];
    }

    /**
     * @export
     */
    public function shop() {
      $this->template->vars('cart_enable', '_');
      if(Controller_User::is_logged()) {
        $user = _A_::$app->session('user');
        $firstname = ucfirst($user['bill_firstname']);
        $lastname = ucfirst($user['bill_lastname']);
        $user_name = '';
        if(!empty($firstname{0}) || !empty($lastname{0})) {
          if(!empty($firstname{0}))
            $user_name = $firstname . ' ';
          if(!empty($lastname{0}))
            $user_name .= $lastname;
        } else {
          $user_name = $user['email'];
        }
        $this->template->vars('user_name', $user_name);
      }
      $this->main->template->vars('page_title', "Online Fabric Store");
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
      $page_title = "Discount Decorator and Designer Fabrics";
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

      if(!empty($data['metadescription'])) $this->template->setMeta('description', $data['metadescription']);
      if(!empty($data['metakeywords'])) $this->template->setMeta('keywords', $data['metakeywords']);
      if(!empty($data['metatitle'])) $this->template->setMeta('title', $data['metatitle']);
      elseif(!empty($data['pname'])) $this->template->setMeta('title', $data['pname']);

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
      if(!is_null(_A_::$app->post('s')) && (!empty(_A_::$app->post('s')))) {
        $search = strtolower(htmlspecialchars(trim(_A_::$app->post('s'))));
        $this->main->template->vars('search_str', _A_::$app->post('s'));
      }
      $this->set_back_url();
      $this->template->vars('in_favorites', Controller_Favorites::product_in($pid));
      $this->template->vars('data', $data);
      $allowed_samples = Model_Samples::allowedSamples($pid);
      $this->template->vars('allowed_samples', $allowed_samples);
      $this->template->vars('cart_enable', '_');
      $this->main->view('product/view');
    }

    public function index($required_access = true) { }

    public function view($partial = false, $required_access = false) { }

    public static function sitemap_order() { return 6; }

  }