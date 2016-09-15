<?php

Class Controller_Admin Extends Controller_Controller
{

    public function admin()
    {
        if (!$this->is_authorized()) {
            if ((_A_::$app->server('REQUEST_METHOD') == 'POST') &&
                !is_null(_A_::$app->post('login')) && !is_null(_A_::$app->post('pass'))
            ) {
                if (empty(_A_::$app->post('login')) && empty(_A_::$app->post('pass'))) exit('Empty Login or Password field');
                $login = _A_::$app->post('login');
                $password = _A_::$app->post('pass');
                if (!$this->authorize($login, $password)) exit('Wrong Login or Password');
                $url = base64_decode(urldecode(_A_::$app->post('redirect')));
                $url = (strlen($url) > 0) ? $url : _A_::$app->router()->UrlTo('admin/home');
                $this->redirect($url);
            } else {

                $redirect = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : base64_encode(_A_::$app->router()->UrlTo('admin/home'));
                $this->template->vars('redirect', $redirect);

                $menu = new Controller_Menu($this);
                $menu->show_menu();

                $this->main->view_admin('admin');
            }
        } else {
            $url = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : _A_::$app->router()->UrlTo('admin/home');
            $this->redirect($url);
        }
    }

    public function is_authorized()
    {
        if (!is_null(_A_::$app->session('_a'))) return true;
        if (!is_null(_A_::$app->cookie('_ar'))) {
            $remember = _A_::$app->cookie('_ar');
            $model = new Model_Auth();
            if ($model->is_admin_remember($remember)) {
                $admin = $model->get_admin_data();
                _A_::$app->setSession('_a', $admin['id']);
                return true;
            }
        }
        return false;
    }

    public function home()
    {
//        session_destroy();
//        unset($_SESSION);
        $this->main->test_access_rights();
        $shop = new Controller_Shop($this->main);
        $shop->all_products();
        $shop->product_filtr_list();

        $this->main->view_admin('home');
    }

    public function log_out()
    {
        _A_::$app->setSession('_a', null);
        _A_::$app->setSession('user', null);
        _A_::$app->setCookie('_ar', null);
        $this->redirect(_A_::$app->router()->UrlTo('/'));
    }

    public function authorize($login, $password)
    {
        $login = mysql_real_escape_string(stripslashes(strip_tags(trim($login))));
        $password = mysql_real_escape_string(stripslashes(strip_tags(trim($password))));
        $model = new Model_Auth();
        $res = $model->admin_authorize($login, $password);
        if ($res) {
            $admin = $model->get_admin_data();
            _A_::$app->setSession('_a', $admin['id']);
        }
        return $res;
    }

    public function is_logged()
    {
        return !is_null(_A_::$app->session('_a'));
    }

    public function is_set_admin_remember()
    {
        return !is_null(_A_::$app->cookie('_ar'));
    }

}
