<?php

  Class Controller_Admin Extends Controller_Controller {

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
          $url = (strlen($url) > 0) ? $url : _A_::$app->router()
            ->UrlTo('admin/home');
          $this->redirect($url);
        } else {

          $redirect = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : base64_encode(_A_::$app->router()
            ->UrlTo('admin/home'));
          $this->template->vars('redirect', $redirect);

          $menu = new Controller_Menu($this);
          $menu->show_menu();

          $this->main->view_admin('admin');
        }
      } else {
        $url = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : _A_::$app->router()
          ->UrlTo('admin/home');
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
//        session_destroy();
//        unset($_SESSION);
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
      $this->redirect(_A_::$app->router()
        ->UrlTo('/'));
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
