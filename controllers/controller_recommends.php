<?php

class Controller_Recommends extends Controller_Controller{

  protected $page_title = "Recommendations for You";

  protected $resolved_scenario = ['', 'empty'];

  protected function search_fields($view = false){
    return [
      'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber', 'a.piece', 'a.best', 'a.specials', 'b.cid', 'c.id', 'd.id', 'e.id',
      'a.priceyard'
    ];
  }

  protected function build_search_filter(&$filter, $view = false){
    $hidden["fabrix_orders.aid"] = Controller_User::get_from_session()['aid'];
    $hidden['a.pnumber'] = 'null';
    if(!isset($filter['hidden']['a.priceyard'])) $hidden['a.priceyard'] = '0.00';
    $hidden['a.pvisible'] = '1';
    $hidden['a.image1'] = 'null';
    $filter['hidden'] = $hidden;
    $totalrows = forward_static_call([$this->model_name, 'get_total_count'], $filter);
    $filter['totalrows'] = $totalrows;
    $res = parent::build_search_filter($filter, $view);
    $filter['hidden'] = $hidden;
    $filter['totalrows'] = $totalrows;
    if(empty($totalrows)) {
      $res['firstpage'] = $filter['firstpage'] = (empty($res) && ($this->scenario() != 'empty'));
      if(!empty($filter['a.priceyard']) && is_string($filter['a.priceyard'])) {
        $prices_idx = $filter['a.priceyard'];
        $filter['a.priceyard'] = [];
        $res['a.priceyard'] = [];
        $rows = Model_Prices::get_list(0, 0, $res_count, $filter, $sort);
        if(!empty($rows[$prices_idx]['min_price'])) {
          $filter['a.priceyard']['from'] = $rows[$prices_idx]['min_price'];
          $res['a.priceyard']['from'] = $rows[$prices_idx]['min_price'];
        }
        if(!empty($rows[$prices_idx]['max_price'])) {
          $filter['a.priceyard']['to'] = $rows[$prices_idx]['max_price'];
          $res['a.priceyard']['to'] = $rows[$prices_idx]['max_price'];
        }
      }

      unset($filter['hidden']["fabrix_orders.aid"]);
    }

    return $res;
  }

  protected function build_order(&$sort, $view = false, $filter = null){
    $sort['b.displayorder'] = 'asc';
    $sort['fabrix_product_categories.display_order'] = 'asc';
  }

  protected function before_search_form_layout(&$search_data, $view = false){
    $categories = [];
    $filter = null;
    $sort = ['a.cname' => 'asc'];
    $rows = Model_Categories::get_list(0, 0, $res_count, $filter, $sort);
    foreach($rows as $row) $categories[$row['cid']] = $row['cname'];
    $sort = ['a.pattern' => 'asc'];
    $rows = Model_Patterns::get_list(0, 0, $res_count, $filter, $sort);
    $patterns = array_combine(array_column($rows, 'id'), array_column($rows, 'pattern'));
    $sort = ['a.color' => 'asc'];
    $rows = Model_Colors::get_list(0, 0, $res_count, $filter, $sort);
    $colors = array_combine(array_column($rows, 'id'), array_column($rows, 'color'));
    $sort = ['a.manufacturer' => 'asc'];
    $rows = Model_Manufacturers::get_list(0, 0, $res_count, $filter, $sort);
    $manufacturers = array_combine(array_column($rows, 'id'), array_column($rows, 'manufacturer'));
    $sort = null;
    $rows = Model_Prices::get_list(0, 0, $res_count, $filter, $sort);
    $prices = array_combine(array_column($rows, 'id'), array_column($rows, 'title'));

    $search_data['categories'] = $categories;
    $search_data['patterns'] = $patterns;
    $search_data['colors'] = $colors;
    $search_data['prices'] = $prices;
    $search_data['manufacturers'] = $manufacturers;
  }

