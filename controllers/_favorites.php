<?php

  class Controller_Favorites extends Controller_Simple {

    protected $form_title_add = 'Add Favorite Fabrics';

    protected function search_fields($view = false) {
      return [
        'a.pname', 'a.pvisible', 'a.dt', 'a.pnumber',
        'a.piece', 'a.best', 'a.specials', 'b.cid',
        'c.id', 'd.id', 'e.id'
      ];
    }

    protected function build_order(&$sort, $view = false) {
      parent::build_order($sort, $view);
      if(!isset($sort) || !is_array($sort) || (count($sort) <= 0)) {
        $sort = ['z.dt' => 'desc'];
        $sort = ['a.pid' => 'desc'];
      }
    }

    protected function load(&$data) {
      $data['pid'] = _A_::$app->post('pid');
      $data['aid'] = Controller_User::get_from_session()['aid'];
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
      $rows = Model_Categories::get_list(0, 0, $res_count);
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
      if(isset($type)) $this->template->vars('action', _A_::$app->router()->UrlTo($this->controller));
    }

    protected function after_save($id, &$data) {
      $row = Model_Product::get_by_id($data['pid']);
      $this->save_warning = $row['pname'] . " added to Favorite Fabrics!";
    }

    protected function edit_add_handling($url, $title, $back_url = null) {
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
      $this->main->template->vars('page_title', "My Favorite Fabrics");
      $this->index(false);
    }

    /**
     * @export
     */
    public function add($required_access = false) {
      $this->main->is_user_authorized();
      parent::add($required_access);
    }

    public function view() { }

    public function edit($required_access = true) { }

    public static function product_in($pid) {
      $res = false;
      $aid = Controller_User::get_from_session()['aid'];
      try {
        $res = Model_Favorites::get_by_id($pid, $aid);
        $res = (isset($res) && is_array($res) && (count($res) > 0));
      } catch(Exceptin $e) {
      };
      return $res;
    }

  }