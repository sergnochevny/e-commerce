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
                $registration_url = _A_::$app->router()->UrlTo('users/registration', $prms);
                $lostpassword_url = _A_::$app->router()->UrlTo('authorization/lost_password', $prms);
                $this->template->vars('registration_url', $registration_url);
                $this->template->vars('lostpassword_url', $lostpassword_url);
                $this->template->vars('redirect', $redirect);
                $this->main->view('user_authorization');
            }
        } else {
            $url = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : _A_::$app->router()->UrlTo('shop');
            $this->redirect($url);
        }
    }

    public function is_authorized()
    {
        if (!is_null(_A_::$app->session('_'))) return true;
        if (!is_null(_A_::$app->cookie('_r'))) {
            $remember = _A_::$app->cookie('_r');
            $model = new Model_Auth();
            if ($model->is_user_remember($remember)) {
                $user = $model->get_user_data();
                _A_::$app->setSession('_', $user['aid']);
                _A_::$app->setSession('user', $user);
                return true;
            }
        }
        return false;
    }

    public function authorize($mail, $password)
    {
        $mail = mysql_real_escape_string(stripslashes(strip_tags(trim($mail))));
        $password = mysql_real_escape_string(stripslashes(strip_tags(trim($password))));
        $model = new Model_Auth();
        $res = $model->user_authorize($mail, $password);
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

    public function is_set_remember()
    {
        return !is_null(_A_::$app->cookie('_ar'));
    }

    public function is_logged()
    {
        return !is_null(_A_::$app->session('_'));
    }

    private function get_from_session()
    {
        return _A_::$app->session('user');
    }

    public function save_edit_registration_data()
    {
        if (!$this->is_user_logged()) {
            $this->redirect(_A_::$app->router()->UrlTo('/'));
        }
        $user_id = $this->get_from_session();
        _A_::$app->get('user_id', $user_id);
        $this->template->vars('action', _A_::$app->router()->UrlTo('user/save_edit'));
        $this->template->vars('title', 'CHANGE REGISTRATION DATA');
        $this->_save_edit_user();
        $this->_edit_user_form();
    }

    public function change_registration_data()
    {
        if ($this->is_logged()) {
            $user_id = $this->get_from_session();
            _A_::$app->get('user_id', $user_id);
            $action = _A_::$app->router()->UrlTo('user/save_edit');
            $this->template->vars('action', $action);
            $title = 'CHANGE REGISTRATION DATA';
            $this->template->vars('title', $title);
            $this->_edit_user();

            $url = '';
            if (!is_null(_A_::$app->get('url'))) {
                $url = _A_::$app->router()->UrlTo(base64_decode(urldecode(_A_::$app->get('url'))));
            }
            $this->template->vars('back_url', _A_::$app->router()->UrlTo(((strlen($url) > 0) ? $url : 'shop')), true);
            $this->main->view('edit');
        }

        $this->redirect(_A_::$app->router()->UrlTo('/'));
    }


}
