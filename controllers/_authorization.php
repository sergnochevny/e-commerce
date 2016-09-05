<?php

class Controller_Authorization extends Controller_Base
{

    protected $main;

    function __construct($main)
    {

        $this->main = $main;
        $this->registry = $main->registry;
        $this->template = $main->template;

    }

    function update_passwd()
    {
        $model = new Model_Auth();
        $model->update_passwd();
    }

    function update_admin_passwd()
    {
        $model = new Model_Auth();
        $model->update_admin_passwd();
    }

    function user_authorize($mail, $password)
    {
        $mail = mysql_real_escape_string(stripslashes(strip_tags(trim($mail))));
        $password = mysql_real_escape_string(stripslashes(strip_tags(trim($password))));
        $model = new Model_Auth();
        $res = $model->user_authorize($mail, $password);
        if ($res) {
            $user = $model->get_user_data();
            $_SESSION['_'] = $user['aid'];
            $_SESSION['user'] = $user;
            //User => Session;
        }
        return $res;
    }

    function admin_authorize($login, $password)
    {
        $login = mysql_real_escape_string(stripslashes(strip_tags(trim($login))));
        $password = mysql_real_escape_string(stripslashes(strip_tags(trim($password))));
        $model = new Model_Auth();
        $res = $model->admin_authorize($login, $password);
        if ($res) {
            $admin = $model->get_admin_data();
            $_SESSION['_a'] = $admin['id'];
        }
        return $res;
    }

    function is_set_admin_remember(){
        return isset($_COOKIE['_ar']);
    }

    function is_set_user_remember(){
        return isset($_COOKIE['_ar']);
    }

    function is_user_authorized()
    {
        if (isset($_SESSION['_'])) return true;
        if (isset($_COOKIE['_r'])) {
            $remember = $_COOKIE['_r'];
            $model = new Model_Auth();
            if ($model->is_user_remember($remember)) {
                $user = $model->get_user_data();
                $_SESSION['_'] = $user['aid'];
                $_SESSION['user'] = $user;
                return true;
            }
        }
        return false;
    }

    function is_admin_authorized()
    {
        if (isset($_SESSION['_a'])) return true;
        if (isset($_COOKIE['_ar'])) {
            $remember = $_COOKIE['_ar'];
            $model = new Model_Auth();
            if ($model->is_admin_remember($remember)) {
                $admin = $model->get_admin_data();
                $_SESSION['_a'] = $admin['id'];
                return true;
            }
        }
        return false;
    }

    function is_admin_logged()
    {
        return isset($_SESSION['_a']);
    }

    function is_user_logged()
    {
        return isset($_SESSION['_']);
    }

