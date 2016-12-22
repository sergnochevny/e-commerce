<?php

  Class Controller_Admin Extends Controller_AdminBase {

    protected function load(&$data) {
      $data = [
        'id' => self::get_from_session(),
        'login' => Model_Admin::sanitize(!is_null(_A_::$app->post('login')) ? _A_::$app->post('login') : ''),
        'create_password' => Model_Admin::sanitize(!is_null(_A_::$app->post('create_password')) ? _A_::$app->post('create_password') : ''),
        'confirm_password' => Model_Admin::sanitize(!is_null(_A_::$app->post('confirm_password')) ? _A_::$app->post('confirm_password') : ''),
      ];
    }

    protected function validate(&$data, &$error) {
      $error = null;
      if(empty($data['login'])) {
        $error = ['An error occurred while login!'];
      } else {
        if(Model_Admin::exist($data['login'], $data['id'])) {
          $error[] = 'User with this login already exists!';
        } else {
          if(!empty($data['create_password'])) {
            $salt = Model_Auth::generatestr();
            $password = Model_Auth::hash_($data['create_password'], $salt, 12);
            $check = Model_Auth::check($data['confirm_password'], $password);
          } else $password = null;

          if(is_null($password) || (isset($check) && ($password == $check))) {
            $data['password'] = $password;
            return true;
          } else {
            $error = ['Confirm Password confirm password does not match!'];
          }
        }
      }
      return false;
    }

    protected function form($url, $data = null) {
      _A_::$app->get($this->id_name, self::get_from_session());
      parent::form($url, $data);
    }

    public function add($required_access = true) { }

    public function edit($required_access = true) { }

    public function delete($required_access = true) { }

    protected function build_back_url(&$back_url = null, &$prms = null) {
      $url = !is_null(_A_::$app->get('url')) ? base64_decode(urldecode(_A_::$app->get('url'))):'';
      $back_url = (strlen($url) > 0) ? $url : 'product';
      $prms=null;
    }

    /**
     * @export
     */
    public function change() {
      $this->main->is_admin_authorized();
      $action = 'admin/change';
      $title = 'CHANGE DATA';
      $this->edit_add_handling($action, $title);
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
          if(!self::authorize($login, $password))
            exit('Wrong Login or Password');
          $url = base64_decode(urldecode(_A_::$app->post('redirect')));
          $url = (strlen($url) > 0) ? $url : _A_::$app->router()->UrlTo('product');
          $this->redirect($url);
        } else {
          $redirect = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : urlencode(base64_encode(_A_::$app->router()->UrlTo('product')));
          $this->template->vars('redirect', $redirect);
          $menu = new Controller_Menu($this);
          $menu->show_menu();
          $this->main->view('admin');
        }
      } else {
        $url = !is_null(_A_::$app->get('url')) ? base64_decode(urldecode(_A_::$app->get('url'))) :
          _A_::$app->router()->UrlTo('product');
        $this->redirect($url);
      }
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

  }