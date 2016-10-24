<?php

  class Controller_Controller extends Controller_Base {

    protected $main;

    public function __construct(Controller_Base $main = null) {
      $this->layouts = _A_::$app->config('layouts');
      parent::__construct();
      if(isset($main) && (explode('_', get_class($main))[0] == 'Controller')) {
        $this->main = $main;
      } else {
        $this->main = new Controller_Main($this);
      }
    }

    protected function search_form($search_form){
      $this->template->vars('search', $search_form);
      $this->template->vars('action', _A_::$app->router()->UrlTo($this->controller));
      $search_form = null;
      ob_start();
      try {
        $this->main->view_layout('search/form');
        $search_form = ob_get_contents();
      } catch(Exception $e) {
      }
      ob_end_clean();
      $this->template->vars('search_form', $search_form);
    }

    protected function after_get_list(&$rows) { }

    protected function search_fields() {
      return null;
    }

    protected function build_search_filter(&$filter) {
      $search_form = null;
      $filter = null;
      $fields = $this->search_fields();
      if(isset($fields)) {
        if(_A_::$app->request_is_post()) $search = _A_::$app->post('search');
        else  $search = _A_::$app->get('search');
        if(isset($search)) {
          $search_form = array_filter($search);
          foreach($fields as $key) {
            if(isset($search_form[$key])) $filter[$key] = $search_form[$key];
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
          if(_A_::$app->request_is_post()) $search = _A_::$app->post('search');
          else  $search = _A_::$app->get('search');
          if(isset($search)) {
            $search = array_filter($search);
            foreach($search as $key => $item) {
              if(preg_match($fields_pattern, $fields[$key]['Type'], $matches) !== false) {
                if(count($matches) > 1) {
                  if(is_array($item)) {
                    $filter[$key] = [$fields_type[$matches[1]][1], $item];
                  }
                  $filter[$key] = [$fields_type[$matches[1]][0], $item];
                }
                $search_form[$key] = $item;
              }
            }
          }
        }
      }

      $this->search_form($search_form);
    }

    protected function get_list() {
      $this->build_search_filter($filter);
      $page = !empty(_A_::$app->get('page')) ? _A_::$app->get('page') : 1;
      $per_page = 12;
      $total = forward_static_call([$this->model_name, 'get_total_count'], $filter);
      if($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
      if($page <= 0) $page = 1;
      $start = (($page - 1) * $per_page);
      $res_count_rows = 0;
      $rows = forward_static_call_array([$this->model_name, 'get_list'], [$start, $per_page, &$res_count_rows, $filter]);
      $this->after_get_list($rows);
      $this->template->vars('rows', $rows);
      ob_start();
      $this->template->view_layout('rows');
      $rows = ob_get_contents();
      ob_end_clean();
      $this->template->vars('count_rows', $res_count_rows);
      $this->template->vars('list', $rows);
      (new Controller_Paginator($this->main))->paginator($total, $page, $this->controller, $per_page);
      $this->main->view_layout('list');
    }

    /**
     * @export
     */
    public function index() {
      $this->main->test_access_rights();
      ob_start();
      $this->get_list();
      $list = ob_get_contents();
      ob_end_clean();
      if(_A_::$app->request_is_ajax()) exit($list);
      $this->template->vars('list', $list);
      if(Controller_Admin::is_logged()) $this->main->view_admin($this->controller);
      else  $this->main->view($this->controller);
    }

  }