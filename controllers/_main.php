<?php

  class Controller_Main extends Controller_Base {

    protected $main;

    public function __construct($main = null) {
      if(explode('_', get_class($main))[0] == 'Controller') {
        $this->main = $main;
        $this->registry = _A_::$app->registry();
        $this->template = $main->template;
      } else {
        parent::__construct();
      }
    }

    public function view_admin($page, $data = null) {
      if(isset($data)) {
        $this->template->vars('data', $data);
      }

      ob_start();
      $this->template->view_layout('admin_menu', 'menu');
      $menu = ob_get_contents();
      ob_end_clean();
      $this->template->vars('menu', $menu);

      if(Controller_Admin::is_logged()) {
        ob_start();
        $this->template->view_layout('my_account_admin_menu', 'menu');
        $my_account_admin_menu = ob_get_contents();
        ob_end_clean();
        $this->template->vars('my_account_admin_menu', $my_account_admin_menu);
      }

      $this->meta_page();
      $this->template->view($page);
    }

    public function meta_page() {
      $route = _A_::$app->server('QUERY_STRING');
      $route = substr($route, 6);
      $route = trim($route, '/\\');
      $route = explode('&', $route);
      $route_control = $route[0];
      $meta = Model_Tools::meta_page($route_control);
      $this->template->vars('meta', $meta);
    }

    public function view_layout($page, $data = null) {
      if(isset($data)) {
        $this->template->vars('data', $data);
      }

      $this->meta_page();
      $this->template->vars('controller', $this);

      $this->template->view_layout($page);
    }

    public function is_user_authorized($redirect_to_url = false) {
      $user = new Controller_User($this);
      if(!$user->is_authorized()) {
        if($redirect_to_url) {
          $redirect = strtolower(explode('/', _A_::$app->server('SERVER_PROTOCOL'))[0]) . "://";
          $redirect .= _A_::$app->server('SERVER_NAME');
          $redirect .= (_A_::$app->server('SERVER_PORT') == '80' ? '' : ':' . _A_::$app->server('SERVER_PORT'));
          $redirect .= _A_::$app->server('REQUEST_URI');
          if(empty(_A_::$app->server('REQUEST_URI'))) {
            $redirect = _A_::$app->router()->UrlTo('shop');
          }
        } else
          $redirect = _A_::$app->server('HTTP_REFERER');
        $url = _A_::$app->router()->UrlTo('user', ['url' => urlencode(base64_encode($redirect))]);
        $this->redirect($url);
      }
    }

    public function test_access_rights($redirect_to_url = true) {
      $admin = new Controller_Admin($this);
      if(!$admin->is_authorized()) {
        if($redirect_to_url) {
          $redirect = strtolower(explode('/', _A_::$app->server('SERVER_PROTOCOL'))[0]) . "://";
          $redirect .= _A_::$app->server('SERVER_NAME');
          $redirect .= (_A_::$app->server('SERVER_PORT') == '80' ? '' : ':' . _A_::$app->server('SERVER_PORT'));
          $redirect .= _A_::$app->server('REQUEST_URI');
          if(empty(_A_::$app->server('REQUEST_URI'))) {
            $redirect = _A_::$app->router()->UrlTo('admin/home');
          }
        } else
          $redirect = _A_::$app->server('HTTP_REFERER');
        $url = _A_::$app->router()->UrlTo('admin', ['url' => urlencode(base64_encode($redirect))]);
        $this->redirect($url);
      }
    }

    public function message() {
      if(isset(_A_::$app->get()['msg'])) {
        $msg = _A_::$app->get()['msg'];
        if($msg == 'remind_sent') {
          $prms = null;
          if(isset(_A_::$app->get()['url'])) {
            $prms['url'] = _A_::$app->get()['url'];
          }
          $back_url = _A_::$app->router()->UrlTo('user', $prms);
          $message = 'A link to change your password has been sent to your e-mail. This link will be valid for 1 hour!!!';
        } elseif($msg == 'remind_expired') {

          $back_url = _A_::$app->router()->UrlTo('/');
          $message = 'This link is no longer relevant. You can not change the password . Repeat the password recovery procedure.';
        }
        $this->template->vars('message', $message);
        $this->view('message');
      }
    }

    public function view($page, $data = null) {
      if(isset($data)) {
        $this->template->vars('data', $data);
      }
      $cart = new Controller_Cart(isset($this->main) ? $this->main : $this);
      $cart->get();

      ob_start();
      $toggle = Controller_User::is_logged();
      if($toggle) {
        $user = _A_::$app->session('user');
        $email = $user['email'];
        $firstname = ucfirst($user['bill_firstname']);
        $lastname = ucfirst($user['bill_lastname']);
        $user_name = '';
        if(!empty($firstname{0}) || !empty($lastname{0})) {
          if(!empty($firstname{0}))
            $user_name = $firstname . ' ';
          if(!empty($lastname{0}))
            $user_name .= $lastname;
        } else {
          $user_name = $email;
        }
        $this->template->vars('user_name', $user_name);
      }
      $this->template->vars('toggle', $toggle);
      $this->template->view_layout('my_account_user_menu', 'menu');
      $my_account_user_menu = ob_get_contents();
      ob_end_clean();
      $this->template->vars('my_account_user_menu', $my_account_user_menu);

      $menu = new Controller_Menu(isset($this->main) ? $this->main : $this);
      $menu->show_menu();
      $this->meta_page();
      $this->template->view($page);
    }

    public function error404() {
      header("HTTP/1.0 404 Not Found");
      header("HTTP/1.1 404 Not Found");
      header("Status: 404 Not Found");
      $this->template->controller = 'main';

      $this->view('404/error');
    }
  }