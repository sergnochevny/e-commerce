<?php

class Controller_Main extends Controller_Base{

  protected $main;

  public function __construct($main = null){
    if(isset($main) && (explode('_', get_class($main))[0] == 'Controller')) {
      $this->main = $main;
      $this->registry = _A_::$app->registry();
      $this->template = $main->template;
    } else {
      $this->layouts = _A_::$app->config('layouts');
      parent::__construct();
    }
  }

  protected function build_canonical_url(){
    $prms = _A_::$app->get();
    $url = array_shift($prms);
    $url = _A_::$app->router()->UrlTo($url, $prms, null, ['url'], true);
    $this->template->vars('canonical_url', $url);
  }

  public function view_admin($page, $data = null){
    if(isset($data)) {
      $this->template->vars('data', $data);
    }

    $this->template->vars('menu', $this->template->view_layout_return('admin', 'menu'));
    if(Controller_AdminBase::is_logged()) {
      $this->template->vars('my_account_admin_menu', $this->template->view_layout_return('admin_account', 'menu'));
    }

    $this->meta_page();
    $this->template->view($page);
  }

  public function meta_page(){
    $meta = $this->template->getMeta();
    if(empty($meta) || !is_array($meta)) $meta = Model_Tools::meta_page();
    $this->template->vars('meta', $meta);
  }

  public function view_layout($page, $data = null){
    if(isset($data)) {
      $this->template->vars('data', $data);
    }
    $this->template->view_layout($page);
  }

  public function view_layout_return($page, $data = null){
    if(isset($data)) {
      $this->template->vars('data', $data);
    }

    return $this->template->view_layout_return($page);
  }

  public function is_user_authorized($redirect_to_url = false){
    $user = new Controller_UserBase($this->main);
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

  public function is_admin_authorized($redirect_to_url = true){
    $admin = new Controller_AdminBase($this->main);
    if(!$admin->is_authorized()) {
      if($redirect_to_url) {
        $redirect = strtolower(explode('/', _A_::$app->server('SERVER_PROTOCOL'))[0]) . "://";
        $redirect .= _A_::$app->server('SERVER_NAME');
        $redirect .= (_A_::$app->server('SERVER_PORT') == '80' ? '' : ':' . _A_::$app->server('SERVER_PORT'));
        $redirect .= _A_::$app->server('REQUEST_URI');
        if(empty(_A_::$app->server('REQUEST_URI'))) {
          $redirect = _A_::$app->router()->UrlTo('product');
        }
      } else
        $redirect = _A_::$app->server('HTTP_REFERER');
      $url = _A_::$app->router()->UrlTo('admin', ['url' => urlencode(base64_encode($redirect))]);
      $this->redirect($url);
    }
  }

  public function is_any_authorized($redirect = null){
    if(!Controller_AdminBase::is_logged() && !Controller_UserBase::is_logged()) {
      $prms = isset($redirect) ? ['url' => urlencode(base64_encode(_A_::$app->router()->UrlTo($redirect)))] : null;
      $this->redirect(_A_::$app->router()->UrlTo('authorization', $prms));
    } else {
      if(Controller_AdminBase::is_logged()) return 'admin';
      if(Controller_UserBase::is_logged()) return 'user';
    }

    return null;
  }

  public function message(){
    if(isset(_A_::$app->get()['msg'])) {
      $msg = _A_::$app->get()['msg'];
      if($msg == 'remind_sent') {
        $prms = null;
        if(!is_null(_A_::$app->get('url'))) $prms['url'] = _A_::$app->get('url');
        $back_url = _A_::$app->router()->UrlTo('user', $prms);
        $message = 'A link to change your password has been sent to your e-mail. This link will be valid for 1 hour!';
      } elseif($msg == 'remind_expired') {
        $back_url = _A_::$app->router()->UrlTo('/');
        $message = 'This link is no longer relevant. You can not change the password . Repeat the password recovery procedure.';
      }
      $this->template->vars('message', $message);
      $this->template->vars('back_url', $back_url);
      if(Controller_AdminBase::is_logged()) $this->view_admin('message');
      else $this->view('message');
    }
  }

  public function view($page, $data = null){
    $this->build_canonical_url();
    if(isset($data)) {
      $this->template->vars('data', $data);
    }
    $cart = new Controller_Cart(isset($this->main) ? $this->main : $this);
    $cart->get();

    $user_logged = Controller_User::is_logged();
    $this->template->vars('user_logged', $user_logged);
    $this->template->vars('my_account_user_menu', $this->template->view_layout_return('user_account', 'menu'));

    $menu = new Controller_Menu(isset($this->main) ? $this->main : $this);
    $menu->show_menu();
    $this->meta_page();
    $this->template->view($page);
  }

  public function error404($msg = null){
    header("HTTP/1.0 404 Not Found");
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    $this->template->controller = 'main';
    $this->template->vars('message', $msg);
    if(Controller_AdminBase::is_logged()) $this->view_admin('404/error');
    else $this->view('404/error');
  }
}