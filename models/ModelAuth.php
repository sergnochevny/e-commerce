<?php

namespace models;

use app\core\App;
use app\core\model\ModelBase;

/**
 * Class ModelAuth
 * @package models
 */
class ModelAuth extends ModelBase{

  /**
   * @var null
   */
  private static $user = null;
  /**
   * @var null
   */
  private static $admin = null;

  /**
   * @var string
   */
  private static $salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  /**
   * @var int
   */
  private static $cost = 12;

  /**
   * @param $input
   * @param null $salt
   * @param null $cost
   * @return string
   */
  public static function hash_($input, $salt = null, $cost = null){
    $cost = sprintf('%02d', min(31, max($cost, 4)));
    $salt = '$2a$' . $cost . '$' . $salt . '$';

    return crypt($input, $salt);
  }

  /**
   * @param $password
   * @param $hash
   * @return string
   */
  public static function check($password, $hash){
    preg_match('/^\$2a\$(\d{2})\$(.{22})/D', $hash, $matches);
    $cost = $matches[1];
    $salt = $matches[2];

    return self::hash_($password, $salt, $cost);
  }

  /**
   * @param int $length
   * @return string
   */
  public static function generatestr($length = 22){
    $salt = self::$salt;
    $numChars = strlen($salt);
    $string = '';
    for($i = 0; $i < $length; $i++) {
      $string .= substr($salt, rand(1, $numChars) - 1, 1);
    }

    return $string;
  }

  /**
   * @param $remember
   * @return bool
   * @throws \Exception
   */
  public static function is_user_remember($remember){
    $q = "SELECT * FROM accounts WHERE remember = :remember";
    $res = static::query($q, ['remember' => $remember]);
    if($res) {
      self::$user = static::fetch_assoc($res);
      if(static::num_rows($res) > 0) {
        $mail = self::$user['email'];
        $hash = self::$user['password'];
        $hash = md5($mail) . $hash;
        $salt = md5(!is_null(App::$app->server('HTTP_X_FORWARDED_FOR')) ? App::$app->server('HTTP_X_FORWARDED_FOR') : App::$app->server('REMOTE_ADDR'));
        if($remember == self::hash_($hash, $salt, self::$cost)) {
          return true;
        } else {
          setcookie('_r', '');
        }
      }
    }

    return false;
  }

  /**
   * @param $mail
   * @return bool
   * @throws \Exception
   */
  public static function is_user($mail){
    $q = "SELECT * FROM accounts WHERE email = :email";
    $res = static::query($q, ['email' => $mail]);
    $result = $res && (static::num_rows($res) > 0);
    static::free_result($res);

    return $result;
  }

  /**
   * @param $mail
   * @param $password
   * @return bool
   * @throws \Exception
   */
  public static function user_authorize($mail, $password){
    $q = "SELECT * FROM accounts WHERE email=:email";
    $res = static::query($q, ['email' => $mail]);
    if($res) {
      if(static::num_rows($res) > 0) {
        self::$user = static::fetch_assoc($res);
        $hash = self::$user['password'];
        if($hash == self::check($password, $hash)) {
          if(!is_null(App::$app->post('rememberme')) && App::$app->post('rememberme') == 1) {
            $hash = md5($mail) . $hash;
            $salt = md5(!is_null(App::$app->server('HTTP_X_FORWARDED_FOR')) ? App::$app->server('HTTP_X_FORWARDED_FOR') : App::$app->server('REMOTE_ADDR'));
            $hash = self::hash_($hash, $salt, self::$cost);
            $q = "UPDATE accounts SET remember = :remember WHERE aid = :aid";
            if(static::query($q, ['remember' => $hash, 'aid' => self::$user['aid']])) {
              setcookie('_r', $hash, time() + 60 * 60 * 24 * 30);
            }
          }

          return true;
        }
      }
      static::free_result($res);
    }

    return (false);
  }

  /**
   * @param $remember
   * @return bool
   * @throws \Exception
   */
  public static function is_admin_remember($remember){
    $q = "SELECT * FROM admins WHERE rememberme = :remember";
    $res = static::query($q, ['remember' => $remember]);
    if($res) {
      self::$admin = static::fetch_assoc($res);
      if(static::num_rows($res) > 0) {
        $login = self::$admin['login'];
        $hash = self::$admin['password'];
        $hash = md5($login) . $hash;
        $salt = md5(!is_null(App::$app->server('HTTP_X_FORWARDED_FOR')) ? App::$app->server('HTTP_X_FORWARDED_FOR') : App::$app->server('REMOTE_ADDR'));
        if($remember == self::hash_($hash, $salt, self::$cost)) {
          return true;
        } else {
          setcookie('_ar', '');
        }
      }
      static::free_result($res);
    }

    return false;
  }

  /**
   * @param $login
   * @return bool
   * @throws \Exception
   */
  public static function is_admin($login){
    $q = "SELECT * FROM admins WHERE login=:login";
    $res = static::query($q, ['login' => $login]);
    $result = $res && (static::num_rows($res) > 0);
    static::free_result($res);

    return $result;
  }

  /**
   * @param $login
   * @param $password
   * @return bool
   * @throws \Exception
   */
  public static function admin_authorize($login, $password){
    $q = "SELECT * FROM admins WHERE login=:login";
    $res = static::query($q, ['login' => $login]);
    if($res) {
      self::$admin = static::fetch_assoc($res);
      if(static::num_rows($res) > 0) {
        $hash = self::$admin['password'];
        if($hash == self::check($password, $hash)) {
          if(!is_null(App::$app->post('rememberme')) && App::$app->post('rememberme') == 1) {
            $hash = md5($login) . $hash;
            $salt = md5(!is_null(App::$app->server('HTTP_X_FORWARDED_FOR')) ? App::$app->server('HTTP_X_FORWARDED_FOR') : App::$app->server('REMOTE_ADDR'));
            $hash = self::hash_($hash, $salt, self::$cost);
            $q = "UPDATE admins SET rememberme = :remember WHERE id = :id";
            if(static::query($q, ['remember' => $hash, 'id' => self::$admin['id']])) {
              setcookie('_ar', $hash, time() + 60 * 60 * 24 * 30);
            }
          }
          static::free_result($res);

          return true;
        }
      }
      static::free_result($res);
    }

    return (false);
  }

  /**
   * @return null
   */
  public static function get_user_data(){
    return self::$user;
  }

  /**
   * @return null
   */
  public static function get_admin_data(){
    return self::$admin;
  }

  /**
   * @param $data
   * @return string
   */
  public static function generate_hash($data){
    $salt = self::generatestr();
    $hash = self::hash_($data, $salt, self::$cost);

    return $hash;
  }

}