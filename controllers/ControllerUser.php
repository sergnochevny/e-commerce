<?php

namespace controllers;

use app\core\App;
use controllers\base\ControllerUserBase;

/**
 * Class ControllerUser
 * @package controllers
 */
class ControllerUser extends ControllerUserBase{

  /**
   * @param $email
   */
  public static function sendWelcomeEmail($email){
    $headers = "From: \"I Luv Fabrix\"<" . App::$app->keyStorage()->system_info_email . ">\n";
    $subject = "Thank you for registering with iluvfabrix.com";
    $body = "Thank you for registering with iluvfabrix.com.\n";
    $body .= "\n";
    $body .= "As a new user, you will get 20% off your first purchase (which you may use any time in the first year) unless we have a sale going on for a discount greater than 20%, in which case you get the greater of the two discounts.\n";
    $body .= "\n";
    $body .= "We will, from time to time, inform you by email of various time limited specials on the iluvfabrix site.  If you wish not to receive these emails, please respond to this email with the word Unsubscribe in the subject line.\n";
    $body .= "\n";
    $body .= "Once again, thank you, and enjoy shopping for World Class Designer Fabrics & Trims on iluvfabrix.com.\n";

    mail($email, $subject, $body, $headers);
  }

  /**
   * @export
   * @throws \Exception
   */
  public function user(){
    if(!$this->is_authorized()) {
      if((App::$app->request_is_post()) && !is_null(App::$app->post('login')) &&
        !is_null(App::$app->post('pass'))) {
        if(empty(App::$app->post('login')) && empty(App::$app->post('pass'))) exit('Empty Email or Password field');
        $email = App::$app->post('login');
        $password = App::$app->post('pass');
        if(!self::authorize($email, $password)) exit('Wrong Email or Password');
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
        $this->main->view('user');
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
    if(self::is_logged()) {
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
    $user = self::get_from_session();
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
    if(self::is_logged()) {
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
      self::sendWelcomeEmail($data['email']);
      $this->template->view_layout('thanx');
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
