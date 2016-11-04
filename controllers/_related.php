<?php

  class Controller_Related extends Controller_FormSimple {

    protected function search_fields($view = false) {
      if ($view){
        return ['a.pid'];
      }
    }

    protected function build_search_filter(&$filter, $view = false) {
      $res = parent::build_search_filter($filter, $view);
      $filter['hidden']['a.pid'] = _A_::$app->get('pid');
      if(!isset($filter['hidden']['a.pid'])) throw new Exception('No Related Products');
      $filter['hidden']['b.pnumber'] = 'null';
      $filter['hidden']['b.image1'] = 'null';
      if ($view){
        $filter['hidden']['b.pvisible'] = '1';
      }
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
      if($view){
        $sort['a.id'] = 'desc';
      }
    }

    /**
     * @export
     */
    public function view() {
      if(_A_::$app->request_is_ajax()) parent::view();
      else throw new Exception('No Related Products');

    }


  }