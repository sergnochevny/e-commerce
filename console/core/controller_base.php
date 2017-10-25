<?php

abstract class Controller_Base{

  protected $controller;
  protected $model_name;
  public $registry;
  public $vars = [];

  public function __construct(){
    $this->registry = _A_::$app->registry();
    $this->controller = strtolower(str_replace('Controller_', '', get_called_class()));
    $this->model_name = 'Model_' . ucfirst($this->controller);
  }

  protected function search_fields($view = false){
    return null;
  }

  protected function build_search_filter(&$filter, $view = false){
    $search_form = null;
    $fields = $this->search_fields($view);
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
    $sort = null;
    if(empty($sort)) $this->build_order($sort, $view, $filter);

    return $sort;
  }

}
