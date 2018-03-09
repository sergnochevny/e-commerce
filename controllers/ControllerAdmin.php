<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerFormSimple;
use classes\helpers\AdminHelper;
use models\ModelAdmin;
use models\ModelAuth;

/**
 * Class ControllerAdmin
 * @package controllers
 */
class ControllerAdmin extends ControllerFormSimple{

  /**
   * @param $data
   */
  protected function load(&$data){
    $data = [
      'id' => AdminHelper::get_from_session(),
      'login' => ModelAdmin::sanitize(!is_null(App::$app->post('login')) ? App::$app->post('login') : ''),
      'create_password' => ModelAdmin::sanitize(!is_null(App::$app->post('create_password')) ? App::$app->post('create_password') : ''),
      'confirm_password' => ModelAdmin::sanitize(!is_null(App::$app->post('confirm_password')) ? App::$app->post('confirm_password') : ''),
    ];
  }

  /**
   * @param $data
   * @param $error
   * @return bool
   * @throws \ErrorException
   * @throws \Exception
   */
  protected function validate(&$data, &$error){
    $error = null;
    if(empty($data['login'])) {
      $error = ['An error occurred while login!'];
    } else {
      if(ModelAdmin::exist($data['login'], $data['id'])) {
        $error[] = 'User with this login already exists!';
      } else {
        if(!empty($data['create_password'])) {
          $salt = ModelAuth::generatestr();
          $password = ModelAuth::hash_($data['create_password'], $salt, 12);
          $check = ModelAuth::check($data['confirm_password'], $password);
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

  /**
   * @param $url
   * @param null $data
   * @param bool $return
   * @throws \Exception
   */
  protected function form($url, $data = null, $return = false){
    App::$app->get($this->id_field, AdminHelper::get_from_session());
    parent::form($url, $data, $return);
    
  }

  /**
   * @param null $back_url
   * @param null $prms
   */
  protected function build_back_url(&$back_url = null, &$prms = null){
    $url = !is_null(App::$app->get('url')) ? base64_decode(urldecode(App::$app->get('url'))) : '';
    $back_url = (strlen($url) > 0) ? $url : 'product';
    $prms = null;
  }

  /**
   * @param bool $required_access
   */
  public function add($required_access = true){
  }

  /**
   * @param bool $required_access
   */
  public function edit($required_access = true){
  }

  /**
   * @param bool $required_access
   */
  public function delete($required_access = true){
  }

  /**
   * @export
   * @throws \Exception
   */
  public function change(){
    $this->main->is_admin_authorized();
    $action = 'admin/change';
    $title = 'CHANGE DATA';
    $this->edit_add_handling($action, $title);
  }

  /**
   * @export
   * @throws \Exception
   */
  public function admin(){
    if(!AdminHelper::is_authorized()) {
      if((App::$app->request_is_post()) &&
        !is_null(App::$app->post('login')) &&
        !is_null(App::$app->post('pass'))) {
        if(empty(App::$app->post('login')) && empty(App::$app->post('pass'))) exit('Empty Login or Password field');
        $login = App::$app->post('login');
        $password = App::$app->post('pass');
        if(!AdminHelper::authorize($login, $password)) exit('Wrong Login or Password');
        $url = base64_decode(urldecode(App::$app->post('redirect')));
        $url = (strlen($url) > 0) ? $url : App::$app->router()->UrlTo('product');
        $this->redirect($url);
      } else {
        $redirect = !is_null(App::$app->get('url')) ? App::$app->get('url') :
          urlencode(base64_encode(App::$app->router()->UrlTo('product')));
        $this->template->vars('redirect', $redirect);
        $menu = new ControllerMenu($this);
        $menu->show_menu();
        $this->main->render_view('admin');
      }
    } else {
      $url = !is_null(App::$app->get('url')) ? base64_decode(urldecode(App::$app->get('url'))) :
        App::$app->router()->UrlTo('product');
      $this->redirect($url);
    }
  }

  /**
   * @export
   * @throws \Exception
   */
  public function log_out(){
    App::$app->setSession('_a', null);
    App::$app->setSession('user', null);
    App::$app->setCookie('_ar', null);
    $this->redirect(App::$app->router()->UrlTo('/'));
  }

}
