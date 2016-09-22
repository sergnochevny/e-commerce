<?php

Class Controller_User Extends Controller_Controller
{

    public function user()
    {
        if (!$this->is_authorized()) {
            if ((_A_::$app->server('REQUEST_METHOD') == 'POST') &&
                !is_null(_A_::$app->post('login')) && !is_null(_A_::$app->post('pass'))
            ) {
                if (empty(_A_::$app->post('login')) && empty(_A_::$app->post('pass'))) exit('Empty Email or Password field');
                $email = _A_::$app->post('login');
                $password = _A_::$app->post('pass');
                if (!$this->authorize($email, $password)) exit('Wrong Email or Password');
                $url = base64_decode(urldecode(_A_::$app->post('redirect')));
                $url = (strlen($url) > 0) ? $url : _A_::$app->router()->UrlTo('shop');
                $this->redirect($url);
            } else {

                $redirect = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : base64_encode(_A_::$app->router()->UrlTo('shop'));
                $prms = null;
                if (!is_null(_A_::$app->get('url'))) {
                    $prms['url'] = _A_::$app->get('url');
                }
                $registration_url = _A_::$app->router()->UrlTo('user/registration', $prms);
                $lostpassword_url = _A_::$app->router()->UrlTo('authorization/lost_password', $prms);
                $this->main->template->vars('registration_url', $registration_url);
                $this->main->template->vars('lostpassword_url', $lostpassword_url);
                $this->main->template->vars('redirect', $redirect);
                $this->main->view('user');
            }
        } else {
            $url = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : _A_::$app->router()->UrlTo('shop');
            $this->redirect($url);
        }
    }

    public function is_authorized()
    {
        if (self::is_logged()) return true;
        if (self::is_set_remember()) {
            $remember = _A_::$app->cookie('_r');
            if (Model_Auth::is_user_remember($remember)) {
                $user = Model_Auth::get_user_data();
                _A_::$app->setSession('_', $user['aid']);
                _A_::$app->setSession('user', $user);
                return true;
            }
        }
        return false;
    }

    public function authorize($email, $password)
    {
        $email = mysql_real_escape_string(stripslashes(strip_tags(trim($email))));
        $password = mysql_real_escape_string(stripslashes(strip_tags(trim($password))));
        $res = Model_Auth::user_authorize($email, $password);
        if ($res) {
            $user = $model->get_user_data();
            _A_::$app->setSession('_', $user['aid']);
            _A_::$app->setSession('user', $user);
        }
        return $res;
    }

    public function log_out()
    {
        _A_::$app->setSession('_', null);
        _A_::$app->setSession('user', null);
        _A_::$app->setCookie('_r', null);
        $url = _A_::$app->router()->UrlTo('shop');
        $this->redirect($url);
    }

    public static function is_set_remember()
    {
        return !is_null(_A_::$app->cookie('_r'));
    }

    public function change()
    {
        if (self::is_logged()) {
            $user = $this->get_from_session();
            $user_id = $user['aid'];
            _A_::$app->get('user_id', $user_id);
            $users = new Controller_Users();
            $action = _A_::$app->router()->UrlTo('user/change');
            $title = 'CHANGE REGISTRATION DATA';
            if (_A_::$app->server('REQUEST_METHOD') == 'POST') {
                $users->_save_edit();
                $users->main->template->vars('action', $action);
                $users->main->template->vars('title', $title);
                $users->_edit_form();
            } else {
                $users->_edit();
                $url = '';
                if (!is_null(_A_::$app->get('url'))) {
                    $url = _A_::$app->router()->UrlTo(base64_decode(urldecode(_A_::$app->get('url'))));
                }
                $users->main->template->vars('title', $title);
                $users->main->template->vars('action', $action);
                $users->main->template->vars('back_url', _A_::$app->router()->UrlTo(((strlen($url) > 0) ? $url : 'shop')), true);
                $users->main->view('edit');
            }
        } else {
            $this->redirect(_A_::$app->router()->UrlTo('authorization'));
        }
    }

    public static function is_logged()
    {
        return !is_null(_A_::$app->session('_'));
    }

    private function get_from_session()
    {
        return _A_::$app->session('user');
    }

    public function registration()
    {
        if (_A_::$app->server('REQUEST_METHOD') == 'POST') {
            $prms = null;
            $users = new Controller_Users();
            if (!$users->_save_new()) {
                $users->main->template->vars('title', 'REGISTRATION USER');
                $users->main->template->vars('action', _A_::$app->router()->UrlTo('user/registration'));
                $users->_new_form('authorization');
            } else {
                $this->template->view_layout('thanx');
            }
        } else {
            $prms = null;
            if (!is_null(_A_::$app->get('url'))) {
                $prms['url'] = _A_::$app->get('url');
            }
            $users = new Controller_Users();
            $users->_new_user();
            $users->template->vars('title', 'REGISTRATION USER');
            $users->template->vars('action', _A_::$app->router()->UrlTo('user/registration'));
            $users->template->vars('back_url', _A_::$app->router()->UrlTo('authorization', $prms), true);
            $users->main->view('new');

        }
    }

    private function sendWelcomeEmail($email)
    {
        $headers = "From: \"I Luv Fabrix\"<info@iluvfabrix.com>\n";
        $subject = "Thank you for registering with iluvfabrix.com";
        $body = "Thank you for registering with iluvfabrix.com.\n";
        $body .= "\n";
        $body .= "As a new user, you will get 20% off your first purchase (which you may use any time in the first year) unless we have a sale going on for a discount greater than 20%, in which case you get the greater of the two discounts.\n";
        $body .= "\n";
        $body .= "We will, from time to time, inform you by email of various time limited specials on the iluvfabrix site.  If you wish not to receive these emails, please respond to this email with the word Unsubscribe in the subject line.\n";
        $body .= "\n";
        $body .= "Once again, thank you.........and enjoy shopping for World Class Designer Fabrics & Trims on iluvfabrix.com.\n";

        mail($email, $subject, $body, $headers);
    }


}
