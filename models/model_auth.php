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
      $q = "select * from fabrix_accounts where remember='" . static::escape( $remember) . "'";
      $res = static::query( $q);
      if($res) {
        self::$user = static::fetch_assoc($res);
        if(static::num_rows($res) > 0) {
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
      $q = "select * from fabrix_accounts where email='" . static::escape( $mail) . "'";
      $res = static::query( $q);
      $res = $res && (static::num_rows($res) > 0);
      return $res;
    }

    public static function user_authorize($mail, $password) {
      $mail = static::escape( $mail);
      $password = static::escape( $password);
      $q = "select * from fabrix_accounts where email='$mail'";
      $res = static::query( $q);
      if($res) {
        if(static::num_rows($res) > 0) {
          self::$user = static::fetch_assoc($res);
          $hash = self::$user['password'];
          if($hash == self::check($password, $hash)) {
            if(!is_null(_A_::$app->post('rememberme')) && _A_::$app->post('rememberme') == 1) {
              $hash = md5($mail) . $hash;
              $salt = md5(!is_null(_A_::$app->server('HTTP_X_FORWARDED_FOR')) ? _A_::$app->server('HTTP_X_FORWARDED_FOR') : _A_::$app->server('REMOTE_ADDR'));
              $hash = self::hash_($hash, $salt, self::$cost);
              $q = "update fabrix_accounts set remember = '" . static::escape( $hash) . "' where aid = " . self::$user['aid'];
              if(static::query( $q)) setcookie('_r', $hash, time() + 60 * 60 * 24 * 30);
            }
            return true;
          }
        }
      }
      return (false);
    }

    public static function is_admin_remember($remember) {
      $q = "select * from fabrix_admins where rememberme ='" . static::escape( $remember) . "'";
      $res = static::query( $q);
      if($res) {
        self::$admin = static::fetch_assoc($res);
        if(static::num_rows($res) > 0) {
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
      $q = "select * from fabrix_admins where login='" . static::escape( $login) . "'";
      $res = static::query( $q);
      $res = $res && (static::num_rows($res) > 0);
      return $res;
    }

    public static function admin_authorize($login, $password) {
      $login = static::escape( $login);
      $password = static::escape( $password);
      $q = "select * from fabrix_admins where login='$login'";
      $res = static::query( $q);
      if($res) {
        self::$admin = static::fetch_assoc($res);
        if(static::num_rows($res) > 0) {
          $hash = self::$admin['password'];
          if($hash == self::check($password, $hash)) {
            if(!is_null(_A_::$app->post('rememberme')) && _A_::$app->post('rememberme') == 1) {
              $hash = md5($login) . $hash;
              $salt = md5(!is_null(_A_::$app->server('HTTP_X_FORWARDED_FOR')) ? _A_::$app->server('HTTP_X_FORWARDED_FOR') : _A_::$app->server('REMOTE_ADDR'));
              $hash = self::hash_($hash, $salt, self::$cost);
              $q = "update fabrix_admins set rememberme = '" . static::escape( $hash) . "' where id = " . self::$admin['id'];
              if(static::query( $q)) setcookie('_ar', $hash, time() + 60 * 60 * 24 * 30);
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