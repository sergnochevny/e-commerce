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
      parent::build_order($sort, $view);
      if($view) {
        $sort['a.id'] = 'desc';
      }
    }

    protected function before_search_form_layout(&$search_data, $view = false) {
      $categories = [];
      $filter = null;
      $sort = ['a.cname' => 'asc'];
      $rows = Model_Categories::get_list(0, 0, $res_count, $filter, $sort);
      foreach($rows as $row) $categories[$row['cid']] = $row['cname'];
      $patterns = [];
      $sort = ['a.pattern' => 'asc'];
      $rows = Model_Patterns::get_list(0, 0, $res_count, $filter, $sort);
      foreach($rows as $row) $patterns[$row['id']] = $row['pattern'];
      $colors = [];
      $sort = ['a.color' => 'asc'];
      $rows = Model_Colors::get_list(0, 0, $res_count, $filter, $sort);
      foreach($rows as $row) $colors[$row['id']] = $row['color'];
      $manufacturers = [];
      $sort = ['a.manufacturer' => 'asc'];
      $rows = Model_Manufacturers::get_list(0, 0, $res_count, $filter, $sort);
      foreach($rows as $row) $manufacturers[$row['id']] = $row['manufacturer'];

      $search_data['categories'] = $categories;
      $search_data['patterns'] = $patterns;
      $search_data['colors'] = $colors;
      $search_data['manufacturers'] = $manufacturers;
    }

    protected function after_get_list(&$rows, $view = false) {
      $related_selected = [];
      $pid = _A_::$app->get('pid');
      if(isset($pid)) {
        $filter['hidden']['view'] = true;
        $filter['hidden']['a.pid'] = $pid;
        $filter['hidden']['b.image1'] = 'null';
        $_rows = Model_Related::get_list(0, 0, $res_count_rows, $filter);
        if(isset($_rows)) foreach($_rows as $row) $related_selected[] = $row['pid'];
      }
      $this->template->vars('related_selected', $related_selected);
    }

    protected function get_list($view = false) {
      $c_product = new Controller_Product($this->main);
      $c_product->scenario($this->scenario());
      $search_form = $c_product->build_search_filter($filter, $view);
      $c_product->build_order($sort, $view);
      $pages = _A_::$app->session('pages');
      $idx = $this->load_search_filter_get_idx($filter, $view);
      $page = !empty($pages[$this->controller][$idx]) ? $pages[$this->controller][$idx] : 1;
      $per_page = $this->per_page;
      $total = Model_Product::get_total_count($filter);
      if($page > ceil($total / $per_page)) $page = ceil($total / $per_page);
      if($page <= 0) $page = 1;
      $start = (($page - 1) * $per_page);
      $res_count_rows = 0;
      $rows = Model_Product::get_list($start, $per_page, $res_count_rows, $filter, $sort);
      $this->after_get_list($rows, $view);
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
      (new Controller_Paginator($this->main))->paginator($total, $page, $this->controller, null, $per_page);
      $this->before_list_layout($view);
      $this->main->view_layout('list');
    }

    /**
     * @export
     */
    public function view() {
      if(_A_::$app->request_is_ajax()) Controller_Controller::get_list(true);
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

    public function delete($required_access = true) {
      parent::delete($required_access);
    }

  }