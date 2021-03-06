<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerController;
use classes\helpers\AdminHelper;
use classes\helpers\FavoritesHelper;
use classes\helpers\UserHelper;
use classes\Paginator;
use models\ModelSamples;
use models\ModelShop;

/**
 * Class ControllerShop
 * @package controllers
 */
class ControllerShop extends ControllerController{

  /**
   * @var string
   */
  protected $id_field = 'pid';
  /**
   * @var string
   */
  protected $name_field = 'pname';
  /**
   * @var string
   */
  protected $data_field = 'dt';
  /**
   * @var string
   */
  protected $page_title = "Fabric Selection";

  protected $reset = [
    'reset' => ['a.pname'],
    'reset_filter' => [
      'b.cid', 'c.id', 'd.id', 'e.id', 'a.priceyard'
    ]
  ];

  /**
   * @param bool $view
   * @return array|null
   */
  protected function search_fields($view = false){
    return [
      'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber', 'a.piece',
      'a.best', 'a.specials', 'b.cid', 'c.id', 'd.id', 'e.id',
      'a.priceyard'
    ];
  }

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function BuildOrder(&$sort, $view = false, $filter = null){
    $type = isset($filter['type']) ? $filter['type'] : null;
    if(isset($type)) {
      switch($type) {
        case 'popular':
          $sort['a.popular'] = 'desc';
          $sort['a.pid'] = 'desc';
          break;
        default:
          $sort['a.pid'] = 'desc';
      }
    } else {
      if(!empty(App::$app->get('cat'))) {
        $sort['shop_product_categories.display_order'] = 'asc';
      } else {
        $sort['b.displayorder'] = 'asc';
        $sort['shop_product_categories.display_order'] = 'asc';
      };
    }
  }

  /**
   * @param $search_data
   * @param bool $view
   * @throws \Exception
   */
  protected function before_search_form_layout(&$search_data, $view = false){
    $type = isset($search_data['type']) ? $search_data['type'] : null;
    if(isset($type)) $this->main->view->setVars('action', App::$app->router()->UrlTo($this->controller . DS . $type));
    if(isset($url_prms)) $this->main->view->setVars('action', App::$app->router()
      ->UrlTo($this->controller, $url_prms));
  }

  /**
   * @param $rows
   * @param bool $view
   * @param null $type
   * @param $filter
   * @param null $search_form
   */
  protected function after_get_list(&$rows, $view = false, &$filter = null, &$search_form = null, $type = null){
    $url_prms = null;
    $main_filter = !empty($search_form) ? array_slice($search_form, 0) : [];
    if(!empty($main_filter)) {
      $main_filter = array_filter($main_filter,
        function($key){
          return in_array($key, $this->reset['reset_filter']);
        },
        ARRAY_FILTER_USE_KEY
      );
    }
    if(!empty($main_filter)) $main_filter['active_filter'] = !empty($main_filter);
    $this->main->view->setVars('filter', $main_filter);
    if(isset($type)) $url_prms['back'] = $type;
    $this->main->view->setVars('url_prms', $url_prms);
  }

  /**
   * @param string $type
   * @param int $max_count_items
   * @return string
   * @throws \Exception
   */
  protected function get_list_by_type($type = 'last', $max_count_items = 50){
    $this->main->view->setVars('page_title', $this->page_title);
    list($filter, $search_form, $sort, $page, $per_page, $total, $res_count_rows, $rows) = $this->get_data_for_list_by_type($type, $max_count_items, $filter);
    $this->after_get_list($rows, false, $filter, $search_form, $type);
    if(isset($filter['active'])) $search_form['active'] = $filter['active'];
    $this->search_form($search_form);
    $this->main->view->setVars('rows', $rows);
    $this->main->view->setVars('sort', $sort);
    $this->main->view->setVars('list', $this->RenderLayoutReturn($type));
    $this->main->view->setVars('count_rows', $res_count_rows);
    (new Paginator($this->main))->getPaginator($total, $page, 'shop' . DS . $type, null, $per_page);
    $this->before_list_layout();

    return $this->RenderLayoutReturn('list', App::$app->RequestIsAjax());
  }

