<?php

  class Controller_Recommends extends Controller_Controller {

    protected function search_fields($view = false) {
      return [
        'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber',
        'a.piece', 'a.best', 'a.specials', 'b.cid',
        'c.id', 'd.id', 'e.id', 'a.priceyard'
      ];
    }

    protected function build_search_filter(&$filter, $view = false) {
      $search = null;
      $res = parent::build_search_filter($filter, $view);

      $filter['hidden']["fabrix_orders.aid"] = Controller_User::get_from_session()['aid'];
      $filter['hidden']['a.pnumber'] = 'null';
      if(!isset($filter['hidden']['a.priceyard']) && !isset($filter['a.priceyard'])) $filter['hidden']['a.priceyard'] = '0.00';
      $filter['hidden']['a.pvisible'] = '1';
      $filter['hidden']['a.image1'] = 'null';

      if(!isset($res['pname']) && !is_null(_A_::$app->post('s')) && (!empty(_A_::$app->post('s')))) {
        $search = strtolower(htmlspecialchars(trim(_A_::$app->post('s'))));
        $this->main->template->vars('search_str', _A_::$app->post('s'));
        $res['a.pname'] = _A_::$app->post('s');
        $filter['a.pname'] = $search;
      }
      return $res;
    }

    protected function build_order(&$sort, $view = false) {
      $sort['b.displayorder'] = 'asc';
      $sort['fabrix_product_categories.display_order'] = 'asc';
    }

    protected function before_search_form_layout(&$search_data, $view = false) {
      $categories = [];
      $filter = null; $sort = ['a.displayorder'=>'asc'];
      $rows = Model_Categories::get_list(0, 0, $res_count, $filter, $sort);
      foreach($rows as $row) $categories[$row['cid']] = $row['cname'];
      $patterns = [];
      $rows = Model_Patterns::get_list(0, 0, $res_count);
      foreach($rows as $row) $patterns[$row['id']] = $row['pattern'];
      $colours = [];
      $rows = Model_Colours::get_list(0, 0, $res_count);
      foreach($rows as $row) $colours[$row['id']] = $row['colour'];
      $manufacturers = [];
      $rows = Model_Manufacturers::get_list(0, 0, $res_count);
      foreach($rows as $row) $manufacturers[$row['id']] = $row['manufacturer'];

      $search_data['categories'] = $categories;
      $search_data['patterns'] = $patterns;
      $search_data['colours'] = $colours;
      $search_data['manufacturers'] = $manufacturers;
    }

    protected function after_get_list(&$rows, $view = false, $type = null) {
      $url_prms = null;
      if(isset($type)) $url_prms['back'] = 'recommends';
      $this->template->vars('url_prms', $url_prms);
    }

    /**
     * @export
     */
    public function recommends() {
      $this->main->is_user_authorized(true);
      $this->template->vars('cart_enable', '_');
      $this->main->template->vars('page_title', "Recommendations for You");
      parent::index(false);
    }

    public function index($required_access = true) { }

    public function view() { }

  }