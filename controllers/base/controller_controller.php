<?php

abstract class Controller_Controller extends Controller_Base{

  protected $id_field = '';
  protected $name_field = '';
  protected $data_field = '';
  protected $main;
  protected $per_page = 12;
  protected $_scenario = '';
  protected $resolved_scenario = [''];
  protected $view_title;
  protected $page_title;

  public function __construct(Controller_Base $main = null){
    $this->layouts = _A_::$app->config('layouts');
    parent::__construct();
    if(isset($main) && (explode('_', get_class($main))[0] == 'Controller')) {
      $this->main = $main;
    } else {
      $this->main = new Controller_Main($this);
    }
  }

  protected function before_search_form_layout(&$search_data, $view = false){
  }

  protected function before_list_layout($view = false){
  }

  protected function build_order(&$sort, $view = false, $filter = null){
    $sort = _A_::$app->get('sort');
    if(isset($sort)) {
      $order = is_null(_A_::$app->get('order')) ? 'DESC' : _A_::$app->get('order');
      $sort = [$sort => $order];
    } elseif(!is_null(_A_::$app->post('sort'))) {
      $sort = _A_::$app->post('sort');
      $order = is_null(_A_::$app->post('order')) ? 'DESC' : _A_::$app->post('order');
      $sort = [$sort => $order];
    }
  }

