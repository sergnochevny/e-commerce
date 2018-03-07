<?php

namespace controllers;

use app\core\App;
use classes\controllers\ControllerController;
use models\ModelAuth;
use models\ModelUser;
use models\ModelUsers;

class ControllerAuthorization extends ControllerController{

  protected $resolved_scenario = ['', 'short'];

  /**
   * @return bool
   */
  private function is_admin_logged(){
    return ControllerAdmin::is_logged();
  }

  /**
   * @return bool
   */
  private function is_user_logged(){
    return ControllerUser::is_logged();
  }

  /**
   * @return bool
   */
  private function is_set_admin_remember(){
    return ControllerAdmin::is_set_remember();
  }

  /**
   * @return bool
   */
  private function is_set_user_remember(){
    return ControllerUser::is_set_remember();
  }

  /**
   * @param $login
   * @param $password
   * @return bool
   * @throws \Exception
   */
  private function admin_authorize($login, $password){
    return ControllerAdmin::authorize($login, $password);
  }

  /**
   * @throws \Exception
   */
  private function lost_password_form(){
    $this->main->render_layout('lost_password_form');
  }

  /**
   * @param $email
   * @param $remind_url
   * @return bool
   * @throws \Exception
   */
  private function send_remind($email, $remind_url){
    $subject = "ILuvFabrix. Change Password.";
    $this->template->vars('remind_url', $remind_url);
    $body = $this->template->render_layout_return('remind/message');
    $demo = (!is_null(App::$app->keyStorage()->system_demo) ? App::$app->keyStorage()->system_demo : DEMO);

    $mailer = App::$app->getMailer();
    $emails = [$email];
    if($demo == 1) {
      $emails = array_merge($emails, explode(',', App::$app->keyStorage()->system_emails_admins));
    }
    array_walk($emails, function(&$item){
      $item = trim($item);
    });
    $emails = array_unique($emails);

    foreach($emails as $email) {
      $messages[] = $mailer->compose(['html' => 'mail-text'], ['body' => $body])
        ->setSubject($subject)
        ->setTo([$email])
        ->setFrom([App::$app->keyStorage()->system_send_from_email => App::$app->keyStorage()->system_site_name . ' robot']);
    }

    if(!empty($messages)) $mailer->sendMultiple($messages);
  }

  /**
   * @export
   * @throws \Exception
   */
  public function authorization(){
    $prms = null;

    if($this->is_admin_logged()) {
      $url = !is_null(App::$app->get('url')) ?
        base64_decode(urldecode(App::$app->get('url'))) :
        App::$app->router()->UrlTo('product');
      if($this->scenario() == 'short') exit();
      $this->redirect($url);
    }
    if($this->is_user_logged()) {
      $url = !is_null(App::$app->get('url')) ?
        base64_decode(urldecode(App::$app->get('url'))) :
        App::$app->router()->UrlTo('shop');
//        if($this->scenario() == 'short') exit();
      $this->redirect($url);
    }
    if($this->is_set_admin_remember()) {
      $remember = App::$app->cookie('_ar');
      if(ModelAuth::is_admin_remember($remember)) {
        $admin = ModelAuth::get_admin_data();
        App::$app->setSession('_a', $admin['id']);
        $url = !is_null(App::$app->get('url')) ?
          base64_decode(urldecode(App::$app->get('url'))) :
          App::$app->router()->UrlTo('product');
//        if($this->scenario() == 'short') exit();
        $this->redirect($url);
      }
    }
    if($this->is_set_user_remember()) {
      $remember = App::$app->cookie('_r');
      if(ModelAuth::is_user_remember($remember)) {
        $user = ModelAuth::get_user_data();
        App::$app->setSession('_', $user['aid']);
        App::$app->setSession('user', $user);
        $url = !is_null(App::$app->get('url')) ?
          base64_decode(urldecode(App::$app->get('url'))) :
          App::$app->router()->UrlTo('shop');
//        if($this->scenario() == 'short') exit();
        $this->redirect($url);
      }
    }

    if((App::$app->request_is_post()) && !is_null(App::$app->post('login')) &&
      !is_null(App::$app->post('pass'))) {
      if(empty(App::$app->post('login'))) exit('Empty Email/Username field');
      if(empty(App::$app->post('pass'))) exit('Empty Password field');

      $login = App::$app->post('login');
      $password = App::$app->post('pass');

      if(ModelAuth::is_admin($login)) {
        if($this->admin_authorize($login, $password)) {
          $url = base64_decode(urldecode(App::$app->post('redirect')));
          $url = (strlen($url) > 0) ? $url : App::$app->router()->UrlTo('product');
          $this->redirect($url);
        }
      }
      if(ModelAuth::is_user($login)) {
        if($this->user_authorize($login, $password)) {
          $url = base64_decode(urldecode(App::$app->post('redirect')));
          $url = (strlen($url) > 0) ? $url : App::$app->router()->UrlTo('shop');
          $this->redirect($url);
        }
      }
      exit('Wrong Email/Username or Password');
    } else {
      $redirect = !is_null(App::$app->get('url')) ? App::$app->get('url') : '';
      $prms = null;
      if(!is_null(App::$app->get('url'))) {
        $prms['url'] = App::$app->get('url');
      }
      $registration_url = App::$app->router()->UrlTo('authorization/registration', $prms);
      $lostpassword_url = App::$app->router()->UrlTo('authorization/lost_password', $prms);
      $this->main->template->vars('registration_url', $registration_url);
      $this->main->template->vars('lostpassword_url', $lostpassword_url);
      $this->main->template->vars('redirect', $redirect);
      if($this->scenario() != 'short') {
        $this->main->render_view('authorization');
      } else {
        $this->main->render_layout((!empty($this->scenario()) ? $this->scenario() . DS : '') . 'authorization');
      }
    }
  }

