<?php

class Controller_Authorization extends Controller_Controller
{

    public function authorization()
    {
        $prms = null;
        $model = new Model_Auth();

        if ($this->is_admin_logged()) {
            $url = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : _A_::$app->router()->UrlTo('admin/home');
            $this->redirect($url);
        }
        if ($this->is_user_logged()) {
            $url = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : _A_::$app->router()->UrlTo('shop');
            $this->redirect($url);
        }
        if ($this->is_set_admin_remember()) {
            $remember = _A_::$app->cookie('_ar');
            if ($model->is_admin_remember($remember)) {
                $admin = $model->get_admin_data();
                _A_::$app->setSession('_a', $admin['id']);
                $url = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : _A_::$app->router()->UrlTo('admin/home');
                $this->redirect($url);
            }
        }
        if ($this->is_set_user_remember()) {
            $remember = _A_::$app->cookie('_r');
            if ($model->is_user_remember($remember)) {
                $user = $model->get_user_data();
                _A_::$app->setSession('_', $user['aid']);
                _A_::$app->setSession('user', $user);
                $url = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : _A_::$app->router()->UrlTo('shop');
                $this->redirect($url);
            }
        }

        if ((_A_::$app->server('REQUEST_METHOD') == 'POST') &&
            !is_null(_A_::$app->post('login')) && !is_null(_A_::$app->post('pass'))
        ) {
            if (empty(_A_::$app->post('login'))) exit('Empty Email/Username field');
            if (empty(_A_::$app->post('pass'))) exit('Empty Password field');

            $login = _A_::$app->post('login');
            $password = _A_::$app->post('pass');

            if ($model->is_admin($login)) {
                if ($this->admin_authorize($login, $password)) {
                    $url = base64_decode(urldecode(_A_::$app->post('redirect')));
                    $url = (strlen($url) > 0) ? $url : _A_::$app->router()->UrlTo('admin/home');
                    $this->redirect($url);
                }
            }
            if ($model->is_user($login)) {
                if ($this->user_authorize($login, $password)) {
                    $url = base64_decode(urldecode(_A_::$app->post('redirect')));
                    $url = (strlen($url) > 0) ? $url : _A_::$app->router()->UrlTo('shop');
                    $this->redirect($url);
                }
            }
            exit('Wrong Email/Username or Password');
        } else {

            $redirect = !is_null(_A_::$app->get('url')) ? _A_::$app->get('url') : '';
            $prms = null;
            if (!is_null(_A_::$app->get('url'))) {
                $prms['url'] = _A_::$app->get('url');
            }
            $registration_url = _A_::$app->router()->UrlTo('users/registration', $prms);
            $lostpassword_url = _A_::$app->router()->UrlTo('authorization/lost_password', $prms);
            $this->main->template->vars('registration_url', $registration_url);
            $this->main->template->vars('lostpassword_url', $lostpassword_url);
            $this->main->template->vars('redirect', $redirect);
            $this->main->view('authorization');
        }
    }

    private function is_admin_logged()
    {
        return (new Controller_Admin($this->main))->is_logged();
    }

    private function is_user_logged()
    {
        return (new Controller_User($this->main))->is_logged();
    }

    private function is_set_admin_remember()
    {
        return (new Controller_Admin($this->main))->is_set_remember();
    }

    private function is_set_user_remember()
    {
        return (new Controller_User($this->main))->is_set_remember();
    }

    private function admin_authorize($login, $password)
    {
        return (new Controller_Admin($this->main))->authorize($login, $password);
    }

    function user_authorize($mail, $password)
    {
        return (new Controller_User($this->main))->authorize($mail, $password);
    }

