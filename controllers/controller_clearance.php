<?php

  class Controller_Clearance extends Controller_FormSimple {

    protected $id_field = 'id';
    protected $view_title = 'Clearance Decorator and Designer Fabrics Online';
    protected $form_title_add = 'Add Product To Clearance';
    protected $resolved_scenario = ['', 'add'];
    protected $save_warning = "The Fabric has been added to Clearance successfully!";

    protected function search_fields($view = false) {
      if($view) {
        $fields = [
          'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber',
          'a.piece', 'a.best', 'a.specials', 'b.cid',
          'c.id', 'd.id', 'e.id', 'a.priceyard'
        ];
      } else {
        $fields = [
          'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber',
          'a.piece', 'a.best', 'a.specials', 'b.cid',
          'c.id', 'd.id', 'e.id'
        ];
      }
      return $fields;
    }

    protected function load(&$data) {
      $data['pid'] = _A_::$app->post('pid');
    }

    protected function validate(&$data, &$error) {
      return true;
    }

    protected function build_search_filter(&$filter, $view = false) {
      $res = parent::build_search_filter($filter, $view);
      if($view) {
        $filter['hidden']['a.pnumber'] = 'null';
        if(!isset($filter['hidden']['a.priceyard']) && !isset($filter['a.priceyard'])) $filter['hidden']['a.priceyard'] = '0.00';
        $filter['hidden']['a.pvisible'] = '1';
        $filter['hidden']['a.image1'] = 'null';
        $filter['hidden']['view'] = true;
      }
      return $res;
    }

    protected function build_order(&$sort, $view = false) {
      if($view) {
        $sort['b.displayorder'] = 'asc';
        $sort['fabrix_product_categories.display_order'] = 'asc';
      } else {
        if($this->scenario() == 'add') {
          $sort = ['a.pid' => 'desc'];
        } else {
          $sort['z.id'] = 'asc';
        }
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

    protected function before_form_layout(&$data = null) {
      if($this->scenario() !== 'add'){
        _A_::$app->get('page', null);
      } else {
        $search_form = $this->build_search_filter($filter);
        $this->search_form($search_form);
      }
      $this->scenario('');
    }

    protected function after_get_list(&$rows, $view = false, $type = null) {
      $url_prms = null;
      if($view){
        $url_prms['back'] = urlencode(base64_encode('clearance/view'));
      }else{
        $url_prms['back'] = 'clearance';
      }
      $this->template->vars('url_prms', $url_prms);
    }

    public function edit($required_access = true) { }

    /**
     * @export
     */
    public function view($partial = false, $required_access = false) {
      $this->template->vars('cart_enable', '_');
      parent::view($partial, $required_access);
    }

  }