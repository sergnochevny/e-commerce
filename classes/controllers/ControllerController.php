<?php

namespace classes\controllers;

use app\core\App;
use app\core\controller\ControllerBase;
use app\core\model\ModelBase;
use classes\Paginator;
use Closure;
use controllers\ControllerAdmin;
use Exception;

/**
 * Class ControllerController
 */
abstract class ControllerController extends ControllerBase{

  protected $id_field = '';
  protected $name_field = '';
  protected $data_field = '';
  protected $main;
  protected $per_page = 12;
  protected $_scenario = '';
  protected $resolved_scenario = [''];
  protected $view_title;
  protected $page_title;

  protected $reset = [
    'reset' => 'all'
  ];

  /**
   * ControllerController constructor.
   * @param ControllerBase|null $main
   */
  public function __construct(ControllerBase $main = null){
    $this->layouts = App::$app->config('layouts');
    parent::__construct();
    if(isset($main) && (strpos(get_class($main), 'Controller') !== false)) {
      $this->main = $main;
    } else {
      $this->main = new ControllerMain($this);
    }
  }

  /**
   * @param $search_data
   * @param bool $view
   */
  protected function before_search_form_layout(&$search_data, $view = false){
  }

  /**
   * @param bool $view
   */
  protected function before_list_layout($view = false){
  }

  /**
   * @param $sort
   * @param bool $view
   * @param null $filter
   */
  protected function build_order(&$sort, $view = false, $filter = null){
    $sort = App::$app->get('sort');
    if(isset($sort)) {
      $order = is_null(App::$app->get('order')) ? 'DESC' : App::$app->get('order');
      $sort = [$sort => $order];
    } elseif(!is_null(App::$app->post('sort'))) {
      $sort = App::$app->post('sort');
      $order = is_null(App::$app->post('order')) ? 'DESC' : App::$app->post('order');
      $sort = [$sort => $order];
    }
  }

