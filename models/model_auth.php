<?php

Class Model_Auth extends Model_Model
{
    private static $user = null;
    private static $admin = null;

    private static $salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    private static $cost = 12;

    public static function hash_($input, $salt = NULL, $cost = NULL)
    {
        $cost = sprintf('%02d', min(31, max($cost, 4)));
        $salt = '$2a$' . $cost . '$' . $salt . '$';
        return crypt($input, $salt);
    }

    public static function check($password, $hash)
    {
        preg_match('/^\$2a\$(\d{2})\$(.{22})/D', $hash, $matches);
        $cost = $matches[1];
        $salt = $matches[2];
        return self::hash_($password, $salt, $cost);
    }

    public static function generatestr($length = 22)
    {
        $salt = self::$salt;
        $numChars = strlen($salt);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($salt, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    public static function is_user_remember($remember)
    {
        $q = "select * from fabrix_accounts where remember='" . mysql_real_escape_string($remember) . "'";
        $res = mysql_query($q);
        if ($res) {
            self::$user = mysql_fetch_assoc($res);
            if (mysql_num_rows($res) > 0) {
                $mail = self::$user['email'];
                $hash = self::$user['password'];
                $hash = md5($mail) . $hash;
                $salt = md5(!is_null(_A_::$app->server('HTTP_X_FORWARDED_FOR')) ? _A_::$app->server('HTTP_X_FORWARDED_FOR') : _A_::$app->server('REMOTE_ADDR'));
                if ($remember == self::hash_($hash, $salt, self::$cost)) {
                    return true;
                } else {
                    setcookie('_r', '');
                }
            }
        }
        return false;
    }

    public static function is_user($mail)
    {
        $res = false;
        $q = "select * from fabrix_accounts where email='" . mysql_real_escape_string($mail) . "'";
        $res = mysql_query($q);
        $res = $res && (mysql_num_rows($res) > 0);
        return $res;
    }

    public static function user_authorize($mail, $password)
    {
        $q = "select * from fabrix_accounts where email='$mail'";
        $res = mysql_query($q);
        if ($res) {
            if (mysql_num_rows($res) > 0) {
                self::$user = mysql_fetch_assoc($res);
                $hash = self::$user['password'];
                if ($hash == self::check($password, $hash)) {
                    if (!is_null(_A_::$app->post('rememberme')) && _A_::$app->post('rememberme') == 1) {
                        $hash = md5($mail) . $hash;
                        $salt = md5(!is_null(_A_::$app->server('HTTP_X_FORWARDED_FOR')) ? _A_::$app->server('HTTP_X_FORWARDED_FOR') : _A_::$app->server('REMOTE_ADDR'));
                        $hash = self::hash_($hash, $salt, self::$cost);
                        $q = "update fabrix_accounts set remember = '" . mysql_real_escape_string($hash) . "' where aid = " . self::$user['aid'];
                        if (mysql_query($q)) setcookie('_r', $hash, time() + 60 * 60 * 24 * 30);
                    }
                    return true;
                }
            }
        }
        return (false);
    }

    public static function is_admin_remember($remember)
    {
        $q = "select * from fabrix_admins where rememberme ='" . mysql_real_escape_string($remember) . "'";
        $res = mysql_query($q);
        if ($res) {
            self::$admin = mysql_fetch_assoc($res);
            if (mysql_num_rows($res) > 0) {
                $login = self::$admin['login'];
                $hash = self::$admin['password'];
                $hash = md5($login) . $hash;
                $salt = md5(!is_null(_A_::$app->server('HTTP_X_FORWARDED_FOR')) ? _A_::$app->server('HTTP_X_FORWARDED_FOR') : _A_::$app->server('REMOTE_ADDR'));
                if ($remember == self::hash_($hash, $salt, self::$cost)) {
                    return true;
                } else {
                    setcookie('_ar', '');
                }
            }
        }
        return false;
    }

    public static function is_admin($login)
    {
        $res = false;
        $q = "select * from fabrix_admins where login='" . mysql_real_escape_string($login) . "'";
        $res = mysql_query($q);
        $res = $res && (mysql_num_rows($res) > 0);
        return $res;
    }

    public static function admin_authorize($login, $password)
    {
        $q = "select * from fabrix_admins where login='$login'";
        $res = mysql_query($q);
        if ($res) {
            self::$admin = mysql_fetch_assoc($res);
            if (mysql_num_rows($res) > 0) {
                $hash = self::$admin['password'];
                if ($hash == self::check($password, $hash)) {
                    if (!is_null(_A_::$app->post('rememberme')) && _A_::$app->post('rememberme') == 1) {
                        $hash = md5($login) . $hash;
                        $salt = md5(!is_null(_A_::$app->server('HTTP_X_FORWARDED_FOR')) ? _A_::$app->server('HTTP_X_FORWARDED_FOR') : _A_::$app->server('REMOTE_ADDR'));
                        $hash = self::hash_($hash, $salt, self::$cost);
                        $q = "update fabrix_admins set rememberme = '" . mysql_real_escape_string($hash) . "' where id = " . self::$admin['id'];
                        if (mysql_query($q)) setcookie('_ar', $hash, time() + 60 * 60 * 24 * 30);
                    }
                    return true;
                }
            }
        }
        return (false);
    }

    public static function get_user_data()
    {
        return self::$user;
    }

    public static function get_admin_data()
    {
        return self::$admin;
    }


    public static function generate_hash($data)
    {
        $salt = self::generatestr();
        $hash = self::hash_($data, $salt, self::$cost);
        return $hash;
    }

    public static function getAccessRights($login)
    {
        $resulthatistim = mysql_query("select * from users WHERE login='$login'");
        $rowsni = mysql_fetch_array($resulthatistim);
        return array('enter_soll' => $rowsni['soll'], 'password' => $rowsni['password'], 'character' => $rowsni['character']);
    }
}