  /**
   * @param $type
   * @param $start
   * @param $limit
   * @param string $layout
   * @return mixed
   * @throws \Exception
   */
  protected function widget_products($type, $start, $limit, $layout = 'list'){
    $row_count = ModelShop::get_widget_list_by_type_count($type);
    if($row_count > ($limit + $start)) {
      $start = rand($start, $row_count - $limit);
    }
    $rows = ModelShop::get_widget_list_by_type($type, $start, $limit, $row_count);
    $this->main->view->setVars('rows', $rows);

    return $this->RenderLayoutReturn('widget/' . $layout);
  }

  /**
   * @param $type
   * @param $start
   * @param $limit
   * @param string $layout
   * @throws \Exception
   */
  protected function widget_products_under_type($type, $start, $limit, $layout = 'list'){
    $row_count = ModelShop::get_widget_list_by_type_count($type);
    if($row_count > ($limit + $start)) {
      $start = rand($start, $row_count - $limit);
    }
    $this->main->view->setVars('rows', ModelShop::get_widget_list_by_type($type, $start, $limit, $row_count));
    $this->main->view->setVars('list_' . $type, $this->RenderLayoutReturn('widget/' . $layout));
  }

  /**
   * @param $limit
   * @param string $layout
   * @return string
   * @throws \Exception
   */
  protected function widget_products_under($limit, $layout = 'list_under'){
    $this->widget_products_under_type('under_20', 0, 5);
    $this->widget_products_under_type('under_40', 0, 5);
    $this->widget_products_under_type('under_60', 0, 5);

    return $this->RenderLayoutReturn('widget/' . $layout);
  }

  /**
   * @param null $back_url
   * @param null $prms
   */
  protected function build_back_url(&$back_url = null, &$prms = null){
    $prms = null;
    if((!empty(App::$app->get('method')))) $prms['method'] = App::$app->get('method');
    if(!is_null(App::$app->get('back'))) {
      $back = App::$app->get('back');
      if(in_array($back, ['matches', 'cart', 'shop', 'favorites', 'clearance', 'home', 'recommends'])) {
        $back_url = ($back == 'home' ? '' : $back);
      } elseif(in_array($back, ['bestsellers', 'last', 'popular', 'specials', 'under'])) {
        $back_url = 'shop' . DS . $back;
      } else {
        $back_url = base64_decode(urldecode($back));
      }
    } else {
      $back_url = 'shop';
    }
  }

  /**
   * @param $data
   * @return string
   * @throws \Exception
   */
  protected function build_discount_info(&$data){
    $discount_info = '';
    if($data['rSystemDiscount'] > 0) {
      $field_name = "Sale price:";
      $pattern = "%s<br><strong " . (!empty($data['bDiscount']) ? "class='reduced'" : "") . ">%s" .
        (!empty($data['bDiscount']) ? "<hr>" : "") . "</strong>";
      $field_value = sprintf($pattern, $data['sPriceDiscount'], $data['srDiscountPrice']);
      $this->main->view->setVars('field_name', $field_name);
      $this->main->view->setVars('field_value', $field_value);
      $discount_info .= $this->RenderLayoutReturn('product/discount');
    }

    if($data['bDiscount']) {
      if($data['bSystemDiscount']) {
        $field_name = "Extra disc. price:";
      } else {
        $field_name = "Sale price:";
      }
      if($data['bSystemDiscount']) {
        $field_value = sprintf("Further reduced by %s.<br><strong>%s</strong>", $data['sDiscount'], $data['sDiscountPrice']);
      } else {
        $field_value = sprintf("Reduced by %s.<br><strong>%s</strong>", $data['sDiscount'], $data['sDiscountPrice']);
      }
      $this->main->view->setVars('field_name', $field_name);
      $this->main->view->setVars('field_value', $field_value);
      $discount_info .= $this->RenderLayoutReturn('product/discount');
    }

    if(strlen($data['sSystemDiscount']) > 0) {
      $field_name = 'Shipping discount:';
      $field_value = $data['sSystemDiscount'];
      $this->main->view->setVars('field_name', $field_name);
      $this->main->view->setVars('field_value', $field_value);
      $discount_info .= $this->RenderLayoutReturn('product/discount');
    }

    if(isset($data['next_change']) && $data['next_change']) {
      $field_name = 'Sale ends in:';
      $field_value = $data['time_rem'];
      $this->main->view->setVars('field_name', $field_name);
      $this->main->view->setVars('field_value', $field_value);
      $discount_info .= $this->RenderLayoutReturn('product/discount');
    }

    return $discount_info;
  }

