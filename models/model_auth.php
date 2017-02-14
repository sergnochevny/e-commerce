<?php

  Class Model_Auth extends Model_Base {

    private static $user = null;
    private static $admin = null;

    private static $salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    private static $cost = 12;

    public static function hash_($input, $salt = null, $cost = null) {
      $cost = sprintf('%02d', min(31, max($cost, 4)));
      $salt = '$2a$' . $cost . '$' . $salt . '$';
      return crypt($input, $salt);
    }

    public static function check($password, $hash) {
      preg_match('/^\$2a\$(\d{2})\$(.{22})/D', $hash, $matches);
      $cost = $matches[1];
      $salt = $matches[2];
      return self::hash_($password, $salt, $cost);
    }

    public static function generatestr($length = 22) {
      $salt = self::$salt;
      $numChars = strlen($salt);
      $string = '';
      for($i = 0; $i < $length; $i++) {
        $string .= substr($salt, rand(1, $numChars) - 1, 1);
      }
      return $string;
    }

    public static function is_user_remember($remember) {
      $q = "select * from fabrix_accounts where remember='" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $remember) . "'";
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      if($res) {
        self::$user = mysqli_fetch_assoc($res);
        if(mysqli_num_rows($res) > 0) {
          $mail = self::$user['email'];
          $hash = self::$user['password'];
          $hash = md5($mail) . $hash;
          $salt = md5(!is_null(_A_::$app->server('HTTP_X_FORWARDED_FOR')) ? _A_::$app->server('HTTP_X_FORWARDED_FOR') : _A_::$app->server('REMOTE_ADDR'));
          if($remember == self::hash_($hash, $salt, self::$cost)) {
            return true;
          } else {
            setcookie('_r', '');
          }
        }
      }
      return false;
    }

    public static function is_user($mail) {
      $res = false;
      $q = "select * from fabrix_accounts where email='" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $mail) . "'";
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      $res = $res && (mysqli_num_rows($res) > 0);
      return $res;
    }

    public static function user_authorize($mail, $password) {
      $mail = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $mail);
      $password = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $password);
      $q = "select * from fabrix_accounts where email='$mail'";
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      if($res) {
        if(mysqli_num_rows($res) > 0) {
          self::$user = mysqli_fetch_assoc($res);
          $hash = self::$user['password'];
          if($hash == self::check($password, $hash)) {
            if(!is_null(_A_::$app->post('rememberme')) && _A_::$app->post('rememberme') == 1) {
              $hash = md5($mail) . $hash;
              $salt = md5(!is_null(_A_::$app->server('HTTP_X_FORWARDED_FOR')) ? _A_::$app->server('HTTP_X_FORWARDED_FOR') : _A_::$app->server('REMOTE_ADDR'));
              $hash = self::hash_($hash, $salt, self::$cost);
              $q = "update fabrix_accounts set remember = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $hash) . "' where aid = " . self::$user['aid'];
              if(mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q)) setcookie('_r', $hash, time() + 60 * 60 * 24 * 30);
            }
            return true;
          }
        }
      }
      return (false);
    }

    public static function is_admin_remember($remember) {
      $q = "select * from fabrix_admins where rememberme ='" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $remember) . "'";
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      if($res) {
        self::$admin = mysqli_fetch_assoc($res);
        if(mysqli_num_rows($res) > 0) {
          $login = self::$admin['login'];
          $hash = self::$admin['password'];
          $hash = md5($login) . $hash;
          $salt = md5(!is_null(_A_::$app->server('HTTP_X_FORWARDED_FOR')) ? _A_::$app->server('HTTP_X_FORWARDED_FOR') : _A_::$app->server('REMOTE_ADDR'));
          if($remember == self::hash_($hash, $salt, self::$cost)) {
            return true;
          } else {
            setcookie('_ar', '');
          }
        }
      }
      return false;
    }

    public static function is_admin($login) {
      $res = false;
      $q = "select * from fabrix_admins where login='" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $login) . "'";
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      $res = $res && (mysqli_num_rows($res) > 0);
      return $res;
    }

    public static function admin_authorize($login, $password) {
      $login = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $login);
      $password = mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $password);
      $q = "select * from fabrix_admins where login='$login'";
      $res = mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q);
      if($res) {
        self::$admin = mysqli_fetch_assoc($res);
        if(mysqli_num_rows($res) > 0) {
          $hash = self::$admin['password'];
          if($hash == self::check($password, $hash)) {
            if(!is_null(_A_::$app->post('rememberme')) && _A_::$app->post('rememberme') == 1) {
              $hash = md5($login) . $hash;
              $salt = md5(!is_null(_A_::$app->server('HTTP_X_FORWARDED_FOR')) ? _A_::$app->server('HTTP_X_FORWARDED_FOR') : _A_::$app->server('REMOTE_ADDR'));
              $hash = self::hash_($hash, $salt, self::$cost);
              $q = "update fabrix_admins set rememberme = '" . mysqli_real_escape_string(_A_::$app->getDBConnection('iluvfabrix'), $hash) . "' where id = " . self::$admin['id'];
              if(mysqli_query(_A_::$app->getDBConnection('iluvfabrix'), $q)) setcookie('_ar', $hash, time() + 60 * 60 * 24 * 30);
            }
            return true;
          }
        }
      }
      return (false);
    }

    public static function get_user_data() {
      return self::$user;
    }

    public static function get_admin_data() {
      return self::$admin;
    }

    public static function generate_hash($data) {
      $salt = self::generatestr();
      $hash = self::hash_($data, $salt, self::$cost);
      return $hash;
    }

  }