  /**
   * @export
   * @throws \Exception
   */
  public function registration(){
    $prms = null;

    if($this->is_admin_logged()) {
      $url = !is_null(App::$app->get('url')) ?
        base64_decode(urldecode(App::$app->get('url'))) :
        App::$app->router()->UrlTo('product');
      $this->redirect($url);
    }
    if($this->is_user_logged()) {
      $url = !is_null(App::$app->get('url')) ?
        base64_decode(urldecode(App::$app->get('url'))) :
        App::$app->router()->UrlTo('shop');
      $this->redirect($url);
    }
    if($this->is_set_admin_remember()) {
      $remember = App::$app->cookie('_ar');
      if(ModelAuth::is_admin_remember($remember)) {
        $admin = ModelAuth::get_admin_data();
        App::$app->setSession('_a', $admin['id']);
        $url = !is_null(App::$app->get('url')) ?
          base64_decode(urldecode(App::$app->get('url'))) :
          App::$app->router()->UrlTo('product');
        $this->redirect($url);
      }
    }
    if($this->is_set_user_remember()) {
      $remember = App::$app->cookie('_r');
      if(ModelAuth::is_user_remember($remember)) {
        $user = ModelAuth::get_user_data();
        App::$app->setSession('_', $user['aid']);
        App::$app->setSession('user', $user);
        $url = !is_null(App::$app->get('url')) ?
          base64_decode(urldecode(App::$app->get('url'))) :
          App::$app->router()->UrlTo('shop');
        $this->redirect($url);
      }
    }

    $redirect = !is_null(App::$app->get('url')) ? App::$app->get('url') : '';
    $prms = null;
    if(!is_null(App::$app->get('url'))) {
      $prms['url'] = App::$app->get('url');
    }
    $this->main->template->vars('redirect', $redirect);
    $this->main->render_view('registration');
  }

  /**
   * @param $mail
   * @param $password
   * @return bool
   * @throws \Exception
   */
  public function user_authorize($mail, $password){
    return ControllerUser::authorize($mail, $password);
  }

