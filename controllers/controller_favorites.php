<?php

  class Controller_Favorites extends Controller_Simple {

    protected $form_title_add = 'Add Fabric Favorites';
    protected $page_title = 'My Fabric Favorites';

    protected function search_fields($view = false) {
      return [
        'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber',
        'a.piece', 'a.best', 'a.specials', 'b.cid',
        'c.id', 'd.id', 'e.id'
      ];
    }

    protected function build_order(&$sort, $view = false, $filter = null) {
      parent::build_order($sort, $view, $filter);
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['z.dt' => 'desc'];
        $sort = ['a.pid' => 'desc'];
      }
    }

    protected function load(&$data) {
      $data['pid'] = _A_::$app->post('pid');
      $data['aid'] = Controller_User::get_from_session()['aid'];
    }

    protected function build_search_filter(&$filter, $view = false) {
      $res = parent::build_search_filter($filter, $view);
      $filter['hidden']['z.aid'] = Controller_User::get_from_session()['aid'];
      return $res;
    }

    protected function validate(&$data, &$error) {
      if(empty($data['pid'])) {
        $error[] = 'Select Product to append to Favorites!';
        $this->template->vars('error', $error);
        return false;
      }
      return true;
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
      if(isset($type)) $this->template->vars('action', _A_::$app->router()->UrlTo($this->controller));
    }

    protected function after_save($id, &$data) {
      $row = Model_Product::get_by_id($data['pid']);
      $this->save_warning = $row['pname'] . " added to Fabric Favorites!";
    }

    protected function edit_add_handling($url, $title) {
      $this->template->vars('form_title', $title);
      $data = null;
      $this->load($data);
      if($this->form_handling($data) && _A_::$app->request_is_post() && _A_::$app->request_is_ajax()) {
        $this->save($data);
        exit($this->form($url, $data));
      } else {
        $this->redirect(_A_::$app->router()->UrlTo('shop'));
      }
    }

    protected function before_form_layout(&$data = null) {
      $this->template->vars('back_url', _A_::$app->router()->UrlTo('shop'));
    }

    /**
     * @export
     */
    public function favorites() {
      $this->main->is_user_authorized(true);
      $this->template->vars('cart_enable', '_');
      $this->index(false);
    }

    /**
     * @export
     */
    public function add($required_access = false) {
      $this->main->is_user_authorized();
      parent::add($required_access);
    }

    /**
     * @export
     */
    public function delete($required_access = false) {
      parent::delete($required_access);
    }

    public function view($partial = false, $required_access = false) { }

    public function edit($required_access = true) { }

    public static function product_in($pid) {
      $res = false;
      $aid = !empty(Controller_User::get_from_session()['aid']) ? Controller_User::get_from_session()['aid'] : null;
      if(!empty($aid)) {
        try {
          $res = Model_Favorites::get_by_id($pid, $aid);
          $res = (isset($res) && is_array($res) && (count($res) > 0));
        } catch(Exception $e) {
        };
      }
      return $res;
    }

  }