  protected function after_get_list(&$rows, $view = false, $type = null){
    $url_prms = null;
    if(isset($type)) $url_prms['back'] = 'recommends';
    $this->template->vars('url_prms', $url_prms);
  }

  protected function load_search_filter($filter, $view){
    $search = null;
    if(!empty($filter['totalrows']) || ($this->scenario() == 'empty')) {
      $search = parent::load_search_filter($filter, $view);
    }

    return $search;
  }

  protected function load_sort($filter, $view = false){
    if(!empty($filter['totalrows'])) {
      $sort = parent::load_sort($filter, $view);
    } else {
      $this->build_order($sort, $view, $filter);
    }

    return $sort;
  }

  protected function search_form($search_form, $view = false){
    $template = ($view ? 'view' . DS : '') . (empty($search_form['firstpage']) ? 'search/form' : 'empty/search/form');
    $prms = null;
    if(!empty($this->scenario())) $prms['method'] = $this->scenario();
    $this->template->vars('action', _A_::$app->router()->UrlTo($this->controller . ($view ? '/view' : ''), $prms));
    $this->before_search_form_layout($search_form, $view);
    $this->template->vars('search', $search_form);
    try {
      $search_form = $this->main->view_layout_return($template);
    } catch(Exception $e) {
      $search_form = null;
    }
    $this->template->vars('search_form', $search_form);

    return $search_form;
  }

  protected function get_list($view = false, $return = false){
    $this->main->template->vars('page_title', $this->page_title);
    $search_form = $this->build_search_filter($filter, $view);
    if(!empty($filter['totalrows']) || ($this->scenario() == 'empty')) {
      $idx = $this->load_search_filter_get_idx($filter, $view);
      $pages = _A_::$app->session('pages');
      $per_pages = _A_::$app->session('per_pages');
      $page = !empty($pages[$this->controller][$idx]) ? $pages[$this->controller][$idx] : 1;
      $per_page = !empty($per_pages[$this->controller][$idx]) ? $per_pages[$this->controller][$idx] : $this->per_page;
      $sort = $this->load_sort($filter, $view);
      $filter['scenario'] = $this->scenario();
      $total = forward_static_call([$this->model_name, 'get_total_count'], $filter);
      if($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
      if($page <= 0) $page = 1;
      $start = (($page - 1) * $per_page);
      $res_count_rows = 0;
      $rows = forward_static_call_array([$this->model_name, 'get_list'], [
        $start, $per_page, &$res_count_rows, &$filter, &$sort
      ]);
      $this->after_get_list($rows, $view);
      if(isset($filter['active'])) $search_form['active'] = $filter['active'];
      $this->template->vars('scenario', $this->scenario());
      $this->search_form($search_form, $view);
      $this->template->vars('rows', $rows);
      $this->template->vars('sort', $sort);
      $this->template->vars('list', $this->template->view_layout_return($view ? 'view' . DS . 'rows' : 'rows'));
      $this->template->vars('count_rows', $res_count_rows);
      $prms = !empty($this->scenario()) ? ['method' => $this->scenario()] : null;
      (new Controller_Paginator($this->main))->paginator($total, $page, $this->controller . ($view ? '/view' : ''), $prms, $per_page);
      $this->set_back_url(empty($filter['totalrows']) ? 'recommends' : null);
      $this->before_list_layout($view);
      if($return) return $this->main->view_layout_return($view ? 'view' . DS . 'list' : 'list');
      $this->main->view_layout($view ? 'view' . DS . 'list' : 'list');
    } else {
      $this->scenario('empty');
      $this->template->vars('scenario', $this->scenario());
      $layout = $this->search_form($search_form, $view);
      if($return) return $layout;
      exit($layout);
    }
  }

  /**
   * @export
   */
  public function recommends(){
    $this->main->is_user_authorized(true);
    $this->template->vars('cart_enable', '_');
    parent::index(false);
  }

  public function index($required_access = true){
  }

  public function view($partial = false, $required_access = false){
  }

}