  protected function search_form($search_form, $view = false){
    $template = $view ? 'view' . DS . (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'search/form' : (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'search/form';
    $prms = null;
    if(!empty($this->scenario())) $prms['method'] = $this->scenario();
    $this->template->vars('action', _A_::$app->router()->UrlTo($this->controller . ($view ? '/view' : ''), $prms));
    $this->before_search_form_layout($search_form, $view);
    $this->template->vars('search', $search_form);
    $search_form = null;
    try {
      $search_form = $this->main->view_layout_return($template);
    } catch(Exception $e) {
    }
    $this->template->vars('search_form', $search_form);

    return $search_form;
  }

  protected function after_get_list(&$rows, $view = false){
  }

  protected function search_fields($view = false){
    return null;
  }

  protected function build_back_url(&$back_url = null, &$prms = null){
    $back_url = $this->controller;
    if($back_url == _A_::$app->router()->action) $back_url = null;
    if(!empty(_A_::$app->get('back'))) $back_url = _A_::$app->get('back');
  }

  protected function set_back_url($back_url = null, $prms = null){
    if(!isset($back_url)) $this->build_back_url($back_url, $prms);
    if(isset($back_url)) {
      $back_url = _A_::$app->router()->UrlTo($back_url, $prms, null, null, false, true);
      $this->template->vars('back_url', $back_url);
    }
  }

  protected function load_search_filter_get_idx($filter, $view = false){
    $idx = Controller_AdminBase::is_logged() . '_' . $view;
    $idx .= (isset($filter['type']) ? $filter['type'] : '') . (!empty($this->scenario()) ? $this->scenario() : '');
    $idx = !empty($idx) ? $idx : 0;

    return $idx;
  }

  protected function load_search_filter($filter, $view){
    //  Implementation save the search context
    $idx = $this->load_search_filter_get_idx($filter, $view);
    if(_A_::$app->request_is_post()) {

      $per_page = _A_::$app->post('per_page');
      if(!empty($per_page)) {
        $per_pages = _A_::$app->session('per_pages');
        $per_pages[$this->controller][$idx] = $per_page;
        _A_::$app->setSession('per_pages', $per_pages);
      }
      if(!empty(_A_::$app->get('page'))) {
        $pages = _A_::$app->session('pages');
        $pages[$this->controller][$idx] = _A_::$app->get('page');
        _A_::$app->setSession('pages', $pages);
      }
      //
      $search = _A_::$app->post('search');
      $search = array_filter(is_array($search) ? $search : [],
        function($val){
          if(is_array($val)) return !empty(array_filter($val));

          return !empty($val);
        }
      );
      //_A_::$app->post('search');
      if(isset($search)) {
        if(isset($search['hidden'])) unset($search['hidden']);
        if((is_array($search) && !count($search)) || !is_array($search)) $search = null;
      }
      if(isset($search)) {
        if(empty(_A_::$app->get('page'))) {
          $pages = _A_::$app->session('pages');
          if(isset($pages[$this->controller][$idx])) {
            unset($pages[$this->controller][$idx]);
            _A_::$app->setSession('pages', $pages);
          }
        }
        //
        $search = _A_::$app->post('search');
        $search = array_filter(is_array($search) ? $search : [],
          function($val){
            if(is_array($val)) return !empty(array_filter($val));

            return !empty($val);
          }
        );
        //_A_::$app->post('search');
        $filters = _A_::$app->session('filters');
        if(!isset($search['reset'])) {
          $filters[$this->controller][$idx] = $search;
        } else {
          unset($filters[$this->controller][$idx]);
        }
        _A_::$app->setSession('filters', $filters);
      } else {
        $filters = _A_::$app->session('filters');
        if(isset($filters[$this->controller][$idx])) {
          $search = $filters[$this->controller][$idx];
        } else return null;
      }
    } else {
      $filters = _A_::$app->session('filters');
      if(isset($filters[$this->controller][$idx])) {
        $search = $filters[$this->controller][$idx];
      } else return null;
    }

    return $search;
  }

  protected function build_search_filter(&$filter, $view = false){
    $search_form = null;
    $fields = $this->search_fields($view);
    $search = $this->load_search_filter($filter, $view);
    $filter = null;
    if(isset($fields)) {
      $h_search = isset($search['hidden']) ? $search['hidden'] : null;
      if(isset($search)) {
        $search_form = array_filter($search, function($val){
          if(is_array($val)) return true;

          return (strlen(trim($val)) > 0);
        });
        foreach($fields as $key) {
          if(isset($search_form[$key])) $filter[$key] = $search_form[$key];
        }
      }
      if(isset($h_search)) {
        $h_search_form = array_filter($h_search, function($val){
          if(is_array($val)) return true;

          return (strlen(trim($val)) > 0);
        });
        foreach($fields as $key) {
          if(isset($h_search_form[$key])) $h_filter[$key] = $h_search_form[$key];
        }
      }
    } else {
      $fields_type = [
        'int' => ['=', 'between'],
        'timestamp' => ['=', 'between'],
        'double' => ['=', 'between'],
        'float' => ['=', 'between'],
        'decimal' => ['=', 'between'],
        'text' => ['like', 'like'],
        'char' => ['like', 'like'],
        'string' => ['like', 'like']
      ];
      $fields_pattern = '#\b[\S]*(int|string|text|char|float|double|decimal|timestamp)[\S]*\b#';
      $fields = forward_static_call([$this->model_name, 'get_fields']);
      if(isset($fields)) {
        $h_search = isset($search['hidden']) ? $search['hidden'] : null;
        if(isset($search)) {
          $search = array_filter($search);
          foreach($search as $key => $item) {
            if(!in_array($key, Model_Base::$filter_exclude_keys)) {
              if(preg_match($fields_pattern, $fields[$key]['Type'], $matches) !== false) {
                if(count($matches) > 1) {
                  if(is_array($item)) {
                    $filter[$key] = [$fields_type[$matches[1]][1], $item];
                  } else  $filter[$key] = [$fields_type[$matches[1]][0], $item];
                }
                $search_form[$key] = $item;
              }
            } else $filter[$key] = $item;
          }
        }
        if(isset($h_search)) {
          $h_search = array_filter($h_search);
          foreach($h_search as $key => $item) {
            if(preg_match($fields_pattern, $fields[$key]['Type'], $matches) !== false) {
              if(count($matches) > 1) {
                if(is_array($item)) {
                  $h_filter[$key] = [$fields_type[$matches[1]][1], $item];
                } else  $h_filter[$key] = [$fields_type[$matches[1]][0], $item];
              }
              $h_search_form[$key] = $item;
            }
          }
        }
      }
    }
    if(isset($h_search_form)) $search_form['hidden'] = $h_search_form;
    if(isset($h_filter)) $filter['hidden'] = $h_filter;

    return $search_form;
  }

  protected function load_sort($filter, $view = false){
    $idx = $this->load_search_filter_get_idx($filter, $view);
    $sorts = _A_::$app->session('sorts');
    $sort = null;
    if(is_null(_A_::$app->get('sort')) && is_null(_A_::$app->post('sort')))
      $sort = !empty($sorts[$this->controller][$idx]) ? $sorts[$this->controller][$idx] : null;
    if(empty($sort)) $this->build_order($sort, $view, $filter);
    if(!empty($sort)) {
      $sorts[$this->controller][$idx] = $sort;
      _A_::$app->setSession('sorts', $sorts);
    }

    return $sort;
  }

  protected function get_list($view = false, $return = false){
    $this->main->template->vars('page_title', $this->page_title);
    $search_form = $this->build_search_filter($filter, $view);
    $idx = $this->load_search_filter_get_idx($filter, $view);
    $pages = _A_::$app->session('pages');
    $per_pages = _A_::$app->session('per_pages');
    $sort = $this->load_sort($filter, $view);
    $page = !empty($pages[$this->controller][$idx]) ? $pages[$this->controller][$idx] : 1;
    $per_page = !empty($per_pages[$this->controller][$idx]) ? $per_pages[$this->controller][$idx] : $this->per_page;
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
    $this->template->vars('list', $this->template->view_layout_return($view ? 'view' . DS . (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'rows' : (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'rows'));
    $this->template->vars('count_rows', $res_count_rows);
    $prms = !empty($this->scenario()) ? ['method' => $this->scenario()] : null;
    (new Controller_Paginator($this->main))->paginator($total, $page, $this->controller . ($view ? '/view' : ''), $prms, $per_page);
    $this->set_back_url();
    $this->before_list_layout($view);
    if($return) return $this->main->view_layout_return($view ? 'view' . DS . (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'list' : (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'list');
    $this->main->view_layout($view ? 'view' . DS . (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'list' : (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'list');
  }

  protected function sitemap_get_list($page = 0, $view = false, $per_page = 1000){
    $this->build_search_filter($filter, $view);
    $this->build_order($sort, $view, $filter);
    $filter['scenario'] = $this->scenario();
    if($page <= 0) $page = 1;
    $start = (($page - 1) * $per_page);
    $res_count_rows = 0;
    $rows = forward_static_call_array([$this->model_name, 'get_list'], [
      $start, $per_page, &$res_count_rows, &$filter, &$sort
    ]);

    return ($res_count_rows > 0) ? $rows : null;
  }

  protected function build_sitemap_url($row, $view){
    $prms = [$this->id_field => $row[$this->id_field]];
    $url = $this->controller . ($view ? DS . 'view' : '');
    $sef = $row[$this->name_field];

    return _A_::$app->router()->UrlTo($url, $prms, $sef);
  }

  protected function build_sitemap_item($row, $view){
    $loc = $this->build_sitemap_url($row, $view);
    $item = ['loc' => $loc, 'changefreq' => 'monthly', 'priority' => 0.5,];
    if(!empty($this->data_field)) $item['lastmod'] = date('Y-m-d', strtotime($row[$this->data_field]));

    return $item;
  }

  public static function urlto_sef_ignore_prms(){
    return null;
  }

  public function scenario($scenario = null){
    if(!is_null($scenario) && in_array($scenario, $this->resolved_scenario)) {
      $this->_scenario = $scenario;
    }

    return $this->_scenario;
  }

  /**
   * @export
   */
  public function index($required_access = true){
    if($required_access) $this->main->is_admin_authorized();
    $list = $this->get_list(false, true);
    if(_A_::$app->request_is_ajax()) exit($list);
    $this->template->vars('list', $list);
    if(Controller_Admin::is_logged()) $this->main->view_admin($this->controller);
    else  $this->main->view((!empty($this->scenario()) ? $this->scenario() . DS : '') . $this->controller);
  }

  /**
   * @export
   */
  public function view($partial = false, $required_access = false){
    if($required_access) $this->main->is_admin_authorized();
    $this->template->vars('view_title', $this->view_title);
    $list = $this->get_list(true, true);
    if(_A_::$app->request_is_ajax()) exit($list);
    $this->template->vars('scenario', $this->scenario());
    $this->template->vars('list', $list);
    if($partial) $this->main->view_layout('view' . (!empty($this->scenario()) ? DS . $this->scenario() : '') . DS . $this->controller);
    elseif($required_access) $this->main->view_admin('view' . (!empty($this->scenario()) ? DS . $this->scenario() : '') . DS . $this->controller);
    else $this->main->view('view' . (!empty($this->scenario()) ? DS . $this->scenario() : '') . DS . $this->controller);
  }

  public static function sitemap_order(){
    return null;
  }

  public static function sitemap_view(){
    return false;
  }

  public function sitemap(Closure $function, $view = false){
    $data = null;
    $page = 1;
    while($rows = $this->sitemap_get_list($page++)) {
      foreach($rows as $row) $data[] = $this->build_sitemap_item($row, $view);
      $function->__invoke($data);
    }
  }

}