  /**
   * @param $search_form
   * @param bool $view
   * @return null
   * @throws \Exception
   */
  protected function search_form($search_form, $view = false){
    $template = $view ? 'view' . DS . (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'search/form' : (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'search/form';
    $prms = null;
    if(!empty($this->scenario())) $prms['method'] = $this->scenario();
    $this->template->vars('action', App::$app->router()->UrlTo($this->controller . ($view ? '/view' : ''), $prms));
    $this->before_search_form_layout($search_form, $view);
    $this->template->vars('search', $search_form);
    $search_form = null;
    try {
      $search_form = $this->main->render_layout_return($template);
    } catch(Exception $e) {
    }
    $this->template->vars('search_form', $search_form);

    return $search_form;
  }

  /**
   * @param $rows
   * @param bool $view
   * @param $filter
   * @param null $search_form
   */
  protected function after_get_list(&$rows, $view = false, &$filter = null, &$search_form = null){
  }

  /**
   * @param bool $view
   * @return null
   */
  protected function search_fields($view = false){
    return null;
  }

  /**
   * @param null $back_url
   * @param null $prms
   */
  protected function build_back_url(&$back_url = null, &$prms = null){
    $back_url = $this->controller;
    if($back_url == App::$app->router()->action) $back_url = null;
    if(!empty(App::$app->get('back'))) $back_url = App::$app->get('back');
  }

  /**
   * @param null $back_url
   * @param null $prms
   * @throws \Exception
   */
  protected function set_back_url($back_url = null, $prms = null){
    if(!isset($back_url)) $this->build_back_url($back_url, $prms);
    if(isset($back_url)) {
      $back_url = App::$app->router()->UrlTo($back_url, $prms, null, null, false, true);
      $this->template->vars('back_url', $back_url);
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
   * @param $filter
   * @param $view
   * @return array|null|string
   * @throws \InvalidArgumentException
   */
  protected function load_search_filter($filter, $view){
    //  Implementation save the search context
    $idx = $this->load_search_filter_get_idx($filter, $view);
    if(App::$app->request_is_post()) {

      $per_page = App::$app->post('per_page');
      if(!empty($per_page)) {
        $per_pages = App::$app->session('per_pages');
        $per_pages[$this->controller][$idx] = $per_page;
        App::$app->setSession('per_pages', $per_pages);
      }
      if(!empty(App::$app->get('page'))) {
        $pages = App::$app->session('pages');
        $pages[$this->controller][$idx] = App::$app->get('page');
        App::$app->setSession('pages', $pages);
      }
      $search = $this->search_from_post();
      if(isset($search)) {
        if(isset($search['hidden'])) unset($search['hidden']);
        if((is_array($search) && !count($search)) || !is_array($search)) $search = null;
      }
      if(isset($search)) {
        if(empty(App::$app->get('page'))) {
          $pages = App::$app->session('pages');
          if(isset($pages[$this->controller][$idx])) {
            unset($pages[$this->controller][$idx]);
            App::$app->setSession('pages', $pages);
          }
        }
        $search = $this->search_from_post();
        if(isset($search['active_filter'])) unset($search['active_filter']);
        $filters = App::$app->session('filters');
        if(!isset($search['reset']) && !isset($search['reset_filter'])) {
          $filters[$this->controller][$idx] = $search;
        } else {
          foreach($this->reset as $reset => $fields) {
            if(isset($search[$reset])) {
              if($fields === 'all') {
                unset($filters[$this->controller][$idx]);
              } else {
                foreach($fields as $field) {
                  if(isset($filters[$this->controller][$idx][$field])) {
                    unset($filters[$this->controller][$idx][$field]);
                  }
                }
              }
            }
          }
        }
        App::$app->setSession('filters', $filters);
      }
    }

    $filters = App::$app->session('filters');
    if(isset($filters[$this->controller][$idx])) {
      $search = $filters[$this->controller][$idx];
    } else $search = null;

    return $search;
  }

  /**
   * @param $controller
   * @return array|null|string
   */
  protected function load_search_filter_by_controller($controller){
    $idx = $this->load_search_filter_get_idx(null);
    $filters = App::$app->session('filters');
    if(isset($filters[$controller][$idx])) {
      $search = $filters[$controller][$idx];
    } else $search = null;

    return $search;
  }

  /**
   * @param $filter
   * @param bool $view
   * @return array|null
   * @throws \InvalidArgumentException
   */
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
            if(!in_array($key, ModelBase::$filter_exclude_keys)) {
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

  /**
   * @param $filter
   * @param bool $view
   * @return null
   */
  protected function load_sort($filter, $view = false){
    $idx = $this->load_search_filter_get_idx($filter, $view);
    $sorts = App::$app->session('sorts');
    $sort = null;
    if(is_null(App::$app->get('sort')) && is_null(App::$app->post('sort')))
      $sort = !empty($sorts[$this->controller][$idx]) ? $sorts[$this->controller][$idx] : null;
    if(empty($sort)) $this->build_order($sort, $view, $filter);
    if(!empty($sort)) {
      $sorts[$this->controller][$idx] = $sort;
      App::$app->setSession('sorts', $sorts);
    }

    return $sort;
  }

  /**
   * @param bool $view
   * @param bool $return
   * @return mixed
   * @throws \Exception
   */
  protected function get_list($view = false, $return = false){
    $this->main->template->vars('page_title', $this->page_title);
    $search_form = $this->build_search_filter($filter, $view);
    $idx = $this->load_search_filter_get_idx($filter, $view);
    $pages = App::$app->session('pages');
    $per_pages = App::$app->session('per_pages');
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
    $this->after_get_list($rows, $view, $filter, $search_form);
    if(isset($filter['active'])) $search_form['active'] = $filter['active'];
    $this->template->vars('scenario', $this->scenario());
    $this->search_form($search_form, $view);
    $this->template->vars('rows', $rows);
    $this->template->vars('sort', $sort);
    $this->template->vars('list', $this->template->render_layout_return($view ? 'view' . DS . (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'rows' : (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'rows'));
    $this->template->vars('count_rows', $res_count_rows);
    $prms = !empty($this->scenario()) ? ['method' => $this->scenario()] : null;
    (new Paginator($this->main))->paginator($total, $page, $this->controller . ($view ? '/view' : ''), $prms, $per_page);
    $this->set_back_url();
    $this->before_list_layout($view);
    if($return) return $this->main->render_layout_return($view ? 'view' . DS . (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'list' : (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'list');
    $this->main->render_layout($view ? 'view' . DS . (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'list' : (!empty($this->scenario()) ? $this->scenario() . DS : '') . 'list');
  }

  /**
   * @param int $page
   * @param bool $view
   * @param int $per_page
   * @return mixed|null
   * @throws \InvalidArgumentException
   */
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

  /**
   * @param $row
   * @param $view
   * @return string
   * @throws \Exception
   */
  protected function build_sitemap_url($row, $view){
    $prms = [$this->id_field => $row[$this->id_field]];
    $url = $this->controller . ($view ? DS . 'view' : '');
    $sef = $row[$this->name_field];

    return App::$app->router()->UrlTo($url, $prms, $sef);
  }

  /**
   * @param $row
   * @param $view
   * @param string $changefreq
   * @param $priority
   * @return array
   * @throws \Exception
   */
  protected function build_sitemap_item($row, $view, $changefreq = 'monthly', $priority = 0.5){
    $loc = $this->build_sitemap_url($row, $view);
    if(!empty($row['changefreq'])) {
      $changefreq = $row['changefreq'];
    }
    if(!empty($row['priority'])) {
      $priority = $row['priority'];
    }
    $item = ['loc' => $loc, 'changefreq' => $changefreq, 'priority' => $priority];
    if(!empty($this->data_field)) $item['lastmod'] = date('Y-m-d', strtotime($row[$this->data_field]));

    return $item;
  }

  /**
   * @return [][]|array|string
   */
  protected function search_from_post(){
    $search = App::$app->post('search');
    $search = array_filter(is_array($search) ? $search : [],
      function($val){
        if(is_array($val)) return !empty(array_filter($val));

        return !empty($val);
      }
    );

    return $search;
  }

  /**
   * @return null
   */
  public static function urlto_sef_ignore_prms(){
    return null;
  }

  /**
   * @param null $scenario
   * @return null|string
   */
  public function scenario($scenario = null){
    if(!is_null($scenario) && in_array($scenario, $this->resolved_scenario)) {
      $this->_scenario = $scenario;
    }

    return $this->_scenario;
  }

  /**
   * @export
   * @throws \Exception
   */
  public function index($required_access = true){
    if($required_access) $this->main->is_admin_authorized();
    $list = $this->get_list(false, true);
    if(App::$app->request_is_ajax()) exit($list);
    $this->template->vars('list', $list);
    if(ControllerAdmin::is_logged()) $this->main-> render_view_admin($this->controller);
    else  $this->main->render_view((!empty($this->scenario()) ? $this->scenario() . DS : '') . $this->controller);
  }

  /**
   * @export
   * @throws \Exception
   */
  public function view($partial = false, $required_access = false){
    if($required_access) $this->main->is_admin_authorized();
    $this->template->vars('view_title', $this->view_title);
    $list = $this->get_list(true, true);
    if(App::$app->request_is_ajax()) exit($list);
    $this->template->vars('scenario', $this->scenario());
    $this->template->vars('list', $list);
    if($partial) $this->main->render_layout('view' . (!empty($this->scenario()) ? DS . $this->scenario() : '') . DS . $this->controller);
    elseif($required_access) $this->main-> render_view_admin('view' . (!empty($this->scenario()) ? DS . $this->scenario() : '') . DS . $this->controller);
    else $this->main->render_view('view' . (!empty($this->scenario()) ? DS . $this->scenario() : '') . DS .
      $this->controller);
  }

  /**
   * @return null
   */
  public static function sitemap_order(){
    return null;
  }

  /**
   * @return bool
   */
  public static function sitemap_view(){
    return false;
  }

  /**
   * @param \Closure $function
   * @param bool $view
   * @throws \Exception
   */
  public function sitemap(Closure $function, $view = false){
    $data = null;
    $page = 1;
    while($rows = $this->sitemap_get_list($page++)) {
      foreach($rows as $row) {
        $data[] = $this->build_sitemap_item($row, $view);
      }
      $function->__invoke($data);
    }
  }

}