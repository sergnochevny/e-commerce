<?php

  class Controller_Authorization extends Controller_Controller {

    private function is_admin_logged() {
      return Controller_Admin::is_logged();
    }

    private function is_user_logged() {
      return Controller_User::is_logged();
    }

    private function is_set_admin_remember() {
      return Controller_Admin::is_set_remember();
    }

    private function is_set_user_remember() {
      return Controller_User::is_set_remember();
    }

    private function admin_authorize($login, $password) {
      return Controller_Admin::authorize($login, $password);
    }

    private function lost_password_form() {
      $this->main->view_layout('lost_password_form');
    }

    private function send_remind($email, $remind_url) {
      $subject = "ILuvFabrix. Change Password.";
      $this->template->vars('remind_url', $remind_url);
      $message = $this->template->view_layout_return('remind/message');
      $headers = "MIME-Version: 1.0' \r\n";
      $headers .= "Content-Type: text/html; charset=UTF-8 \r\n";

      return mail($email, $subject, $message, $headers);
    }

    /**
     * @export
     */
    public function authorization() {
      $prms = null;

      if($this->is_admin_logged()) {
        $url = !is_null(_A_::$app->get('url')) ? base64_decode(urldecode(_A_::$app->get('url'))) : _A_::$app->router()->UrlTo('product');
        $this->redirect($url);
      }
      if($this->is_user_logged()) {
        $url = !is_null(_A_::$app->get('url')) ? base64_decode(urldecode(_A_::$app->get('url'))) : _A_::$app->router()->UrlTo('shop');
        $this->redirect($url);
      }
      if($this->is_set_admin_remember()) {
        $remember = _A_::$app->cookie('_ar');
        if(Model_Auth::is_admin_remember($remember)) {
          $admin = Model_Auth::get_admin_data();
          _A_::$app->setSession('_a', $admin['id']);
          $url = !is_null(_A_::$app->get('url')) ? base64_decode(urldecode(_A_::$app->get('url'))) : _A_::$app->router()->UrlTo('product');
          $this->redirect($url);
        }
      }
      if($this->is_set_user_remember()) {
        $remember = _A_::$app->cookie('_r');
        if(Model_Auth::is_user_remember($remember)) {
          $user = Model_Auth::get_user_data();
          _A_::$app->setSession('_', $user['aid']);
          _A_::$app->setSession('user', $user);
          $url = !is_null(_A_::$app->get('url')) ? base64_decode(urldecode(_A_::$app->get('url'))) : _A_::$app->router()->UrlTo('shop');
          $this->redirect($url);
        }
      }

      if((_A_::$app->request_is_post()) && !is_null(_A_::$app->post('login')) && !is_null(_A_::$app->post('pass'))) {
        if(empty(_A_::$app->post('login')))
          exit('Empty Email/Username field');
        if(empty(_A_::$app->post('pass')))
          exit('Empty Password field');

        $login = _A_::$app->post('login');
        $password = _A_::$app->post('pass');

        if(Model_Auth::is_admin($login)) {
          if($this->admin_authorize($login, $password)) {
            $url = base64_decode(urldecode(_A_::$app->post('redirect')));
            $url = (strlen($url) > 0) ? $url : _A_::$app->router()->UrlTo('product');
            $this->redirect($url);
          }
        }
        if(Model_Auth::is_user($login)) {
          if($this->user_authorize($login, $password)) {
            $url = base64_decode(urldecode(_A_::$app->post('redirect')));
            $url = (strlen($url) > 0) ? $url : _A_::$app->router()->UrlTo('shop');
            $this->redirect($url);
          }
        }
        exit('Wrong Email/Username or Password');
      } else {

        $redirect = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : '';
        $prms = null;
        if(!is_null(_A_::$app->get('url'))) {
          $prms['url'] = _A_::$app->get('url');
        }
        $registration_url = _A_::$app->router()->UrlTo('authorization/registration', $prms);
        $lostpassword_url = _A_::$app->router()->UrlTo('authorization/lost_password', $prms);
        $this->main->template->vars('registration_url', $registration_url);
        $this->main->template->vars('lostpassword_url', $lostpassword_url);
        $this->main->template->vars('redirect', $redirect);
        $this->main->view('authorization');
      }
    }

    /**
     * @export
     */
    public function registration() {
      $prms = null;

      if($this->is_admin_logged()) {
        $url = !is_null(_A_::$app->get('url')) ? base64_decode(urldecode(_A_::$app->get('url'))) : _A_::$app->router()->UrlTo('product');
        $this->redirect($url);
      }
      if($this->is_user_logged()) {
        $url = !is_null(_A_::$app->get('url')) ? base64_decode(urldecode(_A_::$app->get('url'))) : _A_::$app->router()->UrlTo('shop');
        $this->redirect($url);
      }
      if($this->is_set_admin_remember()) {
        $remember = _A_::$app->cookie('_ar');
        if(Model_Auth::is_admin_remember($remember)) {
          $admin = Model_Auth::get_admin_data();
          _A_::$app->setSession('_a', $admin['id']);
          $url = !is_null(_A_::$app->get('url')) ? base64_decode(urldecode(_A_::$app->get('url'))) : _A_::$app->router()->UrlTo('product');
          $this->redirect($url);
        }
      }
      if($this->is_set_user_remember()) {
        $remember = _A_::$app->cookie('_r');
        if(Model_Auth::is_user_remember($remember)) {
          $user = Model_Auth::get_user_data();
          _A_::$app->setSession('_', $user['aid']);
          _A_::$app->setSession('user', $user);
          $url = !is_null(_A_::$app->get('url')) ? base64_decode(urldecode(_A_::$app->get('url'))) : _A_::$app->router()->UrlTo('shop');
          $this->redirect($url);
        }
      }

      $redirect = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : '';
      $prms = null;
      if(!is_null(_A_::$app->get('url'))) {
        $prms['url'] = _A_::$app->get('url');
      }
      $this->main->template->vars('redirect', $redirect);
      $this->main->view('registration');
    }

    public function user_authorize($mail, $password) {
      return Controller_User::authorize($mail, $password);
    }

    /**
     * @export
     */
    public function lost_password() {
      if(_A_::$app->request_is_post()) {
        if(!_A_::$app->get('user_id')) {
          $this->main->template->vars('action', _A_::$app->router()->UrlTo('authorization/lost_password'));
          if(empty(_A_::$app->post('login'))) {
            $error = ['Empty Email. Identify your Email(Login).'];
            $this->main->template->vars('error', $error);
            $this->lost_password_form();
            exit();
          }
          $email = _A_::$app->post('login');
          if(!Model_User::exist($email)) {
            $error = ['Wrong Email(Login) or this Email is not registered.'];
            $this->main->template->vars('error', $error);
            $this->lost_password_form();
            exit();
          }
          $user = Model_User::get_by_email($email);
          $user_id = $user['aid'];
          $date = date('Y-m-d H:i:s', time());
          $remind = Model_Auth::generate_hash($date);
          if(Model_User::set_remind_for_change_pass($remind, $date, $user_id)) {
            $remind_url = _A_::$app->router()->UrlTo('authorization/lost_password', ['remind' => urlencode(base64_encode($remind))]);
            if($this->send_remind($email, $remind_url)) {

              $message = 'A link to change your password has been sent to your e-mail. This link will be valid for 1 hour!';
              $this->main->template->vars('message', $message);
              $this->main->view_layout('msg_span');
            }
          }
        } else {
          //TODO process of change password
          $user_id = _A_::$app->get('user_id');
          $remind = _A_::$app->get('remind');
          if(isset($remind)) {
            if(Model_User::exist(null, $user_id)) {
              $user = Model_Users::get_by_id($user_id);
              if(isset($user)) {
                $result = true;
                $time = strtotime($user['remind_time']);
                $now = time();
                if(($now - $time) <= 3600) {
                  $result = true;
                  if($remind == Model_Auth::check($user['remind_time'], $user['remind'])) {
                    $password = _A_::$app->post('password');
                    $confirm = _A_::$app->post('confirm');
                    if((isset($password) && strlen(trim($password)) > 0) && (isset($confirm) && strlen(trim($confirm)) > 0)) {
                      if($password == $confirm) {
                        $hash = Model_Auth::generate_hash($password);
                        Model_User::update_password($hash, $user_id);
                        Model_User::clean_remind($user_id);
                        $message = 'Congratulattions. Your Password has been changed succesfully!<br>';
                        $message .= 'Now you can go to the <a href="' . _A_::$app->router()->UrlTo('authorization') . '">login form</a> and use it.';
                        $this->main->template->vars('message', $message);
                        $this->main->view_layout('msg_span');
                        exit();
                      } else {
                        $error = ['Password and Confirm Password must be identical!'];
                        $this->main->template->vars('error', $error);
                      }
                    } else {
                      $error = ['Identity Password and Confirm Password!'];
                      $this->main->template->vars('error', $error);
                    }
                    $action = _A_::$app->router()->UrlTo('authorization/lost_password', ['user_id' => $user_id]);
                    $this->main->template->vars('action', $action);
                    $this->main->template->vars('remind', $remind);
                    $this->main->template->vars('user_id', $user_id);
                    $this->main->view_layout('remind/change_password_form');
                  } else {
                    $back_url = _A_::$app->router()->UrlTo('/');
                    $message = 'This link is no longer relevant. You can not change the password . Repeat the password recovery procedure.';
                    $this->main->template->vars('message', $message);
                    $this->main->template->vars('back_url', $back_url);
                    $this->main->view_layout('msg_span');
                  }
                } else {
                  $back_url = _A_::$app->router()->UrlTo('/');
                  $message = 'This link is no longer relevant. You can not change the password . Repeat the password recovery procedure.';
                  $this->template->vars('message', $message);
                  $this->template->vars('back_url', $back_url);
                  $this->main->view_layout('msg_span');
                }
              } else {
                $url = _A_::$app->router()->UrlTo('error404');
                $this->redirect($url);
              }
            } else {
              $url = _A_::$app->router()->UrlTo('error404');
              $this->redirect($url);
            }
          } else {
            $url = _A_::$app->router()->UrlTo('error404');
            $this->redirect($url);
          }
        }
      } else {
        $result = false;
        if(_A_::$app->request_is_get()) {
          $remind = _A_::$app->get('remind');
          if(isset($remind)) {
            $remind = base64_decode(urldecode($remind));
            if(Model_User::remind_exist($remind)) {
              $user = Model_User::get_by_remind($remind);
              if(isset($user)) {
                $user_id = $user['aid'];
                $time = strtotime($user['remind_time']);
                $now = time();
                if((($now - $time) <= 3600) && ($remind == Model_Auth::check($user['remind_time'], $user['remind']))) {
                  $result = true;
                  $action = _A_::$app->router()->UrlTo('authorization/lost_password', ['user_id' => $user_id]);
                  $back_url = _A_::$app->router()->UrlTo('/');
                  $this->template->vars('back_url', $back_url, true);
                  $this->template->vars('action', $action);
                  $this->template->vars('remind', $remind);
                  $this->template->vars('user_id', $user_id);
                  $this->main->view('remind/change_password');
                } else {
                  $result = true;
                  $message = 'This link is no longer relevant. You can not change the password . Repeat the password recovery procedure.';
                  $this->main->template->vars('message', $message);
                  $this->main->view('message');
                }
              }
            }
          } else {
            $result = true;
            $action = _A_::$app->router()->UrlTo('authorization/lost_password');
            $prms = null;
            if(!is_null(_A_::$app->get('url'))) {
              $prms['url'] = _A_::$app->get('url');
            }
            $back_url = _A_::$app->router()->UrlTo('authorization', $prms);
            $this->main->template->vars('action', $action);
            $this->main->template->vars('back_url', $back_url);
            $this->main->view('lost_password');
          }
        }
        if(!$result) {
          $this->main->error404();
        }
      }
    }

    public function index($required_access = true) { }

    public function view($partial = false, $required_access = false) { }

  }