    function authorization()
    {
        $base_url = BASE_URL;
        $model = new Model_Auth();
        if ($this->is_admin_logged()){
            $url = isset($_GET['url']) ? $_GET['url'] : $base_url . '/admin_home';
            $this->redirect($url);
        }
        if ($this->is_user_logged()){
            $url = isset($_GET['url']) ? $_GET['url'] : $base_url . '/shop';
            $this->redirect($url);
        }
        if ($this->is_set_admin_remember()){
            $remember = $_COOKIE['_ar'];
            if ($model->is_admin_remember($remember)) {
                $admin = $model->get_admin_data();
                $_SESSION['_a'] = $admin['id'];
                $url = isset($_GET['url']) ? $_GET['url'] : $base_url . '/admin_home';
                $this->redirect($url);
            }
        }
        if ($this->is_set_user_remember()){
            $remember = $_COOKIE['_r'];
            if ($model->is_user_remember($remember)) {
                $user = $model->get_user_data();
                $_SESSION['_'] = $user['aid'];
                $_SESSION['user'] = $user;
                $url = isset($_GET['url']) ? $_GET['url'] : $base_url . '/shop';
                $this->redirect($url);
            }
        }

        if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['login']) && isset($_POST['pass'])) {
            if (empty($_POST['login']{0})) exit('Empty Email/Username field');
            if (empty($_POST['pass']{0})) exit('Empty Password field');

            $login = $_POST['login'];
            $password = $_POST['pass'];

            if ($model->is_admin($login)){
                if ($this->admin_authorize($login, $password)){
                    $url = base64_decode(urldecode($_POST['redirect']));
                    $url = (strlen($url) > 0) ? $url : $base_url . '/admin_home';
                    $this->redirect($url);
                }
            }
            if ($model->is_user($login)){
                if ($this->user_authorize($login, $password)){
                    $url = base64_decode(urldecode($_POST['redirect']));
                    $url = (strlen($url) > 0) ? $url : $base_url . '/shop';
                    $this->redirect($url);
                }
            }
            exit('Wrong Email/Username or Password');
        } else {

            $redirect = isset($_GET['url']) ? $_GET['url'] : '';
            $registration_url = $base_url . '/registration_user';
            if (isset($_GET['url'])) {
                $registration_url .= '?url=' . $_GET['url'];
            }
            $lostpassword_url = $base_url . '/lost_password';
            if (isset($_GET['url'])) {
                $lostpassword_url .= '?url=' . $_GET['url'];
            }
            $this->template->vars('registration_url', $registration_url);
            $this->template->vars('lostpassword_url', $lostpassword_url);
            $this->template->vars('redirect', $redirect);
            $this->main->view('authorization/authorization');
        }
    }

    function user_authorization()
    {
        $base_url = BASE_URL;
        if (!$this->is_user_authorized()) {
            if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['login']) && isset($_POST['pass'])) {
                if (empty($_POST['login']{0}) && empty($_POST['pass']{0})) exit('Empty Email or Password field');
                $email = $_POST['login'];
                $password = $_POST['pass'];
                if (!$this->user_authorize($email, $password)) exit('Wrong Email or Password');
                $url = base64_decode(urldecode($_POST['redirect']));
                $url = (strlen($url) > 0) ? $url : $base_url . '/shop';
                $this->redirect($url);
            } else {

                $redirect = isset($_GET['url']) ? $_GET['url'] : base64_encode($base_url . '/shop');
                $registration_url = $base_url . '/registration_user';
                if (isset($_GET['url'])) {
                    $registration_url .= '?url=' . $_GET['url'];
                }
                $lostpassword_url = $base_url . '/lost_password';
                if (isset($_GET['url'])) {
                    $lostpassword_url .= '?url=' . $_GET['url'];
                }
                $this->template->vars('registration_url', $registration_url);
                $this->template->vars('lostpassword_url', $lostpassword_url);
                $this->template->vars('redirect', $redirect);
                $this->main->view('authorization/user_authorization');
            }
        } else {
            $url = isset($_GET['url']) ? $_GET['url'] : $base_url . '/shop';
            $this->redirect($url);
        }
    }

    function admin_authorization()
    {
        $base_url = BASE_URL;
        if (!$this->is_admin_authorized()) {
            if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['login']) && isset($_POST['pass'])) {
                if (empty($_POST['login']{0}) && empty($_POST['pass']{0})) exit('Empty Email or Password field');
                $login = $_POST['login'];
                $password = $_POST['pass'];
                if (!$this->admin_authorize($login, $password)) exit('Wrong Login or Password');
                $url = base64_decode(urldecode($_POST['redirect']));
                $url = (strlen($url) > 0) ? $url : $base_url . '/admin_home';
                $this->redirect($url);
            } else {

                $redirect = isset($_GET['url']) ? $_GET['url'] : base64_encode($base_url . '/admin_home');
                $this->template->vars('redirect', $redirect);

                include_once('controllers/_menu.php');
                $menu = new Controller_Menu($this);
                $menu->show_menu();

                $this->main->view_admin('authorization/admin');
            }
        } else {
            $url = isset($_GET['url']) ? $_GET['url'] : $base_url . '/admin_home';
            $this->redirect($url);
        }
    }

    public function admin_log_out()
    {
        $base_url = BASE_URL;
        unset($_SESSION['_a']);
        setcookie('_ar', '');
        $url = $base_url;
        $this->redirect($url);
    }

    public function user_log_out()
    {
        $base_url = BASE_URL;
        unset($_SESSION['_']);
        setcookie('_r', '');
        $url = $base_url . '/shop';
        $this->redirect($url);
    }

    public function get_user_from_session()
    {
        return isset($_SESSION['_']) ? $_SESSION['_'] : null;
    }

    public function send_remind($email, $remind_url)
    {
        $base_url = BASE_URL;
        $subject = "ILuvFabrix. Change Password.";
        ob_start();
        include('views/index/remind/remind_message.php');
        $message = ob_get_contents();
        ob_end_clean();
//        $message = htmlspecialchars(stripslashes(trim($message)));
        $headers = "MIME-Version: 1.0' \r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8 \r\n";

        return mail($email, $subject, $message, $headers);
    }

    private function lost_password_form()
    {
        $this->main->view_layout('authorization/lost_password_form');
    }

    public function lost_password()
    {
        $base_url = BASE_URL;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_GET['user_id'])) {
                $muser = new Model_User();
                $mauth = new Model_Auth();
                if (empty($_POST['login']{0})) {
                    $error = ['Empty Email. Identify your Email(Login).'];
                    $this->template->vars('error', $error);
                    $this->lost_password_form();
                    exit();
                }
                $email = $_POST['login'];
                if (!$muser->user_exist($email)) {
                    $error = ['Wrong Email(Login) or this Email is not registered.'];
                    $this->template->vars('error', $error);
                    $this->lost_password_form();
                    exit();
                }
                $user = $muser->get_user_by_email($email);
                $user_id = $user['aid'];
                $date = date('Y-m-d H:i:s', time());
                $remind = $mauth->generate_hash($date);
                if ($muser->set_remind_for_change_pass($remind, $date, $user_id)) {
                    $remind_url = $base_url . '/lost_password?remind=' . urlencode(base64_encode($remind));
                    if ($this->send_remind($email, $remind_url)) {

                        $message = 'A link to change your password has been sent to your e-mail. This link will be valid for 1 hour!!!';
                        $this->template->vars('message', $message);
                        $this->main->view_layout('msgs/msg_span');
                    }
                }
            } else {
                //TODO process of change password
                $user_id = $_GET['user_id'];
                $remind = isset($_POST['remind']) ? $_POST['remind'] : null;
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
                                    $password = isset($_POST['password']) ? $_POST['password'] : null;
                                    $confirm = isset($_POST['confirm']) ? $_POST['confirm'] : null;
                                    if ((isset($password) && strlen(trim($password)) > 0) &&
                                        (isset($confirm) && strlen(trim($confirm)) > 0)
                                    ) {
                                        if ($password == $confirm) {
                                            $hash = $mauth->generate_hash($password);
                                            $muser->update_password($hash, $user_id);
                                            $muser->clean_remind($user_id);
                                            $message = 'Congratulattions. Your Password has been changed succesfully!!!<br>';
                                            $message .= 'Now you can go to the <a href="' . $base_url . '/user_authorization">login form</a> and use it.';
                                            $this->template->vars('message', $message);
                                            $this->main->view_layout('msgs/msg_span');
                                            exit();

                                        } else {
                                            $error = ['Password and Confirm Password must be identical!!!'];
                                            $this->template->vars('error', $error);
                                        }
                                    } else {
                                        $error = ['Identity Password and Confirm Password!!!'];
                                        $this->template->vars('error', $error);
                                    }
                                    $action = $base_url . '/lost_password?user_id=' . $user_id;
                                    $this->template->vars('action', $action);
                                    $this->template->vars('remind', $remind);
                                    $this->template->vars('user_id', $user_id);
                                    $this->main->view_layout('remind/change_password_form');
                                } else {
                                    $back_url = $base_url;
                                    $message = 'This link is no longer relevant. You can not change the password . Repeat the password recovery procedure.';
                                    $this->template->vars('message', $message);
                                    $this->template->vars('back_url', $back_url);
                                    $this->main->view_layout('msgs/msg_span');
                                }
                            } else {
                                $back_url = $base_url;
                                $message = 'This link is no longer relevant. You can not change the password . Repeat the password recovery procedure.';
                                $this->template->vars('message', $message);
                                $this->template->vars('back_url', $back_url);
                                $this->main->view_layout('msgs/msg_span');
                            }

                        } else {
                            $url = $base_url . '/error404';
                            $this->redirect($url);
                        }
                    } else {
                        $url = $base_url . '/error404';
                        $this->redirect($url);
                    }
                } else {
                    $url = $base_url . '/error404';
                    $this->redirect($url);
                }
            }
        } else {
            $result = false;
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $remind = isset($_GET['remind']) ? $_GET['remind'] : null;
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
                                $action = $base_url . '/lost_password?user_id=' . $user_id;
                                $back_url = $base_url;
                                $this->template->vars('back_url', $back_url, true);
                                $this->template->vars('action', $action);
                                $this->template->vars('remind', $remind);
                                $this->template->vars('user_id', $user_id);
                                $this->main->view('remind/change_password');
                            } else {
                                $result = true;
                                $back_url = $base_url;
                                $message = 'This link is no longer relevant. You can not change the password . Repeat the password recovery procedure.';
                                $this->template->vars('message', $message);
                                $this->template->vars('back_url', $back_url);

                                $this->main->view('msgs/main_message');
                            }
                        }
                    }
                } else {
                    $result = true;
                    $action = $base_url . '/lost_password';
                    $back_url = $base_url . '/user_authorization';
                    if (isset($_GET['url'])) {
                        $back_url .= '?url=' . $_GET['url'];
                    }
                    $this->template->vars('action', $action);
                    $this->template->vars('back_url', $back_url);
                    $this->main->view('authorization/lost_password');

                }
            }
            if (!$result) {
                $this->main->error404();
            }
        }
    }

}