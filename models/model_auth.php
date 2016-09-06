<?php

Class Model_Auth extends Model_Model
{
    private $user = null;
    private $admin = null;

    private $salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    private $cost = 12;

    function hash_($input, $salt = NULL, $cost = NULL)
    {
        $cost = sprintf('%02d', min(31, max($cost, 4)));

        $salt = '$2a$' . $cost . '$' . $salt . '$';

        return crypt($input, $salt);
    }

    function check($password, $hash)
    {
        preg_match('/^\$2a\$(\d{2})\$(.{22})/D', $hash, $matches);

        $cost = $matches[1];
        $salt = $matches[2];

        return $this->hash_($password, $salt, $cost);
    }

    function generatestr($length = 22)
    {
        $salt = $this->salt;
        $numChars = strlen($salt);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($salt, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    public function is_user_remember($remember)
    {
        $q = "select * from fabrix_accounts where remember='" . mysql_real_escape_string($remember) . "'";
        $res = mysql_query($q);
        if ($res) {
            $this->user = mysql_fetch_assoc($res);
            if (mysql_num_rows($res) > 0) {
                $mail = $this->user['email'];
                $hash = $this->user['password'];
                $hash = md5($mail) . $hash;
                $salt = md5(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
                if ($remember == $this->hash_($hash, $salt, $this->cost)) {
                    return true;
                } else {
                    setcookie('_r', '');
                }
            }
        }
        return false;
    }

    public function is_user($mail)
    {
        $res = false;
        $q = "select * from fabrix_accounts where email='" . mysql_real_escape_string($mail) . "'";
        $res = mysql_query($q);
        $res = $res && (mysql_num_rows($res) > 0);
        return $res;
    }

    public function user_authorize($mail, $password)
    {
        $q = "select * from fabrix_accounts where email='$mail'";
        $res = mysql_query($q);
        if ($res) {
            if (mysql_num_rows($res) > 0) {
                $this->user = mysql_fetch_assoc($res);
                $hash = $this->user['password'];
                if ($hash == $this->check($password, $hash)) {
                    if (isset($_POST['rememberme']) && $_POST['rememberme'] == 1) {
                        $hash = md5($mail) . $hash;
                        $salt = md5(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
                        $hash = $this->hash_($hash, $salt, $this->cost);
                        $q = "update fabrix_accounts set remember = '" . mysql_real_escape_string($hash) . "' where aid = " . $this->user['aid'];
                        if (mysql_query($q)) setcookie('_r', $hash, time() + 60 * 60 * 24 * 30);
                    }
                    return true;
                }
            }
        }
        return (false);
    }

    public function is_admin_remember($remember)
    {
        $q = "select * from fabrix_admins where rememberme ='" . mysql_real_escape_string($remember) . "'";
        $res = mysql_query($q);
        if ($res) {
            $this->admin = mysql_fetch_assoc($res);
            if (mysql_num_rows($res) > 0) {
                $login = $this->admin['login'];
                $hash = $this->admin['password'];
                $hash = md5($login) . $hash;
                $salt = md5(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
                if ($remember == $this->hash_($hash, $salt, $this->cost)) {
                    return true;
                } else {
                    setcookie('_ar', '');
                }
            }
        }
        return false;
    }

    public function is_admin($login)
    {
        $res = false;
        $q = "select * from fabrix_admins where login='" . mysql_real_escape_string($login) . "'";
        $res = mysql_query($q);
        $res = $res && (mysql_num_rows($res) > 0);
        return $res;
    }

    public function admin_authorize($login, $password)
    {
        $q = "select * from fabrix_admins where login='$login'";
        $res = mysql_query($q);
        if ($res) {
            $this->admin = mysql_fetch_assoc($res);
            if (mysql_num_rows($res) > 0) {
                $hash = $this->admin['password'];
                if ($hash == $this->check($password, $hash)) {
                    if (isset($_POST['rememberme']) && $_POST['rememberme'] == 1) {
                        $hash = md5($login) . $hash;
                        $salt = md5(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
                        $hash = $this->hash_($hash, $salt, $this->cost);
                        $q = "update fabrix_admins set rememberme = '" . mysql_real_escape_string($hash) . "' where id = " . $this->admin['id'];
                        if (mysql_query($q)) setcookie('_ar', $hash, time() + 60 * 60 * 24 * 30);
                    }
                    return true;
                }
            }
        }
        return (false);
    }

    public function get_user_data()
    {
        return $this->user;
    }

    public function get_admin_data()
    {
        return $this->admin;
    }


    public function generate_hash($data)
    {
        $salt = $this->generatestr();
        $hash = $this->hash_($data, $salt, $this->cost);
        return $hash;
    }

    public function getAccessRights($login)
    {
        $resulthatistim = mysql_query("select * from users WHERE login='$login'");
        $rowsni = mysql_fetch_array($resulthatistim);
        return array('enter_soll' => $rowsni['soll'], 'password' => $rowsni['password'], 'character' => $rowsni['character']);
    }
}