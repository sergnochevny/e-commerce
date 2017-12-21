<?php
/**
 * Copyright (c) 2017. AIT
 */

namespace controllers\base;

use app\core\App;
use app\core\controller\ControllerBase;
use controllers\ControllerCart;
use controllers\ControllerMenu;
use controllers\ControllerUser;
use models\ModelTools;

/**
 * Class ControllerMain
 * @package controllers\base
 */
class ControllerMain extends ControllerBase{

  /**
   * @var null
   */
  protected $main;

  /**
   * ControllerMain constructor.
   * @param null $main
   */
  public function __construct($main = null){
    if(isset($main) && (strpos(get_class($main),'Controller') !== false)) {
      $this->main = $main;
      $this->registry = App::$app->registry();
      $this->template = $main->template;
    } else {
      $this->layouts = App::$app->config('layouts');
      parent::__construct();
    }
  }

    /**
     *
     * @throws \Exception
     */
  protected function build_canonical_url(){
    $prms = App::$app->get();
    $url = array_shift($prms);
    $url = App::$app->router()->UrlTo($url, $prms, null, ['url'], true);
    $this->template->vars('canonical_url', $url);
  }

  /**
   * @param $page
   * @param null $data
   * @throws \Exception
   */
  public function view_admin($page, $data = null){
    if(isset($data)) {
      $this->template->vars('data', $data);
    }

    $this->template->vars('menu', $this->template->view_layout_return('admin', 'menu'));
    if(ControllerAdminBase::is_logged()) {
      $this->template->vars('my_account_admin_menu', $this->template->view_layout_return('admin_account', 'menu'));
    }

    $this->meta_page();
    $this->template->view($page);
  }

  /**
   *
   * @throws \Exception
   */
  public function meta_page(){
    $meta = $this->template->getMeta();
    if(empty($meta) || !is_array($meta)) $meta = ModelTools::meta_page();
    $this->template->vars('meta', $meta);
  }

  /**
   * @param $page
   * @param null $data
   * @throws \Exception
   */
  public function view_layout($page, $data = null){
    if(isset($data)) {
      $this->template->vars('data', $data);
    }
    $this->template->view_layout($page);
  }

  /**
   * @param $page
   * @param null $data
   * @return string
   * @throws \Exception
   */
  public function view_layout_return($page, $data = null){
    if(isset($data)) {
      $this->template->vars('data', $data);
    }

    return $this->template->view_layout_return($page);
  }

  /**
   * @param bool $redirect_to_url
   * @throws \Exception
   */
  public function is_user_authorized($redirect_to_url = false){
    $user = new ControllerUserBase($this->main);
    if(!$user->is_authorized()) {
      if($redirect_to_url) {
        $redirect = strtolower(explode('/', App::$app->server('SERVER_PROTOCOL'))[0]) . "://";
        $redirect .= App::$app->server('SERVER_NAME');
        $redirect .= (App::$app->server('SERVER_PORT') == '80' ? '' : ':' . App::$app->server('SERVER_PORT'));
        $redirect .= App::$app->server('REQUEST_URI');
        if(empty(App::$app->server('REQUEST_URI'))) {
          $redirect = App::$app->router()->UrlTo('shop');
        }
      } else
        $redirect = App::$app->server('HTTP_REFERER');
      $url = App::$app->router()->UrlTo('user', ['url' => urlencode(base64_encode($redirect))]);
      $this->redirect($url);
    }
  }

  /**
   * @param bool $redirect_to_url
   * @throws \Exception
   */
  public function is_admin_authorized($redirect_to_url = true){
    $admin = new ControllerAdminBase($this->main);
    if(!$admin->is_authorized()) {
      if($redirect_to_url) {
        $redirect = strtolower(explode('/', App::$app->server('SERVER_PROTOCOL'))[0]) . "://";
        $redirect .= App::$app->server('SERVER_NAME');
        $redirect .= (App::$app->server('SERVER_PORT') == '80' ? '' : ':' . App::$app->server('SERVER_PORT'));
        $redirect .= App::$app->server('REQUEST_URI');
        if(empty(App::$app->server('REQUEST_URI'))) {
          $redirect = App::$app->router()->UrlTo('product');
        }
      } else
        $redirect = App::$app->server('HTTP_REFERER');
      $url = App::$app->router()->UrlTo('admin', ['url' => urlencode(base64_encode($redirect))]);
      $this->redirect($url);
    }
  }

  /**
   * @param null $redirect
   * @return null|string
   * @throws \Exception
   */
  public function is_any_authorized($redirect = null){
    if(!ControllerAdminBase::is_logged() && !ControllerUserBase::is_logged()) {
      $prms = isset($redirect) ? ['url' => urlencode(base64_encode(App::$app->router()->UrlTo($redirect)))] : null;
      $this->redirect(App::$app->router()->UrlTo('authorization', $prms));
    } else {
      if(ControllerAdminBase::is_logged()) return 'admin';
      if(ControllerUserBase::is_logged()) return 'user';
    }

    return null;
  }

  /**
   *
   * @throws \Exception
   */
  public function message(){
    if(isset(App::$app->get()['msg'])) {
      $msg = App::$app->get()['msg'];
      if($msg == 'remind_sent') {
        $prms = null;
        if(!is_null(App::$app->get('url'))) $prms['url'] = App::$app->get('url');
        $back_url = App::$app->router()->UrlTo('user', $prms);
        $message = 'A link to change your password has been sent to your e-mail. This link will be valid for 1 hour!';
      } elseif($msg == 'remind_expired') {
        $back_url = App::$app->router()->UrlTo('/');
        $message = 'This link is no longer relevant. You can not change the password . Repeat the password recovery procedure.';
      }
      $this->template->vars('message', $message);
      $this->template->vars('back_url', $back_url);
      if(ControllerAdminBase::is_logged()) $this->view_admin('message');
      else $this->view('message');
    }
  }

  /**
   * @param $page
   * @param null $data
   * @throws \Exception
   */
  public function view($page, $data = null){
    $this->build_canonical_url();
    if(isset($data)) {
      $this->template->vars('data', $data);
    }
    $cart = new ControllerCart(isset($this->main) ? $this->main : $this);
    $cart->get();

    $user_logged = ControllerUser::is_logged();
    $this->template->vars('user_logged', $user_logged);
    $this->template->vars('my_account_user_menu', $this->template->view_layout_return('user_account', 'menu'));

    $menu = new ControllerMenu(isset($this->main) ? $this->main : $this);
    $menu->show_menu();
    $this->meta_page();
    $this->template->view($page);
  }

  /**
   * @param null $msg
   * @throws \Exception
   */
  public function error404($msg = null){
    header("HTTP/1.0 404 Not Found");
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    $this->template->controller = 'main';
    $this->template->vars('message', $msg);
    if(ControllerAdminBase::is_logged()) $this->view_admin('404/error');
    else $this->view('404/error');
  }
}