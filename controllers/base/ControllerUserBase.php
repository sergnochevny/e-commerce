<?php

namespace controllers\base;

use app\core\App;
use models\ModelAuth;

/**
 * Class ControllerUserBase
 * @package controllers\base
 */
class ControllerUserBase extends ControllerController{

  /**
   * @return [][]|string
   */
  public static function get_from_session(){
    return App::$app->session('user');
  }

  /**
   * @return bool
   * @throws \Exception
   */
  public function is_authorized(){
    if(self::is_logged())
      return true;
    if(self::is_set_remember()) {
      $remember = App::$app->cookie('_r');
      if(ModelAuth::is_user_remember($remember)) {
        $user = ModelAuth::get_user_data();
        App::$app->setSession('_', $user['aid']);
        App::$app->setSession('user', $user);

        return true;
      }
    }

    return false;
  }

  /**
   * @param $email
   * @param $password
   * @return bool
   * @throws \Exception
   */
  public static function authorize($email, $password){
    $email = stripslashes(strip_tags(trim($email)));
    $password = stripslashes(strip_tags(trim($password)));
    $res = ModelAuth::user_authorize($email, $password);
    if($res) {
      $user = ModelAuth::get_user_data();
      App::$app->setSession('_', $user['aid']);
      App::$app->setSession('user', $user);
    }

    return $res;
  }

  /**
   * @return bool
   */
  public static function is_set_remember(){
    return !is_null(App::$app->cookie('_r'));
  }

  /**
   * @return bool
   */
  public static function is_logged(){
    return !is_null(App::$app->session('_'));
  }

}
