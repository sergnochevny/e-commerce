<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerController;
use classes\helpers\UserHelper;

/**
 * Class ControllerUser
 * @package controllers
 */
class ControllerUser extends ControllerController{

  /**
   * @export
   * @throws \Exception
   */
  public function user(){
    if(!UserHelper::is_authorized()) {
      if((App::$app->request_is_post()) && !is_null(App::$app->post('login')) &&
        !is_null(App::$app->post('pass'))) {
        if(empty(App::$app->post('login')) && empty(App::$app->post('pass'))) exit('Empty Email or Password field');
        $email = App::$app->post('login');
        $password = App::$app->post('pass');
        if(!UserHelper::authorize($email, $password)) exit('Wrong Email or Password');
        $url = base64_decode(urldecode(App::$app->post('redirect')));
        $url = (strlen($url) > 0) ? $url : App::$app->router()->UrlTo('shop');
        $this->redirect($url);
      } else {

        $redirect = !is_null(App::$app->get('url')) ?
          App::$app->get('url') :
          urlencode(base64_encode(App::$app->router()->UrlTo('shop')));
        $prms = null;
        if(!is_null(App::$app->get('url'))) $prms['url'] = App::$app->get('url');
        $registration_url = App::$app->router()->UrlTo('authorization/registration', $prms);
        $lostpassword_url = App::$app->router()->UrlTo('authorization/lost_password', $prms);
        $this->main->template->vars('registration_url', $registration_url);
        $this->main->template->vars('lostpassword_url', $lostpassword_url);
        $this->main->template->vars('redirect', $redirect);
        $this->main->render_view('user');
      }
    } else {
      $url = !is_null(App::$app->get('url')) ? base64_decode(urldecode(App::$app->get('url'))) : App::$app->router()
        ->UrlTo('shop');
      $this->redirect($url);
    }
  }

  /**
   * @export
   * @throws \Exception
   */
  public function log_out(){
    if(UserHelper::is_logged()) {
      App::$app->setSession('_', null);
      App::$app->setSession('user', null);
      App::$app->setCookie('_r', null);
    }
    $this->redirect(App::$app->router()->UrlTo('shop'));
  }

  /**
   * @export
   * @throws \Exception
   */
  public function change(){
    $this->main->is_user_authorized(true);
    $user = UserHelper::get_from_session();
    App::$app->get('aid', $user['aid']);
    $action = 'user/change';
    $title = 'CHANGE REGISTRATION DATA';
    $url = '';
    if(!is_null(App::$app->get('url'))) {
      $url = base64_decode(urldecode(App::$app->get('url')));
    }
    $back_url = (strlen($url) > 0) ? $url : 'shop';
    (new ControllerUsers())->user_handling($data, $action, $back_url, $title, true);
  }

  /**
   * @export
   * @throws \Exception
   */
  public function registration(){
    if(UserHelper::is_logged()) {
      $this->redirect(App::$app->router()->UrlTo('/'));
    } else {
      $action = 'user/registration';
      $title = 'REGISTRATION USER';
      $prms = null;
      if(!is_null(App::$app->get('url'))) {
        $prms['url'] = App::$app->get('url');
      }
      $back_url = App::$app->router()->UrlTo('authorization', $prms);
      (new ControllerUsers())->user_handling($data, $action, $back_url, $title, true, true);
      UserHelper::sendWelcomeEmail($data['email']);
      $this->template->render_layout('thanx');
    }
  }

  /**
   * @param bool $required_access
   */
  public function index($required_access = true){
  }

  /**
   * @param bool $partial
   * @param bool $required_access
   */
  public function view($partial = false, $required_access = false){
  }

}