  /**
   * @export
   * @throws \Exception
   */
  public function lost_password(){
    if(App::$app->request_is_post()) {
      if(!App::$app->get('user_id')) {
        $this->main->template->vars('action', App::$app->router()->UrlTo('authorization/lost_password'));
        if(empty(App::$app->post('login'))) {
          $error = ['Empty Email. Identify your Email(Login).'];
          $this->main->template->vars('error', $error);
          $this->lost_password_form();
          exit();
        }
        $email = App::$app->post('login');
        if(!ModelUser::exist($email)) {
          $error = ['Wrong Email(Login) or this Email is not registered.'];
          $this->main->template->vars('error', $error);
          $this->lost_password_form();
          exit();
        }
        $user = ModelUser::get_by_email($email);
        $user_id = $user['aid'];
        $date = date('Y-m-d H:i:s', time());
        $remind = ModelAuth::generate_hash($date);
        if(ModelUser::set_remind_for_change_pass($remind, $date, $user_id)) {
          $remind_url = App::$app->router()->UrlTo('authorization/lost_password',
            ['remind' => urlencode(base64_encode($remind))]
          );
          if($this->send_remind($email, $remind_url)) {

            $message = 'A link to change your password has been sent to your e-mail. This link will be valid for 1 hour!';
            $this->main->template->vars('message', $message);
            $this->main->render_layout('msg_span');
          }
        }
      } else {
        //TODO process of change password
        $user_id = App::$app->get('user_id');
        $remind = App::$app->post('remind');
        if(isset($user_id) && isset($remind)) {
          if(ModelUser::exist(null, $user_id)) {
            $user = ModelUsers::get_by_id($user_id);
            if(isset($user)) {
              $result = true;
              $time = strtotime($user['remind_time']);
              $now = time();
              if(($now - $time) <= 3600) {
                $result = true;
                if($remind == ModelAuth::check($user['remind_time'], $user['remind'])) {
                  $password = App::$app->post('password');
                  $confirm = App::$app->post('confirm');
                  if((isset($password) && strlen(trim($password)) > 0) && (isset($confirm) && strlen(trim($confirm)) > 0)) {
                    if($password == $confirm) {
                      $hash = ModelAuth::generate_hash($password);
                      ModelUser::update_password($hash, $user_id);
                      ModelUser::clean_remind($user_id);
                      $message = 'Your Password has been changed succesfully!<br>';
                      $message .= 'Now you can go to the <a href="' . App::$app->router()
                          ->UrlTo('authorization') . '">login form</a> and use it.';
                      $this->main->template->vars('message', $message);
                      $this->main->render_layout('msg_span');
                      exit();
                    } else {
                      $error = ['Password and Confirm Password must be identical!'];
                      $this->main->template->vars('error', $error);
                    }
                  } else {
                    $error = ['Identity Password and Confirm Password!'];
                    $this->main->template->vars('error', $error);
                  }
                  $action = App::$app->router()->UrlTo('authorization/lost_password', ['user_id' => $user_id]);
                  $this->main->template->vars('action', $action);
                  $this->main->template->vars('remind', $remind);
                  $this->main->template->vars('user_id', $user_id);
                  $this->main->render_layout('remind/change_password_form');
                } else {
                  $back_url = App::$app->router()->UrlTo('/');
                  $message = 'This link is no longer relevant. You can not change the password . Repeat the password recovery procedure.';
                  $this->main->template->vars('message', $message);
                  $this->main->template->vars('back_url', $back_url);
                  $this->main->render_layout('msg_span');
                }
              } else {
                $back_url = App::$app->router()->UrlTo('/');
                $message = 'This link is no longer relevant. You can not change the password . Repeat the password recovery procedure.';
                $this->template->vars('message', $message);
                $this->template->vars('back_url', $back_url);
                $this->main->render_layout('msg_span');
              }
            } else {
              $url = App::$app->router()->UrlTo('error404');
              $this->redirect($url);
            }
          } else {
            $url = App::$app->router()->UrlTo('error404');
            $this->redirect($url);
          }
        } else {
          $url = App::$app->router()->UrlTo('error404');
          $this->redirect($url);
        }
      }
    } else {
      $result = false;
      if(App::$app->request_is_get()) {
        $remind = App::$app->get('remind');
        if(isset($remind)) {
          $remind = base64_decode(urldecode($remind));
          if(ModelUser::remind_exist($remind)) {
            $user = ModelUser::get_by_remind($remind);
            if(isset($user)) {
              $user_id = $user['aid'];
              $time = strtotime($user['remind_time']);
              $now = time();
              if((($now - $time) <= 3600) && ($remind == ModelAuth::check($user['remind_time'], $user['remind']))) {
                $result = true;
                $action = App::$app->router()->UrlTo('authorization/lost_password', ['user_id' => $user_id]);
                $back_url = App::$app->router()->UrlTo('/');
                $this->template->vars('back_url', $back_url, true);
                $this->template->vars('action', $action);
                $this->template->vars('remind', $remind);
                $this->template->vars('user_id', $user_id);
                $this->main->render_view('remind/change_password');
              } else {
                $result = true;
                $message = 'This link is no longer relevant. You can not change the password . Repeat the password recovery procedure.';
                $this->main->template->vars('message', $message);
                $this->main->render_view('message');
              }
            }
          }
        } else {
          $result = true;
          $action = App::$app->router()->UrlTo('authorization/lost_password');
          $prms = null;
          if(!is_null(App::$app->get('url'))) {
            $prms['url'] = App::$app->get('url');
          }
          $back_url = App::$app->router()->UrlTo('authorization', $prms);
          $this->main->template->vars('action', $action);
          $this->main->template->vars('back_url', $back_url);
          $this->main->render_view('lost_password');
        }
      }
      if(!$result) {
        $this->main->error404();
      }
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