    public function lost_password()
    {
        if (_A_::$app->server('REQUEST_METHOD') == 'POST') {
            if (!_A_::$app->get('user_id')) {
                $muser = new Model_User();
                $mauth = new Model_Auth();
                if (empty(_A_::$app->get('login'))) {
                    $error = ['Empty Email. Identify your Email(Login).'];
                    $this->main->template->vars('error', $error);
                    $this->lost_password_form();
                    exit();
                }
                $email = _A_::$app->get('login');
                if (!$muser->user_exist($email)) {
                    $error = ['Wrong Email(Login) or this Email is not registered.'];
                    $this->main->template->vars('error', $error);
                    $this->lost_password_form();
                    exit();
                }
                $user = $muser->get_user_by_email($email);
                $user_id = $user['aid'];
                $date = date('Y-m-d H:i:s', time());
                $remind = $mauth->generate_hash($date);
                if ($muser->set_remind_for_change_pass($remind, $date, $user_id)) {
                    $remind_url = _A_::$app->router()->UrlTo('authorization/lost_password', ['remind' => urlencode(base64_encode($remind))]);
                    if ($this->send_remind($email, $remind_url)) {

                        $message = 'A link to change your password has been sent to your e-mail. This link will be valid for 1 hour!!!';
                        $this->main->template->vars('message', $message);
                        $this->main->view_layout('msg_span');
                    }
                }
            } else {
                //TODO process of change password
                $user_id = _A_::$app->get('user_id');
                $remind = _A_::$app->get('remind');
                if (isset($remind)) {
                    $muser = new Model_User();
                    if ($muser->user_exist_by_id($user_id)) {
                        $user = $muser->get_user_by_id($user_id);
                        if (isset($user)) {
                            $result = true;
                            $time = strtotime($user['remind_time']);
                            $now = time();
                            if (($now - $time) <= 3600) {
                                $result = true;
                                $mauth = new Model_Auth();
                                if ($remind == $mauth->check($user['remind_time'], $user['remind'])) {
                                    $password = _A_::$app->post('password');
                                    $confirm = _A_::$app->post('confirm');
                                    if ((isset($password) && strlen(trim($password)) > 0) &&
                                        (isset($confirm) && strlen(trim($confirm)) > 0)
                                    ) {
                                        if ($password == $confirm) {
                                            $hash = $mauth->generate_hash($password);
                                            $muser->update_password($hash, $user_id);
                                            $muser->clean_remind($user_id);
                                            $message = 'Congratulattions. Your Password has been changed succesfully!!!<br>';
                                            $message .= 'Now you can go to the <a href="' . _A_::$app->router()->UrlTo('user') . '">login form</a> and use it.';
                                            $this->main->template->vars('message', $message);
                                            $this->main->view_layout('msg_span');
                                            exit();

                                        } else {
                                            $error = ['Password and Confirm Password must be identical!!!'];
                                            $this->main->template->vars('error', $error);
                                        }
                                    } else {
                                        $error = ['Identity Password and Confirm Password!!!'];
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
            if (_A_::$app->server('REQUEST_METHOD') == 'GET') {
                $remind = _A_::$app->get('remind');
                if (isset($remind)) {
                    $remind = base64_decode(urldecode($remind));
                    $muser = new Model_User();
                    if ($muser->remind_exist($remind)) {
                        $user = $muser->get_user_by_remind($remind);
                        if (isset($user)) {
                            $user_id = $user['aid'];
                            $time = strtotime($user['remind_time']);
                            $now = time();
                            $mauth = new Model_Auth();
                            if ((($now - $time) <= 3600) &&
                                ($remind == $mauth->check($user['remind_time'], $user['remind']))
                            ) {
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
                    if (!is_null(_A_::$app->get('url'))) {
                        $prms['url'] = _A_::$app->get('url');
                    }
                    $back_url = _A_::$app->router()->UrlTo('user', $prms);
                    $this->main->template->vars('action', $action);
                    $this->main->template->vars('back_url', $back_url);
                    $this->main->view('lost_password');
                }
            }
            if (!$result) {
                $this->main->error404();
            }
        }
    }

    private function lost_password_form()
    {
        $this->main->view_layout('lost_password_form');
    }

    private function send_remind($email, $remind_url)
    {
        $subject = "ILuvFabrix. Change Password.";
        ob_start();
        $this->template->vars('remind_url', $remind_url);
        $this->template->view_layout('remind/message');
        $message = ob_get_contents();
        ob_end_clean();
//        $message = htmlspecialchars(stripslashes(trim($message)));
        $headers = "MIME-Version: 1.0' \r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8 \r\n";

        return mail($email, $subject, $message, $headers);
    }

}