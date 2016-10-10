<?php

  Class Controller_Admin Extends Controller_Formsimple {

    private static function get_from_session() {
      return _A_::$app->session('_a');
    }

    protected function load(&$data, &$error){

      $data = [
        'id' => self::get_from_session(),
        'login' => $login
      ];
      if(empty($login)) {
        $error = ['Identify login field!!!'];
      } else {
        if(Model_Admin::exist($login, $admin_id)) {
          $error[] = 'User with this login already exists!!!';
        } else {
          if(!empty($create_password)) {
            $salt = Model_Auth::generatestr();
            $password = Model_Auth::hash_($create_password, $salt, 12);
            $check = Model_Auth::check($confirm_password, $password);
          } else $password = null;

          if(is_null($password) || (isset($check) && ($password == $check))) {
            try {
              $admin_id = Model_admin::save($login, $password, $admin_id);
              if(!is_null($password)) Model_User::update_password($password, $admin_id);
              $warning = ['All data saved successfully!!!'];
              $data = null;
            } catch(Exception $e) {
              $error[] = $e->getMessage();
            }
          } else {
            $error = ['Password and Confirm Password must be identical!!!'];
          }
        }
      }
      if(isset($warning)) $this->template->vars('warning', $warning);
      if(isset($error)) $this->template->vars('error', $error);

      return $data;
    }

    protected function save(&$data) {
      $error = null;
      $result = false;
      $error = $data = null;
      if($this->load($data, $error)) {
          if(!empty($data['create_password'])) {
            $salt = Model_Auth::generatestr();
            $password = Model_Auth::hash_($data['create_password'], $salt, 12);
            $check = Model_Auth::check($data['confirm_password'], $password);
          } else $password = null;

          if(is_null($password) || (isset($check) && ($password == $check))) {
            try {
              $data['password'] = is_null($password) ? '' : $password;
              $aid = Model_Users::save($data);
              if(!is_null($password)) Model_User::update_password($password, $aid);
              $warning = ['All data saved successfully!!!'];
              $result = true;
              $data = null;
            } catch(Exception $e) {
              $error[] = $e->getMessage();
            }
          } else {
            $error[] = 'Password and Confirm Password must be identical!!!';
          }
      }
      if(isset($warning)) $this->template->vars('warning', $warning);
      if(isset($error)) $this->template->vars('error', $error);

      return $result;
    }

    protected function form($url, $data = null) {
      _A_::$app->get($this->id_name, self::get_from_session());
      parent::form();
    }

    public function edit() { }

    public function add() { }

    public function delete() { }

    /**
     * @export
     */
    public function change() {
      $this->main->test_access_rights();
      $action = 'admin/change';
      $title = 'CHANGE DATA';
      $url = '';
      if(!is_null(_A_::$app->get('url'))) {
        $url = base64_decode(urldecode(_A_::$app->get('url')));
      }
      $back_url = (strlen($url) > 0) ? $url : 'admin/home';
      $this->edit_add_handling($action, $back_url, $title, true);
    }

    /**
     * @export
     */
    public function admin() {
      if(!$this->is_authorized()) {
        if((_A_::$app->request_is_post()) && !is_null(_A_::$app->post('login')) && !is_null(_A_::$app->post('pass'))) {
          if(empty(_A_::$app->post('login')) && empty(_A_::$app->post('pass')))
            exit('Empty Login or Password field');
          $login = _A_::$app->post('login');
          $password = _A_::$app->post('pass');
          if(!$this->authorize($login, $password))
            exit('Wrong Login or Password');
          $url = base64_decode(urldecode(_A_::$app->post('redirect')));
          $url = (strlen($url) > 0) ? $url : _A_::$app->router()->UrlTo('admin/home');
          $this->redirect($url);
        } else {

          $redirect = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') :
            urlencode(base64_encode(_A_::$app->router()->UrlTo('admin/home')));
          $this->template->vars('redirect', $redirect);

          $menu = new Controller_Menu($this);
          $menu->show_menu();

          $this->main->view_admin('admin');
        }
      } else {
        $url = !is_null(_A_::$app->get('url')) ? base64_decode(urldecode(_A_::$app->get('url'))) :
          _A_::$app->router()->UrlTo('admin/home');
        $this->redirect($url);
      }
    }

    public function is_authorized() {
      if(self::is_logged())
        return true;
      if(self::is_set_remember()) {
        $remember = _A_::$app->cookie('_ar');
        if(Model_Auth::is_admin_remember($remember)) {
          $admin = Model_Auth::get_admin_data();
          _A_::$app->setSession('_a', $admin['id']);
          return true;
        }
      }
      return false;
    }

    /**
     * @export
     */
    public function home() {
      $this->main->test_access_rights();
      $shop = new Controller_Shop($this->main);
      $shop->all_products();
      $shop->product_filter_list();
      $shop->main->view_admin('home');
    }

    /**
     * @export
     */
    public function log_out() {
      _A_::$app->setSession('_a', null);
      _A_::$app->setSession('user', null);
      _A_::$app->setCookie('_ar', null);
      $this->redirect(_A_::$app->router()->UrlTo('/'));
    }

    /**
     * @export
     */
    public function authorize($login, $password) {
      $login = mysql_real_escape_string(stripslashes(strip_tags(trim($login))));
      $password = mysql_real_escape_string(stripslashes(strip_tags(trim($password))));
      $res = Model_Auth::admin_authorize($login, $password);
      if($res) {
        $admin = Model_Auth::get_admin_data();
        _A_::$app->setSession('_a', $admin['id']);
      }
      return $res;
    }

    public static function is_logged() {
      return !is_null(_A_::$app->session('_a'));
    }

    public static function is_set_remember() {
      return !is_null(_A_::$app->cookie('_ar'));
    }

  }
