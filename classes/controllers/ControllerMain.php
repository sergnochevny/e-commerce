<?php
/**
 * Copyright (c) 2017. AIT
 */

namespace classes\controllers;

use app\core\App;
use app\core\controller\ControllerBase;
use classes\helpers\AdminHelper;
use classes\helpers\UserHelper;
use controllers\ControllerCart;
use controllers\ControllerMenu;
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
   * @param \app\core\controller\ControllerBase $main
   * @throws \ReflectionException
   */
  public function __construct($main = null){
    if(isset($main) && (strpos(get_class($main),'Controller') !== false)) {
      $this->main = $main;
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
   * @param null $controller
   * @param null $data
   * @throws \Exception
   */
  public function  render_view_admin($page, $controller = null, $data = null){
    if(isset($data)) {
      $this->template->vars('data', $data);
    }

    $this->template->vars('menu', $this->template->render_layout_return('admin', false,'menu'));
    if(AdminHelper::is_logged()) {
      $this->template->vars('my_account_admin_menu', $this->template->render_layout_return('admin_account', false,'menu'));
    }

    $this->meta_page();
    $this->template->render($page, $controller);
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
   * @param bool $renderJS
   * @param null $controller
   * @param null $data
   * @return mixed
   * @throws \Exception
   */
  public function render_layout($page, $renderJS = true, $controller = null, $data = null){
    if(isset($data)) {
      $this->template->vars('data', $data);
    }
    return $this->template->render_layout($page, $renderJS, $controller);
  }

  /**
   * @param $page
   * @param bool $renderJS
   * @param null $controller
   * @param null $data
   * @return string
   * @throws \Exception
   */
  public function render_layout_return($page, $renderJS = false, $controller = null, $data = null){
    if(isset($data)) {
      $this->template->vars('data', $data);
    }

    return $this->template->render_layout_return($page, $renderJS, $controller);
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
      if(AdminHelper::is_logged()) $this-> render_view_admin('message');
      else $this->render_view('message');
    }
  }

  /**
   * @param $page
   * @param null $controller
   * @param null $data
   * @throws \ReflectionException
   * @throws \Exception
   */
  public function render_view($page, $controller = null, $data = null){
    $this->build_canonical_url();
    if(isset($data)) {
      $this->template->vars('data', $data);
    }
    $cart = new ControllerCart(isset($this->main) ? $this->main : $this);
    $cart->get();

    $this->template->vars('my_account_user_menu', $this->template->render_layout_return('user_account', false,'menu'));

    $menu = new ControllerMenu(isset($this->main) ? $this->main : $this);
    $menu->show_menu();
    $this->meta_page();
    $this->template->render($page, $controller);
  }

  /**
   * @param null $msg
   * @throws \Exception
   */
  public function error404($msg = null){
    header("HTTP/1.0 404 Not Found");
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    $this->template->controller->controller = 'main';
    $this->template->vars('message', $msg);
    if(AdminHelper::is_logged()) $this-> render_view_admin('404/error');
    else $this->render_view('404/error');
  }
}