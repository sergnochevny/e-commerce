<?php

  class Controller_Related extends Controller_FormSimple {

    protected function search_fields($view = false) {
      if($view) {
        return ['a.pid'];
      } else {
        return [
          'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber',
          'a.piece', 'a.best', 'a.specials', 'b.cid',
          'c.id', 'd.id', 'e.id'
        ];
      }
    }

    protected function build_search_filter(&$filter, $view = false) {
      $res = parent::build_search_filter($filter, $view);
      $filter['hidden']['a.pid'] = _A_::$app->get('pid');
      if(!isset($filter['hidden']['a.pid'])) throw new Exception('No Related Products');
      $filter['hidden']['b.image1'] = 'null';
      if($view) {
        $filter['hidden']['b.pnumber'] = 'null';
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
      if($view) {
        $sort['a.id'] = 'desc';
      }
    }

    protected function get_list($view = false) {

      $c_product = new Controller_Product($this->main);
      $search_form = $c_product->build_search_filter($filter, $view);
      $c_product->build_order($sort, $view);
      $page = !empty(_A_::$app->get('page')) ? _A_::$app->get('page') : 1;
      $per_page = 12;
      $total = Model_Product::get_total_count($filter);
      if($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
      if($page <= 0) $page = 1;
      $start = (($page - 1) * $per_page);
      $res_count_rows = 0;
      $rows = Model_Product::get_list($start, $per_page, $res_count_rows, $filter, $sort);
      $c_product->after_get_list($rows, $view);
      if(isset($filter['active'])) $search_form['active'] = $filter['active'];
      $this->search_form($search_form, $view);
      $this->template->vars('rows', $rows);
      $this->template->vars('sort', $sort);
      ob_start();
      $this->template->view_layout('rows');
      $rows = ob_get_contents();
      ob_end_clean();
      $this->template->vars('count_rows', $res_count_rows);
      $this->template->vars('list', $rows);
      (new Controller_Paginator($this->main))->paginator($total, $page, $this->controller, $per_page);
      $this->before_list_layout($view);
      $this->main->view_layout('list');
    }

    /**
     * @export
     */
    public function view() {
      if(_A_::$app->request_is_ajax()) parent::view();
      else throw new Exception('No Related Products');
    }

    /**
     * @export
     */
    public function index($required_access = true) {
      if($required_access) $this->main->is_admin_authorized();
      ob_start();
      $this->get_list();
      $list = ob_get_contents();
      ob_end_clean();
      if(_A_::$app->request_is_ajax()) exit($list);
      else {
        throw new Exception('Error 404');
      }
    }

  }