  /**
   * @param $data
   * @return mixed
   */
  protected function set_product_meta(&$data){
    if(!empty($data['metadescription'])) {
      $this->main->view->setMeta('description', $data['metadescription']);
    } elseif(!empty($data['sdesc'])) {
      $this->main->view->setMeta('description', $data['sdesc']);
    }
    if(!empty($data['metakeywords'])) {
      $this->main->view->setMeta('keywords', $data['metakeywords']);
    } elseif(!empty($data['pname'])) {
      $meta_keywords = array_filter(explode(' ', strtolower($data['pname'])));
      $this->main->view->setMeta('keywords', explode(' ', implode(',', $meta_keywords)));
    }
    if(!empty($data['metatitle'])) {
      $this->main->view->setMeta('title', $data['metatitle']);
    } elseif(!empty($data['pname'])) {
      $this->main->view->setMeta('title', $data['pname']);
    }
  }

  /**
   * @param $row
   * @param $view
   * @return string
   * @throws \Exception
   */
  protected function build_sitemap_url($row, $view){
    $prms = [$this->id_field => $row[$this->id_field]];
    $url = 'shop/product';
    $sef = $row[$this->name_field];

    return App::$app->router()->UrlTo($url, $prms, $sef);
  }

  /**
   * @inheritdoc
   */
  protected function build_sitemap_item($row, $view, $changefreq = 'daily', $priority = 0.5){
    return parent::build_sitemap_item($row, $view, $changefreq, $priority);
  }

