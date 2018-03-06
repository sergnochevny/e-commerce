<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerAdminBase;
use classes\controllers\ControllerController;
use classes\Paginator;
use models\ModelPrices;
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
  protected $page_title = "Online Fabric Store";

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
   * @param $filter
   * @param bool $view
   * @return array|null
   * @throws \Exception
   */
  protected function build_search_filter(&$filter, $view = false){

    $type = isset($filter['type']) ? $filter['type'] : null;
    $res = parent::build_search_filter($filter, $view);
    App::$app->setSession('sidebar_idx', 0);
    $filter['hidden']['a.pnumber'] = 'null';
    if(!isset($filter['hidden']['a.priceyard'])) $filter['hidden']['a.priceyard'] = '0.00';
    $filter['hidden']['a.pvisible'] = '1';
    $filter['hidden']['a.image1'] = 'null';

    if(!isset($res['pname']) && !is_null(App::$app->post('s')) && (!empty(App::$app->post('s')))) {
      $search = strtolower(htmlspecialchars(trim(App::$app->post('s'))));
      $this->main->template->vars('search_str', App::$app->post('s'));
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
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function build_order(&$sort, $view = false, $filter = null){
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
    if(isset($type)) $this->template->vars('action', App::$app->router()->UrlTo($this->controller . DS . $type));
    if(isset($url_prms)) $this->template->vars('action', App::$app->router()->UrlTo($this->controller, $url_prms));
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
    $this->template->vars('filter', $main_filter);
    if(isset($type)) $url_prms['back'] = $type;
    $this->template->vars('url_prms', $url_prms);
  }

  /**
   * @param string $type
   * @param int $max_count_items
   * @return string
   * @throws \Exception
   */
  protected function get_list_by_type($type = 'last', $max_count_items = 50){
    $this->template->vars('page_title', $this->page_title);
    $filter['type'] = $type;
    $search_form = $this->build_search_filter($filter);
    $idx = $this->load_search_filter_get_idx($filter);
    $pages = App::$app->session('pages');
    $per_pages = App::$app->session('per_pages');
    $sort = $this->load_sort($filter);
    $page = !empty($pages[$this->controller][$idx]) ? $pages[$this->controller][$idx] : 1;
    $per_page = !empty($per_pages[$this->controller][$idx]) ? $per_pages[$this->controller][$idx] : $this->per_page;
    $total = ModelShop::get_total_count($filter);
    if(($total > $max_count_items) && ($max_count_items > 0)) $total = $max_count_items;
    if($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
    if($page <= 0) $page = 1;
    $start = (($page - 1) * $per_page);
    $limit = $per_page;
    if($total < ($start + $per_page)) $limit = $total - $start;
    $rows = ModelShop::get_list($start, $limit, $res_count_rows, $filter, $sort);
    $this->after_get_list($rows, false, $filter, $search_form, $type);
    if(isset($filter['active'])) $search_form['active'] = $filter['active'];
    $this->search_form($search_form);
    $this->template->vars('rows', $rows);
    $this->template->vars('sort', $sort);
    $this->template->vars('list', $this->template->view_layout_return($type));
    $this->template->vars('count_rows', $res_count_rows);
    (new Paginator($this->main))->paginator($total, $page, 'shop' . DS . $type, null, $per_page);
    $this->before_list_layout();

    return $this->main->view_layout_return('list');
  }

  /**
   * @param $type
   * @param $start
   * @param $limit
   * @param string $layout
   * @throws \Exception
   */
  protected function widget_products($type, $start, $limit, $layout = 'list'){
    $row_count = ModelShop::get_widget_list_by_type_count($type);
    if($row_count > ($limit + $start)) {
      $start = rand($start, $row_count - $limit);
    }
    $rows = ModelShop::get_widget_list_by_type($type, $start, $limit, $row_count);
    $this->template->vars('rows', $rows);
    $this->template->view_layout('widget/' . $layout);
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
    $this->template->vars('rows', ModelShop::get_widget_list_by_type($type, $start, $limit, $row_count));
    $this->template->vars('list_' . $type, $this->template->view_layout_return('widget/' . $layout));
  }

  /**
   * @param $limit
   * @param string $layout
   * @throws \Exception
   */
  protected function widget_products_under($limit, $layout = 'list_under'){
    $this->widget_products_under_type('under_20', 0, 5);
    $this->widget_products_under_type('under_40', 0, 5);
    $this->widget_products_under_type('under_60', 0, 5);
    $this->template->view_layout('widget/' . $layout);
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
   * @param $filter
   * @param bool $view
   * @return int|string
   */
  protected function load_search_filter_get_idx($filter, $view = false){
    $idx = ControllerAdminBase::is_logged() . '_' . $view;
    $idx .= (isset($filter['type']) ? $filter['type'] : '') . (!empty($this->scenario()) ? $this->scenario() : '');
    $idx = !empty($idx) ? $idx : 0;

    return $idx;
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
   * @export
   * @throws \Exception
   */
  public function shop(){
    $this->template->vars('cart_enable', '_');
    if(ControllerUser::is_logged()) {
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
      $this->template->vars('user_name', $user_name);
    }
    parent::index(false);
  }

  /**
   * @export
   * @throws \Exception
   */
  public function widget(){
    switch(App::$app->get('type')) {
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
      case 'carousel_new':
        $this->widget_products('carousel', 0, 30, 'widget_new_products_carousel');
        break;
      case 'carousel_specials':
        $this->widget_products('carousel', 0, 30, 'widget_specials_products_carousel');
        break;
      case 'bsells_horiz':
        $this->widget_products('bestsellers', 0, 6, 'widget_bsells_products_horiz');
        break;
      case 'under':
        $this->widget_products_under(5, 'list_under');
        break;
    }
  }

  /**
   * @export
   * @throws \Exception
   */
  public function product(){
    $pid = App::$app->get('pid');
    $data = ModelShop::get_product($pid);

    if(!empty($data['metadescription'])) $this->template->setMeta('description', $data['metadescription']);
    if(!empty($data['metakeywords'])) $this->template->setMeta('keywords', $data['metakeywords']);
    if(!empty($data['metatitle'])) $this->template->setMeta('title', $data['metatitle']); elseif(!empty($data['pname'])) $this->template->setMeta('title', $data['pname']);

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
        $field_value = sprintf("Reduced further by %s.<br><strong>%s</strong>", $data['sDiscount'], $data['sDiscountPrice']);
      } else {
        $field_value = sprintf("Reduced by %s.<br><strong>%s</strong>", $data['sDiscount'], $data['sDiscountPrice']);
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
    if(!is_null(App::$app->post('s')) && (!empty(App::$app->post('s')))) {
      $search = strtolower(htmlspecialchars(trim(App::$app->post('s'))));
      $this->main->template->vars('search_str', App::$app->post('s'));
    }
    $this->set_back_url();
    $this->template->vars('in_favorites', ControllerFavorites::product_in($pid));
    $this->template->vars('data', $data);
    $allowed_samples = ModelSamples::allowedSamples($pid);
    $this->template->vars('allowed_samples', $allowed_samples);
    $this->template->vars('cart_enable', '_');
    $this->main->view('product/view');
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
    if(App::$app->request_is_ajax()) {
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
    $this->template->vars('cart_enable', '_');
    $this->page_title = "Discount Decorator and Designer Fabrics";
    $annotation = 'All specially priced items are at their marked down prices for a LIMITED TIME ONLY, after which they revert to their regular rates. All items available on a FIRST COME, FIRST SERVED basis only.';
    $this->main->template->vars('annotation', $annotation);
    $list = $this->get_list_by_type('specials', (!is_null(App::$app->keyStorage()->shop_specials_amount) ? App::$app->keyStorage()->shop_specials_amount : SHOP_SPECIALS_AMOUNT));
    if(App::$app->request_is_ajax()) exit($list);
    $this->template->vars('list', $list);
    $this->main->view('shop');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function popular(){
    $this->template->vars('cart_enable', '_');
    $this->page_title = 'Popular Textiles';
    $list = $this->get_list_by_type('popular', 360);
    if(App::$app->request_is_ajax()) exit($list);
    $this->template->vars('list', $list);
    $this->main->view('shop');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function last(){
    $this->template->vars('cart_enable', '_');
    $this->page_title = "What's New";
    $list = $this->get_list_by_type('last', 50);
    if(App::$app->request_is_ajax()) exit($list);
    $this->template->vars('list', $list);
    $this->main->view('shop');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function best(){
    $this->template->vars('cart_enable', '_');
    $this->page_title = 'Best Textiles';
    $list = $this->get_list_by_type('best', 360);
    if(App::$app->request_is_ajax()) exit($list);
    $this->template->vars('list', $list);
    $this->main->view('shop');
  }

  /**
   * @export
   * @throws \Exception
   */
  public function bestsellers(){
    $this->template->vars('cart_enable', '_');
    $this->page_title = 'Best Sellers';
    $list = $this->get_list_by_type('bestsellers', (!is_null(App::$app->keyStorage()->shop_bestsellers_amount) ?
      App::$app->keyStorage()->shop_bestsellers_amount : SHOP_BSELLS_AMOUNT)
    );
    if(App::$app->request_is_ajax()) exit($list);
    $this->template->vars('list', $list);
    $this->main->view('shop');
  }

  /**
   * @export
   * @throws \Exception
   * @throws \Exception
   */
  public function under(){
    $this->template->vars('cart_enable', '_');
    $this->page_title = 'Under $100';
    $list = $this->get_list_by_type('under', (!is_null(App::$app->keyStorage()->shop_under_amount) ?
      App::$app->keyStorage()->shop_under_amount : SHOP_UNDER_AMOUNT)
    );
    if(App::$app->request_is_ajax()) exit($list);
    $this->template->vars('list', $list);
    $this->main->view('shop');
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
//                ModelRelated::save($data);
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
//            ModelProduct::save($data);
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