<?php

  Class Controller_User Extends Controller_UserBase {

    public static function sendWelcomeEmail($email) {
      $headers = "From: \"I Luv Fabrix\"<" . _A_::$app->keyStorage()->system_info_email . ">\n";
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
     */
    public function user() {
      if(!$this->is_authorized()) {
        if((_A_::$app->request_is_post()) && !is_null(_A_::$app->post('login')) && !is_null(_A_::$app->post('pass'))) {
          if(empty(_A_::$app->post('login')) && empty(_A_::$app->post('pass')))
            exit('Empty Email or Password field');
          $email = _A_::$app->post('login');
          $password = _A_::$app->post('pass');
          if(!self::authorize($email, $password))
            exit('Wrong Email or Password');
          $url = base64_decode(urldecode(_A_::$app->post('redirect')));
          $url = (strlen($url) > 0) ? $url : _A_::$app->router()->UrlTo('shop');
          $this->redirect($url);
        } else {

          $redirect = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : urlencode(base64_encode(_A_::$app->router()->UrlTo('shop')));
          $prms = null;
          if(!is_null(_A_::$app->get('url'))) $prms['url'] = _A_::$app->get('url');
          $registration_url = _A_::$app->router()->UrlTo('user/registration', $prms);
          $lostpassword_url = _A_::$app->router()->UrlTo('authorization/lost_password', $prms);
          $this->main->template->vars('registration_url', $registration_url);
          $this->main->template->vars('lostpassword_url', $lostpassword_url);
          $this->main->template->vars('redirect', $redirect);
          $this->main->view('user');
        }
      } else {
        $url = !is_null(_A_::$app->get('url')) ? base64_decode(urldecode(_A_::$app->get('url'))) : _A_::$app->router()->UrlTo('shop');
        $this->redirect($url);
      }
    }

    /**
     * @export
     */
    public function log_out() {
      if(self::is_logged()) {
        _A_::$app->setSession('_', null);
        _A_::$app->setSession('user', null);
        _A_::$app->setCookie('_r', null);
      }
      $this->redirect(_A_::$app->router()->UrlTo('shop'));
    }

    /**
     * @export
     */
    public function change() {
      $this->main->is_user_authorized(true);
      $user = self::get_from_session();
      _A_::$app->get('aid', $user['aid']);
      $action = 'user/change';
      $title = 'CHANGE REGISTRATION DATA';
      $url = '';
      if(!is_null(_A_::$app->get('url'))) {
        $url = base64_decode(urldecode(_A_::$app->get('url')));
      }
      $back_url = (strlen($url) > 0) ? $url : 'shop';
      (new Controller_Users())->user_handling($data, $action, $back_url, $title, true);
    }

    /**
     * @export
     */
    public function registration() {
      if(self::is_logged()) {
        $this->redirect(_A_::$app->router()->UrlTo('/'));
      } else {
        $action = 'user/registration';
        $title = 'REGISTRATION USER';
        $prms = null;
        if(!is_null(_A_::$app->get('url'))) {
          $prms['url'] = _A_::$app->get('url');
        }
        $back_url = _A_::$app->router()->UrlTo('authorization', $prms);
        (new Controller_Users())->user_handling($data, $action, $back_url, $title, true, true);
        self::sendWelcomeEmail($data['email']);
        $this->template->view_layout('thanx');
      }
    }

    public function index($required_access = true) { }

    public function view() { }

  }