  /**
   * @param $type
   * @param $max_count_items
   * @param $filter
   * @return array
   * @throws \Exception
   */
  protected function get_data_for_list_by_type($type, $max_count_items, &$filter): array{
    $filter['type'] = $type;
    $search_form = $this->build_search_filter($filter);
    $idx = $this->load_search_filter_get_idx($filter);
    $pages = App::$app->session('pages');
    $per_pages = App::$app->session('per_pages');
    $sort = $this->load_sort($filter);
    $page = !empty($pages[$this->controller][$idx]) ? $pages[$this->controller][$idx] : 1;
    $per_page = !empty($per_pages[$this->controller][$idx]) ? $per_pages[$this->controller][$idx] : $this->per_page;
    $total = forward_static_call([$this->model, 'get_total_count'], $filter);
    if(($total > $max_count_items) && ($max_count_items > 0)) $total = $max_count_items;
    if($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
    if($page <= 0) $page = 1;
    $start = (($page - 1) * $per_page);
    $limit = $per_page;
    if($total < ($start + $per_page)) $limit = $total - $start;
    $res_count_rows = 0;
    $rows = forward_static_call_array([$this->model, 'get_list'], [
      $start, $limit, &$res_count_rows, &$filter, &$sort
    ]);

    return [$filter, $search_form, $sort, $page, $per_page, $total, $res_count_rows, $rows];
  }

  /**
   * @param $id
   * @return array
   * @throws \Exception
   */
  protected function get_data_prev_next($id): array{
    $ignored_controllers=['cart'];
    $prev_next = [];
    $controller = $this->controller;
    $max_count_items = null;
    $model = $this->model;
    $back = App::$app->get('back');
    $controllerInstance = $this;
    if(!empty($back) && !in_array($back ,$ignored_controllers)) {
      if(!empty($back) && ($controller !== $back)) {
        if(class_exists(App::$controllersNS . '\Controller' . ucfirst($back))) {
          $controller = $back;
          $controllerInstance = App::$controllersNS . '\Controller' . ucfirst($controller);
          $controllerInstance = new $controllerInstance($this->main);
          if(class_exists(App::$modelsNS . '\Model' . ucfirst($controller))) {
            $model = App::$modelsNS . '\Model' . ucfirst($controller);
          }
        } else {
          $filter['type'] = $back;
          switch($back) {
            case 'specials':
              $max_count_items = (!is_null(App::$app->KeyStorage()->shop_specials_amount) ? App::$app->KeyStorage()->shop_specials_amount : SHOP_SPECIALS_AMOUNT);
              break;
            case 'bestsellers':
              $max_count_items = (!is_null(App::$app->KeyStorage()->shop_bestsellers_amount) ? App::$app->KeyStorage()->shop_bestsellers_amount : SHOP_BSELLS_AMOUNT);
              break;
            case 'under':
              $max_count_items = (!is_null(App::$app->KeyStorage()->shop_under_amount) ? App::$app->KeyStorage()->shop_under_amount : SHOP_UNDER_AMOUNT);
              break;
            case 'last':
              $max_count_items = (!is_null(App::$app->KeyStorage()->shop_last_amount) ? App::$app->KeyStorage()->shop_last_amount : SHOP_LAST_AMOUNT);
              break;
            case 'best':
              $max_count_items = (!is_null(App::$app->KeyStorage()->shop_best_amount) ? App::$app->KeyStorage()->shop_best_amount : SHOP_BEST_AMOUNT);
              break;
            case 'popular':
              $max_count_items = (!is_null(App::$app->KeyStorage()->shop_popular_amount) ? App::$app->KeyStorage()->shop_popular_amount : SHOP_POPULAR_AMOUNT);
              break;
            case 'home':
              break;
            default:
              $controller = 'related';
              $controllerInstance = App::$controllersNS . '\Controller' . ucfirst($controller);
              $controllerInstance = new $controllerInstance($this->main);
              if(class_exists(App::$modelsNS . '\Model' . ucfirst($controller))) {
                $model = App::$modelsNS . '\Model' . ucfirst($controller);
              }
          }
        }
      }
      $controllerInstance->build_search_filter($filter);
      $idx = $controllerInstance->load_search_filter_get_idx($filter);
      $pages = App::$app->session('pages');
      $per_pages = App::$app->session('per_pages');
      $sort = $controllerInstance->load_sort($filter);
      $page = !empty($pages[$controller][$idx]) ? $pages[$controller][$idx] : 1;
      $per_page = !empty($per_pages[$controller][$idx]) ? $per_pages[$controller][$idx] : $controllerInstance->per_page;
      $scenario = $controllerInstance->scenario();
      $filter['scenario'] = $scenario;
      $total = forward_static_call([$model, 'get_total_count'], $filter);
      if(!empty($filter['type']) && !empty($max_count_items) && (($total > $max_count_items) && ($max_count_items > 0))) $total = $max_count_items;
      if($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
      if($page <= 0) $page = 1;
      $start = ($page - (($page > 1) ? 2 : 1)) * $per_page;
      $limit = (($page > 1) ? 3 : 2) * $per_page;
      if(!empty($filter['type']) && ($total < $limit)) {
        $limit = $total - $start;
      }
      $res_count_rows = 0;
      $rows = forward_static_call_array([$model, 'get_list'], [
        $start, $limit, &$res_count_rows, &$filter, &$sort
      ]);
      array_walk($rows, function($item, $key)
      use ($id, $rows, $idx, $controller, $start, $page, $back, $scenario, &$prev_next, $controllerInstance){
        if($item['pid'] == $id) {
          if(!empty($rows[$key - 1])) {
            $url_prms['pid'] = $rows[$key - 1]['pid'];
            $url_prms['back'] = $back;
            if(!empty(App::$app->get('parent'))) $url_prms['parent'] = App::$app->get('parent');
            if(!empty($scenario)) $url_prms['method'] = $scenario;
            $href = App::$app->router()->UrlTo('shop/product', $url_prms, $rows[$key - 1]['pname'], [
              'method', 'parent'
            ]);
            $prev_next['prev']['url'] = $href;
            $prev_next['prev']['title'] = $rows[$key - 1]['pname'];
          }
          if(!empty($rows[$key + 1])) {
            $url_prms['pid'] = $rows[$key + 1]['pid'];
            $url_prms['back'] = $back;
            if(!empty(App::$app->get('parent'))) $url_prms['parent'] = App::$app->get('parent');
            if(!empty($scenario)) $url_prms['method'] = $scenario;
            $href = App::$app->router()->UrlTo('shop/product', $url_prms, $rows[$key + 1]['pname'], [
              'method', 'parent'
            ]);
            $prev_next['next']['url'] = $href;
            $prev_next['next']['title'] = $rows[$key + 1]['pname'];
          }
          if(min($page, 2) * $controllerInstance->per_page == $key) {
            $pages[$controller][$idx] = $page + 1;
            App::$app->setSession('pages', $pages);
          }
          if(($page > 1) && ($controllerInstance->per_page == $key + 1)) {
            $pages[$controller][$idx] = $page - 1;
            App::$app->setSession('pages', $pages);
          }
        }
      });
    }
    return $prev_next;
  }

  /**
   * @param $filter
   * @param bool $view
   * @return int|string
   */
  public function load_search_filter_get_idx($filter, $view = false){
    $idx = AdminHelper::is_logged() . '_' . $view;
    $idx .= (isset($filter['type']) ? $filter['type'] : '') . (!empty($this->scenario()) ? $this->scenario() : '');
    $idx = !empty($idx) ? $idx : 0;

    return $idx;
  }

  /**
   * @param $filter
   * @param bool $view
   * @return array|null
   * @throws \Exception
   */
  public function build_search_filter(&$filter, $view = false){

    $type = isset($filter['type']) ? $filter['type'] : null;
    $res = parent::build_search_filter($filter, $view);
    App::$app->setSession('sidebar_idx', 0);
    $filter['hidden']['a.pnumber'] = 'null';
    if(!isset($filter['hidden']['a.priceyard'])) $filter['hidden']['a.priceyard'] = '0.00';
    $filter['hidden']['a.pvisible'] = '1';
    $filter['hidden']['a.image1'] = 'null';

    if(!isset($res['pname']) && !is_null(App::$app->post('s')) && (!empty(App::$app->post('s')))) {
      $search = strtolower(htmlspecialchars(trim(App::$app->post('s'))));
      $this->main->view->setVars('search_str', App::$app->post('s'));
      $res['a.pname'] = App::$app->post('s');
      $filter['a.pname'] = $search;
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
          App::$app->setSession('sidebar_idx', 6);
          break;
      }
    }

    return $res;
  }

  /**
   * @export
   * @throws \Exception
   */
  public function shop(){
    $this->main->view->setVars('cart_enable', '_');
    if(UserHelper::is_logged()) {
      $user = App::$app->session('user');
      $firstname = ucfirst($user['bill_firstname']);
      $lastname = ucfirst($user['bill_lastname']);
      $user_name = '';
      if(!empty($firstname{0}) || !empty($lastname{0})) {
        if(!empty($firstname{0})) $user_name = $firstname . ' ';
        if(!empty($lastname{0})) $user_name .= $lastname;
      } else {
        $user_name = $user['email'];
      }
      $this->main->view->setVars('user_name', $user_name);
    }
    parent::index(false);
  }

  /**
   * @export
   * @param null $type
   * @return mixed|string
   * @throws \Exception
   */
  public function widget($type = null){
    $result = '';
    $type = empty($type) ? App::$app->get('type') : $type;
    switch($type) {
      case 'popular':
        $result = $this->widget_products('popular', 0, 5);
        break;
      case 'new':
        $result = $this->widget_products('new', 0, 5);
        break;
      case 'best':
        $result = $this->widget_products('best', 0, 5);
        break;
      case 'bestsellers':
        $result = $this->widget_products('bestsellers', 6, 5);
        break;
      case 'carousel_new':
        $result = $this->widget_products('carousel', 0, 30, 'widget_new_products_carousel');
        break;
      case 'carousel_specials':
        $result = $this->widget_products('carousel', 0, 30, 'widget_specials_products_carousel');
        break;
      case 'bsells_horiz':
        $result = $this->widget_products('bestsellers', 0, 6, 'widget_bsells_products_horiz');
        break;
      case 'under':
        $result = $this->widget_products_under(5, 'list_under');
        break;
    }

    return $result;
  }

  /**
   * @export
   * @throws \Exception
   */
  public function product(){
    $pid = App::$app->get('pid');

    $controller_related = new ControllerRelated($this->main);
    $this->main->view->setVars('related_view', $controller_related->view(false, false, $pid));
    $controller_info = new ControllerInfo($this->main);
    $controller_info->scenario('product');
    $this->main->view->setVars('info_view', $controller_info->view(false, false, true));

    $data = ModelShop::get_product($pid);
    $this->set_back_url();
    $this->set_product_meta($data);
    $this->main->view->setVars('discount_info', $this->build_discount_info($data));
    if(!is_null(App::$app->post('s')) && (!empty(App::$app->post('s')))) {
      $search = strtolower(htmlspecialchars(trim(App::$app->post('s'))));
      $this->main->view->setVars('search_str', App::$app->post('s'));
    }
    $this->main->view->setVars('prev_next', $this->get_data_prev_next($pid));
    $this->main->view->setVars('in_favorites', FavoritesHelper::product_in($pid));
    $this->main->view->setVars('data', $data);
    $this->main->view->setVars('allowed_samples', ModelSamples::allowedSamples($pid));
    $this->main->view->setVars('cart_enable', '_');
    $this->render_view('product/view');
  }

  /**
   * @param bool $required_access
   */
  public function index($required_access = true){
  }

  /**
   * @param bool $partial
   * @param bool $required_access
   */
  public function view($partial = false, $required_access = false){
  }

  /**
   * @return int|null
   */
  public static function sitemap_order(){
    return 6;
  }

  /**
   * @export
   * @throws \Exception
   */
  public function filter(){
    $main_filter = $this->build_search_filter($filter);
    if(App::$app->RequestIsAjax()) {
      if(!empty($main_filter) && is_array($main_filter)) {
        $main_filter = array_filter($main_filter,
          function($key){
            return in_array($key, $this->reset['reset_filter']);
          },
          ARRAY_FILTER_USE_KEY
        );

        if(!empty($main_filter)) $main_filter['active_filter'] = !empty(array_filter($main_filter));
      }
      exit(json_encode($main_filter));
    }

    return $this->shop();
  }

  /**
   * @export
   * @throws \Exception
   */
  public function specials(){
    $this->main->view->setVars('cart_enable', '_');
    $this->page_title = "Discount Decorator and Designer Fabric Specials";
    $annotation = 'All specially priced items are at their marked down prices for a LIMITED TIME ONLY, after which they revert to their regular rates. All items available on a FIRST COME, FIRST SERVED basis only.';
    $this->main->view->setVars('annotation', $annotation);
    $list = $this->get_list_by_type('specials', (!is_null(App::$app->KeyStorage()->shop_specials_amount) ? App::$app->KeyStorage()->shop_specials_amount : SHOP_SPECIALS_AMOUNT));
    if(App::$app->RequestIsAjax()) exit($list);
    $this->main->view->setVars('list', $list);
    $this->render_view('shop');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function popular(){
    $this->main->view->setVars('cart_enable', '_');
    $this->page_title = 'Popular Textiles';
    $list = $this->get_list_by_type('popular', (!is_null(App::$app->KeyStorage()->shop_popular_amount) ?
      App::$app->KeyStorage()->shop_popular_amount : SHOP_POPULAR_AMOUNT)
    );
    if(App::$app->RequestIsAjax()) exit($list);
    $this->main->view->setVars('list', $list);
    $this->render_view('shop');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function last(){
    $this->main->view->setVars('cart_enable', '_');
    $this->page_title = "What's New";
    $list = $this->get_list_by_type('last', (!is_null(App::$app->KeyStorage()->shop_last_amount) ?
      App::$app->KeyStorage()->shop_last_amount : SHOP_LAST_AMOUNT)
    );
    if(App::$app->RequestIsAjax()) exit($list);
    $this->main->view->setVars('list', $list);
    $this->render_view('shop');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function best(){
    $this->main->view->setVars('cart_enable', '_');
    $this->page_title = 'Best Textiles';
    $list = $this->get_list_by_type('best', (!is_null(App::$app->KeyStorage()->shop_best_amount) ?
      App::$app->KeyStorage()->shop_best_amount : SHOP_BEST_AMOUNT)
    );
    if(App::$app->RequestIsAjax()) exit($list);
    $this->main->view->setVars('list', $list);
    $this->render_view('shop');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function bestsellers(){
    $this->main->view->setVars('cart_enable', '_');
    $this->page_title = 'Best Sellers';
    $list = $this->get_list_by_type('bestsellers', (!is_null(App::$app->KeyStorage()->shop_bestsellers_amount) ?
      App::$app->KeyStorage()->shop_bestsellers_amount : SHOP_BSELLS_AMOUNT)
    );
    if(App::$app->RequestIsAjax()) exit($list);
    $this->main->view->setVars('list', $list);
    $this->render_view('shop');
  }

  /**
   * @export
   * @throws \Exception
   * @throws \Exception
   */
  public function under(){
    $this->main->view->setVars('cart_enable', '_');
    $this->page_title = 'Under $100';
    $list = $this->get_list_by_type('under', (!is_null(App::$app->KeyStorage()->shop_under_amount) ?
      App::$app->KeyStorage()->shop_under_amount : SHOP_UNDER_AMOUNT)
    );
    if(App::$app->RequestIsAjax()) exit($list);
    $this->main->view->setVars('list', $list);
    $this->render_view('shop');
  }

//
//    /**
//     * @export
//     */
//    public function update_related() {
//      $per_page = 200;
//      $page = 1;
//      $total = ModelProduct::get_total_count();
//      $count = 0;
//      $res_count_rows = 0;
//      $filter = null;
//      $sort = null;
//      while($page <= ceil($total / $per_page)) {
//        $start = (($page++ - 1) * $per_page);
//        $rows = ModelProduct::get_list($start, $per_page, $res_count_rows, $filter, $sort);
//        foreach($rows as $row) {
//          for($i = 1; $i < 6; $i++) {
//            if(!empty(trim($row['rpnumber' . $i]))) {
//              if(!empty($pid = ModelProduct::get_id_by_condition(" LOWER(pnumber) = '" . strtolower($row['rpnumber' . $i]) . "'"))) {
//                $data = ['pid' => $row['pid'], 'r_pid' => $pid];
//                ModelRelated::Save($data);
//              };
//            }
//          }
//        }
//        $count += count($rows);
//        echo $count;
//      }
//    }

//    /**
//     * @export
//     */
//    public function update_products() {
//      $per_page = 200;
//      $page = 1;
//      $total = ModelProduct::get_total_count();
//      $count = 0;
//      $res_count_rows = 0;
//      $filter = null;
//      $sort = null;
//      while($page <= ceil($total / $per_page)) {
//        $start = (($page++ - 1) * $per_page);
//        $rows = ModelProduct::get_list($start, $per_page, $res_count_rows, $filter, $sort);
//        foreach($rows as $data){
//          if(empty($data['sdesc'])) $data['sdesc'] = trim($data['ldesc']);
//          if(empty($data['metadescription'])) $data['metadescription'] = $data['sdesc'];
//          if(empty($data['metatitle'])) $data['metatitle'] = $data['pname'];
//          if(empty($data['metakeywords'])) {
//            $data['metakeywords'] = preg_replace('/[^a-zA-Z0-9]+/i', ' ', $data['metadescription']);
//            $data['metakeywords'] = trim(preg_replace('/\s{2,}/', ' ', $data['metakeywords']));
//            $data['metakeywords'] = strtolower(implode(',', array_filter(array_map('trim', explode(' ', $data['metakeywords'])))));
//          }
//          try{
//            ModelProduct::Save($data);
//          } finally{
//
//          }
//        }
//
//        $count += count($rows);
//        echo $count;
//      }
//    }

//    public function modify_products_images() {
//      $c_image = new ControllerImage();
//      $per_page = 12;
//      $page = 1;
//
//      $total = ModelShop::get_total_count();
//      $count = 0;
//      while($page <= ceil($total / $per_page)) {
//        $start = (($page++ - 1) * $per_page);
//        $rows = ModelShop::get_list($start, $per_page);
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

}