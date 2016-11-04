<?php

  class Controller_Related extends Controller_FormSimple {

    protected function search_fields($view = false) {
      return ['a.pid'];
    }

    protected function build_search_filter(&$filter, $view = false) {
      $res = parent::build_search_filter($filter, $view);
      $filter['hidden']['a.pid'] = _A_::$app->get('pid');
      if(!isset($filter['hidden']['a.pid'])) throw new Exception('No Related Products');
      return $res;
    }

    protected function load(&$data) {
      $data['pid'] = _A_::$app->get('pid');
      $data['r_pid'] = _A_::$app->post('r_pid');
    }

    protected function validate(&$data, &$error) {
      return true;
    }

    protected function build_order(&$sort, $view = false) {
      $sort['a.id'] = 'desc';
    }

    public function index($required_access = true) { }

    public function view() { }

    public function edit($required_access = true) { }

    /**
     * @export
     */
    public function related() {
      if(_A_::$app->request_is_ajax()) exit($this->get_list(true));
      else throw new Exception('No Related Products');
    }

  }