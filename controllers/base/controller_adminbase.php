<?php

class Controller_AdminBase extends Controller_FormSimple{

  protected function validate(&$data, &$error){
  }

  public static function get_from_session(){
    return _A_::$app->session('_a');
  }

  public function is_authorized(){
    if(self::is_logged())
      return true;
    if(self::is_set_remember()) {
      $remember = _A_::$app->cookie('_ar');
      if(Model_Auth::is_admin_remember($remember)) {
        $admin = Model_Auth::get_admin_data();
        _A_::$app->setSession('_a', $admin['id']);

        return true;
      }
    }

    return false;
  }

  public static function authorize($login, $password){
    $login = stripslashes(strip_tags(trim($login)));
    $password = stripslashes(strip_tags(trim($password)));
    $res = Model_Auth::admin_authorize($login, $password);
    if($res) {
      $admin = Model_Auth::get_admin_data();
      _A_::$app->setSession('_a', $admin['id']);
    }

    return $res;
  }

  public static function is_logged(){
    return !is_null(_A_::$app->session('_a'));
  }

  public static function is_set_remember(){
    return !is_null(_A_::$app->cookie('_ar'));
  }

}
