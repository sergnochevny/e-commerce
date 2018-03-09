<?php
/**
 * Date: 09.03.2018
 * Time: 11:58
 */

namespace classes\helpers;

use app\core\App;
use models\ModelAuth;

class AdminHelper{
  /**
   * @return mixed
   */
  public static function get_from_session(){
    return App::$app->session('_a');
  }

  /**
   * @return bool
   * @throws \Exception
   */
  public static function is_authorized(){
    if(self::is_logged())
      return true;
    if(self::is_set_remember()) {
      $remember = App::$app->cookie('_ar');
      if(ModelAuth::is_admin_remember($remember)) {
        $admin = ModelAuth::get_admin_data();
        App::$app->setSession('_a', $admin['id']);

        return true;
      }
    }

    return false;
  }

  /**
   * @param $login
   * @param $password
   * @return bool
   * @throws \Exception
   */
  public static function authorize($login, $password){
    $login = stripslashes(strip_tags(trim($login)));
    $password = stripslashes(strip_tags(trim($password)));
    $res = ModelAuth::admin_authorize($login, $password);
    if($res) {
      $admin = ModelAuth::get_admin_data();
      App::$app->setSession('_a', $admin['id']);
    }

    return $res;
  }

  /**
   * @return bool
   */
  public static function is_logged(){
    return !is_null(App::$app->session('_a'));
  }

  /**
   * @return bool
   */
  public static function is_set_remember(){
    return !is_null(App::$app->cookie('_ar'));
  }

}